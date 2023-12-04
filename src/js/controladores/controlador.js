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
import { VistaProblema } from '../vistas/vista_problema.js'
import { VistaReflexion } from '../vistas/vista_reflexion.js'
import { VistaConflicto } from '../vistas/vista_conflicto.js'
import { VistaFecha } from '../vistas/vista_fecha.js'

class Controlador {
  /**
       * Inicializa los atributos del Controlador y adquiere las referencias del interfaz.
       * @constructor
       */
  constructor () {
    /** @type {Modelo} */
    this.modelo = new Modelo(this)

    // Obtener referencias de las vistas del HTML
    const divvistaMenu = document.getElementById('divvistaMenu')
    const divvistaMapa = document.getElementById('divvistaMapa')
    const divvistaCont = document.getElementById('divvistaCont')
    const divvistaRank = document.getElementById('divvistaRank')
    const divvistaForm = document.getElementById('divvistaForm')
    const divvistaProb = document.getElementById('divvistaProb')
    const divvistaRef = document.getElementById('divvistaRef')
    const divvistaConf = document.getElementById('divvistaConf')
    const divvistaFech = document.getElementById('divvistaFech')

    // Crear instancias de las vistas
    this.vistas = new Map()
    this.vistas.set(Vista.VISTAMENU, new VistaMenu(this, divvistaMenu))
    this.vistas.set(Vista.VISTAMAPA, new VistaMapa(this, divvistaMapa))
    this.vistas.set(Vista.VISTARANKING, new VistaRanking(this, divvistaRank))
    this.vistas.set(Vista.VISTAPROBLEMA, new VistaProblema(this, divvistaProb))
    this.vistas.set(Vista.VISTAFORMULARIO, new VistaFormulario(this, divvistaForm))
    this.vistas.set(Vista.VISTACONTINENTE, new VistaContinente(this, divvistaCont))
    this.vistas.set(Vista.VISTAREFLEXION, new VistaReflexion(this, divvistaRef))
    this.vistas.set(Vista.VISTACONFLICTO, new VistaConflicto(this, divvistaConf))
    this.vistas.set(Vista.VISTAFECHA, new VistaFecha(this, divvistaFech))

    // Muestra la vista del menú
    this.verVista(Vista.VISTAMENU)
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
    const puntosPorPregunta = 10
    this.modelo.aumentarPuntuacion(puntosPorPregunta)
    this.vistas.get(Vista.VISTAMAPA).actualizarPuntuacionEnInterfaz()
    this.vistas.get(Vista.VISTAPROBLEMA).actualizarPuntuacionEnInterfaz()
    this.vistas.get(Vista.VISTAFORMULARIO).actualizarPuntuacionEnInterfaz()
    this.vistas.get(Vista.VISTACONTINENTE).actualizarPuntuacionEnInterfaz()
    this.vistas.get(Vista.VISTAREFLEXION).actualizarPuntuacionEnInterfaz()
    this.vistas.get(Vista.VISTACONFLICTO).actualizarPuntuacionEnInterfaz()
    this.vistas.get(Vista.VISTAFECHA).actualizarPuntuacionEnInterfaz()
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
  async manejarValidacionFormulario () {
    // Obtener el valor del nombre de usuario
    /** @type {string} */
    const username = document.getElementById('username').value

    // Obtener el valor de la puntuación
    /** @type {number} */
    const puntuacion = this.modelo.obtenerPuntuacion()

    /** @type {boolean} */
    const esValido = this.validarFormulario(username)

    if (esValido) {
      // Realizar acciones adicionales si el formulario es válido
      alert('Formulario válido.')
      this.cambiarEnlaceRankingInicio()
      await this.anadirPuntuacion(username, puntuacion)
      this.mostrarRankingActualizado()
    } else {
      alert('Formulario no válido.')
    }
  }

  /**
   * Valida el formulario.
   * @returns {boolean} - true si el formulario es válido, false de lo contrario.
   */
  validarFormulario (username) {
    // Expresión regular para verificar que no comienza con números y tiene máximo 30 caracteres
    /** @type {RegExp} */
    const usernameRegex = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-Z0-9ÑñÁáÉéÍíÓóÚúÜü ]{0,29}$/
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

  /**
   * Cambia a la vista de continente y carga las preguntas asociadas al continente.
   * @param {number} id - Identificador del continente.
   */
  async cambiarContinentes (id) {
    const preguntas = await this.modelo.devolverPreguntasContinente(id)
    await this.vistas.get(Vista.VISTACONTINENTE).actualizarContinente(preguntas, id)
    this.verVista(Vista.VISTACONTINENTE)
  }

  /**
   * Cambia a la vista de problema y carga la pregunta asociada al continente y problema dados.
   * @param {number} idContinente - Identificador del continente.
   * @param {number} idProblema - Identificador del problema.
   */
  async cambiarSoluciones (idContinente, idProblema) {
    const problema = await this.modelo.devolverPregunta(idContinente, idProblema)
    this.vistas.get(Vista.VISTAPROBLEMA).actualizarProblema(problema, idContinente, idProblema)
  }

  /**
   * Cambia a la vista de conflicto y carga la pregunta asociada al continente y conflicto dados.
   * @param {number} idContinente - Identificador del continente.
   * @param {number} idConflicto - Identificador del conflicto.
   */
  async cambiarMotivos (idContinente, idConflicto) {
    const conflicto = await this.modelo.devolverPregunta(idContinente, idConflicto)
    this.vistas.get(Vista.VISTACONFLICTO).actualizarConflicto(conflicto, idContinente, idConflicto)
  }

  /**
   * Añade la puntuación al servidor asociada al nombre de usuario.
   * @param {string} username - Nombre de usuario.
   * @param {number} puntuacion - Puntuación a añadir.
   */
  async anadirPuntuacion (username, puntuacion) {
    await this.modelo.puntuacionPOST(username, puntuacion)
  }

  /**
   * Muestra la vista de ranking actualizado con las puntuaciones almacenadas en el servidor.
   */
  async mostrarRankingActualizado () {
    const ranking = await this.modelo.obtenerRanking()
    this.vistas.get(Vista.VISTARANKING).actualizarRanking(ranking)
    this.verVista(Vista.VISTARANKING)
  }

  /**
   * Devuelve el continente asociado al identificador proporcionado.
   * @param {number} id - Identificador del continente.
   * @returns {Object} - Objeto que representa el continente.
   */
  async devolverContinente (id) {
    const continente = await this.modelo.devolverContinente(id)
    return continente
  }

  /**
   * Cambia la fecha e id del contienente asociados a un conflicto y muestra la vista de fecha.
   * @param {string} fecha - Nueva fecha.
   * @param {number} idContinente - Identificador del continente.
   */
  cambiarFecha (fecha, idContinente) {
    this.vistas.get(Vista.VISTAFECHA).actualizarFecha(fecha, idContinente)
  }

  /**
   * Cambia la reflexión e id del contienente asociados a un problema y muestra la vista de reflexión.
   * @param {string} reflexion - Nueva reflexión.
   * @param {number} idContinente - Identificador del continente.
   */
  cambiarReflexion (reflexion, idContinente) {
    this.vistas.get(Vista.VISTAREFLEXION).actualizarReflexion(reflexion, idContinente)
  }

  /**
   * Elimina la fila asociada al continente dado.
   * @param {number} idContinente - Identificador del continente.
   * @param {number} idFila - Identificador de la fila.
   */
  eliminarFila (idContinente, idFila) {
    this.modelo.eliminarFilaPregunta(idContinente, idFila)
  }

  /**
   * Comprueba si todas las filas de un continente están vacías, elimina el continente y muestra el mapa si lo está.
   * @param {number} idContinente - Identificador del continente.
   */
  async comprobarFilasContinente (idContinente) {
    const continenteVacio = await this.modelo.comprobarFilasContinenteVacio(idContinente)
    if (continenteVacio) {
      this.vistas.get(Vista.VISTAMAPA).eliminarContinente(idContinente)
      this.verVista(Vista.VISTAMAPA)
    } else {
      this.cambiarContinentes(idContinente)
    }
  }

  /**
   * Comprueba si todos los continentes están vacíos, si lo están muestra el formulario para guardar la puntuación
   * si no, comprueba si el continente actual está vacío.
   * @param {number} idContinente - Identificador del continente.
   */
  async comprobarContinentesCambiar (idContinente) {
    const continentesVacios = await this.modelo.comprobarContinentesVacio()
    if (continentesVacios) {
      this.verVista(Vista.VISTAFORMULARIO)
    } else {
      this.comprobarFilasContinente(idContinente)
    }
  }

  /**
   * Comprueba si todos los continentes están vacíos y muestra la vista de formulario o mapa.
   * @param {number} idContinente - Identificador del continente.
   */
  async comprobarContinentesMapa (idContinente) {
    const continentesVacios = await this.modelo.comprobarContinentesVacio()
    if (continentesVacios) {
      this.verVista(Vista.VISTAFORMULARIO)
    } else {
      this.comprobarFilasMapa(idContinente)
    }
  }

  /**
   * Comprueba si todas las filas del continente están vacías, si lo están lo elimina y muestra la vista de mapa.
   * @param {number} idContinente - Identificador del continente.
   */
  async comprobarFilasMapa (idContinente) {
    const continenteVacio = await this.modelo.comprobarFilasContinenteVacio(idContinente)
    if (continenteVacio) {
      this.vistas.get(Vista.VISTAMAPA).eliminarContinente(idContinente)
    }
    this.verVista(Vista.VISTAMAPA)
  }

  /**
   * Cambia el enlace en la vista de ranking para volver al inicio.
   */
  cambiarEnlaceRankingInicio () {
    this.vistas.get(Vista.VISTARANKING).cambiarEnlaceInicio()
  }

  /**
   * Cambia el enlace en la vista de ranking para volver al mapa.
   */
  cambiarEnlaceRankingMapa () {
    this.vistas.get(Vista.VISTARANKING).cambiarEnlaceMapa()
  }

  /**
   * Elimina el botón de inicio en la vista de menú.
   */
  borrarBotonInicio () {
    this.vistas.get(Vista.VISTAMENU).borrarBotonInicio()
  }
}

/** Inicializa el Controlador cuando la ventana se carga completamente. */
window.onload = () => { new Controlador() } // eslint-disable-line no-new
