import { Vista } from './vista.js' 

/**
 * Clase que representa la vista del ranking en la aplicación.
 * @extends Vista
 */
export class Vista_ranking extends Vista {
    /**
     * Construye una instancia de la clase Vista_ranking.
     * @constructor
     * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
     * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del ranking.
     */
    constructor(controlador, base) {
        super(controlador, base) 

        document.addEventListener('keydown', this.irAtras.bind(this)) 

        this.enlaceInicio = this.base.querySelector('#volverMenu') 
        this.enlaceInicio.addEventListener('click', () => this.controlador.verVista(Vista.VISTA1)) 
    }

    /**
     * Función para manejar la pulsación de tecla.
     * @param {KeyboardEvent} event - Objeto que representa el evento de teclado.
     */
    irAtras(event) {
        if (event.key === 'Enter') {
            this.controlador.verVista(Vista.VISTA1) 
        }
    }

    /**
     * Actualiza la puntuación en la interfaz.
     */
    actualizarPuntuacionEnInterfaz() {
        const puntuacionActual = this.controlador.obtenerPuntuacionActual() 
        const puntuacionElemento = this.base.querySelector('#puntuacion') 
        puntuacionElemento.textContent = `Puntuación: ${puntuacionActual}` 
    }
}
