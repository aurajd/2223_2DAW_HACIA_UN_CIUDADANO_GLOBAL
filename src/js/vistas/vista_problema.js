import { Vista } from './vista.js'
/**
 * Clase que representa la vista de una pregunta en la aplicación.
 * @extends Vista
 */
export class VistaProblema extends Vista {
  /**
     * Construye una instancia de la clase VistaPregunta.
     * @constructor
     * @param {controlador} controlador - Instancia del controlador asociada a la vista.
     * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista de la pregunta.
     */
  constructor (controlador, base) {
    super(controlador, base, Vista.VISTAPROBLEMA)

    this.respuestasCorrectas = [false, false, false]
    this.respuestasSeleccionadas = [false, false, false]

    this.divInfoProblema = document.querySelector('#informacionProblema')
    this.imagenProblema = document.querySelector('#imagenProblema')

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.comprobarContinentesMapa(this.idContinente))

    const divOpciones1 = this.base.getElementsByClassName('opcionesContainer')[0]
    this.solucion1 = divOpciones1.getElementsByTagName('button')[0]
    const divOpciones2 = this.base.getElementsByClassName('opcionesContainer')[1]
    this.solucion2 = divOpciones2.getElementsByTagName('button')[0]
    const divOpciones3 = this.base.getElementsByClassName('opcionesContainer')[2]
    this.solucion3 = divOpciones3.getElementsByTagName('button')[0]

    this.restaurarBotones(this.solucion1)
    this.restaurarBotones(this.solucion2)
    this.restaurarBotones(this.solucion3)

    this.botonResponder = document.getElementById('botonAceptarProblema')
    this.botonResponder.addEventListener('click', this.responder.bind(this))

    this.botonContinuar = document.getElementById('botonContinuarProblema')
    this.botonContinuar.addEventListener('click', this.continuar.bind(this))
  }

  /**
   * Actualiza la vista con la información del problema.
   * @param {Object} problema - Información del problema.
   * @param {string} idContinente - ID del continente asociado al problema.
   * @param {string} idProblema - ID del problema.
   */
  actualizarProblema (problema, idContinente, idProblema) {
    this.resetearSeleccion()
    this.mostrarPregunta(problema.titulo)
    this.modificarInformacion(problema.informacion)
    this.modificarImagen(problema.imagen)

    this.idContinente = idContinente
    this.idProblema = idProblema
    this.reflexion = problema.reflexion

    this.restaurarBotones(this.solucion1)
    this.restaurarBotones(this.solucion2)
    this.restaurarBotones(this.solucion3)

    this.botonResponder.style.display = 'block'
    this.botonContinuar.style.display = 'none'

    for (const [index, solucion] of problema.respuestas.entries()) {
      this.modificarRespuesta(index, solucion)
    };
  }

  /**
   * Restaura las funciones de clic para un botón de solución.
   * @param {HTMLElement} boton - Botón de solución.
   */
  restaurarBotones (boton) {
    boton.onclick = this.seleccionarRespuestaProblema.bind(this)
  }

  /**
   * Elimina las funciones de clic para un botón de solución.
   * @param {HTMLElement} boton - Botón de solución.
   */
  eliminarClickBotones (boton) {
    boton.onclick = ''
  }

  /**
   * Modifica la información del problema en la interfaz.
   * @param {string} info - Información del problema.
   */
  modificarInformacion (info) {
    this.divInfoProblema.textContent = info
  }

  /**
   * Modifica la imagen del problema en la interfaz.
   * @param {string} img - Nombre del archivo de imagen.
   */
  modificarImagen (img) {
    if (img == null) {
      this.imagenProblema.style.display = 'none'
    } else {
      this.imagenProblema.src = 'img_subidas/' + img
      this.imagenProblema.style.display = 'block'
    }
  }

  /**
   * Modifica la respuesta en un botón de solución.
   * @param {number} id - Índice de la respuesta.
   * @param {Object} solucion - Información de la respuesta.
   */
  modificarRespuesta (id, solucion) {
    const idBoton = id + 1
    const botonRespuesta = document.getElementById('solucion' + idBoton)
    botonRespuesta.textContent = solucion.textoSolucion
    if (solucion.correcta) {
      this.respuestasCorrectas[id] = true
    } else {
      this.respuestasCorrectas[id] = false
    }
  }

  /**
   * Restablece la selección de respuestas y las clases de los botones.
   */
  resetearSeleccion () {
    this.respuestasSeleccionadas.fill(false)
    this.solucion1.className = ''
    this.solucion2.className = ''
    this.solucion3.className = ''
  }

  /**
   * Muestra la pregunta en la interfaz.
   * @param {string} pregunta - Texto de la pregunta.
   */
  mostrarPregunta (pregunta) {
    const preguntaElemento = document.createElement('p')
    preguntaElemento.textContent = pregunta

    const preguntaContainer = this.base.querySelector('.preguntaContainer')
    preguntaContainer.textContent = ''
    preguntaContainer.appendChild(preguntaElemento)
  }

  /**
   * Maneja la respuesta del usuario al problema.
   */
  responder () {
    if (this.respuestasSeleccionadas.includes(true)) {
      this.botonResponder.style.display = 'none'
      this.botonContinuar.style.display = 'block'
      this.eliminarClickBotones(this.solucion1)
      this.eliminarClickBotones(this.solucion2)
      this.eliminarClickBotones(this.solucion3)
      if (this.respuestasSeleccionadas.toString() === this.respuestasCorrectas.toString()) {
        this.controlador.acertarPregunta()
      }
      for (const [index, respuesta] of this.respuestasSeleccionadas.entries()) {
        if (respuesta) {
          if (this.respuestasCorrectas[index]) {
            eval('this.solucion' + (index + 1)).classList.add('respuestaCorrecta') // eslint-disable-line no-eval
          } else {
            eval('this.solucion' + (index + 1)).classList.add('respuestaIncorrecta') // eslint-disable-line no-eval
          }
        } else {
          if (this.respuestasCorrectas[index]) {
            eval('this.solucion' + (index + 1)).classList.add('respuestaCorrectaNoMarcada') // eslint-disable-line no-eval
          }
        }
      }

      this.controlador.eliminarFila(this.idContinente, this.idProblema)
    }
  }

  /**
   * Maneja el evento de selección de respuesta por parte del usuario.
   * @param {Event} event - Objeto que representa el evento de clic.
   */
  seleccionarRespuestaProblema (event) {
    const idSeleccionado = event.target.id.slice(-1) - 1
    if (!event.target.classList.contains('marcado')) {
      event.target.classList.add('marcado')
      this.respuestasSeleccionadas[idSeleccionado] = true
    } else {
      event.target.classList.remove('marcado')
      this.respuestasSeleccionadas[idSeleccionado] = false
    }
  }

  /**
   * Maneja el evento de clic en el botón "Continuar".
   */
  continuar () {
    this.controlador.cambiarReflexion(this.reflexion, this.idContinente)
    this.resetearSeleccion()
    this.controlador.verVista(Vista.VISTAREFLEXION)
  }
}
