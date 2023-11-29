import { Vista } from './vista.js'

export class VistaReflexion extends Vista {
  constructor (controlador, base) {
    super(controlador, base)
    this.divReflexion = document.getElementById("fraseReflexion")
    this.botonVolver = document.getElementById("botonVolverReflexion")
    this.botonVolver.addEventListener('click', () => this.controlador.verVista(Vista.VISTA2))

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.verVista(Vista.VISTA1))

    this.enlaceRanking = this.base.querySelector('.verRanking')
    this.enlaceRanking.addEventListener('click', () => this.controlador.mostrarRankingActualizado())
  }

  actualizarReflexion(reflexion){
    this.divReflexion.textContent = reflexion
  }
}
