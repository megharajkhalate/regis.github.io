var Password = document.getElementById("Password");
var confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(Password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");


  } else {
        confirm_password.setCustomValidity('');


  }
}
Password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

