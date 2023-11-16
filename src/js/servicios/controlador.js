/**
 * Controlador principal de la aplicación.
 * @class
 * @classdesc El controlador se encarga de aplicar las reglas de negocio, gestionar cambios de vista y permisos.
 */

import {Modelo} from '../modelos/modelo.js'
import {Vista} from '../vistas/vista.js'
import {Vista_menu} from '../vistas/vista_menu.js'
import {Vista_mapa} from '../vistas/vista_mapa.js'
import {Vista_ranking} from "../vistas/vista_ranking.js"
import {Vista_continente} from "../vistas/vista_continente.js"
import {Vista_formulario} from "../vistas/vista_formulario.js"

class Controlador {
    /**
     * Inicializa los atributos del Controlador y adquiere las referencias del interfaz.
     * @constructor
     */
    constructor() {
        /** @type {Modelo} */
        this.modelo = new Modelo() 

        // Obtener referencias de las vistas del HTML
        const divvistaMenu = document.getElementById('divvistaMenu') 
        const divvistaMapa = document.getElementById('divvistaMapa') 
        const divvistaCont = document.getElementById('divvistaCont') 
        const divvistaRank = document.getElementById('divvistaRank') 
        const divvistaForm = document.getElementById('divvistaForm') 

        // Crear instancias de las vistas
        this.vistas = new Map() 
        this.vistas.set(Vista.VISTA1, new Vista_menu(this, divvistaMenu)) 
        this.vistas.set(Vista.VISTA2, new Vista_mapa(this, divvistaMapa)) 
        this.vistas.set(Vista.VISTA3, new Vista_ranking(this, divvistaRank)) 
        this.vistas.set(Vista.VISTA4, new Vista_continente(this, divvistaCont)) 
        this.vistas.set(Vista.VISTA5, new Vista_formulario(this, divvistaForm)) 

        this.verVista(Vista.VISTA1) 
    }

    /**
     * Muestra una vista.
     * @param {Symbol} vista - Símbolo que identifica a la vista.
     */
    verVista(vista) {
        this.ocultarVistas()  // Oculta las vistas
        this.vistas.get(vista).mostrar(true)  // Muestra la vista seleccionada
    }

    /**
     * Oculta todas las vistas.
     */
    ocultarVistas() {
        for (let vista of this.vistas.values()) // Recorre todas las vistas
            vista.mostrar(false) 
    }

    /**
     * Maneja la lógica de acertar una pregunta.
     */
    acertarPregunta() {
        /** @const {number} puntosPorPregunta - Puntos otorgados por acertar una pregunta. */
        const puntosPorPregunta = 10 
        this.modelo.aumentarPuntuacion(puntosPorPregunta) 
        this.vistas.get(Vista.VISTA3).actualizarPuntuacionEnInterfaz() 
    }

    /**
     * Obtiene la puntuación actual.
     * @returns {number} - Puntuación actual.
     */
    obtenerPuntuacionActual() {
        return this.modelo.obtenerPuntuacion() 
    }

    /**
     * Maneja la validación del formulario.
     */
    manejarValidacionFormulario() {
        console.log('Iniciando manejarValidacionFormulario...') 
        /** @type {boolean} */
        const esValido = this.validarFormulario() 
        console.log('Terminando manejarValidacionFormulario.') 
        if (esValido) {
            // Realizar acciones adicionales si el formulario es válido
            alert("Formulario válido.") 
        } else {
            // Realizar acciones adicionales si el formulario no es válido
            alert("Formulario no válido.") 
        }
    }

    /**
     * Valida el formulario.
     * @returns {boolean} - true si el formulario es válido, false de lo contrario.
     */
    validarFormulario() {
        // Obtener el valor del nombre de usuario
        /** @type {string} */
        let username = document.getElementById("username").value 
        // Expresión regular para verificar que no comienza con números y tiene máximo 30 caracteres
        /** @type {RegExp} */
        let usernameRegex = /^[a-zA-Z][a-zA-Z0-9]{0,29}$/ 
        // Verificar si el nombre de usuario cumple con la expresión regular
        if (!usernameRegex.test(username)) {
            // Mostrar mensaje de error
            document.getElementById("usernameError").innerHTML = "El nombre de usuario no es válido." 
            return false  // Evitar que el formulario se envíe
        } else {
            // Limpiar mensaje de error si es válido
            document.getElementById("usernameError").innerHTML = "" 
            return true  // Permitir que el formulario se envíe
        }
    }
}

/** Inicializa el Controlador cuando la ventana se carga completamente. */
window.onload = () => { new Controlador() } 
