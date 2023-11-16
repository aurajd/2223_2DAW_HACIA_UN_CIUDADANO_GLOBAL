export class Modelo {
    constructor() {
        this.mapa = new Map();
        this.puntuacion = 0;
    }

    aumentarPuntuacion(puntos) {
        this.puntuacion += puntos;
    }

    obtenerPuntuacion() {
        return this.puntuacion;
    }
}
