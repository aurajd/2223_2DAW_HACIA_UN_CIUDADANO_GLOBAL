import { Vista } from './vista.js';

export class Vista_mapa extends Vista {
    constructor(controlador, base) {
        super(controlador, base)

        // Coger referencias del interfaz
        this.boton1 = this.base.querySelector('#Boton_eu1') // Reemplaza 'Boton_eu1' con el ID real de tu primer botón
        this.boton2 = this.base.querySelector('#Boton_eu2') // Reemplaza 'Boton_otro' con el ID real de tu segundo botón
        this.boton3 = this.base.querySelector('#Boton_eu3') // Reemplaza 'Boton_otro' con el ID real de tu segundo botón

        // Crear cuadros de texto
        this.cuadroTexto1 = this.crearCuadroTexto('Información detallada sobre el primer botón')
        this.cuadroTexto2 = this.crearCuadroTexto('Información detallada sobre el segundo botón')

        // Agregar cuadros de texto al DOM
        this.base.appendChild(this.cuadroTexto1)
        this.base.appendChild(this.cuadroTexto2)

        // Asociar eventos
        this.boton1.addEventListener('mouseenter', () => this.mostrarCuadroTexto(this.cuadroTexto1))
        this.boton1.addEventListener('mouseleave', () => this.ocultarCuadroTexto(this.cuadroTexto1))
        this.boton1.addEventListener('click', () => this.pulsarBoton(Vista.VISTA4)); // Cambiamos a Vista Continente para el primer botón

        this.boton2.addEventListener('mouseenter', () => this.mostrarCuadroTexto(this.cuadroTexto2))
        this.boton2.addEventListener('mouseleave', () => this.ocultarCuadroTexto(this.cuadroTexto2))
        this.boton2.addEventListener('click', () => this.pulsarBoton(Vista.VISTA4)); // Acciones al hacer clic en el segundo botón

        this.boton3.addEventListener('click', () => this.pulsarBoton(Vista.VISTA3)); // Acciones al hacer clic en el segundo botón
    }

    crearCuadroTexto(texto) {
        const cuadroTexto = document.createElement('div')
        cuadroTexto.classList.add('cuadro-texto')
        cuadroTexto.textContent = texto
        cuadroTexto.style.display = 'none'
        return cuadroTexto;
    }

    mostrarCuadroTexto(cuadroTexto) {
        cuadroTexto.style.display = 'block'
        cuadroTexto.style.backgroundColor = 'black'
    }

    ocultarCuadroTexto(cuadroTexto) {
        cuadroTexto.style.display = 'none'
    }

    pulsarBoton(vista) {
        this.controlador.verVista(vista)
    }
}
