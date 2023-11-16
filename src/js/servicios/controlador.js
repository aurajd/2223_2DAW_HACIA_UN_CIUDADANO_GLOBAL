/*Controlador principal de la aplicación
* Responsabilidad es aplicar las reglas de negocio:
* -Cuándo se cambia pantalla de vista.
* -Quién tiene permiso.
*
* */

import {Modelo} from '../modelos/modelo.js'
import {Vista} from '../vistas/vista.js'
import {Vista_menu} from '../vistas/vista_menu.js'
import {Vista_mapa} from '../vistas/vista_mapa.js'
import {Vista_ranking} from "../vistas/vista_ranking.js"
import {Vista_continente} from "../vistas/vista_continente.js"
//import {Vista_formulario} from "../vistas/vista_form.js"

class Controlador{
    /*
    * Inicializa los atributos del Controlador.
    * Coge las referencias del interfaz.
    * */

    vistas = new Map()
    constructor() {
        this.modelo = new Modelo()
        const divvistaMenu = document.getElementById('divvistaMenu')
        const divvistaMapa = document.getElementById('divvistaMapa')
        const divvistaCont = document.getElementById('divvistaCont')
        const divvistaRank = document.getElementById('divvistaRank')
        //const divvistaForm = document.getElementById('divvistaForm')

        //Creo las vistas
        this.vistas.set(Vista.VISTA1, new Vista_menu(this, divvistaMenu))
        this.vistas.set(Vista.VISTA2, new Vista_mapa(this, divvistaMapa))
        this.vistas.set(Vista.VISTA3, new Vista_ranking(this, divvistaRank))
        this.vistas.set(Vista.VISTA4, new Vista_continente(this, divvistaCont))
        //this.vistas.set(Vista.VISTA5, new Vista_formulario(this, divvistaForm));

        this.verVista(Vista.VISTA1)
    }

    /**
     * Muestra una vista
     * @param vista {Symbol} Símbolo que identifica a la vista
     */
    verVista(vista){
        this.ocultarVistas() //Oculta las vistas
        this.vistas.get(vista).mostrar(true) //Muestra esa seleccionada
    }
    ocultarVistas(){
        for(let vista of this.vistas.values()) //Recorre todas las vistas
            vista.mostrar(false)
    }

    acertarPregunta() {
        // Lógica para determinar cuántos puntos otorgar al acertar una pregunta
        const puntosPorPregunta = 10;
        this.modelo.aumentarPuntuacion(puntosPorPregunta);
        this.vistas.get(Vista.VISTA3).actualizarPuntuacionEnInterfaz();
        // Puedes ajustar la cantidad de puntos según tus necesidades.
    }

    obtenerPuntuacionActual() {
        return this.modelo.obtenerPuntuacion();
    }

    manejarValidacionFormulario() {
        const esValido = this.validarFormulario();
        if (esValido) {
            // Realizar acciones adicionales si el formulario es válido
            alert("Formulario válido. Acciones adicionales aquí.");
        } else {
            // Realizar acciones adicionales si el formulario no es válido
            alert("Formulario no válido. Acciones adicionales aquí.");
        }
    }

// Y al final de tu Controlador.js, puedes agregar la definición de validarFormulario
    validarFormulario() {
        // Obtener el valor del nombre de usuario
        let username = document.getElementById("username").value;

        // Expresión regular para verificar que no comienza con números y tiene máximo 30 caracteres
        let usernameRegex = /^[a-zA-Z][a-zA-Z0-9]{0,29}$/;

        // Verificar si el nombre de usuario cumple con la expresión regular
        if (!usernameRegex.test(username)) {
            // Mostrar mensaje de error
            document.getElementById("usernameError").innerHTML = "El nombre de usuario no es válido.";
            return false; // Evitar que el formulario se envíe
        } else {
            // Limpiar mensaje de error si es válido
            document.getElementById("usernameError").innerHTML = "";
            return true; // Permitir que el formulario se envíe
        }
    }
}

window.onload = () => {new Controlador()}