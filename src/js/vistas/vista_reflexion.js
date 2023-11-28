import { Vista } from './vista.js'

export class VistaReflexion extends Vista {
  constructor (controlador, base) {
    super(controlador, base)
  }

  actualizarPuntuacionEnInterfaz () {
    const puntuacionElemento = this.base.querySelector('.puntosMensaje')
    if (puntuacionElemento) {
      
      const puntuacionActual = this.controlador.obtenerPuntuacionActual()
      puntuacionElemento.textContent = `Puntuación: ${puntuacionActual}`
    }
  }
}
