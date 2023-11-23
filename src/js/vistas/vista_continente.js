import { Vista } from './vista.js'

/**
 * Clase que representa la vista de un continente en la aplicación.
 * @extends Vista
 */
export class VistaContinente extends Vista {
  /**
     * Construye una instancia de la clase Vista_continente.
     * @constructor
     * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
     * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del continente.
     */
  constructor (controlador, base) {
    super(controlador, base, Vista.VISTA2)

    // Agregar un event listener para el evento de pulsación de tecla
    document.addEventListener('keydown', this.irAtras.bind(this))
    // Nombre para mostrar en la vista continente
    this.mostrarInformacion('NOMBRE DEL CONTINENTE')
    
    // Coger referencias del interfaz
    /** @type {HTMLElement} */
    this.boton1 = this.base.querySelector('#problema_1')
    /** @type {HTMLElement} */
    this.boton2 = this.base.querySelector('#problema_2')
    /** @type {HTMLElement} */
    this.boton3 = this.base.querySelector('#problema_3')

    this.boton1.addEventListener('click', () => this.pulsarBoton(Vista.VISTA6))
    this.boton2.addEventListener('click', () => this.pulsarBoton(Vista.VISTA6))
    this.boton3.addEventListener('click', () => this.pulsarBoton(Vista.VISTA6))

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.verVista(Vista.VISTA2))

    this.enlaceRanking = this.base.querySelector('.verRanking')
    this.enlaceRanking.addEventListener('click', () => this.controlador.verVista(Vista.VISTA3))

  }

  /**
     * Función para manejar la pulsación de tecla.
     * @param {KeyboardEvent} event - Objeto que representa el evento de teclado.
     */
  irAtras (event) {
    // Verificar si la tecla presionada es 'b' y si también se presionó la tecla 'Ctrl'
    if (event.key === 'b' && (event.ctrlKey || event.metaKey)) {
      // Cambiar a Vista2
      this.controlador.verVista(Vista.VISTA2)
    }
  }

  /**
     * Función para mostrar Nombres en la vista continente.
     * @param {string} Nombre - Nombre a mostrar.
     */
  mostrarInformacion (Nombre) {
    const NombreElemento = document.createElement('h2')
    NombreElemento.textContent = Nombre

    const NombreContainer = this.base.querySelector('#nombreContinente')
    NombreContainer.appendChild(NombreElemento)    

    const NombreContainer2 = this.base.querySelector('#infoContinente')
    NombreContainer2.textContent = Nombre
    NombreContainer.appendChild(NombreElemento)
  }

  actualizarPuntuacionEnInterfaz () {
    const puntuacionElemento = this.base.querySelector('.puntosMensaje')
    if (puntuacionElemento) {
      const puntuacionActual = this.controlador.obtenerPuntuacionActual()
      puntuacionElemento.textContent = `Puntuación: ${puntuacionActual}`
    }
  }

  pulsarBoton (vista) {
    this.controlador.verVista(vista)
  }

}
