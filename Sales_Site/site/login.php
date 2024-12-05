<?php
include "../autentica/autentica.php";
include "../SQL/config/conexao.php";

$email = $email ?? '';
$mensagem = $mensagem ?? '';
$alert = $alert ?? 'info';
?>

<!DOCTYPE html>
<html lang="pt-BR"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/logo.jpg" type="image/png"/>
    <title>Login - SalesSite</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/estilo.css">
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-container">
            <h2 class="text-center mb-4">Login</h2>
            <form method="post" class="needs-validation" novalidate>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="<?= htmlspecialchars($email) ?>" 
                        placeholder="Digite seu email" 
                        class="form-control" 
                        id="email" 
                        aria-describedby="emailHelp" 
                        required>

                </div>
                <div class="form-group mb-4">
                    <label for="password">Senha</label>
                    <input 
                        type="password" 
                        class="form-control" 
                        name="password" 
                        id="password" 
                        placeholder="Digite sua senha" 
                        required>

                </div>
                <div class="text-center">
                    <button 
                        name="btnEntrar" 
                        type="submit" 
                        class="btn btn-primary w-100">
                        Entrar
                    </button>
                </div>
                <div class="text-center mt-3">
                    <a href="criar_conta.php">Não tem uma conta? Crie aqui!</a>
                </div>
                <?php if (!empty($mensagem)): ?>
                    <div class="alert alert-<?= htmlspecialchars($alert) ?> text-center mt-3" role="alert">
                        <?= htmlspecialchars($mensagem) ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>


</body>
</html>
