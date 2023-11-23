console.log('Carga el script');

// Regex para validaciones
let regexTitulo = /^[a-zA-Z][a-zA-Z0-9 ]{0,49}$/;
let regexInformacion = /^[a-zA-Z][a-zA-Z0-9!¡:;,.¿?"']{0,1998}$/;
let regexFecha = /^(?!$)\d{4}-\d{2}-\d{2}$/;  // Ajustada para el formato de fecha "aaaa-mm-dd"
let regexMotivo = /^[a-zA-Z][a-zA-Z0-9!¡:;,.¿?"']{0,1998}$/;

// Referencias a los elementos del formulario
let titulo = document.getElementById("titulo");
let informacion = document.getElementById("informacion");
let fecha = document.getElementById("fecha");
let imagen = document.getElementById("imagen");
let botonAniadir = document.getElementById("boton1");
let botonBorrar = document.getElementById("boton2");
let contenedorDuplicados = document.getElementById("contenedorDuplicados");
let divOriginal = document.getElementById("duplicadoOriginal");

// Contador para generar IDs únicos
let contadorDuplicados = 0;

// Asignar eventos blur a los campos de entrada
titulo.addEventListener("blur", validarTitulo);
informacion.addEventListener("blur", validarInformacion);
fecha.addEventListener("blur", validarFecha);
imagen.addEventListener("change", validarTamanioImagen);
botonAniadir.addEventListener("click", duplicarDiv);
// botonBorrar.addEventListener("click", borrarDiv);

function duplicarDiv() {
    // Clonar el nodo del div original (incluyendo todos los elementos dentro)
    let nuevoDiv = divOriginal.cloneNode(true);

    // Generar un ID único para el nuevo div clonado
    let nuevoID = "duplicado" + contadorDuplicados;
    nuevoDiv.id = nuevoID;

    // Incrementar el contador para el próximo clon
    contadorDuplicados++;

    // Agregar el nuevo div clonado al contenedor de duplicados
    contenedorDuplicados.appendChild(nuevoDiv);
}


function validarTitulo() {
    validar(regexTitulo, titulo);
}

function validarInformacion() {
    validar(regexInformacion, informacion);
}

function validar(regex, element) {
    if (regex.test(element.value)) {
        // La entrada es válida, aplicar estilo verde
        element.classList.remove("box_shadow_red");
        element.classList.add("box_shadow_green");
    } else {
        // La entrada no es válida, aplicar estilo rojo
        element.classList.remove("box_shadow_green");
        element.classList.add("box_shadow_red");
    }
}

function validarFecha() {
    let fechaIntroducida = fecha.value;
    let fechaFormateada = obtenerFechaActual();

    // Ajustar el formato de fecha formateada al formato "yyyy-mm-dd"
    let fechaFormateadaAjustada = fechaFormateada.split('/').reverse().join('-');

    if (fechaIntroducida <= fechaFormateadaAjustada) {
        // La fecha introducida es válida y es igual o anterior a la fecha actual
        fecha.classList.remove("box_shadow_red");
        fecha.classList.add("box_shadow_green");
    } else {
        // La fecha introducida no es válida o es posterior a la fecha actual
        fecha.classList.remove("box_shadow_green");
        fecha.classList.add("box_shadow_red");
    }
}

function obtenerFechaActual() {
    // Crea un nuevo objeto Date, que representa la fecha y la hora actuales
    let fechaActual = new Date();

    // Formatea la fecha para obtener una cadena legible en el formato "dd/mm/aaaa"
    let opcionesFormato = { year: 'numeric', month: '2-digit', day: '2-digit' };
    let fechaFormateada = fechaActual.toLocaleDateString('es-ES', opcionesFormato);

    return fechaFormateada;
}

function validarTamanioImagen() {
    // Obtener el primer archivo seleccionado (asumimos que solo se permite seleccionar un archivo a la vez)
    let archivo = imagen.files[0];

    // Verificar si se seleccionó un archivo
    if (archivo) {
        // Obtener el tamaño del archivo en bytes
        let tamanoEnBytes = archivo.size;

        // Convertir el tamaño a megabytes (1 megabyte = 1024 * 1024 bytes)
        let tamanoEnMB = tamanoEnBytes / (1024 * 1024);

        // Verificar si el tamaño del archivo es menor o igual a 5 MB
        if (tamanoEnMB <= 3) {
            imagen.classList.remove("box_shadow_red");
            imagen.classList.add("box_shadow_green");
        } else {
            imagen.classList.remove("box_shadow_green");
            imagen.classList.add("box_shadow_red");
        }
    } else {
        imagen.classList.remove("box_shadow_green");
        imagen.classList.add("box_shadow_red");
    }
}

