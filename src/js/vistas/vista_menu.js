import { Vista } from './vista.js';

export class Vista_menu extends Vista {
    constructor(controlador, base) {
        super(controlador, base);
        // Coger referencias del interfaz
        this.enlace1 = this.base.querySelectorAll('p')[0];
        this.enlace2 = this.base.querySelectorAll('p')[1];

        // Asociar eventos
        this.enlace1.onclick = this.pulsarEnlace1.bind(this);
        this.enlace2.onclick = this.pulsarEnlace2.bind(this);
    }

    pulsarEnlace1() {
        this.controlador.verVista(Vista.VISTA2); // Cambiamos a Vista Mapa
    }

    pulsarEnlace2() {
        this.controlador.verVista(Vista.VISTA3); // Cambiamos a Vista Ranking
    }
}
