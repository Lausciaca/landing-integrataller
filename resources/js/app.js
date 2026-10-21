import './analytics';

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

    // Los elementos que entran en la misma tanda se escalonan; los que entran solos aparecen sin espera
    const observer = new IntersectionObserver((entries) => {
        entries
            .filter((entry) => entry.isIntersecting)
            .forEach((entry, index) => {
                entry.target.style.setProperty('--retraso', `${Math.min(index, 5) * 90}ms`);
                show(entry.target);
                observer.unobserve(entry.target);
            });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

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

document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initStickyHeader();
    initScrollReveal();
    initRecorrido();
});
