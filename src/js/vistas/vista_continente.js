import { Vista } from './vista.js' 

/**
 * Clase que representa la vista de un continente en la aplicación.
 * @extends Vista
 */
export class Vista_continente extends Vista {
    /**
     * Construye una instancia de la clase Vista_continente.
     * @constructor
     * @param {Controlador} controlador - Instancia del controlador asociada a la vista.
     * @param {HTMLElement} base - Elemento HTML que sirve como base para la vista del continente.
     */
    constructor(controlador, base) {
        super(controlador, base, Vista.VISTA2) 
        
        // Agregar un event listener para el evento de pulsación de tecla
        document.addEventListener('keydown', this.irAtras.bind(this)) 
        // Pregunta para mostrar en la vista continente
        this.mostrarPregunta('¿Cuál es la capital de este continente?') 
        // Opciones de respuesta
        this.opcionesRespuesta = ['Opción 1', 'Opción 2', 'Opción 3'] 
        // Crear botones para cada opción de respuesta
        this.crearBotonesRespuesta() 
    }

    /**
     * Función para manejar la pulsación de tecla.
     * @param {KeyboardEvent} event - Objeto que representa el evento de teclado.
     */
    irAtras(event) {
        // Verificar si la tecla presionada es 'b' y si también se presionó la tecla 'Ctrl'
        if (event.key === 'b' && (event.ctrlKey || event.metaKey)) {
            // Cambiar a Vista2
            this.controlador.verVista(Vista.VISTA2) 
        }
    }

    /**
     * Función para mostrar preguntas en la vista continente.
     * @param {string} pregunta - Pregunta a mostrar.
     */
    mostrarPregunta(pregunta) {
        const preguntaElemento = document.createElement('p') 
        preguntaElemento.textContent = pregunta 

        // Reemplaza 'preguntaContainer' con el ID o la clase real de tu contenedor de preguntas
        const preguntaContainer = this.base.querySelector('#preguntaContainer') 
        preguntaContainer.appendChild(preguntaElemento) 
    }

    /**
     * Función para crear botones de opción de respuesta.
     */
    crearBotonesRespuesta() {
        const opcionesContainer = this.base.querySelector('#opcionesContainer') 

        // Crear y agregar botones para cada opción de respuesta
        this.opcionesRespuesta.forEach((opcion, index) => {
            const boton = document.createElement('button') 
            boton.textContent = opcion 
            boton.addEventListener('click', () => this.responder(index + 1))  // Sumar 1 para evitar índices de opción 0

            opcionesContainer.appendChild(boton) 
        }) 
    }

    /**
     * Función para manejar la respuesta del usuario.
     * @param {number} opcionSeleccionada - Índice de la opción seleccionada.
     */
    responder(opcionSeleccionada) {
        if (opcionSeleccionada === 1) {
            console.log('Respuesta correcta') 
            this.controlador.acertarPregunta() 
        } else {
            console.log('Respuesta incorrecta') 
        }
    }
}