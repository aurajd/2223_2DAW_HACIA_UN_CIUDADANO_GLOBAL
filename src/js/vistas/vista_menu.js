import { Vista } from './vista.js'

/**
 * Clase que representa la vista del menú de la aplicación.
 * @extends Vista
 */
export class VistaMenu extends Vista {
  /**
     * Construye una instancia de la clase Vista_menu.
     * @constructor
     * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
     * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del menú.
     */
  constructor (controlador, base) {
    super(controlador, base)

    // Coger referencias del interfaz
    /** @type {HTMLElement} */
    this.enlace1 = this.base.querySelectorAll('p')[0]
    /** @type {HTMLElement} */
    this.enlace2 = this.base.querySelectorAll('p')[1]
    /** @type {HTMLElement} */
    this.enlace3 = this.base.querySelectorAll('p')[2]

    // Asociar eventos
    this.enlace1.onclick = this.pulsarEnlace1.bind(this)
    this.enlace2.onclick = this.pulsarEnlace2.bind(this)
    this.enlace3.onclick = this.pulsarEnlace3.bind(this)
  }

  /**
     * Maneja el evento de hacer clic en el primer enlace del menú.
     */
  pulsarEnlace1 () {
    this.controlador.verVista(Vista.VISTA2) // Cambiamos a Vista Mapa
  }

  /**
     * Maneja el evento de hacer clic en el segundo enlace del menú.
     */
  pulsarEnlace2 () {
    this.controlador.verVista(Vista.VISTA3) // Cambiamos a Vista Ranking
  }

  /**
     * Maneja el evento de hacer clic en el tercer enlace del menú.
     */
  pulsarEnlace3 () {
    this.controlador.verVista(Vista.VISTA5) // Cambiamos a Vista Formulario
  }
}
