import { send } from './analytics';

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

    const onScroll = () => header.classList.toggle('shadow-2', window.scrollY > 8);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

function initScrollReveal() {
    const targets = document.querySelectorAll('[data-revelar]');
    if (!targets.length) return;

    const show = (el) => el.classList.add('is-visible');

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) {
        targets.forEach(show);
        return;
    }

    // Los elementos que entran en la misma tanda se escalonan apenas; los que entran solos aparecen sin espera.
    // Se revelan un poco antes de llegar a la pantalla para que al bajar rápido ya estén visibles.
    const observer = new IntersectionObserver((entries) => {
        entries
            .filter((entry) => entry.isIntersecting)
            .forEach((entry, index) => {
                entry.target.style.setProperty('--retraso', `${Math.min(index, 3) * 50}ms`);
                show(entry.target);
                observer.unobserve(entry.target);
            });
    }, { threshold: 0, rootMargin: '0px 0px 15% 0px' });

    document.documentElement.classList.add('revelar-listo');
    targets.forEach((el) => observer.observe(el));
}

// La línea del recorrido sigue al scroll: se llena hasta el 60% de la pantalla y enciende los pasos que alcanza
function initRecorrido() {
    const recorrido = document.querySelector('.recorrido');
    const pista = recorrido?.querySelector('[data-recorrido-pista]');
    if (!recorrido || !pista) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const pasos = [...recorrido.querySelectorAll('.recorrido-paso')];
    let pendiente = false;

    const update = () => {
        pendiente = false;
        const marca = window.innerHeight * 0.6;
        const { top, height } = pista.getBoundingClientRect();
        const progreso = Math.min(1, Math.max(0, (marca - top) / height));
        recorrido.style.setProperty('--progreso', progreso.toFixed(4));

        pasos.forEach((paso) => {
            const nodo = paso.querySelector('.recorrido-nodo').getBoundingClientRect();
            paso.classList.toggle('is-activo', nodo.top + nodo.height / 2 <= marca);
        });
    };

    const onScroll = () => {
        if (pendiente) return;
        pendiente = true;
        requestAnimationFrame(update);
    };

    recorrido.classList.add('is-dinamico');
    update();
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);
}

// Borrador del diálogo: si se cierra sin enviar, lo escrito vuelve al reabrirlo (solo en esta pestaña).
const BORRADOR_KEY = 'it_demo_borrador';

function guardarBorrador(form) {
    try {
        const datos = {
            name: form.elements.name?.value || '',
            phone: form.elements.phone?.value || '',
            branches: form.querySelector('input[name="branches"]:checked')?.value || '',
        };
        if (Object.values(datos).some((valor) => valor.trim() !== '')) {
            window.sessionStorage.setItem(BORRADOR_KEY, JSON.stringify(datos));
        } else {
            window.sessionStorage.removeItem(BORRADOR_KEY);
        }
    } catch {
        // Almacenamiento bloqueado: no hay borrador.
    }
}

function restaurarBorrador(form) {
    try {
        const datos = JSON.parse(window.sessionStorage.getItem(BORRADOR_KEY) || 'null');
        if (!datos) return;
        ['name', 'phone'].forEach((campo) => {
            if (form.elements[campo] && !form.elements[campo].value && typeof datos[campo] === 'string') form.elements[campo].value = datos[campo];
        });
        const opcion = form.querySelector(`input[name="branches"][value="${CSS.escape(String(datos.branches || ''))}"]`);
        if (opcion && !form.querySelector('input[name="branches"]:checked')) opcion.checked = true;
    } catch {
        // Borrador ilegible o almacenamiento bloqueado.
    }
}

function borrarBorrador() {
    try {
        window.sessionStorage.removeItem(BORRADOR_KEY);
    } catch {
        // Almacenamiento bloqueado.
    }
}

function formularioVacio(form) {
    const escrito = ['name', 'phone'].some((campo) => (form?.elements[campo]?.value || '').trim() !== '');
    return !escrito && !form?.querySelector('input[name="branches"]:checked');
}

// "Pedí tu demo" abre el formulario corto en la misma pantalla. Sin <dialog>, el enlace sigue a /contacto.
function initDemoDialog() {
    const dialog = document.querySelector('[data-demo-dialog]');
    if (!dialog || typeof dialog.showModal !== 'function') return;

    const form = dialog.querySelector('[data-demo-form]');
    let opener = null;

    document.addEventListener('click', (event) => {
        const link = event.target.closest?.('a[data-cta="demo"]');
        if (!link || event.defaultPrevented || event.metaKey || event.ctrlKey || event.shiftKey) return;

        event.preventDefault();
        opener = link;
        if (form) restaurarBorrador(form);
        dialog.showModal();
        document.documentElement.classList.add('dialogo-abierto');
        // En el celular no se abre el teclado de entrada: primero se ve el formulario completo
        if (window.matchMedia('(pointer: fine)').matches) dialog.querySelector('input[name="name"]')?.focus();
    });

    dialog.addEventListener('close', () => {
        document.documentElement.classList.remove('dialogo-abierto');
        if (form && !form.dataset.enviado) guardarBorrador(form);
        opener?.focus({ preventScroll: true });
    });
    // Tocar el fondo oscuro cierra solo si no hay nada escrito (la X y Escape cierran siempre)
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog && formularioVacio(form)) dialog.close();
    });
    dialog.querySelectorAll('[data-dialog-close]').forEach((button) => button.addEventListener('click', () => dialog.close()));
}

// El formulario de demo se envía con fetch: los errores aparecen sin recargar y, si sale bien, se pasa a la página de gracias
function initDemoForms() {
    document.querySelectorAll('[data-demo-form]').forEach((form) => {
        const submit = form.querySelector('[data-submit]');
        const notice = form.querySelector('[data-form-aviso]');
        const submitText = submit.textContent;

        const setSending = (sending) => {
            submit.disabled = sending;
            submit.textContent = sending ? 'Enviando…' : submitText;
        };

        const clearErrors = () => {
            notice.hidden = true;
            form.querySelectorAll('[data-error-for]').forEach((error) => {
                error.hidden = true;
                error.textContent = '';
            });
            form.querySelectorAll('[aria-invalid]').forEach((field) => field.removeAttribute('aria-invalid'));
        };

        const showErrors = (errors) => {
            let first = null;
            Object.entries(errors).forEach(([name, messages]) => {
                const error = form.querySelector(`[data-error-for="${name}"]`);
                if (!error) return;
                error.textContent = [].concat(messages)[0];
                error.hidden = false;
                const field = form.querySelector(`[data-campo="${name}"]`) || form.querySelector(`[name="${name}"]`);
                field?.setAttribute('aria-invalid', 'true');
                first ??= form.querySelector(`[name="${name}"]`);
            });
            first?.focus();
        };

        const fail = (reason) => {
            notice.hidden = false;
            setSending(false);
            send('form_error', { l: `demo: ${reason}` });
        };

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            if (submit.disabled) return;
            clearErrors();
            setSending(true);

            let response;
            try {
                response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin',
                });
            } catch {
                fail('sin conexión');
                return;
            }

            const data = await response.json().catch(() => ({}));
            if (response.ok) {
                form.dataset.enviado = '1';
                borrarBorrador();
                window.location.assign(data.redirect || '/demo/solicitada');
            } else if (response.status === 422 && data.errors) {
                setSending(false);
                showErrors(data.errors);
                send('form_error', { l: `demo: faltan ${Object.keys(data.errors).join(', ')}` });
            } else {
                fail(`error ${response.status}`);
            }
        });
    });
}

// YouTube recién se carga al tocar el póster: la página no paga el peso del reproductor
function initVideos() {
    document.querySelectorAll('[data-video-youtube]').forEach((link) => {
        link.addEventListener('click', (event) => {
            if (event.metaKey || event.ctrlKey || event.shiftKey) return;
            event.preventDefault();
            const iframe = document.createElement('iframe');
            iframe.src = `https://www.youtube-nocookie.com/embed/${encodeURIComponent(link.dataset.videoYoutube)}?autoplay=1&rel=0`;
            iframe.title = link.dataset.videoTitle || 'Video';
            iframe.allow = 'autoplay; encrypted-media; picture-in-picture';
            iframe.allowFullscreen = true;
            iframe.className = 'aspect-video h-full w-full';
            link.replaceWith(iframe);
            iframe.focus();
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initDemoDialog();
    initDemoForms();
    initMobileMenu();
    initStickyHeader();
    initScrollReveal();
    initRecorrido();
    initVideos();
});
