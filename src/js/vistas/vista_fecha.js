import { Vista } from './vista.js'

export class VistaFecha extends Vista {
  constructor (controlador, base) {
    super(controlador, base)

    this.divFecha = document.getElementById("fraseFecha")
    this.botonVolver = document.getElementById("botonVolverFecha")
    this.botonVolver.addEventListener('click', () => this.controlador.comprobarContinentesCambiar(this.idContinente))

    this.enlaceInicio = this.base.querySelector('.verMenu')
    this.enlaceInicio.addEventListener('click', () => this.controlador.comprobarContinentesMapa(this.idContinente))
  }

  actualizarFecha(fecha, idContinente){
    console.log(idContinente)
    this.idContinente = idContinente
    console.log(this.idContinente)
    let date = new Date(fecha)
    let options = { year: 'numeric', month: 'long', day: 'numeric' };
    this.divFecha.textContent = "El conflicto comenzó el "+date.toLocaleDateString("es-ES", options)
  }
}
