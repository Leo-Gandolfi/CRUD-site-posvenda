<?php 


session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/SQL/config/conexao.php";

//include "../autentica/autentica.php";

if (!isset($_SESSION['logged_in'])) {
    header('Location: ../site/login.php');
    exit;
}


$sessao = trim($_SESSION['fabrica']);
$nome = trim($_SESSION['user']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Site</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="/img/logo.jpg" />
    <link rel="stylesheet" href="/css/shadowbox.css">
    <link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/style/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>


<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/index.php"><img style="width:100%; height:100%" src="../img/logo.jpg" alt=""></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#"></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Formulários <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/site/form-peca.php">Peças</a></li>
            <li><a href="/site/form-produto.php">Produtos</a></li>
            <li><a href="/site/form-atendimento.php">Atendimento</a></li>
            <!-- <li role="separator" class="divider"></li> -->
            <li><a href="/site/form-defeito.php">Defeito</a></li>
            <!-- <li role="separator" class="divider"></li> -->
            <li><a href="/site/form-fabrica.php">Fábrica</a></li>
          </ul>
        </li>
      </ul>

      <ul class="nav navbar-nav">
        <li><a href="#"></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ordem de Serviço <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/site/form-os.php">Cadastro OS</a></li>
            <li><a href="/site/pesquisa-os.php">Pesquisa OS</a></li>

          </ul>
        </li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="#">Link</a></li> -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="bi bi-gear-fill"></i> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Perfil</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="/site/logout.php">Sair</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="../js/shadowbox.js"></script>

