function hapMeny() {
  const lista = document.getElementById("navLinks");

  if (lista.style.display === "flex") {
    lista.style.display = "none";
  } else {
    lista.style.display = "flex";
  }
}

const productCards = document.querySelectorAll('.product-card');

productCards.forEach(card => {
  const radios = card.querySelectorAll('input[type="radio"]');
  const priceElem = card.querySelector('.price-value');

  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      priceElem.textContent = radio.dataset.price;
    });
  });
});
