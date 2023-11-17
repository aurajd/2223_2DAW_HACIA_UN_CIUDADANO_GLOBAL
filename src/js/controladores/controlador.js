/**
 * Controlador principal de la aplicación.
 * @class
 * @classdesc El controlador se encarga de aplicar las reglas de negocio, gestionar cambios de vista y permisos.
 */

import { Modelo } from '../modelos/modelo.js'
import { Vista } from '../vistas/vista.js'
import { VistaMenu } from '../vistas/vista_menu.js'
import { VistaMapa } from '../vistas/vista_mapa.js'
import { VistaRanking } from '../vistas/vista_ranking.js'
import { VistaContinente } from '../vistas/vista_continente.js'
import { VistaFormulario } from '../vistas/vista_formulario.js'

class Controlador {
  /**
     * Inicializa los atributos del Controlador y adquiere las referencias del interfaz.
     * @constructor
     */
  constructor () {
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
    this.vistas.set(Vista.VISTA1, new VistaMenu(this, divvistaMenu))
    this.vistas.set(Vista.VISTA2, new VistaMapa(this, divvistaMapa))
    this.vistas.set(Vista.VISTA3, new VistaRanking(this, divvistaRank))
    this.vistas.set(Vista.VISTA4, new VistaContinente(this, divvistaCont))
    this.vistas.set(Vista.VISTA5, new VistaFormulario(this, divvistaForm))

    this.verVista(Vista.VISTA1)
  }

  /**
     * Muestra una vista.
     * @param {Symbol} vista - Símbolo que identifica a la vista.
     */
  verVista (vista) {
    this.ocultarVistas() // Oculta las vistas
    this.vistas.get(vista).mostrar(true) // Muestra la vista seleccionada
  }

  /**
     * Oculta todas las vistas.
     */
  ocultarVistas () {
    for (const vista of this.vistas.values()) { // Recorre todas las vistas
      vista.mostrar(false)
    }
  }

  /**
     * Maneja la lógica de acertar una pregunta.
     */
  acertarPregunta () {
    /** @const {number} puntosPorPregunta - Puntos otorgados por acertar una pregunta. */
    const puntosPorPregunta = 10
    this.modelo.aumentarPuntuacion(puntosPorPregunta)
    this.vistas.get(Vista.VISTA3).actualizarPuntuacionEnInterfaz()
    this.vistas.get(Vista.VISTA5).actualizarPuntuacionEnInterfaz()
  }

  /**
     * Obtiene la puntuación actual.
     * @returns {number} - Puntuación actual.
     */
  obtenerPuntuacionActual () {
    return this.modelo.obtenerPuntuacion()
  }

  /**
     * Maneja la validación del formulario.
     */
  manejarValidacionFormulario () {
    /** @type {boolean} */
    const esValido = this.validarFormulario()

    if (esValido) {
      // Realizar acciones adicionales si el formulario es válido
      alert('Formulario válido.')
      this.verVista(Vista.VISTA3)
    } else {
      alert('Formulario no válido.')
    }
  }

  /**
     * Valida el formulario.
     * @returns {boolean} - true si el formulario es válido, false de lo contrario.
     */
  validarFormulario () {
    // Obtener el valor del nombre de usuario
    /** @type {string} */
    const username = document.getElementById('username').value
    // Expresión regular para verificar que no comienza con números y tiene máximo 30 caracteres
    /** @type {RegExp} */
    const usernameRegex = /^[a-zA-Z][a-zA-Z\s0-9]{0,29}$/
    // Verificar si el nombre de usuario cumple con la expresión regular
    if (!usernameRegex.test(username)) {
      // Mostrar mensaje de error
      document.getElementById('usernameError').innerHTML = 'El nombre de usuario no es válido. No puede empezar por números o caracteres especiales.'
      return false // Evitar que el formulario se envíe
    } else {
      // Limpiar mensaje de error si es válido
      document.getElementById('usernameError').innerHTML = ''
      return true // Permitir que el formulario se envíe
    }
  }
}

/** Inicializa el Controlador cuando la ventana se carga completamente. */
window.onload = () => { new Controlador() } // eslint-disable-line no-new
