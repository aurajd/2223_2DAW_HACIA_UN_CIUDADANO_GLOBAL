function validarFormulario() {
    // Obtener el valor del nombre de usuario
    let username = document.getElementById("username").value;

    // Expresión regular para verificar que no comienza con números y tiene máximo 30 caracteres
    let usernameRegex = /^[a-zA-Z][a-zA-Z0-9]{0,29}$/;

    // Verificar si el nombre de usuario cumple con la expresión regular
    if (!usernameRegex.test(username)) {
        // Mostrar mensaje de error
        document.getElementById("usernameError").innerHTML = "El nombre de usuario no es válido.";
        return false; // Evitar que el formulario se envíe
    } else {
        // Limpiar mensaje de error si es válido
        document.getElementById("usernameError").innerHTML = "";
        return true; // Permitir que el formulario se envíe
    }
}