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
    /** @const {number} puntosPorPregunta - Puntos otorgados por acertar una pregunta. */
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
    console.log(username)

    // Obtener el valor de la puntuación
    /** @type {number} */
    const puntuacion = this.modelo.obtenerPuntuacion()
    console.log(puntuacion)

    /** @type {boolean} */
    const esValido = this.validarFormulario(username)

    if (esValido) {
      // Realizar acciones adicionales si el formulario es válido
      alert('Formulario válido.')
      this.cambiarEnlaceRankingInicio()
      await this.anadirPuntuacion(username,puntuacion)
      this.mostrarRankingActualizado()
    } else {
      alert('Formulario no válido.')
    }
  }

  /**
       * Valida el formulario.
       * @returns {boolean} - true si el formulario es válido, false de lo contrario.
       */
  validarFormulario (username,puntuacion) {
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

  async cambiarContinentes(id){
    const preguntas = await this.modelo.devolverPreguntasContinente(id);
    await this.vistas.get(Vista.VISTACONTINENTE).actualizarContinente(preguntas,id)
    this.verVista(Vista.VISTACONTINENTE)
  }

  async cambiarSoluciones (idContinente,idProblema){
    const problema = await this.modelo.devolverPregunta(idContinente,idProblema);
    this.vistas.get(Vista.VISTAPROBLEMA).actualizarProblema(problema,idContinente,idProblema)
  }

  async cambiarMotivos(idContinente,idConflicto){
    console.log(idContinente)
    const conflicto = await this.modelo.devolverPregunta(idContinente,idConflicto);
    this.vistas.get(Vista.VISTACONFLICTO).actualizarConflicto(conflicto,idContinente,idConflicto)
  }

  async anadirPuntuacion(username,puntuacion){
    await this.modelo.puntuacionPOST(username,puntuacion)
  }

  async mostrarRankingActualizado(){
    const ranking = await this.modelo.obtenerRanking()
    this.vistas.get(Vista.VISTARANKING).actualizarRanking(ranking)
    this.verVista(Vista.VISTARANKING)
  }

  async devolverContinente(id){
    const continente = await this.modelo.devolverContinente(id)
    return continente
  }

  cambiarFecha(fecha,idContinente){
    console.log(idContinente)
    this.vistas.get(Vista.VISTAFECHA).actualizarFecha(fecha,idContinente)
  }

  cambiarReflexion(reflexion,idContinente){
    this.vistas.get(Vista.VISTAREFLEXION).actualizarReflexion(reflexion,idContinente)
  }
  
  eliminarFila(idContinente,idFila){
    this.modelo.eliminarFilaPregunta(idContinente,idFila)
  }

  async comprobarFilasContinente(idContinente){
    const continenteVacio = await this.modelo.comprobarFilasContinenteVacio(idContinente)
    if(continenteVacio){
      this.vistas.get(Vista.VISTAMAPA).eliminarContinente(idContinente)
      this.verVista(Vista.VISTAMAPA)
    }else{
      this.cambiarContinentes(idContinente)
    }
  }

  async comprobarContinentesCambiar(idContinente){
    const continentesVacios = await this.modelo.comprobarContinentesVacio()
    if(continentesVacios){
      this.verVista(Vista.VISTAFORMULARIO)
    }else{
      this.comprobarFilasContinente(idContinente);
    }
  }

  async comprobarContinentesMapa(idContinente){
    const continentesVacios = await this.modelo.comprobarContinentesVacio()
    if(continentesVacios){
      this.verVista(Vista.VISTAFORMULARIO)
    }else{
      this.comprobarFilasMapa(idContinente);
    }
  }

  async comprobarFilasMapa(idContinente){
    const continenteVacio = await this.modelo.comprobarFilasContinenteVacio(idContinente)
    if(continenteVacio){
      this.vistas.get(Vista.VISTAMAPA).eliminarContinente(idContinente)
    }
    this.verVista(Vista.VISTAMAPA)

  }

  async volverMapaComprobar(){
    if(await this.modelo.comprobarContinentesVacio()){
      this.verVista(Vista.VISTAFORMULARIO)
    }else{
      this.verVista(Vista.VISTAMAPA)
    }
  }

  cambiarEnlaceRankingInicio(){
    this.vistas.get(Vista.VISTARANKING).cambiarEnlaceInicio()
  }

  cambiarEnlaceRankingMapa(){
    this.vistas.get(Vista.VISTARANKING).cambiarEnlaceMapa()
  }
  
  borrarBotonInicio(){
    this.vistas.get(Vista.VISTAMENU).borrarBotonInicio()
  }
}

/** Inicializa el Controlador cuando la ventana se carga completamente. */
window.onload = () => { new Controlador() } // eslint-disable-line no-new
