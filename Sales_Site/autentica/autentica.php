<?php 
include "../SQL/config/conexao.php";

session_start();

if(isset($_POST['btnEntrar']))
{      
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); 
    $senha = $_POST['password']; 
    $mensagem = '';

    if(!isset($email) || strlen(trim($email)) == 0)
    {
        $mensagem = "Informe suas credenciais";
        echo '<style type="text/css">
        #email {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }

    if(strlen(trim($senha)) == 0)
    {
        $mensagem = "Informe suas credenciais";
        echo '<style type="text/css">
        #password {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }

    if(strlen(trim($mensagem)) == 0)
    {   
        // Consulta no banco de dados para verificar as credenciais
        $sql = "SELECT * FROM usuario WHERE email = '$email'";
        $res = pg_query($con, $sql);
        
        // Verifique se a consulta foi bem-sucedida e se retornou resultados
        if ($res && pg_num_rows($res) > 0) {
            $credenciais = pg_fetch_assoc($res);
            
            // Verifique se a senha é válida
            if(password_verify($senha, $credenciais['senha'])){
                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = $credenciais['nome'];
                $_SESSION['email'] = $credenciais['email'];
                $_SESSION['fabrica'] = $credenciais['fabrica'];
                header("Location: ../index.php");
                exit;
            } else {
                $mensagem = "Credenciais inválidas";
                $alert = "warning";
            }
        } else {
            $mensagem = "Credenciais inválidas";
            $alert = "warning";
        }
    }
}

?>
