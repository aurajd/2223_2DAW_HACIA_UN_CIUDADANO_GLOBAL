import { Vista } from './vista.js'

/**
 * Clase que representa la vista de la fecha de inicio del conflicto en la aplicación.
 * @extends Vista
 */
export class VistaFecha extends Vista {
  /**
   * Construye una instancia de la clase VistaFecha.
   * @constructor
   * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
   * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista de la fecha.
   */
  constructor (controlador, base) {
    super(controlador, base)

    this.divFecha = document.getElementById('fraseFecha')
    this.botonVolver = document.getElementById('botonVolverFecha')
    this.enlaceInicio = this.base.querySelector('.verMenu')

    this.botonVolver.addEventListener('click', () => this.controlador.comprobarContinentesCambiar(this.idContinente))
    this.enlaceInicio.addEventListener('click', () => this.controlador.comprobarContinentesMapa(this.idContinente))
  }

  /**
   * Actualiza la vista de fecha con la información proporcionada.
   * @param {string} fecha - Fecha en formato ISO.
   * @param {string} idContinente - Identificador único del continente.
   */
  actualizarFecha (fecha, idContinente) {
    this.idContinente = idContinente
    const date = new Date(fecha)
    const options = { year: 'numeric', month: 'long', day: 'numeric' }
    this.divFecha.textContent = 'El conflicto comenzó el ' + date.toLocaleDateString('es-ES', options)
  }
}
