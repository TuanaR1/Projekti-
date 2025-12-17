function hapMeny() {
  const lista = document.getElementById("navLinks");

  if (lista.style.display === "flex") {
    lista.style.display = "none";
  } else {
    lista.style.display = "flex";
  }
}

const form = document.getElementById("contactForm");
const email = document.getElementById("email");
const message = document.getElementById("message");

const emailError = document.getElementById("emailError");
const messageError = document.getElementById("messageError");

form.addEventListener("submit", function(e){
    e.preventDefault();
    let valid = true;

    if(email.value.trim() === ""){
        emailError.textContent = "Email is required";
        valid = false;
    } else if(!/\S+@\S+\.\S+/.test(email.value)){
        emailError.textContent = "Invalid email address";
        valid = false;
    } else {
        emailError.textContent = "";
    }

    if(message.value.trim() === ""){
        messageError.textContent = "Message is required";
        valid = false;
    } else {
        messageError.textContent = "";
    }

    if(valid){
        alert("Message sent successfully!");
        form.reset();
    }
});
