
<?php

include "../site/navbar.php";

if(!empty($_GET['serie'])){
    $pesquisa = $_GET['serie'];
    $tipo = "serie";
    
}

elseif(!empty($_GET['referencia'])){
    $pesquisa = $_GET['referencia'];
    $tipo = "referencia";
    $sql = "select * from produto where $tipo='$pesquisa'";

}

elseif(!empty($_GET['descricao'])){
    $pesquisa = trim($_GET['descricao']);
    $tipo = "descricao";
    $sql = "select * from produto where $tipo='$pesquisa'";

// }

// elseif(!empty($_GET['defeito'])){
//     $pesquisa = $_GET['defeito'];
//     $tipo = "defeito";
//     $sql = "select * from produto where $tipo='$pesquisa'";

}else{

    $sql = "select * from produto";

}

?>
<div class="alert alert-danger text-center" role="alert"><?=$mensagem?></div>    
<?php

if (isset($_POST['pesquisaReferencia'])){
    $referencia = $_POST['referencia'];
    
    $sql = "select * from produto where referencia='$referencia'";

}


// $sql = "select * from produto where $tipo='$pesquisa'";

$res = pg_query($con, $sql);

if(pg_num_rows($res) > 0){

?>
 

<div class="table table-responsive">
    <table class="table table-condensed">
        
        <thead>
            <tr>
                <th>ID</th>
                <th>Referencia</th>
                <th>Descrição</th>
                <th>Garantia</th>
                <th>Ativo</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for($i = 0; $i < pg_num_rows($res); $i++) {
                $idProduto = pg_fetch_result($res, $i, 'produto');
                $referencia = pg_fetch_result($res, $i, 'referencia');
                $descricao = pg_fetch_result($res, $i, 'descricao');
                $garantia = pg_fetch_result($res, $i, 'garantia');
                $ativo = pg_fetch_result($res, $i, 'ativo');

                if($ativo == "t")
                {
                    $ativo = "Sim";
                }else{
                    $ativo = "Não";
                }
                $data = pg_fetch_result($res, $i, 'data_input');
                
        
            ?>

            <tr data-referencia="<?= $referencia ?>" data-idProduto="<?=$idProduto?>" data-descricao="<?= $descricao ?>">

                <td><?=$idProduto?></td>
                <td><?=$referencia?></td>
                <td><?=$descricao?></td>
                <td><?=$garantia?></td>
                <td><?=$ativo?></td>
                <td><?=$data?></td>

            </tr>

            <?php } ?>
        </tbody>
        
    <?php } ?>
    
    </table>
</div>

<style>

    .encima{
        background: lightgray;
        cursor: pointer;select * from os
    }
</style>

<script>

    $(function() {
        $("table tbody tr").mouseover(function(){
            $(this).addClass("encima");
        })
        $("table tbody tr").mouseleave(function(){
            $(this).removeClass("encima");
        })
        $("table tbody tr").click(function() {

            var referencia = $(this).data("referencia");
            var descricao = $(this).data("descricao");
            var idProduto = $(this).data("idproduto");

            window.parent.retornaProduto(referencia, descricao, idProduto);
            window.parent.Shadowbox.close();
        })
    })  
</script>

</html>