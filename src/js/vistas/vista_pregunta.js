import { Vista } from './vista.js'
import { Rest } from '../servicios/rest.js'

/**
 * Clase que representa la vista de un continente en la aplicación.
 * @extends Vista
 */
export class VistaPregunta extends Vista {
  /**
     * Construye una instancia de la clase Vista_continente.
     * @constructor
     * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
     * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del continente.
     */
  constructor (controlador, base) {
    super(controlador, base, Vista.VISTA6)

    // Agregar un event listener para el evento de pulsación de tecla
    document.addEventListener('keydown', this.irAtras.bind(this))
    // Pregunta para mostrar en la vista continente
    this.mostrarPregunta('¿Cuál es la capital de este continente?')
    this.actualizarPuntuacionEnInterfaz()

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
     * Función para mostrar preguntas en la vista continente.
     * @param {string} pregunta - Pregunta a mostrar.
     */
  mostrarPregunta (pregunta) {
    const preguntaElemento = document.createElement('p')
    preguntaElemento.textContent = pregunta

    const preguntaContainer = this.base.querySelector('#preguntaContainer')
    preguntaContainer.appendChild(preguntaElemento)
  }

  /**
     * Función para manejar la respuesta del usuario.
     * @param {number} opcionSeleccionada - Índice de la opción seleccionada.
     */

  responder (opcionSeleccionada) {
    // Obtener la URL correcta para la solicitud GET
    const url = 'https://opendata.aemet.es/opendata/api/observacion/convencional/todas?api_key=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJtbmlldG9iZW5pdGV6Lmd1YWRhbHVwZUBhbHVtbmFkby5mdW5kYWNpb25sb3lvbGEubmV0IiwianRpIjoiZDQzMDE0ZTctZmY5OS00OTc2LWExYzYtYWY3NTE0MWQxNzM4IiwiaXNzIjoiQUVNRVQiLCJpYXQiOjE3MDAyMDk1ODcsInVzZXJJZCI6ImQ0MzAxNGU3LWZmOTktNDk3Ni1hMWM2LWFmNzUxNDFkMTczOCIsInJvbGUiOiIifQ.aQyVYfeUFTx0wDjDVX3y5ahE1nNN7zULVhL0-DCjyKU' // Reemplaza con la URL correcta

    // Realizar la petición GET para obtener información sobre continentes
    Rest.getContinentInfo(url, data => {
      console.log('Información de continentes:', data)
      // Puedes realizar acciones adicionales en función de la respuesta de la API
    })

    // Resto del código de la función responder
    if (opcionSeleccionada === 1) {
      console.log('Respuesta correcta')
      this.controlador.acertarPregunta()
      this.actualizarPuntuacionEnInterfaz()
    } else {
      console.log('Respuesta incorrecta')
    }
  }

  actualizarPuntuacionEnInterfaz () {
    const puntuacionElemento = this.base.querySelector('#puntuacion')
    if (puntuacionElemento) {
      const puntuacionActual = this.controlador.obtenerPuntuacionActual()
      puntuacionElemento.textContent = `Puntuación: ${puntuacionActual}`
    }
  }
}
