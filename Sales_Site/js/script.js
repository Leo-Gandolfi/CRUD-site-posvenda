

// Adicione este código se quiser que o submenu desapareça quando clicar fora do menu
document.addEventListener("click", function(e) {
    var dropdown = document.querySelectorAll(".dropdown");
    for (var i = 0; i < dropdown.length; i++) {
      if (!dropdown[i].contains(e.target)) {
        dropdown[i].classList.remove("active");
      }
    }
  });
  
  // Adicione este código se quiser que o submenu apareça/desapareça quando clicar no item de menu
  var dropdown = document.querySelectorAll(".dropdown > a");
  for (var i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function(e) {
      var submenu = this.nextElementSibling;
      submenu.classList.toggle("active");
      e.preventDefault();
    });
  }
  
  