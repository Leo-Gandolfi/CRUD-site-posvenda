<?php
    
include("navbar.php");

$codigo = '';
$descricao = '';
$mensagem = '';

if (isset($_POST['deleteInfo'])) {
    $id = $_POST['delete_table'];
    $sql = "delete from defeito where defeito='$id'";
    $res = pg_query($con, $sql);
    $mensagem = "Fábrica Deletada";
    $alert = "success";

}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "select * from defeito where defeito = '$id' and fabrica='$sessao'";
    $res = pg_query($con, $sql);

    $parametros = pg_fetch_assoc($res);

    // echo "ALOU" . $descricao . $codigo; exit;

    $codigo = $parametros['codigo'];
    $descricao = $parametros['descricao'];

}

if (isset($_POST['btnCadastrar'])) {
    $codigo = filter_var($_POST['codigo'], FILTER_SANITIZE_STRING);
    $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_STRING);
    $mensagem = '';

    // VERIFICA SE O CAMPO ESTÁ VAZIO.  
    if (empty(trim($codigo))) {
        $mensagem .= 'Digite a Referência. <br>';
        echo '<style type="text/css">
        #codigo{
            border: 2px groove red;
        }
        </style>';
        $alert = "alert alert-danger";
    }
    if (strlen(trim($descricao)) < 10) {
        $mensagem .= 'Descreva o defeito (10 caracteres min). <br>';
        echo '<style type="text/css">
        #descricao {
            border: 2px groove red;
        }
        </style>';
        $alert = "alert alert-danger";


        $erro = 'n';
    }


    if (isset($_GET['id']) and strlen($mensagem) == 0) {
        $sql = "UPDATE defeito SET codigo = '$codigo', descricao = '$descricao' where defeito='$id'";
        $res = pg_query($con, $sql);
        $alert = "alert alert-info";
        $mensagem = "Cadastro atualizado!";
        header('location: http://localhost:8080/site/form-defeito.php?');

    }
    if (strlen($mensagem) == 0) {
        $sql = "select * from defeito where codigo = '$codigo' and fabrica='$sessao'";
        $res = pg_query($con, $sql);

        if (pg_num_rows($res) >= 1) {
            $alert = "warning";
            $mensagem = 'Código anteriormente cadastrado';
        }

        if (strlen($mensagem) == 0) {
            $sql = "INSERT INTO defeito (codigo, descricao, fabrica) VALUES ('$codigo','$descricao', '$sessao')";
            $res = pg_query($con, $sql);
            $mensagem = "Defeito cadastrado! ";
            $alert = "success";

            if (pg_last_error($con) > 0) {
                $alert = "warning";
                $mensagem = "Falha ao cadastrar defeito.";
            }
        }
    }
}

?>


    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Apagar Defeito?</h1>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="deleteIdHolder" value="" class="deleteIdHolder">
                        <button type="submit" name="deleteInfo" class="btn btn-primary">Sim</button>
                        <button type="submit" name="close" class="btn btn-primary">Não</button>
                        <input type="hidden" class="form-control delete_table" name="delete_table" value=""
                            id="delete_table" placeholder="">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="" class="container">
        <div class="row">
        <div class="col-md-2"></div>
        <div style="background:lightgray; padding:30px; border: 2px solid black; margin-top:3%; border-radius:10px" class="col-md-8">
        <form method="POST">
                <span class="text-center" id="">
                    <h1>Defeito</h1>
                </span>

                <div class="form-group">
                    <label for="exampleInputEmail1">CÓDIGO:</label>
                    <input type="text" id="codigo" class="form-control codigo" name="codigo"
                        value="<?= $codigo ?>" placeholder="">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">DESCRIÇÃO:</label>
                    <input type="text" value="<?= $descricao ?>" id="descricao" name="descricao" class="form-control"
                        placeholder="">
                </div>
                <input type="hidden" value="<?=$sessao?>">
                <div class="form-group text-center">
                    <br>
                    <button type="submit" value="1" name="btnCadastrar" class="btn btn-default">Cadastrar</button>
                </div>
                <div class="alert alert-<?= $alert ?> text-center" role="alert">
                    <?= $mensagem ?>
                </div>
            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
    </div>

    
    <?php

    $sql = "select * from defeito where fabrica='$sessao'";
    $res = pg_query($con, $sql);

    if(pg_num_rows($res) > 0){
        ?>
    <div style="background:white; width:60%; margin-top:20px; border: 2px solid black; border-radius:10px"
    class="container table-responsive">
    <a type="button" href="lista/gerar_arquivo.php?tipo=defeito" class="btn btn-primary"><i class="bi bi-file-earmark-medical"></i> Excel</a>
    <table class="table">
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
    
                <?php
                for ($i = 0; $i < pg_num_rows($res); $i++) {
    
                    $id = pg_fetch_result($res, $i, 'defeito');
                    $codigo = pg_fetch_result($res, $i, 'codigo');
                    $descricao = pg_fetch_result($res, $i, 'descricao');
    
                    ?>
    
                    <tr>
                        <td><?= $codigo ?></td>
                        <td><?= $descricao ?></td>
                        
                        <td><button name="btnEditar" value="" href=" " onclick="sendID(<?= $id ?>);" class="tn btn-primary btn">Editar</button></td>
                        <td><form method="POST"><a type="button" onclick="deleteID(<?= $id ?>)" name="excluir" class="btn btn-primary btn" data-toggle="modal" data-target="#deleteModal">Apagar</a></form></td>
    
                    </tr>
    
                <?php }}else{ $mensagem = "Nenhum cadastro encontrado"; $alert="warning"; ?>
                            <div class="alert alert-<?= $alert ?> text-center" role="alert">
                                <?= $mensagem ?>
                            </div>
                <?php } ?>
            </tbody>
    </div>
    <script>

        $(function () {
            $("table tbody tr").mouseover(function () {
                $(this).addClass("encima");
            })
            $("table tbody tr").mouseleave(function () {
                $(this).removeClass("encima");
            })

            window.parent.retornaProduto(codigo, descricao);
            window.parent.Shadowbox.close();
        })

        function sendID(id) {
            window.location.href = "/site/form-defeito.php?&id=" + id;
        }

        function deleteID(id) {
            $('.delete_table').val(id);
        }
    </script>
</body>

</html>