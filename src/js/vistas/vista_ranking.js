import { Vista } from './vista.js'

/**
 * Clase que representa la vista del ranking en la aplicación.
 * @extends Vista
 */
export class VistaRanking extends Vista {
  /**
     * Construye una instancia de la clase Vista_ranking.
     * @constructor
     * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
     * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del ranking.
     */
  constructor (controlador, base) {
    super(controlador, base)
    this.filas = this.base.getElementsByTagName('tr')

    this.enlaceInicio = this.base.querySelector('.verMenu')
  }

  actualizarRanking(ranking){
    for(let [index, fila] of ranking.filas.entries()){
        this.actualizarFila(fila,index)
    }
  }
  
  actualizarFila(fila,index){
    const filaRanking = this.filas[index+1]
    filaRanking.getElementsByTagName('td')[0].textContent = fila['nombreJugador']
    filaRanking.getElementsByTagName('td')[1].textContent = "Puntuación: "+fila['puntuacion']
  }

  cambiarEnlaceMapa(){
    this.enlaceInicio.onclick = () => {this.controlador.verVista(Vista.VISTAMAPA)}
  }

  cambiarEnlaceInicio(){
    this.enlaceInicio.onclick = () => {this.controlador.verVista(Vista.VISTAMENU)}
  }
}
