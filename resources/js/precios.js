/*
 * Calculadora de la sección de precios. Misma fórmula que
 * Suscripciones::calcularMontoEstimado del SaaS: el descuento de la beta
 * va solo sobre la base; las sucursales y los usuarios extra, a precio lleno.
 */

const pesos = new Intl.NumberFormat('es-AR', { style: 'currency', currency: 'ARS', maximumFractionDigits: 0 });

export function estimar(plan, talleres = 1, usuarios = 1) {
    const talleresExtra = Math.max(0, Math.max(1, talleres) - plan.talleres_incluidos);
    const usuariosExtra = Math.max(0, Math.max(1, usuarios) - plan.usuarios_incluidos);
    const montoTalleres = talleresExtra * plan.precio_taller_extra;
    const montoUsuarios = usuariosExtra * plan.precio_usuario_extra;

    return {
        base: plan.precio_final,
        talleres_extra: talleresExtra,
        monto_talleres: montoTalleres,
        usuarios_extra: usuariosExtra,
        monto_usuarios: montoUsuarios,
        total: Math.round((plan.precio_final + montoTalleres + montoUsuarios) * 100) / 100,
    };
}

export function initCalculadora() {
    const calculadora = document.querySelector('[data-calculadora]');
    const datos = document.getElementById('precios-datos');
    if (!calculadora || !datos) return;

    let plan;
    try {
        plan = JSON.parse(datos.textContent);
    } catch {
        return;
    }

    const talleres = calculadora.querySelector('[data-calc="talleres"]');
    const usuarios = calculadora.querySelector('[data-calc="usuarios"]');
    const salida = (nombre) => calculadora.querySelector(`[data-calc-salida="${nombre}"]`);

    const actualizar = () => {
        const r = estimar(plan, Number(talleres.value), Number(usuarios.value));
        ['base', 'monto_talleres', 'monto_usuarios', 'total'].forEach((clave) => {
            salida(clave).textContent = pesos.format(r[clave]);
        });
        salida('talleres_extra').textContent = `(${r.talleres_extra})`;
        salida('usuarios_extra').textContent = `(${r.usuarios_extra})`;
    };

    talleres.addEventListener('change', actualizar);
    usuarios.addEventListener('change', actualizar);
    actualizar();
}
