import { Vista } from './vista.js'

/**
 * Clase que representa la vista del mapa de la aplicación.
 * @extends Vista
 */
export class VistaMapa extends Vista {
  /**
   * Construye una instancia de la clase VistaMapa.
   * @constructor
   * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
   * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del mapa.
   */
  constructor (controlador, base) {
    super(controlador, base)

    // this.preguntaContinentes = this.modelo.obtenerPreguntas();

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

    this.cuadrosTexto = []

    // Crear cuadros de texto
    /** @type {HTMLElement} */
    this.crearCuadroTexto(0, 'texto_eur', this.boton1)

    /** @type {HTMLElement} */
    this.crearCuadroTexto(1, 'texto_asi', this.boton2)

    /** @type {HTMLElement} */
    this.crearCuadroTexto(2, 'texto_oce', this.boton3)

    /** @type {HTMLElement} */
    this.crearCuadroTexto(3, 'texto_ame_nor', this.boton4)

    /** @type {HTMLElement} */
    this.crearCuadroTexto(4, 'texto_ame_sur', this.boton5)

    /** @type {HTMLElement} */
    this.crearCuadroTexto(5, 'texto_afr', this.boton6)

    this.boton1.addEventListener('click', (event) => {
      this.modificarPreguntas(event)
    }) // Cambiamos a Vista Continente para el primer botón

    this.boton2.addEventListener('click', (event) => {
      this.modificarPreguntas(event)
    }) // Cambiamos a Vista Continente para el segundo botón

    this.boton3.addEventListener('click', (event) => {
      this.modificarPreguntas(event)
    }) // Cambiamos a Vista Continente para el tercer botón

    this.boton4.addEventListener('click', (event) => {
      this.modificarPreguntas(event)
    }) // Cambiamos a Vista Continente para el cuarto botón

    this.boton5.addEventListener('click', (event) => {
      this.modificarPreguntas(event)
    }) // Cambiamos a Vista Continente para el quinto botón

    this.boton6.addEventListener('click', (event) => {
      this.modificarPreguntas(event)
    }) // Cambiamos a Vista Continente para el sexto botón

    this.enlaceRanking = this.base.querySelector('.verRanking')
    this.enlaceRanking.addEventListener('click', () => {
      this.controlador.cambiarEnlaceRankingMapa()
      this.controlador.mostrarRankingActualizado()
    })
  }

  /**
   * Crea un cuadro de texto con el texto proporcionado.
   * @param {number} idContinente - ID del continente asociado al cuadro de texto.
   * @param {string} idDiv - ID del cuadro de texto HTML.
   * @param {HTMLElement} boton - Botón asociado al cuadro de texto.
   */
  async crearCuadroTexto (idContinente, idDiv, boton) {
    const cuadroTexto = document.createElement('pre')
    cuadroTexto.classList.add('cuadro-texto')
    const continente = await this.controlador.devolverContinente(idContinente)
    cuadroTexto.textContent = continente.resumenInfo
    cuadroTexto.style.display = 'none'
    cuadroTexto.id = idDiv
    this.base.appendChild(cuadroTexto)
    this.cuadrosTexto.push(cuadroTexto)

    // Asociar eventos
    boton.addEventListener('mouseenter', () => this.mostrarCuadroTexto(this.cuadrosTexto[idContinente]))
    boton.addEventListener('mouseleave', () => this.ocultarCuadroTexto(this.cuadrosTexto[idContinente]))
  }

  /**
   * Muestra un cuadro de texto.
   * @param {HTMLElement} cuadroTexto - Cuadro de texto a mostrar.
   */
  mostrarCuadroTexto (cuadroTexto) {
    cuadroTexto.style.display = 'block'
  }

  /**
   * Oculta un cuadro de texto.
   * @param {HTMLElement} cuadroTexto - Cuadro de texto a ocultar.
   */
  ocultarCuadroTexto (cuadroTexto) {
    cuadroTexto.style.display = 'none'
  }

  /**
   * Modifica las preguntas al hacer clic en un botón.
   * @param {Event} event - Objeto que representa el evento de clic.
   */
  modificarPreguntas (event) {
    const id = event.target.id.slice(-1) - 1
    this.controlador.cambiarContinentes(id)
  }

  /**
   * Elimina un continente.
   * @param {number} idContinente - ID del continente a eliminar.
   */
  eliminarContinente (idContinente) {
    const boton = 'this.boton' + (idContinente + 1)
    eval(boton).remove() // eslint-disable-line no-eval
  }
}
