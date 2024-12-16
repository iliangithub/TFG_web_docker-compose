let eyeicon2 = document.getElementById("eyeicon2");

let password2 = document.getElementById("input_error2");

eyeicon2.onclick = function(){
    if(password2.type == "password"){
        password2.type = "text";
        eyeicon2.src = "../../IMAGENES/eye-open.png";
    }else{
        password2.type = "password";
        eyeicon2.src = "../../IMAGENES/eye-close.png";
    }
}