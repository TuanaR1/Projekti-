function hapMeny() {
  const lista = document.getElementById("navLinks");

  if (lista.style.display === "flex") {
    lista.style.display = "none";
  } else {
    lista.style.display = "flex";
  }
}


//Validimi 

const form = document.getElementById("registerForm");
const nameInput = document.getElementById("name");
const username = document.getElementById("username");
const email = document.getElementById("email");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword");

const nameError = document.getElementById("nameError");
const userError = document.getElementById("userError");
const emailError = document.getElementById("emailError");
const passError = document.getElementById("passError");
const confirmError = document.getElementById("confirmError");

form.addEventListener("submit", function(e){
    e.preventDefault();
    let valid = true;

    if(nameInput.value.trim() === ""){
        nameError.textContent = "Name is required";
        valid = false;
    } else {
        nameError.textContent = "";
    }
    if(username.value.trim() === ""){
        userError.textContent = "Username is required";
        valid = false;
    } else {
        userError.textContent = "";
    }

    if(email.value.trim() === ""){
        emailError.textContent = "Email is required";
        valid = false;
    } else if(!/\S+@\S+\.\S+/.test(email.value)){
        emailError.textContent = "Email is invalid";
        valid = false;
    } else {
        emailError.textContent = "";
    }

    

    if(password.value.trim() === ""){
        passError.textContent = "Password is required";
        valid = false;
    } else if(password.value.length < 6){
        passError.textContent = "Password must be at least 6 characters";
        valid = false;
    } else {
        passError.textContent = "";
    }

    if(confirmPassword.value.trim() === ""){
        confirmError.textContent = "Please confirm your password";
        valid = false;
    } else if(confirmPassword.value !== password.value){
        confirmError.textContent = "Passwords do not match";
        valid = false;
    } else {
        confirmError.textContent = "";
    }

    if(valid){
        alert("Registration successful!");
        form.reset();
    }
});
