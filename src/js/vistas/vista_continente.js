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

    this.h2Nombre = document.querySelector("#nombreContinente") 
    this.imagenContinente = document.querySelector("#imagenInfo")

    this.infoContinente = document.querySelector("#informacionContinente")

    this.divsPreguntas = this.base.getElementsByClassName('opcionesContainer')

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.verVista(Vista.VISTA2))

    this.enlaceRanking = this.base.querySelector('.verRanking')
    this.enlaceRanking.addEventListener('click', () => this.controlador.mostrarRankingActualizado())

    this.idContinente = ''


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

  async actualizarContinente(preguntas,id){
    const continente = await this.controlador.devolverContinente(id);
    for (let divsPregunta of this.divsPreguntas) {
      divsPregunta.textContent= ''
    }
    let i = 0;
    this.idContinente = id;
    this.modificarImagen(continente["imagen"])
    this.mostrarNombre(continente["nombre"])
    this.mostrarInformacion(continente["informacion"])
    for (let [index,pregunta] of preguntas.entries()){
      const btnPregunta = document.createElement("button");
      btnPregunta.classList.add('problema')
      btnPregunta.textContent = pregunta["titulo"]
      if(pregunta["tipo"]=="problema"){
        this.prepararProblema(btnPregunta,index)
      }else{
        this.prepararConflicto(btnPregunta,index)
      }
      this.divsPreguntas[i++].appendChild(btnPregunta)
    }
  }

  prepararProblema(btnPregunta,index){
    btnPregunta.id = "idProblema"+index
    btnPregunta.onclick = this.prepararSoluciones.bind(this)
  }

  prepararConflicto(btnPregunta,index){
    btnPregunta.id = "idConflicto"+index
    btnPregunta.onclick = this.prepararMotivos.bind(this)
  }

  prepararSoluciones(event){
    let idProblema = event.target.id.slice(-1)
    this.controlador.cambiarSoluciones(this.idContinente,idProblema);
    this.controlador.verVista(Vista.VISTA6)
  }

  prepararMotivos(event){
    let idConflicto = event.target.id.slice(-1)
    this.controlador.cambiarMotivos(this.idContinente,idConflicto);
    this.controlador.verVista(Vista.VISTA8)
  }

  /**
   * Función para mostrar Nombres en la vista continente.
   * @param {string} Nombre - Nombre a mostrar.
   */
  mostrarNombre(nombre) {
    this.h2Nombre.textContent = nombre
  }

  mostrarInformacion (info) {
    this.infoContinente.textContent = info
  }

  modificarImagen(img){
    if(img == null){
      this.imagenContinente.style.display = "none"
    }else{
      this.imagenContinente.src = "img/"+img
      this.imagenContinente.style = "block";
    }

  }

}
