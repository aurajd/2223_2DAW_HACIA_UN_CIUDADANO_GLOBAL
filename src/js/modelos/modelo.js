/**
 * Clase que representa el modelo de la aplicación.
 */
export class Modelo {
    /**
     * Constructor de la clase Modelo.
     * Inicializa el mapa y la puntuación.
     */
    constructor() {
        /** @type {Map} */
        this.mapa = new Map()  // Mapa para almacenar datos, puedes ajustar según necesidades específicas.
        /** @type {number} */
        this.puntuacion = 0  // Puntuación inicializada en 0.
    }

    /**
     * Aumenta la puntuación actual por la cantidad de puntos proporcionada.
     * @param {number} puntos - Cantidad de puntos a incrementar.
     */
    aumentarPuntuacion(puntos) {
        this.puntuacion += puntos 
    }

    /**
     * Obtiene la puntuación actual del modelo.
     * @returns {number} - Puntuación actual.
     */
    obtenerPuntuacion() {
        return this.puntuacion 
    }
}