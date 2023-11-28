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

  async obtenerPreguntas(){
    const preguntas = []
    const preguntasEuropa = await this.obtenerPreguntasContinente(1);
    preguntas.push(preguntasEuropa)
    const preguntasAsia = await this.obtenerPreguntasContinente(2);
    preguntas.push(preguntasAsia)
    const preguntasOceania = await this.obtenerPreguntasContinente(3);
    preguntas.push(preguntasOceania)
    const preguntasAmericaNorte = await this.obtenerPreguntasContinente(4);
    preguntas.push(preguntasAmericaNorte)
    const preguntasAmericaSur = await this.obtenerPreguntasContinente(5);
    preguntas.push(preguntasAmericaSur)
    const preguntasAfrica = await this.obtenerPreguntasContinente(6);
    preguntas.push(preguntasAfrica)
    return preguntas;
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
}
