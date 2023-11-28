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

    // Nombre para mostrar en la vista continente
    this.mostrarInformacion('NOMBRE DEL CONTINENTE')

    // Coger referencias del interfaz
    /** @type {HTMLElement} */
    this.boton1 = this.base.getElementsByClassName('problema')[0]
    /** @type {HTMLElement} */
    this.boton2 = this.base.getElementsByClassName('problema')[1]
    /** @type {HTMLElement} */
    this.boton3 = this.base.getElementsByClassName('problema')[2]

    this.boton1.addEventListener('click', this.prepararSoluciones.bind(this))
    this.boton2.addEventListener('click', this.prepararSoluciones.bind(this))
    this.boton3.addEventListener('click', this.prepararMotivos.bind(this))

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

  prepararSoluciones(event){
    this.controlador.resetearProblema();
    this.controlador.modificarSoluciones(event.target.id);
    this.controlador.verVista(Vista.VISTA6)
  }

  prepararMotivos(event){
    this.controlador.resetearConflicto();
    this.controlador.modificarMotivos(event.target.id);
    this.controlador.verVista(Vista.VISTA8)
  }

  /**
   * Función para mostrar Nombres en la vista continente.
   * @param {string} Nombre - Nombre a mostrar.
   */
  mostrarInformacion (Nombre) {
    const NombreElemento = document.createElement('h2')
    NombreElemento.textContent = Nombre

    const NombreContainer = this.base.querySelector('#nombreContinente')
    NombreContainer.appendChild(NombreElemento)

    const NombreContainer2 = this.base.querySelector('#infoContinente')
    NombreContainer2.textContent = Nombre
    NombreContainer.appendChild(NombreElemento)
  }

  actualizarPuntuacionEnInterfaz () {
    const puntuacionElemento = this.base.querySelector('.puntosMensaje')
    if (puntuacionElemento) {
      const puntuacionActual = this.controlador.obtenerPuntuacionActual()
      puntuacionElemento.textContent = `Puntuación: ${puntuacionActual}`
    }
  }

  modificarPregunta (pregunta, index) {
    const botonRespuesta = this.base.getElementsByClassName('problema')[index]
    botonRespuesta.textContent = pregunta.texto
    botonRespuesta.id = 'idPregunta'+pregunta.id
  }
}
