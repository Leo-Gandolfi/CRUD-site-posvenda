<!-- PARTE DO PHP QUE FARÁ A VALIDAÇÃO DO FORMULÁRIO -->

<?php

include("navbar.php");

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT os.*, produto.descricao, produto.referencia FROM os
    JOIN produto ON os.produto = produto.produto and os.os = '$id'";

    $res = pg_query($con, $sql);

    // $array = pg_fetch_all($res)[0];

    for ($i = 0; $i < pg_num_rows($res); $i++) {
        $id = pg_fetch_result($res, $i, 'os');
        $dataAbertura = pg_fetch_result($res, $i, 'data_abertura');
        $notaFiscal = pg_fetch_result($res, $i, 'nota_fiscal');
        $dataCompra = pg_fetch_result($res, $i, 'data_compra');
        $aparencia = pg_fetch_result($res, $i, 'aparencia');
        $acessorios = pg_fetch_result($res, $i, 'acessorio');
        $nome = pg_fetch_result($res, $i, 'nome_consumidor');
        $documento = pg_fetch_result($res, $i, 'cpf_cnpj');
        $cep = pg_fetch_result($res, $i, 'cep_consumidor');
        $estado = pg_fetch_result($res, $i, 'estado_consumidor');
        $cidade = pg_fetch_result($res, $i, 'cidade_consumidor');
        $bairro = pg_fetch_result($res, $i, 'bairro_consumidor');
        $endereco = pg_fetch_result($res, $i, 'endereco_consumidor');
        $numero = pg_fetch_result($res, $i, 'numero_consumidor');
        $telefone = pg_fetch_result($res, $i, 'telefone_consumidor');
        $celular = pg_fetch_result($res, $i, 'celular_consumidor');
        $email = pg_fetch_result($res, $i, 'email_consumidor');
        $idProduto = pg_fetch_result($res, $i, 'produto');
        $numeroSerie = pg_fetch_result($res, $i, 'numero_serie');
        $referencia = pg_fetch_result($res, $i, 'referencia');
        $descricao = pg_fetch_result($res, $i, 'descricao');
        $defeito = pg_fetch_result($res, $i, 'defeito');
        $tipoAtendimento = pg_fetch_result($res, $i, 'tipo_atendimento');

        function organizar_data($data)
        {
            $partes = explode('-', $data);
            $nova_data = $partes[2] . '/' . $partes[1] . '/' . $partes[0];
            return $nova_data;
        }

        $dataAbertura = organizar_data($dataAbertura);
        $dataCompra = organizar_data($dataCompra);
        // echo "data Abertura e compra" . $dataAbertura . "     " . $dataCompra;exit;

    }

}
if (isset($_POST['btncadastrar'])) {


    // ESSA ṔARTE FAZ A CONVERSÃO DA DATA PARA PODER SER USADA NO SQL

    $erro = '';

    $dataAbertura = $_POST['dataAbertura'];
    $parteData = explode('/', $dataAbertura);
    $dia = $parteData[0];
    $mes = $parteData[1];
    $ano = $parteData[2];
    $dataInvertidaAbertura = $ano . '-' . $mes . '-' . $dia;

    $dataCompra = $_POST['dataCompra'];
    $parteData2 = explode('/', $dataCompra);
    $dia = $parteData2[0];
    $mes = $parteData2[1];
    $ano = $parteData2[2];
    $dataInvertidaCompra = $ano . '-' . $mes . '-' . $dia;


    // VARIÁVEIS ASSOCIADAS AO INPUT

    $notaFiscal = filter_var($_POST['notaFiscal'], FILTER_SANITIZE_STRING);
    $acessorios = filter_var($_POST['acessorios'], FILTER_SANITIZE_STRING);
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $documento = filter_var($_POST['documento'], FILTER_SANITIZE_STRING);
    $cep = filter_var($_POST['cep'], FILTER_SANITIZE_STRING);
    $estado = filter_var($_POST['estado'], FILTER_SANITIZE_STRING);
    $cidade = filter_var($_POST['cidade'], FILTER_SANITIZE_STRING);
    $bairro = filter_var($_POST['bairro'], FILTER_SANITIZE_STRING);
    $endereco = filter_var($_POST['endereco'], FILTER_SANITIZE_STRING);
    $numero = filter_var($_POST['numero'], FILTER_SANITIZE_STRING);
    $complemento = filter_var($_POST['complemento'], FILTER_SANITIZE_STRING);
    $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_STRING);
    $celular = filter_var($_POST['celular'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $numeroSerie = filter_var($_POST['numeroSerie'], FILTER_SANITIZE_STRING);
    $referencia = filter_var($_POST['referencia'], FILTER_SANITIZE_STRING);
    $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_STRING);
    $defeito = filter_var($_POST['defeito'], FILTER_SANITIZE_STRING);
    $aparencia = filter_var($_POST['aparencia'], FILTER_SANITIZE_STRING);
    $acessorio = filter_var($_POST['acessorios'], FILTER_SANITIZE_STRING);
    $cepVerificado = filter_var($cep, FILTER_SANITIZE_NUMBER_INT);
    $emailVerificado = filter_var($email, FILTER_SANITIZE_EMAIL);
    $idProduto = filter_var($_POST['idProduto'], FILTER_SANITIZE_EMAIL);
    $tipoAtendimento = filter_var($_POST['tipoAtendimento'], FILTER_SANITIZE_EMAIL);
    $defeito = (int) $_POST['defeito'];

    $limpar = array('(', ')', '-', '.', ' ', '/');

    $telefone = str_replace($limpar, '', $telefone);

    $celular = str_replace($limpar, '', $celular);
    $documento = str_replace($limpar, '', $documento);
    $cep = str_replace($limpar, '', $cep);
    $complemento = str_replace($limpar, '', $complemento);

    // faz a validação com o que foi filtrado_POST['email'];


    if (!filter_var($emailVerificado, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Email inválido";
    }


    
    if (strlen($dataAbertura) == 0){
        $mensagem .= 'Digite a data de abertura. <br>';
        echo '<style type="text/css">
        #data_abertura {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($dataCompra) == 0){
        $mensagem .= 'Digite a data de compra. <br>';
        echo '<style type="text/css">
        #data_compra {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($tipoAtendimento) == 0){
        $mensagem .= 'Selecione o tipo de atendimento. <br>';
        echo '<style type="text/css">
        #tipo_atendimento {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($aparencia) == 0){
        $mensagem .= 'Digite a aparencia. <br>';
        echo '<style type="text/css">
        #aparencia {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($notaFiscal) == 0){
        $mensagem .= 'Digite a nota fiscal. <br>';
        echo '<style type="text/css">
        #nota_fiscal {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($acessorio) == 0){
        $mensagem .= 'Digite os acessórios. <br>';
        echo '<style type="text/css">
        #acessorios {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($numeroSerie) == 0){
        $mensagem .= 'Digite o numero de série. <br>';
        echo '<style type="text/css">
        #serie {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($referencia) == 0){
        $mensagem .= 'Digite a referência. <br>';
        echo '<style type="text/css">
        #referencia {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($descricao) == 0){
        $mensagem .= 'Digite a descrição. <br>';
        echo '<style type="text/css">
        #descricao {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if ($defeito == 0){
        $mensagem .= 'Selecione um defeito. <br>';
        echo '<style type="text/css">
        #defeito {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($nome) == 0){
        $mensagem .= 'Digite a aparência. <br>';
        echo '<style type="text/css">
        #nome {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($documento) == 0){
        $mensagem .= 'Digite o Documento. <br>';
        echo '<style type="text/css">
        #doc {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($cep) == 0){
        $mensagem .= 'Digite o CEP. <br>';
        echo '<style type="text/css">
        #cep {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($estado) == 0){
        $mensagem .= 'Digite o Estado <br>';
        echo '<style type="text/css">
        #estado {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($cidade) == 0){
        $mensagem .= 'Digite a cidade. <br>';
        echo '<style type="text/css">
        #cidade {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($bairro) == 0){
        $mensagem .= 'Digite o bairro. <br>';
        echo '<style type="text/css">
        #bairro {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($endereco) == 0){
        $mensagem .= 'Digite o endereço. <br>';
        echo '<style type="text/css">
        #endereco {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if (strlen($numero) == 0){
        $mensagem .= 'Digite o número da casa. <br>';
        echo '<style type="text/css">
        #numero {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }


    if (strlen($celular) < 8) {
        $mensagem .= "Digite o celular. <br>";
        $alert = "warning";
        echo '<style type="text/css">
        #celular {
            border: 2px groove red;
        }
        </style>';
    }

    if (strlen($cep) > 0 and strlen($cep) < 8) {
        $mensagem .= "CEP inválido.";
        $alert = "warning";
        echo '<style type="text/css">
        #cep {
            border: 2px groove red;
        }
        </style>';
    }

    if (strlen($email) == 0) {
        $mensagem .= "Digite o email. <br>";
        $alert = "warning";
        echo '<style type="text/css">
        #email {
            border: 2px groove red;
        }
        </style>';
    }

    if (isset($_GET['id']) and strlen($mensagem) == 0) {
        $id = $_GET['id'];
        echo $complemento . $tipoAtendimento;
        $sql_update = "UPDATE os SET 
        data_abertura = '$dataAbertura',
        nota_fiscal = '$notaFiscal',
        data_compra = '$dataCompra',
        aparencia = '$aparencia',
        acessorio = '$acessorio',
        nome_consumidor = '$nome',
        cpf_cnpj = '$documento',
        cep_consumidor = '$cep',
        estado_consumidor = '$estado',
        cidade_consumidor = '$cidade',
        bairro_consumidor = '$bairro',
        endereco_consumidor = '$endereco',
        numero_consumidor = '$numero',
        complemento = '$complemento',
        telefone_consumidor = '$telefone',
        celular_consumidor = '$celular',
        email_consumidor = '$email',
        produto = '$idProduto',
        numero_serie = '$numeroSerie',
        tipo_atendimento = '$tipoAtendimento',
        defeito = '$defeito'
        WHERE os = '$id';
        ";

        $res = pg_query($con, $sql_update);
        $mensagem = "Cadastro Atualizado";
        $alert = "success";
    }

    if (strlen($mensagem) == 0) {

        $mensagem = 'Ordem Cadastrada com sucesso!';
        $alert = "seccess";

        $sql = "INSERT INTO os (data_abertura, nota_fiscal, data_compra, aparencia, acessorio, nome_consumidor, cpf_cnpj, cep_consumidor, estado_consumidor, cidade_consumidor, bairro_consumidor, endereco_consumidor, numero_consumidor, telefone_consumidor, celular_consumidor, email_consumidor, Produto , numero_serie, defeito) VALUES ('$dataInvertidaAbertura','$notaFiscal' ,'$dataInvertidaCompra', '$aparencia', '$acessorio', '$nome', '$documento', '$cep', '$estado', '$cidade', '$bairro', '$endereco', '$numero', '$telefone', '$celular', '$email', '$idProduto', '$numeroSerie', '$defeito')";

        $res = pg_query($con, $sql);
        if (pg_last_error($con) > 0) {

            $mensagem = "Erro no cadastro do produto";
            $alert = "warning";
        }
    }
}


?>

<?php
$sqlDefeito = "select * from defeito";
$resDefeito = pg_query($con, $sqlDefeito);

?>

    <div id="" style="margin-top:3%; " class="container">
        <div class="row">
            <div class="col-md-3"></div>
                <div style="background: white; border-radius: 5px ; padding: 30px;" class="col-md-6">
                        <h1 class="text-center">Cadastro de OS</h1>                
                    <form method="POST" id="submit" class="form-horizontal">
                    <div style="display:flex; justify-content:space-between">
                        <div>
                    <span class="" id="data_abertura">Data de Abertura</span>
                    <input name="dataAbertura" value="<?= $dataAbertura ?>" type="text"
                        class="form-control dataAbertura text-center" placeholder="" aria-describedby="basic-addon1">
                        </div>
                    <div>
                        <span id="tipo_atendimento">Tipo de Atendimento</span>
                        <select value="" name="tipoAtendimento" class="form-control text-center">
                            <option value="">Selecione o tipo de Atendimento...</option>
                            <?php
                            $sqlAtendimento = "select * from tipo_atendimento where ativo='t'";
                            $resAtendimento = pg_query($con, $sqlAtendimento);

                            for ($i = 0; $i < pg_num_rows($resAtendimento); $i++) {
                                $codigoAtendimento = pg_fetch_result($resAtendimento, $i, 'tipo_atendimento');
                                $descricaoAtendimento = pg_fetch_result($resAtendimento, $i, 'descricao');
                                ?>
                            <option name="tipoAtendimento" value="<?= $codigoAtendimento ?>"><?= "Nº: " . $codigoAtendimento . ". Descrição: " . $descricaoAtendimento ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>  
                </div>
              
                <div style="display:flex; justify-content:space-between">
                    <div>
                        <span  id="data_compra">Data da Compra</span>
                        <input name="dataCompra" value="<?= $dataCompra ?>" type="text" class="form-control dataCompra text-center"
                            placeholder="" aria-describedby="basic-addon1">
                    </div>
                    <div>
                        <span  id="aparencia">Aparência</span>
                        <input name="aparencia" value="<?= $aparencia ?>" type="text"
                            class="form-control aparencia text-center aparencia" placeholder="" aria-describedby="basic-addon1">
                    </div>

                </div>
                <div style="display:flex; justify-content:space-between">
                            <div>
                <span  id="nota_fiscal">Nota Fiscal</span>
                <input name="notaFiscal" value="<?= $notaFiscal ?>" type="text" class="form-control text-center notaFiscal"
                    placeholder="" aria-describedby="basic-addon1">
                    </div>
                    <div>
                        
                <span  id="acessorios">Acessórios</span>
                <input name="acessorios" value="<?= $acessorios ?>" type="text" class="form-control text-center acessorio"
                    placeholder="" aria-describedby="basic-addon1">
                    </div>
                </div>

                <!-- DADOS DO PRODUTO ------------------------------------------------------------------------------->
                <br>

                    <h1 class="text-center" >Dados do Produto</h1>

                <input name="idProduto" value="<?= $idProduto ?>" type="hidden" class="form-control idProduto text-center"
                    placeholder="" aria-describedby="basic-addon1">


                <span  id="serie">Nº de Série: </span>
                <input name="numeroSerie" value="<?= $numeroSerie ?>" type="text"
                    class="form-control numeroSerie text-center" placeholder="" aria-describedby="basic-addon1">

                <span  id="referencia">Referência: </span>
                <input name="referencia" value="<?= $referencia ?>" type="text" class="form-control referencia text-center"
                    placeholder="" aria-describedby="basic-addon1">

                <span  id="descricao">Descrição: </span>
                <input name="descricao" value="<?= $descricao ?>" type="text" class="form-control descricao text-center"
                    placeholder="" aria-describedby="basic-addon1">

                <span  id="defeito">Defeito: </span>
                <select value="" name="defeito" class="form-control text-center defeito">
                    <option value="">Selecione Defeito...</option>
                    <?php
                    for ($i = 0; $i < pg_num_rows($resDefeito); $i++) {
                        $codigoDefeito = pg_fetch_result($resDefeito, $i, 'codigo');
                        $descricaoDefeito = pg_fetch_result($resDefeito, $i, 'descricao');
                        ?>
                    <option name="defeito" value="<?= $codigoDefeito ?>"><?= "Nº: " . $codigoDefeito . ". Defeito: " . $descricaoDefeito ?> </option>
                    <?php
                    }
                    ?>
                </select>

                <span class="input-group-btn  text-center">
                    <button class="btn btn-default pesquisar" style="" value="1" type="button"><i
                            class="glyphicon glyphicon-search"></i></button>
                </span>


                <!-- DADOS DO CONSUMIDOR  ------------------------------------------------------------------------>

                    <h1 class="text-center">Dados do Consumidor</h1>

                <label  style="" id="nome">Nome: </label>
                <input name="nome" value="<?= $nome ?>" type="text" class="form-control text-center" placeholder=""
                    aria-describedby="basic-addon1">


                <!-- Muda entre CPF e CNPJ ------------->

                <div id="doc" class="text-center">
                    <label class="btn btn-primary">
                        <input type="radio" name="options" class="options" value="CPF" checked id="option2"> CPF
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="options" class="options" value="CNPJ" id="option3"> CNPJ
                    </label>
                </div>
                    <input name="documento" type="text" value="<?= $documento ?>" class="form-control text-center documento"
                    aria-describedby="basic-addon1">

                <span id="cep" >CEP</span>
                <input name="cep" value="<?= $cep ?>" type="text" class="form-control text-center cep"
                    placeholder="" aria-describedby="basic-addon1">

                <span  id="estado">Estado</span>
                <input name="estado"  value="<?= $estado ?>" type="text" class="form-control estado text-center"
                    placeholder="" aria-describedby="basic-addon1">

                <span  id="cidade">Cidade</span>
                <input name="cidade" value="<?= $cidade ?>" type="text" class="form-control text-center"
                    placeholder="" aria-describedby="basic-addon1">

                <span  id="bairro">Bairro</span>
                <input name="bairro" value="<?= $bairro ?>" type="text" class="form-control bairro text-center"
                    placeholder="" aria-describedby="basic-addon1">

                <span  id="endereco">Endereço</span>
                <input name="endereco" value="<?= $endereco ?>" type="text" class="form-control text-center"
                    placeholder="" aria-describedby="basic-addon1">

                <span  id="numero">Nº</span>
                <input name="numero" value="<?= $numero ?>" type="text" class="form-control text-center" placeholder=""
                    aria-describedby="basic-addon1">


                <span  id="complemento">Complemento</span>
                <input name="complemento" value="<?= $complemento ?>" type="text" class="form-control text-center"
                    placeholder="" aria-describedby="basic-addon1">


                <span  id="telefone">Telefone</span>
                <input name="telefone" value="<?= $telefone ?>" type="text" class="form-control text-center telefone"
                    placeholder="(99) 9 9999-9999" aria-describedby="basic-addon1">

                <span  id="celular">Celular</span>
                <input name="celular" value="<?= $celular ?>" type="text" class="form-control text-center celular"
                    placeholder="(99) 9 9999-9999" aria-describedby="basic-addon1">

                <span  id="email">E-mail</span>
                <input name="email" value="<?= $email ?>" type="text" class="form-control text-center" placeholder=""
                    aria-describedby="basic-addon1">

                <br>

                <br>
                <div style="display:flex; justify-content:center" class="">
                    <button style="font-size:15px" type="submit" style="" name="btncadastrar" value="1"
                        class="btn btn-info">Cadastrar</button>
                    <button value="1" id="limpar" class="btn btn-danger" style="margin-left:10%; font-size:15px">Limpar</button>
                </div>
                <br>

                <div style="font-size:15px"class="alert alert-<?= $alert ?> text-center" role="alert">
                    <?= $mensagem ?>
                </div>
            
                </form>
            </div>
        <div class="col-md-3"></div>
        </div>
    </div>

    <style>
    .dropdown-menu{
        font-size: 15px !important;
    }
    .form-control{
        font-size: 15px !important;

    }
    .options{
        font-size: 15px !important;

    }
    </style>




<script>
        

        $(document).ready(function () {
            $('.documento').mask('999.999.999-99');

            $('.options').change(function () {
                var maskType = $(this).val();
                var newMask;
                $(".documento").val('');

                if (maskType === 'CNPJ') {
                    newMask = '99.999.999/9999-99';
                } else if (maskType === 'CPF') {
                    newMask = '999.999.999-99';
                }

                $('.documento').mask(newMask);
            });
        });

        $('.dataAbertura').mask('99/99/9999');
        $('.dataCompra').mask('99/99/9999');
        $('.cep').mask('99999-999');
        $('.telefone').mask('(99) 9999-9999');
        $('.celular').mask('(99) 9999-9999');


        $("#cep").change(function () {

            var cep = $(this).val()

            $.ajax({
                url: `http://viacep.com.br/ws/${cep}/json/`,
                type: "GET",
                dataType: "json",
                async: false,
                timeout: 10000,
                data: {},
                beforeSend: function () {

                },
                success: function (dados) {
                    $("#endereco").val(dados.logradouro)
                    $("#bairro").val(dados.bairro)
                    $("#cidade").val(dados.localidade)
                    $("#estado").val(dados.uf)
                },
            });
        })
        //

        function retornaProduto(referencia, descricao, idProduto) {

            console.log(idProduto, referencia, descricao);
            $(".referencia").val(referencia);
            $(".descricao").val(descricao);
            $(".idProduto").val(idProduto);

        }

        $("#limpar").click(function () {
            $(".dataAbertura").val("");
            $(".dataCompra").val("");
            $(".tipoAtendimento").val("");
            $(".dataCompra").val("");
            $(".aparencia").val("");
            $(".notaFiscal").val("");
            $(".acessorio").val("");
            $(".numeroSerie").val("");
            $(".referencia").val("");
            $(".descricao").val("");
            $(".defeito").val("");
            $(".nome").val("");
            $(".documento").val("");
            $(".cep").val("");
            $(".estado").val("");
            $(".cidade").val(""); l
            $(".bairro").val("");
            $(".endereco").val("");
            $(".numero").val("");
            $(".complemento").val("");
            $(".telefone").val("");
            $(".celular").val("");
            $(".email").val("");


        })
    </script>
    <script>

        $(function () {
            Shadowbox.init();
            $(".pesquisar").click(function () {
                var referencia = $(".referencia").val();
                var descricao = $(".descricao").val();
                var defeito = $(".defeito").val();

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



</body>

</html>