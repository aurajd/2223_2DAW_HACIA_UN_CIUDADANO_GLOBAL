/**
 * Clase que representa la vista para la administración de continentes en la aplicación.
 * @class
 */
class VistaAdminContinente {
  /**
     * Constructor de la clase VistaAdminContinente.
     * Inicializa las expresiones regulares y establece las referencias a los elementos del formulario.
     * @constructor
     */
  constructor () {
    this.regexInformacion = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-Z0-9ÑñÁáÉéÍíÓóÚúÜü!¡:;,.¿?"' ]{0,1999}$/
    this.regexResumen= /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-Z0-9ÑñÁáÉéÍíÓóÚúÜü0!¡:;,.¿?"' ]{0,99}$/

    // Referencias a los elementos del formulario
    this.informacion = document.getElementsByTagName('textarea')[0]
    this.resumen = document.getElementsByTagName('textarea')[1]
    this.imagen = document.querySelector('input[type=file]')
    this.formulario = document.querySelector('form')

    this.imagen.addEventListener('change', this.validarTamanioImagen.bind(this))
    this.informacion.addEventListener('blur', (event) => this.validar(this.regexInformacion, event.target))
    this.resumen.addEventListener('blur', (event) => this.validar(this.regexResumen, event.target))

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
    const informacionValida = this.validar(this.regexInformacion, this.informacion)
    const resumenValida = this.validar(this.regexResumen, this.resumen)
    const imagenValida = this.validarTamanioImagen()

    if (!informacionValida || !resumenValida || !imagenValida) {
      alert('Completa todos los campos correctamente antes de enviar el formulario.')
      event.preventDefault()
    }
  }

  
}

/** Inicializa la vista cuando la ventana se carga completamente. */
window.onload = () => { new VistaAdminContinente() } // eslint-disable-line no-new
