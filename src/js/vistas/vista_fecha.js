import { Vista } from './vista.js'

export class VistaFecha extends Vista {
  constructor (controlador, base) {
    super(controlador, base)

    this.divFecha = document.getElementById("fraseFecha")
    this.botonVolver = document.getElementById("botonVolverFecha")
    this.botonVolver.addEventListener('click', () => this.controlador.verVista(Vista.VISTA2))

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.verVista(Vista.VISTA1))

    this.enlaceRanking = this.base.querySelector('.verRanking')
    this.enlaceRanking.addEventListener('click', () => this.controlador.mostrarRankingActualizado())
  }

  actualizarFecha(fecha){
    let date = new Date(fecha)
    let options = { year: 'numeric', month: 'long', day: 'numeric' };
    this.divFecha.textContent = "El conflicto comenzó el "+date.toLocaleDateString("es-ES", options)
  }
}
