import { Vista } from './vista.js'

/**
 * Clase que representa la vista del formulario en la aplicación.
 * @extends Vista
 */
export class VistaFormulario extends Vista {
  /**
     * Construye una instancia de la clase Vista_formulario.
     * @constructor
     * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
     * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del formulario.
     */
  constructor (controlador, base) {
    super(controlador, base)

    this.formulario = this.base.querySelector('form')
    this.formulario.addEventListener('submit', (event) => this.enviarFormulario(event))

    this.botonCancelar = document.getElementById('botonCancelarFormulario')
    this.botonCancelar.addEventListener('click', () => this.cancelarEnvio())
  }

  /**
   * Función para manejar el envío del formulario.
   * @param {Event} event - Objeto que representa el evento de formulario.
   */
  enviarFormulario (event) {
    event.preventDefault()
    this.borrarBotonInicio()
    this.controlador.manejarValidacionFormulario()
  }

  /**
   * Función para cancelar el envío del formulario.
   */
  cancelarEnvio(){
    this.borrarBotonInicio()
    this.controlador.verVista(Vista.VISTAMENU)
  }

  /**
   * Borra el botón de inicio.
   */
  borrarBotonInicio(){
    this.controlador.borrarBotonInicio();
  }
}
