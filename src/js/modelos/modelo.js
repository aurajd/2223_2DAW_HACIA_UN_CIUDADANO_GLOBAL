/**
 * Clase que representa el modelo de la aplicación.
 */
export class Modelo {
  /**
   * Constructor de la clase Modelo.
   * Inicializa la puntuación y las preguntas y la información del continente.
   * @param {Controlador} modelo - Instancia del controlador asociada al modelo.
   */
  constructor (modelo) {
    this.modelo = modelo; // - Instancia del controlador asociada al modelo.
    this.puntuacion = 0 // Puntuación inicializada en 0.

    this.preguntas = this.obtenerPreguntas();
    this.infoContinentes = this.obtenerInfoContinentes();
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

  /**
   * Realiza una solicitud POST para enviar la puntuación al servidor.
   * @param {string} username - Nombre de usuario.
   * @param {number} puntuacion - Puntuación a añadir.
   * @returns {Promise<boolean>} - Promesa que resuelve a true si la operación fue exitosa.
   */
  puntuacionPOST(username,puntuacion){
    //Validación de datos...
    const formData = new FormData()
    formData.append('nombre', username)
    formData.append('puntuacion', puntuacion)
    const opciones = {
        method: 'POST',
        body: formData
    }
    return fetch('./index.php?controller=ranking&action=anadir_puntuacion',opciones)
    .then(respuesta => respuesta.text())
    .then(texto => {
        return true;
    })
  }
  
   /**
   * Obtiene la información de los continentes desde el servidor.
   * @returns {Promise<Object>} - Promesa que resuelve a un objeto con la información de los continentes.
   */
  obtenerInfoContinentes(){
    return fetch('./index.php?controller=preguntas_ajax&action=devolver_info_continentes')
    .then(respuesta => respuesta.json() )
    .then(objeto => {
        return objeto
    })
  }

  /**
   * Obtiene todas las preguntas de los continentes.
   * @returns {Promise<Array>} - Promesa que resuelve a un array de preguntas.
   */
  async obtenerPreguntas(){
    const preguntas = []
    preguntas.push(await this.obtenerPreguntasContinente(1))
    preguntas.push(await this.obtenerPreguntasContinente(2))
    preguntas.push(await this.obtenerPreguntasContinente(3))
    preguntas.push(await this.obtenerPreguntasContinente(4))
    preguntas.push(await this.obtenerPreguntasContinente(5))
    preguntas.push(await this.obtenerPreguntasContinente(6))
    return preguntas;
  }

  /**
   * Devuelve la pregunta asociada al identificador de continente y pregunta proporcionados.
   * @param {number} idContinente - Identificador del continente.
   * @param {number} idPregunta - Identificador de la pregunta.
   * @returns {Promise<Object>} - Promesa que resuelve a un objeto que representa la pregunta.
   */
  async devolverPregunta(idContinente,idPregunta){
    let preguntas = await this.preguntas;
    return preguntas[idContinente][idPregunta];
  }

  /**
   * Devuelve todas las preguntas asociadas al continente proporcionado.
   * @param {number} id - Identificador del continente.
   * @returns {Promise<Array>} - Promesa que resuelve a un array de preguntas.
   */
  async devolverPreguntasContinente(id){
    let preguntas = await this.preguntas;
    return preguntas[id];
  }

  /**
   * Devuelve la información del continente asociado al identificador proporcionado.
   * @param {number} id - Identificador del continente.
   * @returns {Promise<Object>} - Promesa que resuelve a un objeto que representa el continente.
   */
  async devolverContinente(id){
    let continente = await this.infoContinentes;
    return continente[id];
  }

  /**
   * Elimina una fila de pregunta asociada al continente y fila dados.
   * @param {number} idContinente - Identificador del continente.
   * @param {number} idFila - Identificador de la fila.
   */
  async eliminarFilaPregunta(idContinente,idFila){
    let preguntas = await this.preguntas
    preguntas[idContinente].splice(idFila,1)
  }

  /**
   * Comprueba si todas las filas del continente están vacías.
   * @param {number} idContinente - Identificador del continente.
   * @returns {Promise<boolean>} - Promesa que resuelve a true si todas las filas están vacías.
   */
  async comprobarFilasContinenteVacio(idContinente){
    let preguntas = await this.preguntas
    let longitud = preguntas[idContinente].length
    return longitud<1;
  }

  /**
   * Comprueba si todos los continentes están vacíos.
   * @returns {Promise<boolean>} - Promesa que resuelve a true si todos los continentes están vacíos.
   */
  async comprobarContinentesVacio(){
    let preguntas = await this.preguntas
    for (const pregunta of preguntas) {
      let longitud = pregunta.length
      if(longitud>0){
        return false
      }
    }
    return true;
  }

  /**
   * Elimina un continente y todas sus filas de preguntas asociadas.
   * @param {number} idContinente - Identificador del continente.
   */
  async eliminarFilaContinente(idContinente){
    let preguntas = await this.preguntas
    console.log(preguntas)
    preguntas.splice(idContinente,1)
    console.log(preguntas)
  }

  /**
   * Obtiene preguntas asociadas a un continente desde el servidor.
   * @param {number} id - Identificador del continente.
   * @returns {Promise<Array>} - Promesa que resuelve a un array de preguntas.
   */
  obtenerPreguntasContinente(id){
    return fetch('./index.php?controller=preguntas_ajax&action=devolver_problema_random&id='+id)
    .then(respuesta => respuesta.json() )
    .then(objeto => {
      console.log(objeto)
        return objeto
    })
    

    // Estructura
    // [
    //   {'idProblema': 1,
    //   'tipo': 'problema', 
    //   'titulo': "titulo problema 1",
    //   'informacion': "informacion problema 1",
    //   'imagen': null,
    //   'reflexion': 'reflexion ejemplo 1',
    //   "respuestas": [
    //     { "numSolucion": 1, "textoSolucion" : "respuesta 11" , "correcta" : 0 },
    //     { "numSolucion": 2, "textoSolucion" : "respuesta 12" , "correcta" : 0 },
    //     { "numSolucion": 3, "textoSolucion" : "respuesta 13" , "correcta" : 1 }
    //   ]
    //   },
    //   {'idProblema': 2,
    //   'tipo': 'problema', 
    //   'texto': "titulo problema 2",
    //   'informacion': "informacion problema 1",
    //   'imagen': null,
    //   'reflexion': 'reflexion ejemplo 1',
    //   "respuestas": [
    //     { "numSolucion": 1, "textoSolucion" : "respuesta 21" , "correcta" : true },
    //     { "numSolucion": 2, "textoSolucion" : "respuesta 22" , "correcta" : false },
    //     { "numSolucion": 3, "textoSolucion" : "respuesta 23" , "correcta" : true }
    //   ]
    //   },
    //   {'idConflicto': 3,
    //   'tipo': 'conflicto', 
    //   'texto': "titulo conflicto 3",
    //   'informacion': "informacion problema 1",
    //   'imagen': null,
    //   'fechaInicio': '2023-11-28',
    //   'numMotivo' : 1,
    //   "respuestas": [
    //     { "textoMotivo" : "respuesta 31" , 'numMotivo' : 1},
    //     { "textoMotivo" : "respuesta 32", 'numMotivo' : 2},
    //     { "textoMotivo" : "respuesta 33", 'numMotivo' : 3}
    //   ]
    //   },
    // ]
  }

  /**
   * Obtiene el ranking de puntuaciones desde el servidor.
   * @returns {Promise<Array>} - Promesa que resuelve a un array de puntuaciones.
   */
  obtenerRanking(){
    return fetch('./index.php?controller=ranking&action=devolver_puntuaciones_ajax')
    .then(respuesta => respuesta.json() )
    .then(objeto => {
        return objeto
    })
  }

}
