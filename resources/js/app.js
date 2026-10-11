function initMobileMenu() {
    const toggle = document.querySelector('[data-menu-toggle]');
    const panel = document.querySelector('[data-menu-panel]');
    if (!toggle || !panel) return;

    const openIcon = toggle.querySelector('[data-icon-open]');
    const closeIcon = toggle.querySelector('[data-icon-close]');

    const setOpen = (open) => {
        panel.classList.toggle('hidden', !open);
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Cerrar menú' : 'Abrir menú');
        openIcon?.classList.toggle('hidden', open);
        closeIcon?.classList.toggle('hidden', !open);
    };

    toggle.addEventListener('click', () => setOpen(panel.classList.contains('hidden')));
    panel.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setOpen(false)));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !panel.classList.contains('hidden')) setOpen(false);
    });
}

function initStickyHeader() {
    const header = document.querySelector('[data-site-header]');
    if (!header) return;

    const onScroll = () => header.classList.toggle('border-secondary/20', window.scrollY > 8);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

function initNewsletterPopup() {
    const dialog = document.querySelector('[data-newsletter-dialog]');
    if (!dialog || typeof dialog.showModal !== 'function') return;

    const close = dialog.querySelector('[data-newsletter-close]');
    const storageKey = 'integrataller-newsletter-popup-at';
    const coolingPeriod = 14 * 24 * 60 * 60 * 1000;
    let hasShown = false;

    if (dialog.dataset.forceOpen === 'true') {
        hasShown = true;
        dialog.showModal();
        return;
    }

    try {
        const lastShown = Number(window.localStorage.getItem(storageKey) || 0);
        if (Date.now() - lastShown < coolingPeriod) return;
    } catch {
        // The popup still works when storage is unavailable; it is limited to this page view.
    }

    const show = () => {
        if (hasShown || dialog.open) return;
        hasShown = true;
        try {
            window.localStorage.setItem(storageKey, String(Date.now()));
        } catch {
            // Keep the interaction usable in privacy-restricted browser contexts.
        }
        dialog.showModal();
    };

    close?.addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) dialog.close();
    });

    const mobile = window.matchMedia('(max-width: 639px)').matches;
    let timer;
    if (!mobile) timer = window.setTimeout(show, 45000);

    const onScroll = () => {
        const scrollable = document.documentElement.scrollHeight - window.innerHeight;
        if (scrollable <= 0) return;
        const threshold = mobile ? 0.78 : 0.58;
        if (window.scrollY / scrollable >= threshold) {
            window.removeEventListener('scroll', onScroll);
            if (timer) window.clearTimeout(timer);
            show();
        }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
}

document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initStickyHeader();
    initNewsletterPopup();
});
