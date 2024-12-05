<?php
include("navbar.php");

$checked = "checked";



if (isset($_POST['deleteInfo'])) {
    $id = $_POST['deleteIdHolder'];
    $sql = "delete from peca where peca='$id' and fabrica='$sessao'";
    $res = pg_query($con, $sql);
    $mensagem = "Peça Deletada";
    $alert = "success";
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "select * from peca where peca = '$id' and fabrica='$sessao'";

    $res = pg_query($con, $sql);

    $parametros = pg_fetch_assoc($res);

    // echo "ALOU" . $descricao . $referencia; exit;

    $referencia = $parametros['referencia'];
    $descricao = $parametros['descricao'];
    $ativo = $parametros['ativo'];
    if ($ativo == 't') {
        $checked = "checked";
    } else {
        $checked = "";
    }


}

if (isset($_POST['btnCadastrar'])) {
    $sessao = trim($_SESSION['fabrica']);
    $referencia = filter_var($_POST['referencia'], FILTER_SANITIZE_STRING);
    $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_STRING);
    $ativo = (int) ($_POST['ativo'] == "t") ? 'true' : 'false';
    $mensagem = '';

    // VERIFICA SE O CAMPO ESTÁ VAZIO.  
    if (empty($referencia)) {
        $mensagem .= 'Digite a referência.<br>';
        $erro = 'TRUE';
        echo '<style type="text/css">
        #referencia {
            border: 2px groove red;
        }
        </style>';
    }
    
    if (strlen(trim($descricao)) < 5) {
        $mensagem .= 'Descreva a peça(5 caracteres min).<br>';
        echo '<style type="text/css">
        #descricao {
            border: 2px groove red;
        }
        </style>';
        $alert = "alert alert-danger";

    }
    
    if (isset($_GET['id']) and strlen($mensagem) == 0) {
        $sql = "UPDATE peca SET referencia = '$referencia', descricao = '$descricao' where peca='$id' and fabrica='$sessao'";
        $res = pg_query($con, $sql);
        $mensagem = "Cadastro atualizado!";
        header('location: http://localhost:8080/site/form-peca.php');
    }

    $sql = "select * from peca where referencia = '$referencia' and fabrica=$sessao";
    $res = pg_query($con, $sql);

    if(pg_num_rows($res) > 0 and strlen($mensagem) == 0){
        $mensagem = "Referência anteriormente Cadastrada";
        $alert = "warning";
    }


    if (strlen($mensagem) == 0) {
        $sql = "INSERT INTO peca (referencia, descricao, fabrica) VALUES ('$referencia','$descricao', '$sessao')";
        $res = pg_query($con, $sql);
        $mensagem = "Peça cadastrada! ";
        $alert = "success";
        if (pg_last_error($con) > 0) {
            $mensagem = "Falha ao cadastrar atendimento.";
            $alert = "danger";
        }
    }
}

?>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Excluir formulário? </h1>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="deleteIdHolder" value="" class="deleteIdHolder">
                        <button type="submit" name="deleteInfo" class="btn btn-primary">Sim</button>
                        <button type="button" name="close" data-dismiss="modal" class="btn btn-primary">Não</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--AQUI FICA O FORMULÁRIO -->

    <div id="" class="container">
        <div class="row">
        <div class="col-md-2"></div>
        <div style="background:lightgray; border: 2px solid black; margin-top:3%; border-radius:10px" class="col-md-8">
            <form method="POST">
                <span class="text-center" id="">
                    <h1>Peças</h1>
                </span>

                <div class="form-group">
                    <label for="referencia">REFERENCIA:</label>
                    <input type="text" class="form-control referencia" name="referencia" value="<?= $referencia ?>"
                        id="referencia" placeholder="">
                </div>

                <div class="form-group">
                    <label for="descricao">DESCRIÇÃO:</label>
                    <input type="text" value="<?= $descricao ?>" name="descricao" class="form-control" id="descricao"
                        placeholder="">
                </div>

                <div class="form-group text-center">
                    <br>
                    <button type="submit" value="1" name="btnCadastrar" class="btn btn-primary">Cadastrar</button>
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

$sql = "select * from peca where fabrica = '$sessao'";
$res = pg_query($con, $sql);

if(pg_num_rows($res) > 0){
    ?>
<div style="background:white; width:60%; margin-top:20px; border: 2px solid black; border-radius:10px"
class="container table-responsive">
<a type="button" href="lista/gerar_arquivo.php?tipo=peca" class="btn btn-primary"><i class="bi bi-file-earmark-medical"></i> Excel</a>
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

                $id = pg_fetch_result($res, $i, 'peca');
                $referencia = pg_fetch_result($res, $i, 'referencia');
                $descricao = pg_fetch_result($res, $i, 'descricao');

                ?>

                <tr>
                    <td><?= $referencia ?></td>
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

        // $(".pesquisar").click(function(){

        //     var serie = $(".serie").val(); 
        //     var referencia = $(".referencia").val(); 
        //     var descricao = $(".descricao").val(); 
        //     var peca = $(".peca").val(); 
        // )}

        $(function () {
            $("table tbody tr").mouseover(function () {
                $(this).addClass("encima");
            })
            $("table tbody tr").mouseleave(function () {
                $(this).removeClass("encima");
            })

            window.parent.retornaPeça(referencia, descricao);
            window.parent.Shadowbox.close();
        })


        $("ativo").prop("checked", true);
        $("ativo").prop("checked", false);

        function deleteID(id) {
            $('.deleteIdHolder').val(id);
        }

        function sendID(id) {
            window.location.href = "form-peca.php?&id=" + id;
        }
    </script>
</body>

</html>