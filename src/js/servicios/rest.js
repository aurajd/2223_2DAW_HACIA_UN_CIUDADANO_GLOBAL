/**
 * Clase de Servicio para llamadas AJAX
 */
export class Rest {
    /**
     * Función para manejar la respuesta del usuario.
     * @param {number} opcionSeleccionada - Índice de la opción seleccionada.
     */
    responder(opcionSeleccionada) {
        const url = 'https://opendata.aemet.es/opendata/api/observacion/convencional/todas'; // Reemplaza con la URL correcta

        // Realizar la petición GET
        Rest.get(url)
            .then(responseData => {
                // Procesar la respuesta de la API
                console.log(responseData);
                // Puedes realizar acciones adicionales en función de la respuesta de la API
            })
            .catch(error => {
                // Maneja errores en la petición
                console.error(error);
            });
    }

}