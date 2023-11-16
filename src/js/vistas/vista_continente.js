import { Vista } from './vista.js';

export class Vista_continente extends Vista {
    constructor(controlador, base) {
        super(controlador, base, Vista.VISTA2);

        // Agregar un event listener para el evento de pulsación de tecla
        document.addEventListener('keydown', this.irAtras.bind(this));

        // Pregunta para mostrar en la vista continente
        this.mostrarPregunta('¿Cuál es la capital de este continente?');

        // Opciones de respuesta
        this.opcionesRespuesta = ['Opción 1', 'Opción 2', 'Opción 3'];

        // Crear botones para cada opción de respuesta
        this.crearBotonesRespuesta();
    }

    // Función para manejar la pulsación de tecla
    irAtras(event) {
        // Verificar si la tecla presionada es 'b' y si también se presionó la tecla 'Ctrl'
        if (event.key === 'b' && (event.ctrlKey || event.metaKey)) {
            // Cambiar a Vista2
            this.controlador.verVista(Vista.VISTA2);
        }
    }

    // Función para mostrar preguntas en la vista continente
    mostrarPregunta(pregunta) {
        const preguntaElemento = document.createElement('p');
        preguntaElemento.textContent = pregunta;

        // Reemplaza 'preguntaContainer' con el ID o la clase real de tu contenedor de preguntas
        const preguntaContainer = this.base.querySelector('#preguntaContainer');
        preguntaContainer.appendChild(preguntaElemento);
    }

    // Función para crear botones de opción de respuesta
    crearBotonesRespuesta() {
        const opcionesContainer = this.base.querySelector('#opcionesContainer');

        // Crear y agregar botones para cada opción de respuesta
        this.opcionesRespuesta.forEach((opcion, index) => {
            const boton = document.createElement('button');
            boton.textContent = opcion;
            boton.addEventListener('click', () => this.responder(index + 1)); // Sumar 1 para evitar índices de opción 0

            opcionesContainer.appendChild(boton);
        });
    }

    // Función para manejar la respuesta del usuario
    responder(opcionSeleccionada) {
        // Aquí puedes implementar la lógica para verificar si la respuesta es correcta
        // Puedes comparar opcionSeleccionada con la respuesta correcta y actuar en consecuencia

        // Ejemplo:
        if (opcionSeleccionada === 1) {
            console.log('Respuesta correcta');
            this.controlador.acertarPregunta();
        } else {
            console.log('Respuesta incorrecta');
        }
    }
}
