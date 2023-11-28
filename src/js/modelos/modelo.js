/**
 * Clase que representa el modelo de la aplicación.
 */
export class Modelo {
  /**
     * Constructor de la clase Modelo.
     * Inicializa el mapa y la puntuación.
     */
  constructor () {
    /** @type {Map} */
    this.mapa = new Map() // Mapa para almacenar datos, puedes ajustar según necesidades específicas.
    /** @type {number} */
    this.puntuacion = 0 // Puntuación inicializada en 0.
  }

  /**
     * Aumenta la puntuación actual por la cantidad de puntos proporcionada.
     * @param {number} puntos - Cantidad de puntos a incrementar.
     */
  aumentarPuntuacion (puntos) {
    this.puntuacion += puntos
  }

  /**
     * Obtiene la puntuación actual del modelo.
     * @returns {number} - Puntuación actual.
     */
  obtenerPuntuacion () {
    return this.puntuacion
  }

  obtenerProblemas(id){
    let problemas = [
      {'texto': "Problema 1 de continente "+id, 'id': 1},
      {'texto': "Problema 2 de continente "+id, 'id': 2},
    ]
    return problemas
  }

  obtenerConflicto(id){
    let conflicto = {'texto': "Conflicto 1 de continente "+id, 'id': 3}
    return conflicto
  }

  obtenerSoluciones(id){
    let respuestas = [
      {'texto': "solucion 1 de pregunta "+id, 'correcto': true},
      {'texto': "solucion 2 de pregunta "+id, 'correcto': false},
      {'texto': "solucion 3 de pregunta "+id, 'correcto': true},
    ]
    return respuestas
  }

  obtenerMotivos(id){
    let respuestas = [
      {'texto': "Motivo 1 de pregunta "+id, 'id': 1},
      {'texto': "Motivo 2 de pregunta "+id, 'id': 2},
      {'texto': "Motivo 3 de pregunta "+id, 'id': 3},
    ]
    return respuestas
  }

  obtenerMotivoCorrecto(id){
    let idMotivo = 1;
    return idMotivo;
  }
}
