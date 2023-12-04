import { Vista } from './vista.js'

/**
 * Clase que representa la vista de reflexión en la aplicación.
 * @extends Vista
 */
export class VistaReflexion extends Vista {
  /**
   * Construye una instancia de la clase VistaReflexion.
   * @constructor
   * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
   * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista de reflexión.
   */
  constructor (controlador, base) {
    super(controlador, base)
    this.divReflexion = document.getElementById('fraseReflexion')
    this.botonVolver = document.getElementById('botonVolverReflexion')
    this.botonVolver.addEventListener('click', () => this.controlador.comprobarContinentesCambiar(this.idContinente))

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.comprobarContinentesMapa(this.idContinente))
  }

  /**
   * Actualiza la vista de reflexión con la información proporcionada.
   * @param {string} reflexion - Texto de la reflexión.
   * @param {string} idContinente - Identificador del continente asociado.
   */
  actualizarReflexion (reflexion, idContinente) {
    this.divReflexion.textContent = reflexion
    this.idContinente = idContinente
  }
}
