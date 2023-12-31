import { Vista } from './vista.js'

/**
 * Clase que representa la vista de una pregunta en la aplicación.
 * @extends Vista
 */
export class VistaConflicto extends Vista {
  /**
   * Construye una instancia de la clase VistaPregunta.
   * @constructor
   * @param {controlador} controlador - Instancia del controlador asociada a la vista.
   * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista de la pregunta.
   */
  constructor (controlador, base) {
    super(controlador, base)

    this.respuestaCorrecta = 0
    this.respuestaSeleccionada = 0

    this.divInfoConflicto = document.querySelector('#informacionConflicto')
    this.imagenConflicto = document.querySelector('#imagenConflicto')

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.comprobarContinentesMapa(this.idContinente))

    const divOpciones1 = this.base.getElementsByClassName('opcionesContainer')[0]
    this.motivo1 = divOpciones1.getElementsByTagName('button')[0]
    const divOpciones2 = this.base.getElementsByClassName('opcionesContainer')[1]
    this.motivo2 = divOpciones2.getElementsByTagName('button')[0]
    const divOpciones3 = this.base.getElementsByClassName('opcionesContainer')[2]
    this.motivo3 = divOpciones3.getElementsByTagName('button')[0]

    this.restaurarBotones(this.motivo1)
    this.restaurarBotones(this.motivo2)
    this.restaurarBotones(this.motivo3)

    this.botonResponder = document.getElementById('botonAceptarConflicto')
    this.botonResponder.addEventListener('click', this.responder.bind(this))
    this.botonContinuar = document.getElementById('botonContinuarConflicto')
    this.botonContinuar.addEventListener('click', this.continuar.bind(this))
  }

  /**
   * Actualiza la vista del conflicto con la información proporcionada.
   * @param {object} conflicto - Objeto que contiene la información del conflicto.
   * @param {string} idContinente - Identificador del continente al que pertenece el conflicto.
   * @param {string} idConflicto - Identificador único del conflicto.
   */
  actualizarConflicto (conflicto, idContinente, idConflicto) {
    this.resetearSeleccion()
    this.restaurarBotones(this.motivo1)
    this.restaurarBotones(this.motivo2)
    this.restaurarBotones(this.motivo3)
    this.botonResponder.style.display = 'block'
    this.botonContinuar.style.display = 'none'
    this.mostrarPregunta(conflicto.titulo)
    this.modificarInformacion(conflicto.informacion)
    this.modificarImagen(conflicto.imagen)

    this.fecha = conflicto.fechaInicio
    this.idContinente = idContinente
    this.idConflicto = idConflicto
    for (const [index, solucion] of conflicto.respuestas.entries()) {
      this.modificarRespuesta(index, solucion, conflicto.numMotivo)
    };
  }

  /**
   * Restaura la funcionalidad de los botones de respuesta.
   * @param {HTMLElement} boton - Botón de respuesta.
   */
  restaurarBotones (boton) {
    boton.onclick = this.seleccionarMotivo.bind(this)
  }

  /**
   * Elimina la funcionalidad de los botones de respuesta.
   * @param {HTMLElement} boton - Botón de respuesta.
   */
  eliminarClickBotones (boton) {
    boton.onclick = ''
  }

  /**
   * Modifica la información del conflicto en la vista.
   * @param {string} info - Información del conflicto.
   */
  modificarInformacion (info) {
    this.divInfoConflicto.textContent = info
  }

  /**
   * Modifica una respuesta específica del conflicto en la vista.
   * @param {number} id - Identificador de la respuesta.
   * @param {object} motivo - Objeto que contiene la información del motivo de la respuesta.
   * @param {number} numMotivo - Número del motivo de la respuesta.
   */
  modificarRespuesta (id, motivo, numMotivo) {
    const idBoton = id + 1
    const botonRespuesta = document.getElementById('motivo' + idBoton)
    botonRespuesta.textContent = motivo.textoMotivo
    if (motivo.numMotivo == numMotivo) { // eslint-disable-line eqeqeq
      this.respuestaCorrecta = idBoton
    }
  }

  /**
   * Modifica la imagen del conflicto en la vista.
   * @param {string|null} img - Nombre del archivo de imagen o null si no hay imagen.
   */
  modificarImagen (img) {
    if (img == null) {
      this.imagenConflicto.style.display = 'none'
    } else {
      this.imagenConflicto.src = 'img_subidas/' + img
      this.imagenConflicto.style.display = 'block'
    }
  }

  /**
   * Resetea la selección del usuario.
   */
  resetearSeleccion () {
    this.respuestaSeleccionada = 0
    this.motivo1.className = ''
    this.motivo2.className = ''
    this.motivo3.className = ''
  }

  /**
   * Muestra la pregunta en la vista del conflicto.
   * @param {string} pregunta - Pregunta a mostrar.
   */
  mostrarPregunta (pregunta) {
    const preguntaElemento = document.createElement('p')
    preguntaElemento.textContent = pregunta

    const preguntaContainer = this.base.querySelector('.preguntaContainer')
    preguntaContainer.textContent = ''
    preguntaContainer.appendChild(preguntaElemento)
  }

  /**
   * Maneja la respuesta del usuario.
   */
  responder () {
    if (this.respuestaSeleccionada !== 0) {
      this.botonResponder.style.display = 'none'
      this.botonContinuar.style.display = 'block'
      this.eliminarClickBotones(this.motivo1)
      this.eliminarClickBotones(this.motivo2)
      this.eliminarClickBotones(this.motivo3)
      eval('this.motivo' + this.respuestaCorrecta).classList.add('respuestaCorrecta') // eslint-disable-line no-eval
      if (this.respuestaSeleccionada == this.respuestaCorrecta) { // eslint-disable-line eqeqeq
        this.controlador.acertarPregunta()
      } else {
        eval('this.motivo' + this.respuestaSeleccionada).classList.add('respuestaIncorrecta') // eslint-disable-line no-eval
      }
      this.controlador.eliminarFila(this.idContinente, this.idConflicto)
    }
  }

  /**
   * Maneja el evento de seleccionar un motivo.
   * @param {Event} event - Evento de clic en el botón de motivo.
   */
  seleccionarMotivo (event) {
    const idRespuestaSeleccionada = event.target.id.match(/\d+$/)[0]
    if (event.target.classList.contains('marcado')) {
      event.target.classList.remove('marcado')
      this.respuestaSeleccionada = 0
    } else {
      this.motivo1.classList.remove('marcado')
      this.motivo2.classList.remove('marcado')
      this.motivo3.classList.remove('marcado')
      event.target.classList.add('marcado')
      this.respuestaSeleccionada = idRespuestaSeleccionada
    }
  }

  /**
   * Continúa con la siguiente vista después de responder el conflicto.
   */
  continuar () {
    this.controlador.cambiarFecha(this.fecha, this.idContinente)
    this.resetearSeleccion()
    this.controlador.verVista(Vista.VISTAFECHA)
  }
}
