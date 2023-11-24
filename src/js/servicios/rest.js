export class Rest {
  /**
   * Realiza una solicitud POST a la URL proporcionada con los datos especificados.
   * @param {string} url - La URL a la que se enviará la solicitud.
   * @param {Object} data - Los datos que se enviarán en el cuerpo de la solicitud.
   * @param {function} callback - La función de retorno de llamada que se ejecutará después de recibir la respuesta.
   */
  static post (url, data, callback) {
    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then(respuesta => {
        if (!respuesta.ok) {
          throw new Error('La solicitud no fue exitosa: ' + respuesta.status)
        }
        return respuesta.json()
      })
      .then(objeto => {
        if (callback) {
          callback(objeto)
        }
      })
      .catch(error => {
        console.error('Error en la solicitud:', error)
        // Puedes agregar código para manejar el error, por ejemplo, llamar a otro callback de error
      })
  }
}
