/**
 * Clase que representa una vista en la aplicación.
 */
export class Vista {
  /**
   * Símbolos que representan distintas vistas en la aplicación.
   * @type {Symbol}
   */
  static VISTAMENU = Symbol('Inicio')
  static VISTAMAPA = Symbol('Mapa')
  static VISTARANKING = Symbol('Ranking')
  static VISTACONTINENTE = Symbol('Continente')
  static VISTAFORMULARIO = Symbol('Formulario')
  static VISTAPROBLEMA = Symbol('Problema')
  static VISTAREFLEXION = Symbol('Reflexion')
  static VISTACONFLICTO = Symbol('conflicto')
  static VISTAFECHA = Symbol('fecha')

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

  /**
   * Actualiza la puntuación en la interfaz, si es aplicable.
   */
  actualizarPuntuacionEnInterfaz () {
    const puntuacionElemento = this.base.querySelector('.puntosMensaje')
    if (puntuacionElemento) {
      const puntuacionActual = this.controlador.obtenerPuntuacionActual()
      puntuacionElemento.textContent = `Puntuación: ${puntuacionActual}`
    }
  }
}
