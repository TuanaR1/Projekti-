function hapMeny() {
  const lista = document.getElementById("navLinks");

  if (lista.style.display === "flex") {
    lista.style.display = "none";
  } else {
    lista.style.display = "flex";
  }
}

// Validimi formes

const form = document.getElementById("loginForm");
const username = document.getElementById("username");
const password = document.getElementById("password");
const userError = document.getElementById("userError");
const passError = document.getElementById("passError");

form.addEventListener("submit", function (e) {
    e.preventDefault();

    let valid = true;

    if (username.value.trim() === "") {
        userError.textContent = "Username is required";
        valid = false;
    } else {
        userError.textContent = "";
    }

    if (password.value.trim() === "") {
        passError.textContent = "Password is required";
        valid = false;
    } else if (password.value.length < 6) {
        passError.textContent = "Password must be at least 6 characters";
        valid = false;
    } else {
        passError.textContent = "";
    }

    if (valid) {
        alert("Login successful!");
        form.reset();
    }
});
