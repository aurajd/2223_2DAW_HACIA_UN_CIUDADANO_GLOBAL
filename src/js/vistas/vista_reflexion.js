import { Vista } from './vista.js'

export class VistaReflexion extends Vista {
  constructor (controlador, base) {
    super(controlador, base)
    this.divReflexion = document.getElementById("fraseReflexion")
    this.botonVolver = document.getElementById("botonVolverReflexion")
    this.botonVolver.addEventListener('click', () => this.controlador.comprobarContinentesCambiar(this.idContinente))

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.comprobarContinentesMapa(this.idContinente))
  }

  actualizarReflexion(reflexion, idContinente){
    this.divReflexion.textContent = reflexion
    this.idContinente = idContinente
  }
}
