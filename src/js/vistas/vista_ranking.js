import { Vista } from './vista.js';

export class Vista_ranking extends Vista {
    constructor(controlador, base) {
        super(controlador, base);
        this.comprobacionesForm();
        // Agregar un event listener para el evento de pulsación de tecla
        document.addEventListener('keydown', this.irAtras.bind(this));

        // Obtener referencia al enlace de Inicio
        this.enlaceInicio = this.base.querySelector('#volverMenu'); // Reemplaza 'enlaceInicio' con el ID real de tu enlace

        // Asociar evento al enlace de Inicio
        this.enlaceInicio.addEventListener('click', () => this.controlador.verVista(Vista.VISTA1));

        // Obtener referencia al formulario
        this.formulario = this.base.querySelector('form');

        // Asociar evento al formulario para enviarFormulario en el evento submit
        this.formulario.addEventListener('submit', (event) => this.enviarFormulario(event));
    }

    // Función para manejar la pulsación de tecla
    irAtras(event) {
        // Verificar si la tecla presionada es 'b' y si también se presionó la tecla 'Ctrl'
        if (event.key === 'Enter') {
            // Cambiar a Vista1
            this.controlador.verVista(Vista.VISTA1);
        }
    }

    // Ejemplo de cómo podrías actualizar la puntuación en la interfaz de usuario
    actualizarPuntuacionEnInterfaz() {
        const puntuacionActual = this.controlador.obtenerPuntuacionActual();
        const puntuacionElemento = this.base.querySelector('#puntuacion p');
        puntuacionElemento.textContent = `Puntuación: ${puntuacionActual}`;
    }

    // En tu método inicializarEventos de la Vista_formulario.js
    comprobacionesForm() {
        const inputUsername = this.base.querySelector('#username');
        inputUsername.addEventListener('input', () => this.validarFormulario());
    }

    enviarFormulario(event) {
        event.preventDefault(); // Evitar el envío predeterminado del formulario
        this.controlador.manejarValidacionFormulario(); // Llamar a la función del controlador
    }
}
