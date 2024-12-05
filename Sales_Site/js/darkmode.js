const toggleSwitch = document.querySelector('.switch__container ');
const sobre = document.getElementById("sobre");
const sobre_texto = document.getElementById("sobre_texto");
const marcas = document.getElementById('marcas');
// const sobre_texto = document.querySelector('.sobre_texto');

// $("sobre").val('')

function switchTheme(event) {
    if (event.target.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        document.body.classList.add('dark-mode');
        sobre.classList.remove('qualquercoisa');
        sobre.classList.add('qualquercoisa_dark');
        sobre_texto.classList.remove('sobre-texto');
        sobre_texto.classList.add('sobre-texto_dark');
        marcas.classList.add('dark-mode');

        // document.sobre.classList.add('dark-mode');
        // sobre.style = "background-color:black";
        // sobre.style = "color:white";

    }else{
        document.documentElement.setAttribute('data-theme', 'light');
        document.body.classList.remove('dark-mode');
        // sobre.style = "background:white";
        sobre.classList.remove('qualquercoisa_dark');
        sobre.classList.add('qualquercoisa')
        sobre_texto.classList.remove('sobre-texto_dark');
        sobre_texto.classList.add('sobre-texto');
        marcas.classList.remove('dark-mode');



    }
}

toggleSwitch.addEventListener('change', switchTheme, false);