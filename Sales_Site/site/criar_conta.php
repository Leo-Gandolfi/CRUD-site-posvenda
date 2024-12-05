<?php
include "../SQL/config/conexao.php";

$mensagem = '';
$usuario = '';
$senha = '';
$email = '';

if(isset($_POST["btnCriar"]))
{   
    $senhaValidada = True;
    $usuario = filter_var($_POST['nome']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = filter_var($_POST['senha']);
    $confirmaSenha = filter_var($_POST['confirma_senha']);
    $fabrica = ($_POST['fabrica']);
    $mensagem = '';
    
    $emailVerificado = filter_var($email, FILTER_SANITIZE_EMAIL);

    if(strlen($usuario) < 4){
        $mensagem .= "Usuario deve ter ao menos 4 caracteres.<br>";
        echo '<style type="text/css">
        #nome    {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }

    if (!filter_var($emailVerificado, FILTER_VALIDATE_EMAIL)) {
        $mensagem .= "Email invalido. <br>";
        echo '<style type="text/css">
        #email {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }   
    if(strlen(trim($senha)) < 6)
    {
        $mensagem .= "A senha deve ter, no mínimo, 6 caracteres.<br>";
        echo '<style type="text/css">
        #senha {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }

    elseif($senha != $confirmaSenha){
        $mensagem .= "Senhas não confirmam.<br>";
        echo '<style type="text/css">
        #confirma_senha {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }

    if(strlen($fabrica) == 0){
        $mensagem .= "Selecione uma fábrica";
        $alert = "warning"; 
    }

    if($mensagem == ''){
        $sql = "select * from usuario where nome = '$usuario'";
        $res = pg_query($con, $sql);

        if(pg_num_rows($res) > 0){
            $mensagem .= "Usuário ja cadastrado <br>";
            echo '<style type="text/css">
            #nome{
                border: 2px groove red;
            }
            </style>';
            $alert = "alert alert-warning";
        }

        $sql = "select * from usuario where email = '$email'";
        $res = pg_query($con, $sql);

        if(pg_num_rows($res) > 0){
            $mensagem .= "Email ja cadastrado.";
            echo '<style type="text/css">
            #email{
                border: 2px groove red;
            }
            </style>';
            $alert = "alert alert-warning";
        }
    }   

    if($mensagem == '')
    {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (nome, email, senha, fabrica) VALUES ('$usuario', '$email', '$senha', '$fabrica')";
        
        $res = pg_query($con, $sql);
        $mensagem = "Conta criada! Clique acima para entrar!";
        $alert = "alert alert-success";

        if(strlen(pg_last_error($con)) > 0)
        {
            $mensagem = "Falha ao gravar usuario";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/logo.jpg" type="image/icon type"/>
    <title>Criar Conta</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style/estilo.css">
</head>
<body>

<div class="container">
    <div class="col-md-1 col-sm-1"></div>

    <div style="background:white; margin-top:5%; padding:20px 0 ; border-radius:10px" class="col-md-12">
        
        <div class="col-md-6 text-center"><h1>Junte-se a nós!</h1><img src="/img/people.jpg" style="border:5px solid black; border-radius:10px; margin-top:5%" alt="Happy"></div>
        <div class="col-md-4">
            <div class="text-center"><h1>Criar Conta</h1></div>
            <form method="post">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" value="<?=$usuario?>" class="form-control" id="nome" >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?=$email?>" class="form-control" id="email" aria-describedby="emailHelp" >
                    <small id="emailHelp" class="form-text text-muted">Nunca iremos compartilhar seu email.</small>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Senha</label>
                    <div style="display:flex" class="form-group">
                        <input type="password" name="senha" class="form-control" id="senha" >
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('senha')">👁️</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirma_senha">Confirme a Senha</label>
                    <input type="password" name="confirma_senha" class="form-control" id="confirma_senha">
                </div>

                <label for="confirma_senha">Fabrica</label>
                <select value="" name="fabrica" class="form-control text-center">
                    <option value="">Selecione o nome da Fábrica...</option>
                    <?php
                    $sql_fabrica = "select * from fabrica";
                    $res_fabrica = pg_query($con, $sql_fabrica);

                    for ($i = 0; $i < pg_num_rows($res_fabrica); $i++) {
                        $id_fabrica = pg_fetch_result($res_fabrica, $i, 'fabrica');
                        $nome_fabrica = pg_fetch_result($res_fabrica, $i, 'nome');
                    ?>
                    <option name="fabrica" value="<?= $id_fabrica?>"><?=$nome_fabrica ?> </option>
                    <?php
                    }
                    ?>
                </select>

                <div class="text-center">
                <button style="margin:10px;" name="btnCriar" type="submit" class="btn btn-primary">Criar</button>
                </form>
                <br>
                <a href="login.php">Já tem uma conta? Entre por aqui</a>
                <div class="alert alert-<?=$alert?> text-center" role="alert">
                    <?=$mensagem?>
                </div>
            </div>
        </div>
    </div>  
    
    <div class="col-md-1 col-sm-1"></div>
</div>

</body>

<script>
    function togglePassword(fieldId) {
        var field = document.getElementById(fieldId);
        var field2 = document.getElementById('confirma_senha');
        var type = field.type === "password" ? "text" : "password";
        field.type = type;
        field2.type = type;
    }
</script>

</html>
