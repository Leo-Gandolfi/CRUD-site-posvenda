<?php

include "../autentica/autentica.php";
include("navbar.php");

session_start();

if (isset($_POST['deleteInfo'])) {
    $id = $_POST['delete_table'];
    $sql = "delete from fabrica where fabrica='$id'";
    $res = pg_query($con, $sql);
    $mensagem = "Fábrica Deletada";
    $alert = "success";

}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "select * from fabrica where fabrica = '$id'";
    $res = pg_query($con, $sql);
    $parametros = pg_fetch_assoc($res);
    $nome = $parametros['nome'];
}

if (isset($_POST['btnCadastrar'])) {
    $sessao = $_SESSION['fabrica'];
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);

    if (empty(trim($nome))) {
        $mensagem .= 'Digite o nome da fábrica.<br>';
        echo '<style type="text/css">
        #nome {
            border: 2px groove red;
        }
        </style>';
    }

    if (isset($_GET['id'])) {
        if (strlen(trim($nome)) == 0) {
            $mensagem = "Campo não pode ficar vazio";
            $alert = "warning";
        }

        if (strlen(trim($mensagem)) == 0) {
            $id = $_GET['id'];
            $sql = "update fabrica set nome = '$nome' where fabrica = '$id'";
            $res = pg_query($con, $sql);
            $mensagem = "Fabrica Atualizada";
            if (strlen(pg_last_error($con) > 0)) {
                $mensagem = "Falha ao atualizar";
            }
        }
    }

    if (strlen(trim($mensagem)) == 0) {
        $sql = "select * from fabrica where nome = '$nome'";
        $res = pg_query($con, $sql);

        if (pg_num_rows($res) >= 1) {
            $mensagem = 'Fábrica anteriormente cadastrada';
            $alert = "warning";
        }

        if (strlen(trim($mensagem)) == 0) {
            $sql = "INSERT INTO fabrica (nome) VALUES ('$nome')";
            $res = pg_query($con, $sql);
            $mensagem = "Fábrica cadastrada! ";
            $alert = "success";
            if (pg_last_error($con) > 0) {
                $mensagem = "Falha ao cadastrar fábrica.";
            }
        }
    }
}

?>

<script>

    function sendID(id) {
        console.log("Olá");
        window.location.href = "form-fabrica.php?&id=" + id;
    }

</script>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Excluir fábrica?</h1>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="deleteIdHolder" value="" class="deleteIdHolder">
                        <button type="submit" name="deleteInfo" class="btn btn-primary">Sim</button>
                        <button type="button" name="close" data-dismiss="modal" class="btn btn-primary">Não</button>
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
        <div style="background:lightgray; border: 2px solid black; margin-top:3%; border-radius:10px" class="col-md-8">
            <form method="POST">
                <span class="text-center" id="">
                    <h1>Fábrica</h1>
                </span>

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control nome" name="nome" value="<?= $nome ?>" id="nome"
                        placeholder="">
                </div>

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


    <div style="background:white; width:60%; margin-top:20px; border: 2px solid black; border-radius:10px"
        class="container table-responsive">
        <table class="table">

            <?php

            $sql = "select * from fabrica";
            $res = pg_query($con, $sql);
            ?>
            <thead>
                <tr>
                    <th>Chave</th>
                    <th>Nome</th>
                </tr>
            </thead>
            <tbody>

                <?php
                for ($i = 0; $i < pg_num_rows($res); $i++) {

                    $id = pg_fetch_result($res, $i, 'fabrica');
                    $nome = pg_fetch_result($res, $i, 'nome');



                    ?>

                    <tr>
                        <td>
                            <?= $id ?>
                        </td>
                        <td>
                            <?= $nome ?>
                        </td>
                        <td><button name="btnEditar" value="" href=" " onclick="sendID(<?= $id ?>);"
                                class="btn btn-primary btn">Editar</button></td>
                        <td>
                            <form method="POST"><a type="button" onclick="deleteID(<?= $id ?>)" name="excluir"
                                    class="btn btn-primary btn" data-toggle="modal" data-target="#deleteModal">Apagar</a>
                            </form>
                        </td>

                    </tr>

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

            window.parent.retornaFabrica(fabrica, nome);
            window.parent.Shadowbox.close();
        })

        function deleteID(id) {
            $('.delete_table').val(id);
        }
    </script>


</body>

</html>