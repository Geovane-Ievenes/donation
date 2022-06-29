<?php
session_start();
include('./head-page.php');
?>

    <title>Login</title>
    <link href="./css/login.css" rel="stylesheet">
  </head>
  <body>
  <div class="container">
       <div class="content first-content">
           <div class="first-column">
               <img src="./imagens/doacao_login.png">
               <div>
                <h2 class="title">Bem vindo ao Do.Nation!</h2>
                <p class="description">Torne-se parte deste incrível projeto.</p>
                <p class="description">Nós da Do.Nation, contamos com você! </p>
               </div>
           </div>
           
           <div class="second-column">
               <h2 class="title-primary">Acesse sua conta</h2>
               <div class="social-media">
                   <ul class="list-social-media">
                       <li class="item-social-media">
                            <a href="#"><i class="fab fa-facebook-square"></i></a>
                       </li>
                       <li class="item-social-media">
                            <a href="#"><i class="fab fa-google"></i></a>
                       </li>
                    </ul>
               </div>
               <p class="description-primary">Ou utilize seu Email</p>
               <form action="logar.php" class="form" method="POST">
                   <input type="Email" name="email" id="email" placeholder="Email">
                   <input type="Senha" name="senha" id="senha"placeholder="Senha">
                   <button name ="logar" class="btn">Login</button>
               </form>

               <span style="margin-top: 10px;">Ainda não é cadastrado? <a href="cadastro.php">Registre-se</a></span>
           </div>
       </div>
    </div>
    </div>
  </body>
</html>