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

    this.divInfoProblema = document.querySelector("#informacionProblema")
    this.imagenProblema = document.querySelector("#imagenProblema")
    // Agregar un event listener para el evento de pulsación de tecla
    document.addEventListener('keydown', this.irAtras.bind(this))

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

    this.idContinente = ''
    this.idProblema = ''
    const botonResponder = document.getElementById('botonAceptarProblema')
    botonResponder.addEventListener('click',this.responder)
  }

  actualizarProblema(problema,idContinente,idProblema){
    this.resetearSeleccion();
    this.mostrarPregunta(problema["titulo"])
    this.modificarInformacion(problema["informacion"]);
    this.modificarImagen(problema["imagen"])
    let i = 0;
    this.idContinente = idContinente;
    this.idProblema = idProblema;

    for (let [index,solucion] of problema["respuestas"].entries()){
      this.modificarRespuesta(index,solucion)
    };
  }

  modificarInformacion(info){
    this.divInfoProblema.textContent = info
  }

  modificarImagen(img){
    if(img == null){
      this.imagenProblema.style.display = "none";
    }else{
      this.imagenProblema.src = "img/"+img
      this.imagenProblema.style.display = "block";
    }
  }

  modificarRespuesta (id,solucion) {
    let idBoton = id+1
    const botonRespuesta = document.getElementById('solucion'+idBoton)
    botonRespuesta.textContent = solucion["textoSolucion"]
    if(solucion["correcta"]){
      this.respuestasCorrectas[id] = true
    } else{
      this.respuestasCorrectas[id] = false
    }
  }

  resetearSeleccion (){
    this.respuestasSeleccionadas.fill(false)
    this.solucion1.classList.remove('marcado')
    this.solucion2.classList.remove('marcado')
    this.solucion3.classList.remove('marcado')
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
    preguntaContainer.textContent = ""
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
    console.log("respuestas seleccionadas:"+this.respuestasSeleccionadas)
    console.log("respuestas correctas:"+this.respuestasCorrectas)
  }
}
