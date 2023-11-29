/**
 * Clase que representa el modelo de la aplicación.
 */
export class Modelo {
  /**
     * Constructor de la clase Modelo.
     * Inicializa el mapa y la puntuación.
     */
  constructor (modelo) {
    this.modelo = modelo; // - Instancia del controlador asociada al modelo.
    /** @type {Map} */
    this.mapa = new Map() // Mapa para almacenar datos, puedes ajustar según necesidades específicas.
    /** @type {number} */
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
  obtenerMotivoCorrecto(id){
    let idMotivo = 1;
    return idMotivo;
  }

  puntuacionPOST(username,puntuacion){
    //Validación de datos...
    const formData = new FormData()
    formData.append('nombre', username)
    formData.append('puntuacion', puntuacion)
    const opciones = {
        method: 'POST',
        body: formData
    }
    fetch('./index.php?controller=ranking&action=anadir_puntuacion',opciones)
    .then(respuesta => respuesta.text())
    .then(texto => {
        console.log(texto)
    })
  }
  
  obtenerInfoContinentes(){
    return fetch('./index.php?controller=preguntas_ajax&action=devolver_info_continentes')
    .then(respuesta => respuesta.json() )
    .then(objeto => {
        return objeto
    })
  }


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

  async devolverPregunta(idContinente,idProblema){
    let preguntas = await this.preguntas;
    return preguntas[idContinente][idProblema];
  }

  async devolverPreguntasContinente(id){
    let preguntas = await this.preguntas;
    return preguntas[id];
  }

  async devolverContinente(id){
    let continente = await this.infoContinentes;
    return continente[id];
  }

  async eliminarFilaPregunta(idContinente,idFila){
    let preguntas = await this.preguntas
    preguntas[idContinente].splice(idFila,1)
  }

  async comprobarFilasContinenteVacio(idContinente){
    let preguntas = await this.preguntas
    let longitud = preguntas[idContinente].length
    return longitud<1;
  }

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

  async eliminarFilaContinente(idContinente){
    let preguntas = await this.preguntas
    console.log(preguntas)
    preguntas.splice(idContinente,1)
    console.log(preguntas)

  }

  obtenerPreguntasContinente(id){
    return fetch('./index.php?controller=preguntas_ajax&action=devolver_problema_random')
    .then(respuesta => respuesta.json() )
    .then(objeto => {
        return objeto
    })

    // Estructura
    // [
    //   {'tipo': 'problema', 
    //   'titulo': "titulo problema 1",
    //   'informacion': "informacion problema 1",
    //   'imagen': null,
    //   'reflexion': 'reflexion ejemplo 1',
    //   "respuestas": [
    //     { "texto" : "respuesta 11" , "correcta" : false },
    //     { "texto" : "respuesta 12" , "correcta" : false },
    //     { "texto" : "respuesta 13" , "correcta" : true }
    //   ]
    //   },
    //   {'tipo': 'problema', 
    //   'texto': "titulo problema 2",
    //   'informacion': "informacion problema 1",
    //   'imagen': null,
    //   'reflexion': 'reflexion ejemplo 1',
    //   "respuestas": [
    //     { "texto" : "respuesta 21" , "correcta" : true },
    //     { "texto" : "respuesta 22" , "correcta" : false },
    //     { "texto" : "respuesta 23" , "correcta" : true }
    //   ]
    //   },
    //   {'tipo': 'conflicto', 
    //   'texto': "titulo conflicto 3",
    //   'informacion': "informacion problema 1",
    //   'imagen': null,
    //   'fechaInicio': '2023-11-28',
    //   'numMotivo' : 1,
    //   "respuestas": [
    //     { "texto" : "respuesta 31" , 'numMotivo' : 1},
    //     { "texto" : "respuesta 32", 'numMotivo' : 2},
    //     { "texto" : "respuesta 33", 'numMotivo' : 3}
    //   ]
    //   },
    // ]
  }

  obtenerRanking(){
    return fetch('./index.php?controller=ranking&action=devolver_puntuaciones_ajax')
    .then(respuesta => respuesta.json() )
    .then(objeto => {
        return objeto
    })
  }

}
