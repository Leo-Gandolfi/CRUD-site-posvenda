<?php
$checked = '';
include("navbar.php");

$codigo = '';
$descricao = '';
$mensagem = '';



if(isset($_POST['deleteInfo'])){
    $id = $_POST['deleteIdHolder'];
    
    $sql = "delete from tipo_atendimento where tipo_atendimento='$id'";
    $res = pg_query($con, $sql);
    $mensagem = "Atendimento Deletado";
    $alert = "success";
    
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "select * from tipo_atendimento where tipo_atendimento = '$id' and fabrica='$sessao'";

    $res = pg_query($con, $sql);

    $parametros = pg_fetch_assoc($res);

    // echo "ALOU" . $descricao . $referencia; exit;

    $codigo = $parametros['codigo'];
    $descricao = $parametros['descricao'];
    $ativo = $parametros['ativo'];
    if ($ativo == 't') {
        $checked = "checked";
    } else {
        $checked = "";
    }


}
    

if(isset($_POST['salvarAlt'])){

    $id = filter_var($_POST['editarID']);
    $codigo = filter_var($_POST['novoCodigo']);
    $descricao = filter_var($_POST['novaDescricao']);
    $ativo = $_POST['novoAtivo'] == "t";
    $erro = '';

    
    if(strlen(trim($descricao)) < 10){
        $mensagem = 'Descreva o tipo de atendimento';
        $erro = 'erro';
    }

    if (empty($codigo) or empty($descricao)) {
        $mensagem = 'Todos os campos devem ser Preenchidos';
        $erro = 'erro';
    }

    if(empty($erro)){
        $sql = "UPDATE tipo_atendimento SET codigo = '$codigo', descricao = '$descricao', ativo='$ativo' where tipo_atendimento='$id'";
        $res = pg_query($con, $sql);
        $mensagem = "Cadastro Atualizado";
        $alert = "success";

    }
    
}

if(isset($_POST['btnCadastrar']))
{
    $codigo = filter_var($_POST['codigo']);
    $descricao = filter_var($_POST['descricao']);

    $ativo = ($_POST['ativo'] == true) ? 't' : 'f' ;
    $mensagem = '';
    // VERIFICA SE O CAMPO ESTÁ VAZIO.  
    if (empty(trim($codigo))) {
        $mensagem .= 'Digite o código. <br>';
        echo '<style type="text/css">
        #codigo{
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";
    }
    if(strlen(trim($descricao)) < 10){
        $mensagem .= 'Descreva o tipo de atendimento (10 caracteres min). <br>';
        echo '<style type="text/css">
        #descricao {
            border: 2px groove red;
        }
        </style>';
        $alert = "warning";

        $erro = 'n';
    }

    if (isset($_GET['id']) and strlen($mensagem) == 0) {
        $sql = "UPDATE tipo_atendimento SET codigo = '$codigo', descricao = '$descricao', ativo = '$ativo' where tipo_atendimento='$id'";
        $res = pg_query($con, $sql);
        $mensagem = "Cadastro atualizado!";
        header('location: http://localhost:8080/site/form-atendimento.php');
    }
     
    if(strlen($mensagem) == 0){
        $sql = "select * from tipo_atendimento where codigo = '$codigo' and fabrica = $sessao";
        $res = pg_query($con, $sql);

        if(pg_num_rows($res) > 0)
        {
            $mensagem = 'Código anteriormente cadastrado';
            $alert = "warning";
        }
        if(strlen($mensagem) == 0){
            $sql = "INSERT INTO tipo_atendimento (codigo, descricao, ativo, fabrica) VALUES ('$codigo','$descricao', '$ativo', $sessao)";
            $res = pg_query($con, $sql);
            $mensagem = "Atendimento cadastrado";
            $alert = "success";

            if(pg_last_error($con) > 0){
                $mensagem = "Falha ao cadastrar atendimento";
            }
        }
    }
}

?>  

<script>
    function retornaID(id){

        $(".id").val(id)

    }
</script>


<!-- EDIT Modal -->
<script>

    function sendID(id){
        console.log('id', id);
        $('.editarID').val(id);
        $('.novoCodigo').val(codigo);
        $('.novaDescricao').val(descricao);

    }
</script>

<!--DELETE Modal -->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h1>Excluir formulário? </h1>
    </div>
      <div class="modal-body">
      <form method="POST">
      <input type="hidden" name="deleteIdHolder" value="" class="deleteIdHolder" >
      <button type="submit" name="deleteInfo" class="btn btn-primary">Sim</button>
      <button type="button" name="close" data-dismiss="modal" class="btn btn-primary">Não</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="" class="container">
        <div class="row">
        <div class="col-md-2"></div>
        <div style="background:white; padding:30px; border: 2px solid black; margin-top:3%; border-radius:10px" class="col-md-8">
                <form  method="POST" class="form-horizontal">
                <span class="text-center" id=""><h1>Tipo de Atendimento</h1></span>

                <div style="display:flex; margin-top:10%; justify-content: center;"class="form-group">
                    <div class="width:100px%">
                        <label for="codigo">CÓDIGO</label>
                        <input  style="width:50%;" type="text" maxlength="20" class="form-control codigo" name="codigo" value="<?=$codigo?>"id="codigo" placeholder="">
                    </div>
                    <div class="">
                        <label for="descricao">DESCRIÇÃO</label>
                        <input  style="width:30rem;" type="text" maxlength="100" value="<?=$descricao?>" name="descricao" class="form-control" id="descricao" placeholder="">
                    </div>
                </div>

                <div class="form-group text-center">
                    <input name="ativo" value="t" id="ativo" type="checkbox" <?=$checked?>><label for="ativo"> Ativo </label>
                </div>
                
                <div class="form-group text-center">
                    <br>
                    <button type="submit" value="1" name="btnCadastrar" class="btn btn-primary">Cadastrar</button>
                </div>

                <div class="alert alert-<?=$alert?> text-center" role="alert">
                    <?=$mensagem?>
                </div>

            <input value="" type="hidden" class="id" name="id" id="id">
        </div>
    </form>
        <div class="col-md-2"></div>
        </div>
    </div>

    <div style="background:white; width:60%; margin-top:20px; border: 2px solid black; border-radius:10px"
    class="container table-responsive">
    <table class="table">
    <a type="button" href='lista/gerar_arquivo.php?tipo=tipo_atendimento' class="btn btn-primary"><i class="bi bi-file-earmark-medical"></i> Excel</a>

    
    <?php

$sql = "select * from tipo_atendimento where fabrica = '$sessao'";
$res = pg_query($con, $sql);

if(pg_num_rows($res) > 0){
        ?>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Ativo</th>
            </tr>
        </thead>
        <tbody>

            <?php
            for ($i = 0; $i < pg_num_rows($res); $i++) {

                $id = pg_fetch_result($res, $i, 'tipo_atendimento');
                $codigo = pg_fetch_result($res, $i, 'codigo');
                $descricao = pg_fetch_result($res, $i, 'descricao');
                $ativo = pg_fetch_result($res, $i, 'ativo');
                if ($ativo == 't'){
                    $ativo = "Sim";
                }else{
                    $ativo = "Não";
                }
                

                ?>

                <tr>
                    <td><?= $codigo ?></td>
                    <td><?= $descricao ?></td>
                    <td><?= $ativo ?></td>
                    
                    <td><button name="btnEditar" value="" href="" onclick="sendID(<?=$id?>);" class="btn btn-primary btn">Editar</button></td>
                    <td><form method="POST"><a type="button" onclick="deleteID(<?= $id?>)" name="excluir" class="btn btn-primary btn" data-toggle="modal" data-target="#deleteModal">Apagar</a></form></td>

                </tr>

            <?php }}else{ $mensagem = "Nenhum cadastro encontrado"; $alert="warning"; ?>
                        <div class="alert alert-<?= $alert ?> text-center" role="alert">
                            <?= $mensagem ?>
                        </div>
            <?php } ?>
        </tbody>
</div>

<script>
    
    $(function() {
        $("table tbody tr").mouseover(function(){
            $(this).addClass("encima");
        })
        $("table tbody tr").mouseleave(function(){
            $(this).removeClass("encima");
        })

        window.parent.retornaProduto(codigo, descricao);
        window.parent.Shadowbox.close();
    })

    $( "ativo" ).prop( "checked", true );
    $( "ativo" ).prop( "checked", false );


    function deleteID(id){
        $('.deleteIdHolder').val(id);
    }

    function sendID(id) {
            window.location.href = "form-atendimento.php?&id=" + id;
        }
</script>


</body>
</html>