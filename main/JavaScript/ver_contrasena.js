let eyeicon = document.getElementById("eyeicon");

let password = document.getElementById("contrasena_inicioses");

eyeicon.onclick = function(){
    if(password.type == "password"){
        password.type = "text";
        eyeicon.src = "../../IMAGENES/eye-open.png";
    }else{
        password.type = "password";
        eyeicon.src = "../../IMAGENES/eye-close.png";
    }
}