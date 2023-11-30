/**
 * Script para la validación y manipulación de formularios en la aplicación.
 */
class VistaAdminConflicto {
    constructor () {
        // Expresiones regulares para validaciones
        this.regexTitulo = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-Z0-9ÑñÁáÉéÍíÓóÚúÜü ]{0,49}$/;
        this.regexInformacion = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-Z0-ÑñÁáÉéÍíÓóÚúÜü9!¡:;,.¿?"' ]{0,1998}$/;
        this.regexFecha = /^(?!$)\d{4}-\d{2}-\d{2}$/;  // Ajustada para el formato de fecha "aaaa-mm-dd"
        this.regexMotivo = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü][a-zA-ZÑñÁáÉéÍíÓóÚúÜü0-9!¡:;,.¿?"' ]{0,1998}$/;


        this.contadorDuplicados = contenedorDuplicados.getElementsByTagName('div').length;
        // Referencias a los elementos del formulario
        this.titulo = document.getElementById("titulo");
        this.informacion = document.getElementById("informacion");
        this.fecha = document.getElementById("fecha");
        this.imagen = document.getElementById("imagen");
        this.divsSoluciones = document.getElementsByClassName("motivos")
        this.botonAniadir = document.getElementById("boton1");
        this.botonBorrar = document.getElementById("boton2");
        this.contenedorDuplicados = document.getElementById("contenedorDuplicados");
        this.divOriginal = document.getElementById("duplicadoOriginal");
        this.formulario = document.querySelector("form")
        this.botonEnviar = document.getElementById("enviar");


        // Asignar eventos blur a los campos de entrada
        this.titulo.addEventListener("blur", this.validarTitulo.bind(this));
        this.informacion.addEventListener("blur", this.validarInformacion.bind(this));
        this.fecha.addEventListener("change", this.validarFecha.bind(this));
        this.imagen.addEventListener("change", this.validarTamanioImagen.bind(this));

        for (const divSolucion of this.divsSoluciones) {
            divSolucion.getElementsByTagName("textarea")[0].addEventListener("blur", (event) => this.validar(this.regexMotivo,event.target))
        }

        this.botonAniadir.addEventListener("click", this.duplicarDiv.bind(this));
        this.botonBorrar.addEventListener("click", this.borrarDuplicado.bind(this));    
        this.botonEnviar.addEventListener("click",(event) => this.validarFormulario())
        //PARA EVITAR QUE CON EL ENTER SE MANDE
        this.formulario.addEventListener("submit",(event) => this.validarFormularioSubmit(event))
    }
    /**
     * Función para validar el formulario antes de enviarlo.
     */
    validarFormulario() {
        // Realizar todas las validaciones
        let tituloValido = this.validarTitulo();
        let informacionValida = this.validarInformacion();
        let fechaValida = this.validarFecha();
        let imagenValida = this.validarTamanioImagen();
        let radiosValidos = this.validarRadios();
        let textareasValidos = this.validarTextarea(); // Nueva validación para textarea

        console.log("tituloValido:", tituloValido);
        console.log("informacionValida:", informacionValida);
        console.log("fechaValida:", fechaValida);
        console.log("imagenValida:", imagenValida);
        console.log("radiosValidos:", radiosValidos);
        console.log("textareasValidos:", textareasValidos);

        // Verificar si todos los campos son válidos
        if (tituloValido && informacionValida && fechaValida && imagenValida && radiosValidos && textareasValidos) {
            // Aquí puedes enviar el formulario o realizar otras acciones
            document.getElementById("form").submit();
        } else {
            // Mostrar un mensaje de error o realizar otras acciones
            alert("Completa todos los campos correctamente antes de enviar el formulario.");
            return false;
        }
    }

    validarFormularioSubmit(event) {
        // Realizar todas las validaciones
        let tituloValido = this.validarTitulo();
        let informacionValida = this.validarInformacion();
        let fechaValida = this.validarFecha();
        let imagenValida = this.validarTamanioImagen();
        let radiosValidos = this.validarRadios();
        let textareasValidos = this.validarTextarea(); // Nueva validación para textarea

        console.log("tituloValido:", tituloValido);
        console.log("informacionValida:", informacionValida);
        console.log("fechaValida:", fechaValida);
        console.log("imagenValida:", imagenValida);
        console.log("radiosValidos:", radiosValidos);
        console.log("textareasValidos:", textareasValidos);

        // Verificar si todos los campos son válidos
        if (!tituloValido || !informacionValida || !fechaValida || !imagenValida || !radiosValidos || !textareasValidos) {
            event.preventDefault()
            alert("Completa todos los campos correctamente antes de enviar el formulario.");
            
        }
    }

    /**
     * Función para validar los campos de tipo textarea.
     * @returns {boolean} - true si todos los campos son válidos, false si al menos uno es inválido.
     */
    validarTextarea() {
        let textareas = document.querySelectorAll('textarea');
        let textareasValidos = true;

        textareas.forEach(textarea => {
            // Obtener el valor del textarea y aplicar la expresión regular
            let motivoValido = this.validar(this.regexMotivo, textarea);

            // Actualizar la variable textareasValidos basada en la validez del motivo
            if (motivoValido == false)
                textareasValidos = false;
        });

        return textareasValidos;
    }

    /**
     * Función para validar los campos de tipo radio.
     * @returns {boolean} - true si al menos un radio está seleccionado, false si ninguno está seleccionado.
     */
    validarRadios() {
        // Obtener todos los elementos de tipo radio con name="motivoCorrecto"
        let radios = document.querySelectorAll('input[name="motivoCorrecto"]');

        // Variable para almacenar si al menos uno está seleccionado
        let algunSeleccionado = false;

        // Iterar sobre los elementos de radio
        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                algunSeleccionado = true;
                break;  // Si al menos uno está seleccionado, salir del bucle
            }
        }

        // Verificar si al menos uno está seleccionado
        if (algunSeleccionado) {
            return true;
        } else {
            // Mostrar un mensaje de error o realizar otras acciones
            alert("Selecciona al menos una opción antes de enviar el formulario.");
            return false;
        }
    }

    borrarDuplicado(){
        if (this.contadorDuplicados > 0) {
            this.contenedorDuplicados.removeChild(this.contenedorDuplicados.lastElementChild);
            this.contadorDuplicados--;
        }
    }

    duplicarDiv() {
        // Clonar el nodo del div original (incluyendo todos los elementos dentro)
        let nuevoDiv = this.divOriginal.cloneNode(true);
        

        // Generar un ID único para el nuevo div clonado
        let nuevoID = "duplicado" + this.contadorDuplicados;
        nuevoDiv.id = nuevoID;

        // Incrementar el contador para el próximo clon
        this.contadorDuplicados++;

        nuevoDiv.querySelector("label").htmlFor = "motivo"+(this.contadorDuplicados+3);
        nuevoDiv.getElementsByTagName("textarea")[0].id = "motivo"+(this.contadorDuplicados+3);
        nuevoDiv.getElementsByTagName("textarea")[0].class = "textarea";
        nuevoDiv.getElementsByTagName("textarea")[0].name = "motivos[" + (this.contadorDuplicados+3) + "]";
        nuevoDiv.getElementsByTagName("textarea")[0].value = "";
        nuevoDiv.getElementsByTagName("textarea")[0].className = "";
        nuevoDiv.getElementsByTagName("textarea")[0].addEventListener("blur", (event) => this.validar(this.regexMotivo,event.target))
        nuevoDiv.getElementsByTagName("h2")[0].textContent = "Motivo "+(this.contadorDuplicados+3)
        nuevoDiv.querySelector("input[type='radio']").value = (this.contadorDuplicados+3);
        
        if (nuevoDiv.querySelector("input[type='radio']").checked == true){
            nuevoDiv.querySelector("input[type='radio']").checked = false;
            this.divOriginal.querySelector("input[type='radio']").checked = true;
        }

        // Agregar el nuevo div clonado al contenedor de duplicados
        this.contenedorDuplicados.appendChild(nuevoDiv);
    }

    /**
     * Función para validar el campo de título.
     * @returns {boolean} - true si el campo es válido, false si es inválido.
     */
    validarTitulo() {
        return this.validar(this.regexTitulo, titulo);
    }

    /**
     * Función para validar el campo de información.
     * @returns {boolean} - true si el campo es válido, false si es inválido.
     */
    validarInformacion() {
        return this.validar(this.regexInformacion, informacion);
    }

    /**
     * Función para validar el campo de fecha.
     * @returns {boolean} - true si el campo es válido, false si es inválido.
     */
    validarFecha() {
        let fechaIntroducida = this.fecha.value;
        let fechaFormateada = this.obtenerFechaActual();

        // Ajustar el formato de fecha formateada al formato "yyyy-mm-dd"
        let fechaFormateadaAjustada = fechaFormateada.split('/').reverse().join('-');

        if (fechaIntroducida <= fechaFormateadaAjustada) {
            // La fecha introducida es válida y es igual o anterior a la fecha actual
            this.fecha.classList.remove("box_shadow_red");
            this.fecha.classList.add("box_shadow_green");
            return true;
        } else {
            // La fecha introducida no es válida o es posterior a la fecha actual
            this.fecha.classList.remove("box_shadow_green");
            this.fecha.classList.add("box_shadow_red");
            return false;
        }
    }

    /**
     * Función para obtener la fecha actual en formato "dd/mm/aaaa".
     * @returns {string} - La fecha actual formateada.
     */
    obtenerFechaActual() {
        // Crea un nuevo objeto Date, que representa la fecha y la hora actuales
        let fechaActual = new Date();

        // Formatea la fecha para obtener una cadena legible en el formato "dd/mm/aaaa"
        let opcionesFormato = { year: 'numeric', month: '2-digit', day: '2-digit' };
        let fechaFormateada = fechaActual.toLocaleDateString('es-ES', opcionesFormato);

        return fechaFormateada;
    }

    /**
     * Función para validar el tamaño de la imagen seleccionada.
     * @returns {boolean} - true si la imagen es válida, false si es inválida.
     */
    validarTamanioImagen() {
        // Obtener el primer archivo seleccionado (asumimos que solo se permite seleccionar un archivo a la vez)
        let archivo = this.imagen.files[0];

        // Verificar si se seleccionó un archivo
        if (archivo) {
            // Obtener el tamaño del archivo en bytes
            let tamanoEnBytes = archivo.size;

            // Convertir el tamaño a megabytes (1 megabyte = 1024 * 1024 bytes)
            let tamanoEnMB = tamanoEnBytes / (1024 * 1024);

            // Verificar si el tamaño del archivo es menor o igual a 3 MB
            if (tamanoEnMB > 3) {
                alert("La imagen debe pesar menos de 3 MB");
                this.imagen.value = null
                return false;
            } else {
                return true;
            }
        }

        // No se seleccionó ningún archivo, considerar la validación como "válida"
        return true;
    }

    /**
     * Función para aplicar la validación con una expresión regular a un elemento.
     * @param {RegExp} regex - Expresión regular para la validación.
     * @param {HTMLElement} element - Elemento HTML a validar.
     * @returns {boolean} - true si el elemento es válido, false si es inválido.
     */
    validar(regex, element) {
        if (regex.test(element.value)) {
            // La entrada es válida, aplicar estilo verde
            element.classList.remove("box_shadow_red");
            element.classList.add("box_shadow_green");
            return true;
        } else {
            // La entrada no es válida, aplicar estilo rojo
            element.classList.remove("box_shadow_green");
            element.classList.add("box_shadow_red");
            return false;
        }
    }
}

/** Inicializa la vista cuando la ventana se carga completamente. */
window.onload = () => { new VistaAdminConflicto() } // eslint-disable-line no-new