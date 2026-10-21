/*
 * Medición de la landing.
 *
 * 1. Analítica propia, anónima y sin cookies: eventos por beacon a /api/t que
 *    la app administrativa importa. La sesión vive en sessionStorage.
 * 2. Consentimiento: Meta Pixel, Microsoft Clarity y GA4 solo cargan después
 *    de que la persona acepta en el banner (cookie `it_consent`).
 */

const ENDPOINT = '/api/t';
const ATTR_KEY = 'it_attr';
const SESSION_TIMEOUT_MS = 30 * 60 * 1000;
const UTM_KEYS = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'];

const config = (() => {
    try {
        return JSON.parse(document.getElementById('it-analytics')?.textContent || '{}');
    } catch {
        return {};
    }
})();
const tags = config.tags || {};

function uuid() {
    if (window.crypto?.randomUUID) return window.crypto.randomUUID();
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, (c) => {
        const r = (Math.random() * 16) | 0;
        return (c === 'x' ? r : (r & 0x3) | 0x8).toString(16);
    });
}

function sessionStore() {
    try {
        return window.sessionStorage;
    } catch {
        return null;
    }
}

/* ---------- Atribución de la sesión ---------- */

function externalReferrer() {
    try {
        const ref = document.referrer ? new URL(document.referrer) : null;
        return ref && ref.host !== location.host ? ref.href.slice(0, 500) : null;
    } catch {
        return null;
    }
}

// Parámetros de la URL sin importar mayúsculas (UTM_Source) y tolerando enlaces pegados con "&amp;".
function urlParams() {
    const params = new Map();
    new URLSearchParams(location.search.replace(/&amp;/gi, '&')).forEach((value, key) => {
        const name = key.trim().toLowerCase();
        if (value.trim() && !params.has(name)) params.set(name, value.trim());
    });
    return params;
}

// Red de Meta según el referente, para visitas con fbclid pero sin UTM.
function metaNetwork(referrer) {
    try {
        const host = referrer ? new URL(referrer).host : '';
        if (/(^|\.)instagram\.com$/.test(host)) return 'instagram';
        if (/(^|\.)(facebook\.com|fb\.com|messenger\.com)$/.test(host)) return 'facebook';
    } catch {
        // Referente inválido.
    }
    return 'meta';
}

function loadAttribution() {
    const store = sessionStore();
    let attr = null;
    try {
        attr = JSON.parse(store?.getItem(ATTR_KEY) || 'null');
    } catch {
        attr = null;
    }

    const params = urlParams();
    const utm = {};
    UTM_KEYS.forEach((key) => {
        const value = params.get(key);
        if (value) utm[key] = value.slice(0, 150);
    });
    // utm_id ({{campaign.id}} en Meta) sirve de campaña si el nombre no llegó.
    if (!utm.utm_campaign && params.get('utm_id')) utm.utm_campaign = params.get('utm_id').slice(0, 150);
    const fbclid = params.get('fbclid');
    const gclid = params.get('gclid');
    // Anuncio de Meta sin UTM: al menos queda la red; la campaña no se inventa.
    if (fbclid && !utm.utm_source) utm.utm_source = metaNetwork(document.referrer);
    const fromCampaign = Object.keys(utm).length > 0 || fbclid || gclid;
    const expired = !attr || Date.now() - (attr.last || 0) > SESSION_TIMEOUT_MS;

    if (expired || fromCampaign) {
        // Sesión nueva (o llegada desde otro anuncio): se toma la fuente de esta página.
        attr = {
            session_id: expired ? uuid() : attr.session_id,
            landing_page: location.pathname,
            referrer: externalReferrer() || (expired ? null : attr.referrer),
            ...utm,
            click_id: fbclid ? 'fbclid' : gclid ? 'gclid' : null,
            fbclid: fbclid ? fbclid.slice(0, 500) : null,
        };
    }

    attr.last = Date.now();
    try {
        store?.setItem(ATTR_KEY, JSON.stringify(attr));
    } catch {
        // Almacenamiento bloqueado: se mide igual, como sesión de una página.
    }
    return attr;
}

const attribution = loadAttribution();

export function send(type, extra = {}) {
    const payload = JSON.stringify({
        t: type,
        p: location.pathname,
        a: attribution,
        w: window.innerWidth,
        ...extra,
    });
    try {
        if (navigator.sendBeacon?.(ENDPOINT, new Blob([payload], { type: 'text/plain' }))) return;
    } catch {
        // Cae al fetch.
    }
    fetch(ENDPOINT, { method: 'POST', body: payload, keepalive: true, headers: { 'Content-Type': 'text/plain' } }).catch(() => {});
}

/* ---------- Consentimiento y etiquetas de terceros ---------- */

let consent = readConsent();

function readConsent() {
    const match = document.cookie.match(/(?:^|; )it_consent=v(\d+)\.a([01])\.m([01])/);
    if (!match || Number(match[1]) !== Number(config.consentVersion || 1)) return null;
    return { analytics: match[2] === '1', marketing: match[3] === '1' };
}

function saveConsent(choice) {
    const value = `v${config.consentVersion || 1}.a${choice.analytics ? 1 : 0}.m${choice.marketing ? 1 : 0}`;
    const secure = location.protocol === 'https:' ? '; Secure' : '';
    document.cookie = `it_consent=${value}; Max-Age=${365 * 24 * 3600}; Path=/; SameSite=Lax${secure}`;
    consent = choice;
}

function loadScript(src) {
    const script = document.createElement('script');
    script.async = true;
    script.src = src;
    document.head.appendChild(script);
}

function loadPixel(id) {
    if (window.fbq) return;
    const fbq = function (...args) {
        fbq.callMethod ? fbq.callMethod(...args) : fbq.queue.push(args);
    };
    fbq.push = fbq;
    fbq.loaded = true;
    fbq.version = '2.0';
    fbq.queue = [];
    window.fbq = fbq;
    window._fbq = fbq;
    loadScript('https://connect.facebook.net/en_US/fbevents.js');
    window.fbq('init', id);
    window.fbq('track', 'PageView');
}

function loadClarity(id) {
    if (window.clarity) return;
    window.clarity = function (...args) {
        (window.clarity.q = window.clarity.q || []).push(args);
    };
    loadScript(`https://www.clarity.ms/tag/${encodeURIComponent(id)}`);
    // Permite filtrar grabaciones y mapas de calor por campaña.
    UTM_KEYS.forEach((key) => attribution[key] && window.clarity('set', key, attribution[key]));
}

function loadGa4(id) {
    if (window.gtag) return;
    window.dataLayer = window.dataLayer || [];
    window.gtag = function () {
        window.dataLayer.push(arguments);
    };
    loadScript(`https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(id)}`);
    window.gtag('js', new Date());
    window.gtag('config', id);
}

function applyConsent() {
    if (!consent) return;
    if (consent.analytics && tags.clarity) loadClarity(tags.clarity);
    if (consent.analytics && tags.ga4) loadGa4(tags.ga4);
    if (consent.marketing && tags.pixel) loadPixel(tags.pixel);

    // Conversión que dejó el servidor (demo o suscripción): mismo event_id que la Conversions API.
    if (config.conversion && !config.conversion.reported) {
        config.conversion.reported = true;
        reportConversion(config.conversion.meta, config.conversion.ga, config.conversion.id);
    }
}

function reportConversion(metaEvent, gaEvent, eventId) {
    if (consent?.marketing && window.fbq && metaEvent) window.fbq('track', metaEvent, {}, { eventID: eventId });
    if (consent?.analytics && window.gtag && gaEvent) window.gtag('event', gaEvent);
}

function initBanner() {
    const banner = document.querySelector('[data-cookie-banner]');
    if (!banner) return;

    const options = banner.querySelector('[data-cookie-options]');
    const boxes = [...banner.querySelectorAll('[data-consent]')];
    const saveButton = banner.querySelector('[data-cookie-save]');
    const configureButton = banner.querySelector('[data-cookie-configure]');

    const open = (detailed) => {
        boxes.forEach((box) => {
            box.checked = Boolean(consent?.[box.dataset.consent]);
        });
        options.hidden = !detailed;
        saveButton.hidden = !detailed;
        configureButton.hidden = detailed;
        banner.hidden = false;
    };

    const decide = (choice) => {
        const previous = consent;
        saveConsent(choice);
        banner.hidden = true;
        // Revocar no descarga scripts ya cargados: se recarga para dejar de medir.
        if ((previous?.analytics && !choice.analytics) || (previous?.marketing && !choice.marketing)) {
            location.reload();
            return;
        }
        applyConsent();
    };

    banner.querySelector('[data-cookie-accept]').addEventListener('click', () => decide({ analytics: true, marketing: true }));
    banner.querySelector('[data-cookie-reject]').addEventListener('click', () => decide({ analytics: false, marketing: false }));
    configureButton.addEventListener('click', () => open(true));
    saveButton.addEventListener('click', () => {
        const choice = { analytics: false, marketing: false };
        boxes.forEach((box) => {
            choice[box.dataset.consent] = box.checked;
        });
        decide(choice);
    });
    document.querySelectorAll('[data-cookie-preferences]').forEach((button) => button.addEventListener('click', () => open(true)));

    if (!consent) open(false);
}

/* ---------- Eventos de la página ---------- */

function initTracking() {
    send('pageview');

    document.querySelectorAll('[data-attribution]').forEach((input) => {
        input.value = JSON.stringify(attribution);
    });

    document.addEventListener('click', (event) => {
        const target = event.target.closest?.('a, button');
        if (!target) return;

        const href = target.getAttribute('href') || '';
        const text = (target.textContent || target.getAttribute('aria-label') || '').trim().replace(/\s+/g, ' ').slice(0, 80);
        if (/wa\.me|api\.whatsapp\.com/.test(href)) {
            const eventId = uuid();
            send('whatsapp_click', { l: text || 'WhatsApp', e: eventId });
            reportConversion('Contact', 'contact', eventId);
        } else if (target.closest('[data-cta]')) {
            const cta = target.closest('[data-cta]');
            send('cta_click', { l: `${cta.dataset.cta}: ${text}`.slice(0, 150) });
        }
    }, { capture: true });

    document.querySelectorAll('[data-demo-form]').forEach((form) => {
        form.addEventListener('focusin', () => send('form_start', { l: 'demo' }), { once: true });
    });

    const reached = new Set();
    const onScroll = () => {
        const scrollable = document.documentElement.scrollHeight - window.innerHeight;
        const percent = scrollable <= 0 ? 100 : ((window.scrollY + 1) / scrollable) * 100;
        [25, 50, 75, 100].forEach((mark) => {
            if (percent >= mark - 1 && !reached.has(mark)) {
                reached.add(mark);
                send('scroll', { v: mark });
            }
        });
    };
    let scrollTimer = null;
    window.addEventListener('scroll', () => {
        clearTimeout(scrollTimer);
        scrollTimer = setTimeout(onScroll, 200);
    }, { passive: true });

    // Tiempo con la página visible; se envía al ocultarla o cerrarla.
    let visibleSince = document.visibilityState === 'visible' ? Date.now() : null;
    let accumulated = 0;
    const flush = () => {
        if (visibleSince) {
            accumulated += Date.now() - visibleSince;
            visibleSince = null;
        }
        const seconds = Math.round(accumulated / 1000);
        if (seconds > 0) send('engagement', { v: seconds });
        accumulated = 0;
    };
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden') flush();
        else visibleSince = Date.now();
    });
    window.addEventListener('pagehide', flush);
}

document.addEventListener('DOMContentLoaded', () => {
    initTracking();
    initBanner();
    applyConsent();
});
