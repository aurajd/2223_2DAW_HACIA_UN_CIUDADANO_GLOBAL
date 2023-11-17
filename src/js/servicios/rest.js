/**
 * Clase de Servicio para llamadas AJAX
 */
export class Rest {
    /**
     * Realiza una petición AJAX GET
     * @param {string} url - La URL a la que se realizará la petición
     * @returns {Promise} - Una promesa que se resolverá con los datos de la respuesta
     */
    static getContinentInfo(url, callback) {
        // Realizar la petición GET
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (callback) {
                    callback(data);
                }
            })
            .catch(error => {
                console.error('Error en la petición GET:', error);
            });
    }
}
