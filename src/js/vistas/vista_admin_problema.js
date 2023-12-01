/**
 * Clase que representa la vista para la administración de problemas en la aplicación.
 * @class
 */
class VistaAdminProblema {
  /**
     * Constructor de la clase VistaAdminProblema.
     * Inicializa las expresiones regulares y establece las referencias a los elementos del formulario.
     * @constructor
     */
  constructor () {
    this.regexTitulo = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-Z0-9ÑñÁáÉéÍíÓóÚúÜü ]{0,49}$/
    this.regexInformacion = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-Z0-ÑñÁáÉéÍíÓóÚúÜü9!¡:;,.¿?"' ]{0,1998}$/
    this.regexSolucion = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-ZÑñÁáÉéÍíÓóÚúÜü0-9!¡:;,.¿?"' ]{0,1998}$/

    // Referencias a los elementos del formulario
    this.titulo = document.getElementById('titulo')
    this.informacion = document.getElementById('informacion')
    this.reflexion = document.getElementById('reflexion')
    this.imagen = document.getElementById('imagen')
    this.divsSoluciones = document.getElementsByClassName('motivos')
    this.botonAnadir = document.getElementById('boton1')
    this.botonBorrar = document.getElementById('boton2')
    this.contenedorDuplicados = document.getElementById('contenedorDuplicados')
    this.divOriginal = document.getElementById('duplicadoOriginal')
    this.formulario = document.querySelector('form')

    this.contadorDuplicados = this.contenedorDuplicados.getElementsByTagName('div').length

    this.imagen.addEventListener('change', this.validarTamanioImagen.bind(this))
    this.titulo.addEventListener('blur', (event) => this.validar(this.regexTitulo, event.target))
    this.informacion.addEventListener('blur', (event) => this.validar(this.regexInformacion, event.target))
    this.reflexion.addEventListener('blur', (event) => this.validar(this.regexInformacion, event.target))

    for (const divSolucion of this.divsSoluciones) {
      divSolucion.getElementsByTagName('textarea')[0].addEventListener('blur', (event) => this.validar(this.regexSolucion, event.target))
    }

    this.botonAnadir.addEventListener('click', this.duplicarDiv.bind(this))
    this.botonBorrar.addEventListener('click', this.borrarDuplicado.bind(this))

    this.formulario.addEventListener('submit', (event) => this.validarFormulario(event))
  }

  /**
     * Función para validar un elemento con una expresión regular.
     * @param {RegExp} regex - Expresión regular para la validación.
     * @param {HTMLElement} elemento - Elemento HTML a validar.
     * @returns {boolean} - true si el elemento es válido, false si es inválido.
     */
  validar (regex, elemento) {
    if (regex.test(elemento.value)) {
      // La entrada es válida, aplicar estilo verde
      elemento.classList.remove('box_shadow_red')
      elemento.classList.add('box_shadow_green')
      return true
    } else {
      // La entrada no es válida, aplicar estilo rojo
      elemento.classList.remove('box_shadow_green')
      elemento.classList.add('box_shadow_red')
      return false
    }
  }

  /**
     * Función para validar el tamaño de la imagen seleccionada.
     * @returns {boolean} - true si la imagen es válida, false si es inválida.
     */
  validarTamanioImagen () {
    // Obtener el primer archivo seleccionado (asumimos que solo se permite seleccionar un archivo a la vez)
    const archivo = this.imagen.files[0]

    // Verificar si se seleccionó un archivo
    if (archivo) {
      // Obtener el tamaño del archivo en bytes
      const tamanoEnBytes = archivo.size

      // Convertir el tamaño a megabytes (1 megabyte = 1024 * 1024 bytes)
      const tamanoEnMB = tamanoEnBytes / (1024 * 1024)

      // Verificar si el tamaño del archivo es menor o igual a 3 MB
      if (tamanoEnMB > 3) {
        alert('La imagen debe pesar menos de 3 MB')
        this.imagen.value = null
        return false
      }
    }

    // No se seleccionó ningún archivo, considerar la validación como "válida"
    return true
  }

  /**
     * Función para validar el formulario antes de enviarlo.
     * @param {Event} event - Evento de formulario submit.
     */
  validarFormulario (event) {
    const tituloValido = this.validar(this.regexTitulo, this.titulo)
    const informacionValida = this.validar(this.regexInformacion, this.informacion)
    const reflexionValidada = this.validar(this.regexInformacion, this.reflexion)
    const imagenValida = this.validarTamanioImagen()
    const checkboxValidos = this.validarCheckbox()
    const textareasValidos = this.validarTextareas()

    if (!tituloValido || !informacionValida || !reflexionValidada || !imagenValida || !checkboxValidos || !textareasValidos) {
      alert('Completa todos los campos correctamente antes de enviar el formulario.')
      event.preventDefault()
    }
  }

  /**
     * Función para validar si al menos un checkbox está seleccionado.
     * @returns {boolean} - true si al menos un checkbox está seleccionado, false si ninguno está seleccionado.
     */
  validarCheckbox () {
    const checkboxes = document.querySelectorAll('input[type=checkbox]')
    for (const checkbox of checkboxes) {
      if (checkbox.checked) { return true }
    }
    return false
  }

  /**
     * Función para validar los campos de tipo textarea.
     * @returns {boolean} - true si todos los campos de textarea son válidos, false si al menos uno es inválido.
     */
  validarTextareas () {
    let textAreaValidos = true
    for (const divSolucion of this.divsSoluciones) {
      const textArea = divSolucion.getElementsByTagName('textarea')[0]
      if (!this.validar(this.regexSolucion, textArea)) { textAreaValidos = false }
    }
    return textAreaValidos
  }

  /**
     * Función para duplicar un div con soluciones.
     */
  duplicarDiv () {
    // Clonar el nodo del div original (incluyendo todos los elementos dentro)
    const nuevoDiv = this.divOriginal.cloneNode(true)

    // Generar un ID único para el nuevo div clonado e incrementa el contador para el próximo clon
    const nuevoID = 'duplicado' + this.contadorDuplicados++
    nuevoDiv.id = nuevoID

    nuevoDiv.querySelector('label').htmlFor = 'motivo' + (this.contadorDuplicados + 3)
    nuevoDiv.getElementsByTagName('textarea')[0].id = 'motivo' + (this.contadorDuplicados + 3)
    nuevoDiv.getElementsByTagName('textarea')[0].class = ''
    nuevoDiv.getElementsByTagName('textarea')[0].name = 'soluciones[' + (this.contadorDuplicados + 3) + ']'
    nuevoDiv.getElementsByTagName('textarea')[0].value = ''
    nuevoDiv.getElementsByTagName('textarea')[0].className = ''
    nuevoDiv.getElementsByTagName('textarea')[0].addEventListener('blur', (event) => this.validar(this.regexSolucion, event.target))
    nuevoDiv.getElementsByTagName('h2')[0].textContent = 'Solución ' + (this.contadorDuplicados + 3)
    nuevoDiv.querySelector("input[type='checkbox']").name = 'correctas[' + (this.contadorDuplicados + 3) + ']'
    nuevoDiv.querySelector("input[type='checkbox']").value = (this.contadorDuplicados + 3)
    nuevoDiv.querySelector("input[type='checkbox']").checked = false

    // Agregar el nuevo div clonado al contenedor de duplicados
    this.contenedorDuplicados.appendChild(nuevoDiv)
  }

  /**
     * Función para borrar el último div duplicado.
     */
  borrarDuplicado () {
    if (this.contadorDuplicados > 0) {
      this.contenedorDuplicados.removeChild(this.contenedorDuplicados.lastElementChild)
      this.contadorDuplicados--
    }
  }
}

/** Inicializa la vista cuando la ventana se carga completamente. */
window.onload = () => { new VistaAdminProblema() } // eslint-disable-line no-new
