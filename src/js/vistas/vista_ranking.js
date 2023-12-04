import { Vista } from './vista.js'

/**
 * Clase que representa la vista del ranking en la aplicación.
 * @extends Vista
 */
export class VistaRanking extends Vista {
  /**
   * Construye una instancia de la clase VistaRanking.
   * @constructor
   * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
   * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del ranking.
   */
  constructor (controlador, base) {
    super(controlador, base)
    this.filas = this.base.getElementsByTagName('tr')

    this.enlaceInicio = this.base.querySelector('.verMenu')
  }

  /**
   * Actualiza la vista del ranking con la información proporcionada.
   * @param {Object} ranking - Información del ranking.
   */
  actualizarRanking (ranking) {
    for (const [index, fila] of ranking.filas.entries()) {
      this.actualizarFila(fila, index)
    }
  }
  
  actualizarFila(fila,index){
    const filaRanking = this.filas[index+1]
    filaRanking.getElementsByTagName('td')[0].textContent = fila['nombreJugador']
    filaRanking.getElementsByTagName('td')[1].textContent = "Puntuación: "+fila['puntuacion']
  }

  /**
   * Actualiza una fila específica en la tabla de ranking.
   * @param {Object} fila - Información de la fila del ranking.
   * @param {number} index - Índice de la fila en la tabla.
   */
  actualizarFila (fila, index) {
    const filaRanking = this.filas[index + 1]
    filaRanking.getElementsByTagName('td')[0].textContent = fila.nombreJugador
    filaRanking.getElementsByTagName('td')[1].textContent = 'Puntuación: ' + fila.puntuacion
  }

  /**
   * Cambia el enlace del botón de inicio para regresar al mapa.
   */
  cambiarEnlaceMapa () {
    this.enlaceInicio.onclick = () => { this.controlador.verVista(Vista.VISTAMAPA) }
  }

  /**
   * Cambia el enlace del botón de inicio para regresar al menú.
   */
  cambiarEnlaceInicio () {
    this.enlaceInicio.onclick = () => { this.controlador.verVista(Vista.VISTAMENU) }
  }
}
