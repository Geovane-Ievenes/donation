
        <link rel="stylesheet" >
<header class="cabecalho_site">
        <a href="index.php" class="logo-redirect"><div class="logo">
            <img src="./logos/1.png" alt="coração" id="coracao">
            <img src="./logos/2.png" alt="globo" id="globo">
            <img src="./logos/3.png" alt="legenda" id="legenda">
        </div></a>
        <div class="slogan">
            <cite>"Um pequeno ato para um homem, mas um grande passo para o futuro"</cite>
        </div>
        <?php
      
             if(isset($_SESSION['nome_usuario'])){
                if(!isset($_SESSION['cod_perfil_ong'])){
                    include ('./include/menu-doador.php');
                }
                else{ 
                    include('./include/menu-ong.php');
                }
            }
            else{
                include('./include/menu-deslogado.php');
            }
        ?>
          <!-- Javascript do menu-->
        <script src="./js/menu.js"></script>
        </div>
        <nav>
            <ul>
                <li><a href="projetos.php">Projetos</a></li>
                <li><a href="loja.php">Loja</a></li>
                <li><a href="donation.php">Do.Nation</a></li>
            </ul>
        </nav>
    </header>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="./js/header-animation.js"></script>