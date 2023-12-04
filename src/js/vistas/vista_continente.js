import { Vista } from './vista.js'
/**
 * Clase que representa la vista de un continente en la aplicación.
 * @extends Vista
 */
export class VistaContinente extends Vista {
  /**
   * Construye una instancia de la clase VistaContinente.
   * @constructor
   * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
   * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del continente.
   */
  constructor (controlador, base) {
    super(controlador, base, Vista.VISTAMAPA)

    this.h2Nombre = document.querySelector('#nombreContinente')
    this.imagenContinente = document.querySelector('#imagenInfo')

    this.infoContinente = document.querySelector('#informacionContinente')

    this.divsPreguntas = this.base.getElementsByClassName('opcionesContainer')

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.comprobarContinentesMapa(this.idContinente))

    this.idContinente = ''
  }

  /**
   * Actualiza la vista del continente con la información proporcionada.
   * @param {array} preguntas - Lista de preguntas asociadas al continente.
   * @param {string} id - Identificador único del continente.
   */
  async actualizarContinente (preguntas, id) {
    const continente = await this.controlador.devolverContinente(id)
    for (const divsPregunta of this.divsPreguntas) {
      divsPregunta.textContent = ''
    }
    let i = 0
    this.idContinente = id
    this.modificarImagen(continente.imagen)
    this.mostrarNombre(continente.nombre)
    this.mostrarInformacion(continente.informacion)
    for (const [index, pregunta] of preguntas.entries()) {
      const btnPregunta = document.createElement('button')
      btnPregunta.classList.add('problema')
      btnPregunta.textContent = pregunta.titulo
      if (pregunta.tipo == 'problema') { // eslint-disable-line eqeqeq
        this.prepararProblema(btnPregunta, index)
      } else {
        this.prepararConflicto(btnPregunta, index)
      }
      this.divsPreguntas[i++].appendChild(btnPregunta)
    }
  }

  /**
   * Prepara un problema para ser mostrado en la vista de soluciones.
   * @param {HTMLElement} btnPregunta - Botón de la pregunta.
   * @param {number} index - Índice de la pregunta.
   */
  prepararProblema (btnPregunta, index) {
    btnPregunta.id = 'idProblema' + index
    btnPregunta.onclick = this.prepararSoluciones.bind(this)
  }

  /**
   * Prepara un conflicto para ser mostrado en la vista de motivos.
   * @param {HTMLElement} btnPregunta - Botón de la pregunta.
   * @param {number} index - Índice de la pregunta.
   */
  prepararConflicto (btnPregunta, index) {
    btnPregunta.id = 'idConflicto' + index
    btnPregunta.onclick = this.prepararMotivos.bind(this)
  }

  /**
   * Prepara la vista de soluciones para mostrar las soluciones de un problema.
   * @param {Event} event - Evento de clic en el botón de la pregunta.
   */
  prepararSoluciones (event) {
    const idProblema = event.target.id.slice(-1)
    this.controlador.cambiarSoluciones(this.idContinente, idProblema)
    this.controlador.verVista(Vista.VISTAPROBLEMA)
  }

  /**
   * Prepara la vista de motivos para mostrar los motivos de un conflicto.
   * @param {Event} event - Evento de clic en el botón de la pregunta.
   */
  prepararMotivos (event) {
    const idConflicto = event.target.id.slice(-1)
    this.controlador.cambiarMotivos(this.idContinente, idConflicto)
    this.controlador.verVista(Vista.VISTACONFLICTO)
  }

  /**
   * Muestra el nombre en la vista del continente.
   * @param {string} nombre - Nombre a mostrar.
   */
  mostrarNombre (nombre) {
    this.h2Nombre.textContent = nombre
  }

  /**
   * Muestra la información en la vista del continente.
   * @param {string} info - Información a mostrar.
   */
  mostrarInformacion (info) {
    this.infoContinente.textContent = info
  }

  /**
   * Modifica la imagen en la vista del continente.
   * @param {string|null} img - Nombre del archivo de imagen o null si no hay imagen.
   */
  modificarImagen (img) {
    if (img == null) {
      this.imagenContinente.style.display = 'none'
    } else {
      this.imagenContinente.src = 'img/' + img
      this.imagenContinente.style = 'block'
    }
  }
}
