import { Vista } from './vista.js'
import { Rest } from '../servicios/rest.js'

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

    this.respuestaCorrecta = 0;
    this.respuestaSeleccionada = 0;

    this.divInfoConflicto = document.querySelector("#informacionConflicto")
    this.imagenConflicto = document.querySelector("#imagenConflicto")
    // Agregar un event listener para el evento de pulsación de tecla
    document.addEventListener('keydown', this.irAtras.bind(this))

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.verVista(Vista.VISTA2))

    this.enlaceRanking = this.base.querySelector('.verRanking')
    this.enlaceRanking.addEventListener('click', () => this.controlador.mostrarRankingActualizado())

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
    this.botonResponder.addEventListener('click',this.responder.bind(this))
    this.botonContinuar = document.getElementById('botonContinuarConflicto')
    this.botonContinuar.addEventListener('click',this.continuar.bind(this))
  }

  actualizarConflicto(conflicto,idContinente,idConflicto){
    this.resetearSeleccion();
    this.restaurarBotones(this.motivo1)
    this.restaurarBotones(this.motivo2)
    this.restaurarBotones(this.motivo3)
    this.botonResponder.style.display = "block";
    this.botonContinuar.style.display = "none";
    this.mostrarPregunta(conflicto["titulo"])
    this.modificarInformacion(conflicto["informacion"]);
    this.modificarImagen(conflicto["imagen"])
    let i = 0;
    this.fecha = conflicto["fechaInicio"]
    this.idContinente = idContinente;
    this.idConflicto = idConflicto;
    for (let [index,solucion] of conflicto["respuestas"].entries()){
      this.modificarRespuesta(index,solucion,conflicto["numMotivo"])
    };
  }

  restaurarBotones(boton){
    boton.onclick = this.seleccionarMotivo.bind(this);
  }

  eliminarClickBotones(boton){
    boton.onclick = "";
  }

  modificarInformacion(info){
    this.divInfoConflicto.textContent = info
  }

  modificarRespuesta (id,motivo,numMotivo) {
    let idBoton = id+1
    const botonRespuesta = document.getElementById('motivo'+idBoton)
    botonRespuesta.textContent = motivo["textoMotivo"]
    if(motivo["numMotivo"]==numMotivo){
      this.respuestaCorrecta = idBoton
    }
  }

  modificarImagen(img){
    if(img == null){
      this.imagenConflicto.style.display = "none";
    }else{
      this.imagenConflicto.src = "img/"+img
      this.imagenConflicto.style.display = "block";
    }
  }

  resetearSeleccion (){
    this.respuestaSeleccionada = 0
    this.motivo1.className = ""
    this.motivo2.className = ""
    this.motivo3.className = ""
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
  responder () {
    if(this.respuestaSeleccionada !==0){
      this.botonResponder.style.display = "none";
      this.botonContinuar.style.display = "block";
      this.eliminarClickBotones(this.motivo1);
      this.eliminarClickBotones(this.motivo2);
      this.eliminarClickBotones(this.motivo3);
      eval('this.motivo' + this.respuestaCorrecta).classList.add ("respuestaCorrecta")
      if (this.respuestaSeleccionada == this.respuestaCorrecta) {
        console.log('Respuesta correcta')
        this.controlador.acertarPregunta()
      } else {
        eval('this.motivo' + this.respuestaSeleccionada).classList.add ("respuestaIncorrecta")
        console.log('Respuesta incorrecta')
      }
      this.controlador.eliminarFila(this.idContinente,this.idConflicto)
      this.controlador.comprobarFilasContinente(this.idContinente)
    }
  }

  seleccionarMotivo(event) {
    let idRespuestaSeleccionada = event.target.id.match(/\d+$/)[0]
    if(event.target.classList.contains('marcado')){
      event.target.classList.remove('marcado')
      this.respuestaSeleccionada = 0;
    }else{
      this.motivo1.classList.remove('marcado')
      this.motivo2.classList.remove('marcado')
      this.motivo3.classList.remove('marcado')
      event.target.classList.add('marcado')
      this.respuestaSeleccionada = idRespuestaSeleccionada;
    }
    console.log("respuesta seleccionada:"+this.respuestaSeleccionada)
    console.log("respuesta correcta:"+this.respuestaCorrecta)
  }

  continuar(){
    this.controlador.cambiarFecha(this.fecha)
    this.resetearSeleccion();
    this.controlador.verVista(Vista.VISTA9)
  }
}
