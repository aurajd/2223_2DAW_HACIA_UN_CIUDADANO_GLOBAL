export class Rest {
  
  static getJSON(url, params, callback) {
    let paramsGET = '?';
    for (let param in params) {
      paramsGET += param + '=';
      paramsGET += params[param] + '&';
    }
  
    fetch(encodeURI(url + paramsGET.substring(0, paramsGET.length - 1)))
      .then(respuesta => {
        if (!respuesta.ok) {
          throw new Error('La solicitud no fue exitosa: ' + respuesta.status);
        }
        return respuesta.json();
      })
      .then(objeto => {
        if (callback) {
          callback(objeto);
        }
      })
      .catch(error => {
        console.error('Error en la solicitud:', error);
        // Puedes agregar código para manejar el error, por ejemplo, llamar a otro callback de error
      });
  }

  static post(url, data, callback) {
    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        // Puedes agregar otros encabezados según sea necesario
      },
      body: JSON.stringify(data),
    })
      .then(respuesta => {
        if (!respuesta.ok) {
          throw new Error('La solicitud no fue exitosa: ' + respuesta.status);
        }
        return respuesta.json();
      })
      .then(objeto => {
        if (callback) {
          callback(objeto);
        }
      })
      .catch(error => {
        console.error('Error en la solicitud:', error);
        // Puedes agregar código para manejar el error, por ejemplo, llamar a otro callback de error
      });
  }
}

