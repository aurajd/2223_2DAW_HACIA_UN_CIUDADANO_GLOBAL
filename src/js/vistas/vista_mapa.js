import { Vista } from './vista.js'

/**
 * Clase que representa la vista del mapa de la aplicación.
 * @extends Vista
 */
export class VistaMapa extends Vista {
  /**
     * Construye una instancia de la clase Vista_mapa.
     * @constructor
     * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
     * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del mapa.
     */
  constructor (controlador, base) {
    super(controlador, base)

    // Coger referencias del interfaz
    /** @type {HTMLElement} */
    this.boton1 = this.base.querySelector('#boton_eu1')
    /** @type {HTMLElement} */
    this.boton2 = this.base.querySelector('#boton_eu2')
    /** @type {HTMLElement} */
    this.boton3 = this.base.querySelector('#boton_eu3')
    /** @type {HTMLElement} */
    this.boton4 = this.base.querySelector('#boton_eu4')
    /** @type {HTMLElement} */
    this.boton5 = this.base.querySelector('#boton_eu5')
    /** @type {HTMLElement} */
    this.boton6 = this.base.querySelector('#boton_eu6')

    // Crear cuadros de texto
    /** @type {HTMLElement} */
    this.cuadroTexto1 = this.crearCuadroTexto('Información detallada sobre el primer botón')
    /** @type {HTMLElement} */
    this.cuadroTexto2 = this.crearCuadroTexto('Información detallada sobre el segundo botón')
    /** @type {HTMLElement} */
    this.cuadroTexto3 = this.crearCuadroTexto('Información detallada sobre el tercer botón')
    /** @type {HTMLElement} */
    this.cuadroTexto4 = this.crearCuadroTexto('Información detallada sobre el cuarto botón')
    /** @type {HTMLElement} */
    this.cuadroTexto5 = this.crearCuadroTexto('Información detallada sobre el quinto botón')
    /** @type {HTMLElement} */
    this.cuadroTexto6 = this.crearCuadroTexto('Información detallada sobre el sexto botón')

    // Agregar cuadros de texto al DOM
    this.base.appendChild(this.cuadroTexto1)
    this.base.appendChild(this.cuadroTexto2)
    this.base.appendChild(this.cuadroTexto3)
    this.base.appendChild(this.cuadroTexto4)
    this.base.appendChild(this.cuadroTexto5)
    this.base.appendChild(this.cuadroTexto6)

    // Asociar eventos
    this.boton1.addEventListener('mouseenter', () => this.mostrarCuadroTexto(this.cuadroTexto1))
    this.boton1.addEventListener('mouseleave', () => this.ocultarCuadroTexto(this.cuadroTexto1))
    this.boton1.addEventListener('click', () => this.pulsarBoton(Vista.VISTA4)) // Cambiamos a Vista Continente para el primer botón

    this.boton2.addEventListener('mouseenter', () => this.mostrarCuadroTexto(this.cuadroTexto2))
    this.boton2.addEventListener('mouseleave', () => this.ocultarCuadroTexto(this.cuadroTexto2))
    this.boton2.addEventListener('click', () => this.pulsarBoton(Vista.VISTA4)) // Cambiamos a Vista Continente para el segundo botón

    this.boton3.addEventListener('mouseenter', () => this.mostrarCuadroTexto(this.cuadroTexto3))
    this.boton3.addEventListener('mouseleave', () => this.ocultarCuadroTexto(this.cuadroTexto3))
    this.boton3.addEventListener('click', () => this.pulsarBoton(Vista.VISTA4)) // Cambiamos a Vista Continente para el terccer botón
    
    this.boton4.addEventListener('mouseenter', () => this.mostrarCuadroTexto(this.cuadroTexto4))
    this.boton4.addEventListener('mouseleave', () => this.ocultarCuadroTexto(this.cuadroTexto4))
    this.boton4.addEventListener('click', () => this.pulsarBoton(Vista.VISTA4)) // Cambiamos a Vista Continente para el cuarto botón
    
    this.boton5.addEventListener('mouseenter', () => this.mostrarCuadroTexto(this.cuadroTexto5))
    this.boton5.addEventListener('mouseleave', () => this.ocultarCuadroTexto(this.cuadroTexto5))
    this.boton5.addEventListener('click', () => this.pulsarBoton(Vista.VISTA4)) // Cambiamos a Vista Continente para el quinto botón

    this.boton6.addEventListener('mouseenter', () => this.mostrarCuadroTexto(this.cuadroTexto6))
    this.boton6.addEventListener('mouseleave', () => this.ocultarCuadroTexto(this.cuadroTexto6))
    this.boton6.addEventListener('click', () => this.pulsarBoton(Vista.VISTA4)) // Cambiamos a Vista Continente para el sexto botón

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.verVista(Vista.VISTA1))

    this.enlaceRanking = this.base.querySelector('.verRanking')
    this.enlaceRanking.addEventListener('click', () => this.controlador.verVista(Vista.VISTA3))

  }

  /**
     * Crea un cuadro de texto con el texto proporcionado.
     * @param {string} texto - Texto para el cuadro de texto.
     * @returns {HTMLElement} - Cuadro de texto creado.
     */
  crearCuadroTexto (texto) {
    const cuadroTexto = document.createElement('div')
    cuadroTexto.classList.add('cuadro-texto')
    cuadroTexto.textContent = texto
    cuadroTexto.style.display = 'none'
    return cuadroTexto
  }

  /**
     * Muestra un cuadro de texto.
     * @param {HTMLElement} cuadroTexto - Cuadro de texto a mostrar.
     */
  mostrarCuadroTexto (cuadroTexto) {
    cuadroTexto.style.display = 'block'
    cuadroTexto.style.backgroundColor = 'black'
    cuadroTexto.style.color = 'white'
  }

  /**
     * Oculta un cuadro de texto.
     * @param {HTMLElement} cuadroTexto - Cuadro de texto a ocultar.
     */
  ocultarCuadroTexto (cuadroTexto) {
    cuadroTexto.style.display = 'none'
  }

  /**
     * Maneja el evento de hacer clic en un botón.
     * @param {Symbol} vista - Vista a la que se cambiará.
     */
  pulsarBoton (vista) {
    this.controlador.verVista(vista)
  }
}
