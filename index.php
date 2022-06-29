<?php 
session_start();
include('./head-page.php');
?>
    <!--Itens do Menu Perfil-->
    <title>Do.Nation - Página Inicial</title>
    <link rel="stylesheet" href="index.css">
    <style>
      /*Project Popup CSS*/ 
      .popup{
          position: fixed;
          top: 0; bottom: 0; 
          left: 0; right:0;
          margin: auto;
          width: 500px;
          height: 300px;
          padding: 10px;
          border: solid 1px none;
          border-radius: 10px;
          background: #fff;
          display: none;
          z-index: 3;
      }
      .popup img {
        position: absolute;
        left: 85%;
        width: 40%;
      }
      .popup div {
          padding: 5px;
      }
      .popup .content-project {
          font-size: 18px;
      }
      .popup .content-project .temas {
          text-align: center;
          font-size: 15px;
      }
      .popup div button {
          width: 150px;
          height: 60px;
          font-family: "FREDOKA ONE";
          border: none;
          background: #ffe879;
          border-radius: 10px;
          font-size: 16px;
          text-transform: uppercase;
          justify-content: center;
          align-items: center;
          margin: 0 145px 0;
      }

      #fechar:hover{
          cursor:pointer;
      }

      #cobrir-fundo{
          width: 100vw;
          height: 100vh;
          background-color: #000;
          opacity: 0.5;
          position: fixed;
          top: 0px;
          left: 0px;
          display: none;
          z-index: 2;
      }

      /*Project Popup inputs*/ 
      .nome-projeto-popup{
          font-size: 30px;
          font-family: "FREDOKA ONE";
      }

      /*Single Image*/ 

      .projeto ul li:hover{
          opacity: 0.95;
          /*Zoom da imagem*/ 
      }
  </style>
</head>
<body>
    <?php
        include("./include/header.php");
    ?>
    <main>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./imagens/banner_carousel_home_step_one.png" class="d-block w-100" alt="Projeto A">
                </div>
                <div class="carousel-item">
                    <img src="./imagens/banner_carousel_home_step_two.png" class="d-block w-100" alt="Projeto B">
                </div>
                <div class="carousel-item">
                    <img src="./imagens/banner_carousel_home_step_three.png" class="d-block w-100" alt="Projeto C">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <script>
            var myCarousel = document.querySelector('#myCarousel')
            var carousel = new bootstrap.Carousel(myCarousel, {
                interval: 2000,
                wrap: false
            });
        </script>
        <div class="content_text">
            <div class="intro_site">
                <h2>Um pequeno ato, um impacto enorme</h2>
                <section class="site_text">
                    <p class="intro_text">Bem-vindos à Do.Nation, uma plataforma onde você irá descobrir que fazer o bem é maravilhoso e é aqui que a mágica acontece, navegue pelo site e descubra projetos das mais variadas causas e propósitos.</p>
                    <img src="./imagens/intro_landing_page.png" class="intro_page">
                </section>
            </div>
            <div class="text_block text_cupom">
                <h2>Compondo os Cupons</h2>
                <section class="site_text">
                  <div class="left">
                    <p class="intro_text">Os cupons que a nossa plataforma disponibiliza são feitos em contanto direto com <span class="enfase_text">empreendimentos parceiros</span>, para trazer até aqui a maior variedade e qualidade possível, e agradecer o ato de altruísmo que foi realizado por você!</p>
                    <p class="intro_text"></p>
                  </div>
                  <div class="right">
                    <img class="cupom_block" src="./imagens/cupom_block.png">
                  </div>
                </section>
            </div>
            <div class="text_block text_nationcoin" id="text_nationcoin">
                <h2>Nation Coin, a moeda da união</h2>
                <section class="site_text">
                  <div class="left">
                    <img class="nation_coin" src="./imagens/nation_coins.png">
                  </div>
                  <div class="right">
                    <p class="intro_text">A Nation Coin é a moeda que foi criada pela nossa plataforma para agradecer a todos que fizerem doações para qualquer instituição de nossa página!!!</p>
                    <p class="intro_text">Elas são distribuídas com base no valor doado, não servindo apenas de recordação, podendo serem trocadas por cupons de desconto de todas as lojas parceiras!!!</p>
                  </div>
                </section>
            </div>
            <div class="text_block text_mascote">
                <h2>Para salvar o mundo... Nada melhor que um herói</h2>
                <section class="site_text">
                  <div class="left">
                    <p class="intro_text">Senhoras e senhoras, aprensentamos o Doacão!</p>
                    <cite class="intro_text">"Olá, meu nome é Doacão , e eu sou o Super herói que tem o melhor superpoder de todos!!! A solidariedade e o amor ao próximo! A minha missão é mostrar pra todo mundo que não precisa de uma máscara e uma capa maneira, que nem a minha, pra fazer a diferença no mundo!</cite>
                    <cite class="intro_text">Eu serei seu guia nessa vasta plataforma estrei pronto para responder quaisquer dúvidas que possam surgir, pelo ícone de ajuda no canto inferior da tela, ou pela seção de perguntas Frequentes na página inicial."</cite>
                  </div>
                  <div class="right">
                    <img src="./imagens/doacao.png" class="doacao_block">
                  </div>                 
                </section>
            </div>
            
        <div class="faq text_block">
          <h2>Perguntas Frequentes</h2>
            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    COMO GERENCIAR UM PROJETO?
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <span>Ao criar um projeto e todas as especificações forem atendidas, será possível gerenciá-lo na página de gerenciamento de projetos que será encontrada nas páginas de informações do projeto.</span>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    COMO FAZER UMA DOAÇÃO?
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <span>Primeiramente, o usuário se cadastra no site, após isso, basta escolher a campanha desejada  na página de projetos e selecionar o botão de realizar doação, escolher o método de pagamento e  finalizá-lo e fazendo isso o usuário recebe as <strong>NationCoins</strong>.</span>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    COMO VALIDAR UMA ONG OU PROJETO?
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <span>Ao realizar a criação de um projeto, será requerida sua validação, que será efetuada na página de perfil do projeto, ao solicitar uma validação os administradores irão avaliar se todos os requerimentos foram preenchidos corretamente, assim validando o determinado projeto.</span>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    COMO ONG, QUANDO POSSO CADASTRAR MEUS PROJETOS?
                  </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <span>A ONG poderá abrir uma doação, assim que seus dados forem validados.</span>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    QUANTAS NATION COINS GANHO COM CADA DOAÇÃO?
                  </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <span>O valor das Nation Coins variam da quantia doada. Consulte: <a href="#text_nationcoin" target="_self">Abre na mesma janela</a>.</span>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    O QUÃO SEGURO É O SISTEMA DE DOAÇÃO E TROCA?
                  </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <span>O sistema de doação e trocas da donation é totalmente seguro, pois, será utilizado o método pix para transações, fortalecendo assim, a segurança do site</span>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </main>
    <?php
        include("./include/footer.php");
    ?>
</body>
</html>