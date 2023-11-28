import { Vista } from './vista.js'
import { Rest } from '../servicios/rest.js'

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
    super(controlador, base, Vista.VISTA6)

    this.respuestasCorrectas = [false,false,false]
    this.respuestasSeleccionadas = [false,false,false]

    this.idContinente = 0;
    // Agregar un event listener para el evento de pulsación de tecla
    document.addEventListener('keydown', this.irAtras.bind(this))

    // Pregunta para mostrar en la vista de la pregunta
    this.mostrarPregunta('¿Cuál es la capital de este continente?')
    this.actualizarPuntuacionEnInterfaz()

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.verVista(Vista.VISTA2))

    this.enlaceRanking = this.base.querySelector('.verRanking')
    this.enlaceRanking.addEventListener('click', () => this.controlador.mostrarRankingActualizado())

    const divOpciones1 = this.base.getElementsByClassName('opcionesContainer')[0]
    this.solucion1 = divOpciones1.getElementsByTagName('button')[0]
    const divOpciones2 = this.base.getElementsByClassName('opcionesContainer')[1]
    this.solucion2 = divOpciones2.getElementsByTagName('button')[0]
    const divOpciones3 = this.base.getElementsByClassName('opcionesContainer')[2]
    this.solucion3 = divOpciones3.getElementsByTagName('button')[0]

    
    this.solucion1.onclick = this.seleccionarRespuestaProblema.bind(this);
    this.solucion2.onclick = this.seleccionarRespuestaProblema.bind(this);
    this.solucion3.onclick = this.seleccionarRespuestaProblema.bind(this);


    const botonResponder = document.getElementById('botonAceptar')
    botonResponder.addEventListener('click',this.responder)
  }

  /**
   * Método para realizar una solicitud AJAX y manejar la respuesta.
   */
  llamarAjax = () => {
    // Recojo valores y hago validaciones
    const i1Value = document.getElementById('respuesta1').value
    const i2Value = document.getElementById('respuesta2').value

    const params = {
      param1: i1Value,
      param2: i2Value
    }

    // Asegúrate de que Rest.post esté implementado adecuadamente
    Rest.post('js/servicios/ajax1.php', params, this.verResultadoAJAX)
  }

  modificarRespuesta (respuesta, id) {
    const botonRespuesta = document.getElementById('solucion'+id)
    botonRespuesta.textContent = respuesta.texto
    if(respuesta.correcto){
      this.respuestasCorrectas[id-1] = true
    } else{
      this.respuestasCorrectas[id-1] = false
    }
  }

  
  modificarInformacionProblema(problema){
    
  }

  resetearSeleccion (){
    this.respuestasSeleccionadas.fill(false)
    this.solucion1.classList.remove('marcado')
    this.solucion2.classList.remove('marcado')
    this.solucion3.classList.remove('marcado')
  }

  /**
   * Método para mostrar el resultado de la solicitud AJAX.
   * @param {Object} respuesta - Objeto que representa la respuesta de la solicitud.
   */
  verResultadoAJAX = (respuesta) => {
    console.log(respuesta)
    const p = document.createElement('p')
    document.body.appendChild(p)
    p.textContent = respuesta.atrib1 + ' ' + respuesta.atrib2
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
     * Función para mostrar preguntas en la vista de la pregunta.
     * @param {string} pregunta - Pregunta a mostrar.
     */
  mostrarPregunta (pregunta) {
    const preguntaElemento = document.createElement('p')
    preguntaElemento.textContent = pregunta

    const preguntaContainer = this.base.querySelector('.preguntaContainer')
    preguntaContainer.appendChild(preguntaElemento)
  }

  /**
     * Función para manejar la respuesta del usuario.
     * @param {number} opcionSeleccionada - Índice de la opción seleccionada.
     */
  responder (event) {
    let opcionSeleccionada = event.target.id
    if (opcionSeleccionada == 'respuesta1') {
      console.log('Respuesta correcta')
      this.controlador.acertarPregunta()
      this.actualizarPuntuacionEnInterfaz()
    } else {
      console.log('Respuesta incorrecta')
    }
  }

  /**
   * Método para actualizar la puntuación en la interfaz.
   */
  actualizarPuntuacionEnInterfaz () {
    const puntuacionElemento = this.base.querySelector('.puntosMensaje')
    if (puntuacionElemento) {
      const puntuacionActual = this.controlador.obtenerPuntuacionActual()
      console.log(puntuacionActual)
      puntuacionElemento.textContent = `Puntuación: ${puntuacionActual}`
    }
  }

  seleccionarRespuestaProblema(event) {
    let idSeleccionado = event.target.id.slice(-1)-1
    if(!event.target.classList.contains('marcado')){
      event.target.classList.add('marcado')
      this.respuestasSeleccionadas[idSeleccionado] = true;
    }else{
      event.target.classList.remove('marcado')
      this.respuestasSeleccionadas[idSeleccionado] = false;
    }
    console.log(this.respuestasSeleccionadas)
  }
}
