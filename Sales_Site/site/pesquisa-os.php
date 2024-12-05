<?php

include "SQL/config/conexao.php";
include("navbar.php");

$mensagem = '';
$cond = "";


if (isset($_POST['btnPesquisar'])) {
    $mensagem = "";
    $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_STRING);

    $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_STRING);
    $dataAbertura = filter_var($_POST['dataAbertura'], FILTER_SANITIZE_STRING);
    $dataInicio = filter_var($_POST['dataInicio'], FILTER_SANITIZE_STRING);
    $dataFim = filter_var($_POST['dataFim'], FILTER_SANITIZE_STRING);
    $referencia = filter_var($_POST['referencia'], FILTER_SANITIZE_STRING);
    $tipoData = filter_var($_POST['tipoData'], FILTER_SANITIZE_STRING);
    $limpar = array('(', ')', '-', '.', ' ');
    $cpf = str_replace($limpar, '', $cpf);

    function inverterData($data)
    {
        $partes = explode('/', $data);
        $nova_data = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
        return $nova_data;
    }
    // $dataInicio = inverterData($dataInicio);
// $dataFim = inverterData($dataFim);

    // echo "data inicio e fim :" . $dataInicio . "   " . $dataFim. ". tipo data: " . $tipoData; exit;

    if (empty($cpf) and empty($descricao) and empty($dataAbertura) and empty($referencia) and empty($dataInicio) and empty($dataFim)) {
        $mensagem = "Sem parâmetros para pesquisa";
        $alert = "alert alert-danger";
    }

    if(!empty($dataInicio) and empty($dataFim)){
        $mensagem = "Falha no período. Necessário digitar data de início e fim.";
        $alert = "alert alert-warning";

    }

    if(!empty($dataFim) and empty($dataAbertura)){
        $mensagem = "Falha no período. Necessário digitar data de início e fim.";
        $alert = "alert alert-warning";


    }

    if (strlen($mensagem) == 0) {

        if (strlen(trim($cpf)) > 0) {
            $cond .= "and os.cpf_cnpj = '$cpf'";
        }

        if (strlen(trim($descricao)) > 0) {
            $cond .= "WHERE produto.descricao LIKE '%$descricao%'";
        }

        if (strlen(trim($dataAbertura)) > 0) {
            $cond .= "and os.data_abertura = '$dataAbertura'";
        }

        if (strlen(trim($referencia)) > 0) {
            $cond .= "and produto.referencia = '$referencia'";
        }

        if (strlen(trim($dataInicio)) > 0 and strlen(trim($dataFim)) > 0) {
            $cond .= "and $tipoData between '$dataInicio' and '$dataFim'";
        }

        if(strlen($mensagem)==0){
            $sql = "SELECT os.*, produto.descricao, produto.referencia FROM os
            JOIN produto ON os.produto = produto.produto $cond";
            $res = pg_query($con, $sql);
            if (pg_num_rows($res) < 1) {
                $mensagem = "Nenhum Cadastro Encontrado";
                $alert = "alert alert-warning";
                $erro = "true";
            }
    
            if (strlen(pg_last_error($con)) > 0) {
                $mensagem = "Falha na pesquisa";
                $alert = "alert alert-danger";

            }

        }

    }
}

if (isset($_POST['deleteInfo'])) {
    $id = $_POST['deleteIdHolder'];
    $sql = "delete from os where os='$id'";
    $res = pg_query($con, $sql);
    $mensagem = "Cadastro OS apagado";
    $alert = "alert alert-success";
}

?>


<script>
    function retornaID(id) {

        $(".id").val(id)
    }
</script>

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

    <div style="margin-top: 3%; background: lightgray; box-shadow: 2px 2px 20px 5px rgb(0, 0, 0);"class="container">
        <form method="POST" action="">
                <div class="col-md-12">
                    <span class="text-center" id="">
                        <h1>Pesquisar na Tabela OS</h1>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12"><br></div>
                </div>
            <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                    <label for="dataAbertura">Pesquisar por:</label><br>
                    <label class="">
                        <input type="radio" name="tipoData" class="tipoData" value="data_abertura" id="option1"
                            checked> Data Abertura
                    </label>
                    <label class="">
                        <input type="radio" name="tipoData" class="tipoData" value="data_fechamento" id="option2">
                        Data Fechamento
                    </label>
                    <label class="">
                        <input type="radio" name="tipoData" class="tipoData" value="data_digitacao" id="option3">
                        Data Digitação
                    </label>
                    </div>
                </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" class="form-control cpf" name="cpf" id="cpf" value="<?= $cpf ?>"
                            placeholder="Documento">
                    </div>
                    <label for="serie">Referência:</label>
                        <input type="text" value="<?= $referencia ?>" name="serie" class="form-control" id="referencia"
                            placeholder="">
                        <button type="button" class="btn btn-default pesquisarInfo" aria-label="Left Align">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                </div>

                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="dataInicio">Data Início:</label>
                        <input type="text" value="<?= $dataInicio ?>" name="dataInicio"
                            class="form-control dataInicio" id="dataInicio" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="dataFim">Data Fim:</label>
                        <input type="text" value="<?= $dataFim ?>" name="dataFim" class="form-control dataFim"
                            id="dataFim" placeholder="">
                    </div>

                </div>
                <div class="col-md-1"></div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="form-group text-center">
                        <button type="submit" value="" name="btnPesquisar"
                            class="btn btn-primary">Pesquisar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="<?=$alert?> text-center" role="alert">
        <?= $mensagem ?>
    </div>
    </div>

    <input value="" type="hidden" class="id" name="id" id="id">

        <?php
        if (isset($_POST['btnPesquisar']) and strlen($mensagem)==0) {
            ?>
                <div style="background:white; margin-top: 2%; border-radius:5px ;" class='table-responsive'>
                    <table class="table">

                        <thead>
                            <tr>
                                <th> Data de Abertura </th>
                                <th> Nota Fiscal </th>
                                <th> Data de Compra </th>
                                <th> Aparência </th>
                                <th> Acessórios </th>
                                <th> Nome </th>
                                <th> CPF </th>
                                <th> CEP </th>
                                <th> Estado </th>
                                <th> Cidade </th>
                                <th> Bairro </th>
                                <th> Endereço </th>
                                <th> Número </th>
                                <th> Complemento </th>
                                <th> Telefone </th>
                                <th> Celular </th>
                                <th> Email </th>
                                <th> Número de Série </th>
                                <th> Referência </th>
                                <th style="background:lightblue"> Produto </th>
                                <th style="background:lightblue"> Descrição </th>
                                <th> Defeito </th>
                                <th> Nº Atendimento </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            for ($i = 0; $i < pg_num_rows($res); $i++) {
                                $id = pg_fetch_result($res, $i, 'os');
                                $dataabertura = pg_fetch_result($res, $i, 'data_abertura');
                                $notafiscal = pg_fetch_result($res, $i, 'nota_fiscal');
                                $datacompra = pg_fetch_result($res, $i, 'data_compra');
                                $aparencia = pg_fetch_result($res, $i, 'aparencia');
                                $acessorios = pg_fetch_result($res, $i, 'acessorio');
                                $nome = pg_fetch_result($res, $i, 'nome_consumidor');
                                $cpf = pg_fetch_result($res, $i, 'cpf_cnpj');
                                $cep = pg_fetch_result($res, $i, 'cep_consumidor');
                                $estado = pg_fetch_result($res, $i, 'estado_consumidor');
                                $cidade = pg_fetch_result($res, $i, 'cidade_consumidor');
                                $bairro = pg_fetch_result($res, $i, 'bairro_consumidor');
                                $endereco = pg_fetch_result($res, $i, 'endereco_consumidor');
                                $numero = pg_fetch_result($res, $i, 'numero_consumidor');
                                $telefone = pg_fetch_result($res, $i, 'telefone_consumidor');
                                $celular = pg_fetch_result($res, $i, 'celular_consumidor');
                                $email = pg_fetch_result($res, $i, 'email_consumidor');
                                $produto = pg_fetch_result($res, $i, 'produto');
                                $numero_serie = pg_fetch_result($res, $i, 'numero_serie');
                                $referencia = pg_fetch_result($res, $i, 'referencia');
                                $descricao = pg_fetch_result($res, $i, 'descricao');
                                $selectdefeito = pg_fetch_result($res, $i, 'defeito');
                                $complemento = pg_fetch_result($res, $i, 'complemento');
                                $tipoAtendimento = pg_fetch_result($res, $i, 'tipo_atendimento');

                                ?>

                                <tr>
                                    <td>
                                        <?= $dataabertura = date('d/m/Y', strtotime($dataabertura)) ?>
                                    </td>
                                    <td>
                                        <?= $notafiscal ?>
                                    </td>
                                    <td>
                                        <?= $datacompra = date('d/m/Y', strtotime($datacompra)) ?>
                                    </td>
                                    <td>
                                        <?= $aparencia ?>
                                    </td>
                                    <td>
                                        <?= $acessorios ?>
                                    </td>
                                    <td>
                                        <?= $nome ?>
                                    </td>
                                    <td>
                                        <?= $cpf ?>
                                    </td>
                                    <td>
                                        <?= $cep ?>
                                    </td>
                                    <td>
                                        <?= $estado ?>
                                    </td>
                                    <td>
                                        <?= $cidade ?>
                                    </td>
                                    <td>
                                        <?= $bairro ?>
                                    </td>
                                    <td>
                                        <?= $endereco ?>
                                    </td>
                                    <td>
                                        <?= $numero ?>
                                    </td>
                                    <td>
                                        <?= $complemento ?>
                                    </td>
                                    <td>
                                        <?= $telefone ?>
                                    </td>
                                    <td>
                                        <?= $celular ?>
                                    </td>
                                    <td>
                                        <?= $email ?>
                                    </td>
                                    <td>
                                        <?= $numero_serie ?>
                                    </td>
                                    <td>
                                        <?= $referencia ?>
                                    </td>
                                    <td>
                                        <?= $descricao ?>
                                    </td>
                                    <td>
                                        <?= $selectdefeito ?>
                                    </td>
                                    <td>
                                        <?= $produto ?>
                                    </td>
                                    <td>
                                        <?= $tipoAtendimento ?>
                                    </td>
                                    <td><a href="form-os.php?id=<?= $id ?>" name="editarCadastro"
                                            class="btn btn-primary btn-lg btnEditar" id="btnEditar">Editar</a><a
                                            style="background:#B22222;" type="button" onclick="deleteID(<?= $id ?>)"
                                            name="excluir" class="btn btn-primary btn-lg" data-toggle="modal"
                                            data-target="#deleteModal">Apagar</a></td>
                                </tr>

                            <?php }
        } ?>
                    </tbody>
                </table>
            </div>





        <script>

            $(function () {
                $("table tbody tr").mouseover(function () {
                    $(this).addClass("encima");
                })
                $("table tbody tr").mouseleave(function () {
                    $(this).removeClass("encima");
                })

                window.parent.retornaProduto(codigo, descricao, idProduto);
                window.parent.Shadowbox.close();
            })

            $(function () {
                //declare function 
                Shadowbox.init();
                $(".pesquisarInfo").click(function () {

                    concole.log("Alou, chegou aqui!");

                    var referencia = $(".referencia").val();
                    var descricao = $(".descricao").val();
                    var defeito = $(".defeito").val();

                    // console.log("referencia ", referencia);

                    Shadowbox.open({
                        content: "pesquisa-produto.php?&referencia=" + referencia + "&descricao=" + descricao + "&defeito=" + defeito,
                        player: "iframe",
                        title: "",
                        width: 1300,
                        height: 600
                    });
                });


            });

        </script>


        <script>
            $('.cpf').mask('999.999.999-99');
            $('.dataInicio').mask('99/99/9999');
            $('.dataFim').mask('99/99/9999');
        </script>

        <script>
            function deleteID(id) {
                $('.deleteIdHolder').val(id);
            }
        </script>


    </body>

</html>