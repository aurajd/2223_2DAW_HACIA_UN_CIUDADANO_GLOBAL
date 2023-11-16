export class Vista {
    static VISTA1 = Symbol('Inicio');
    static VISTA2 = Symbol('Mapa');
    static VISTA3 = Symbol('Ranking');
    static VISTA4 = Symbol('Continente');
    //static VISTA5 = Symbol('Formulario');

    constructor(controlador, base) {
        this.controlador = controlador;
        this.base = base;
    }

    /**
     * Muestra u oculta la vista
     * @param ver {Boolean} Indica si la vista debe mostrarse (true) u ocultarse (false).
     */
    mostrar(ver) {
        if (ver)
            this.base.style.display = 'block'
        else
            this.base.style.display = 'none'
    }
}