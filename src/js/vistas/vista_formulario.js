import { Vista } from './vista.js' 

/**
 * Clase que representa la vista del formulario en la aplicación.
 * @extends Vista
 */
export class Vista_formulario extends Vista {
    /**
     * Construye una instancia de la clase Vista_formulario.
     * @constructor
     * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
     * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del formulario.
     */
    constructor(controlador, base) {
        super(controlador, base) 

        document.addEventListener('keydown', this.irAtras.bind(this)) 

        this.formulario = this.base.querySelector('form') 
        this.formulario.addEventListener('submit', (event) => this.enviarFormulario(event)) 
    }

    /**
     * Función para manejar la pulsación de tecla.
     * @param {KeyboardEvent} event - Objeto que representa el evento de teclado.
     */
    irAtras(event) {
        if (event.key === 'Enter') {
            event.preventDefault()  // Evitar el envío predeterminado del formulario
            this.controlador.verVista(Vista.VISTA1) 
        }
    }

    /**
     * Función para manejar el envío del formulario.
     * @param {Event} event - Objeto que representa el evento de formulario.
     */
    enviarFormulario(event) {
        event.preventDefault() 
        this.controlador.manejarValidacionFormulario() 
    }
}