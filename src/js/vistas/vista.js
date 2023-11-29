/**
 * Clase que representa una vista en la aplicación.
 */
export class Vista {
  /**
     * Símbolos que representan distintas vistas en la aplicación.
     * @type {Symbol}
     */
  static VISTA1 = Symbol('Inicio')
  static VISTA2 = Symbol('Mapa')
  static VISTA3 = Symbol('Ranking')
  static VISTA4 = Symbol('Continente')
  static VISTA5 = Symbol('Formulario')
  static VISTA6 = Symbol('Problema')
  static VISTA7 = Symbol('Reflexion')
  static VISTA8 = Symbol('conflicto')
  static VISTA9 = Symbol('fecha')

  /**
     * Constructor de la clase Vista.
     * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
     * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista.
     */
  constructor (controlador, base) {
    this.controlador = controlador
    this.base = base
  }

  /**
     * Muestra u oculta la vista.
     * @param {boolean} ver - Indica si la vista debe mostrarse (true) u ocultarse (false).
     */
  mostrar (ver) {
    if (ver) {
      this.base.style.display = 'block'
    } else {
      this.base.style.display = 'none'
    }
  }
}
