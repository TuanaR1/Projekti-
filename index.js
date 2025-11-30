function hapMeny() {
  const lista = document.getElementById("navLinks");

  if (lista.style.display === "flex") {
    lista.style.display = "none";
  } else {
    lista.style.display = "flex";
  }
}