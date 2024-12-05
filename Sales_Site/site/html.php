<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <nav>
    <ul>
        <li><a href="#">Menu Item 1</a></li>
        <li><a href="#">Menu Item 2</a>
        <ul>
            <li><a href="#">Submenu Item 1</a></li>
            <li><a href="#">Submenu Item 2</a></li>
        </ul>
        </li>
        <li><a href="#">Menu Item 3</a>
        <ul>
            <li><a href="#">Funci</a></li>
            <li><a href="#">Funci</a></li>
            <li><a href="#">Funci</a></li>
        </ul>
        </li>

    </ul>
    </nav>
    <style>
        nav ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

nav li {
  display: inline-block;
  position: relative;
}

nav a {
  display: block;
  padding: 10px;
  text-decoration: none;
  color: #333;
}

nav ul ul {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  background-color: #fff;
  padding: 0;
  margin: 0;
  border: 1px solid #ccc;
  z-index: 1;
}

nav ul ul li {
  display: block;
  width: 100%;
}

nav li:hover > ul {
  display: block;
}

nav ul ul li:hover {
  background-color: #f5f5f5;
}

nav ul ul a {
  color: #333;
  padding: 10px;
  display: block;
}

nav ul ul ul {
  left: 100%;
  top: 0;
}

    </style>

    <script>
        
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

    </script>
</body>
</html>