<?php

//include "../autentica/autentica.php";
include "site/navbar.php";

?>

    <div style="margin-top:3%; border-radius:5px; padding:20px; background:white; " class="input-group container" >
        
        <div class="col-12">
            <h1 style=" font-size:25px" class="text-center">Quem somos</h1>
            <p  style=" font-size:20px" id="sobre_texto" class="sobre-texto ">
            Na Sales Site, acreditamos que um excelente serviço não termina após a compra, mas se estende por todo o processo pós-venda. Com foco na satisfação do cliente, oferecemos suporte contínuo, assistência personalizada e soluções rápidas para garantir que cada experiência com nossos produtos seja a melhor possível. Nossa equipe dedicada está sempre pronta para atender, resolver dúvidas e proporcionar um atendimento ágil e eficiente, reforçando o compromisso com a qualidade e o bem-estar de nossos clientes. Confie na [Nome da Empresa] para estar sempre ao seu lado, antes, durante e após a compra!
            </p>
        </div>

    </div>

    <div style="background:white; padding:30px; margin-top:3%" class="container text-center">
    <div class="row">
        <div class="col-md-2 "></div>
        <div class="col-md-8 ">
            <div  id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>

                <div height="100px" class="carousel-inner">
                    <div class="carousel-item active">
                    <img class="d-block w-100"   src="../img/makita.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="../img/multilaser.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="../img/consul.jpg"  alt="Third slide">
                    </div>

                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Próximo</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-2 "></div>
        </div>
    </div>

    <div style="margin-top:10%"class="container">
        <div id="sobre" class="col-md-4 col-sm-12 text-center">
            <h1> Consultas Técnicas </h1>
            <img src="../img/suporte.jpg" alt="">
            <p>Auxílio imediato com resolução de problemas referentes ao seu site. Fácil acesso aos nossos técnicos </p>
        </div>

        <div  id="sobre" class="col-md-4 col-sm-12 text-center">
            <h1> Customização </h1>
            <img src="../img/sites.jpeg" alt="">
            <p>Algum texto sobre Customização  e como a empresa faz um bom trabalho ao entregar satisfação </p>
        </div>
        <div  id="sobre" class="col-md-4 col-sm-12 text-center">
            <h1> Nosso Sistema </h1>
            <img src="../img/sistema.jpg" alt="">
            <p>Sistema sólido e confiável. Com mais de 25 anos de refinamento. Nossa história garante integridade.</p>
        </div>

    </div>

        

    <footer>Sales Site <?php echo date('Y')?></footer>

    <script>
        AOS.init();
    </script>


</body>
<style>
    #sobre{
        font-size: 30px;
        margin-bottom: 5%;
        background: white;

    }

    #sobre>img{
        width: 120px;
        height: 120px;
    }

    .carousel{
        /* width: 100%; */
    }

    .carousel-inner img {
        width: 100%;
        margin: auto;
        border-radius: 10px ;

    }

    @media (max-width: 300px) {
        .carousel-caption {
            display: none;
        }

    }

</style>


</html>