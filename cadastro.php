<?php
session_start();
include('./head-page.php');
?>
    <title>Cadastre-Se</title>
    <link rel="stylesheet" href="cadastro.css">
    <style>
        .error-message{
            color: #f00;
            font-size: 9pt;
        }

        .form_area#ong{
            display: none;
        }
 
        .files{
            display: flex;
            flex-direction: column;
        }

        .input-title{
            display: inline;
            margin: 0px;
            padding: 0px;
        }

        .obrigatorio{
            color: #f00;
            display: inline;
        }

        .input_form input{
            display: inline;
            margin: 0px;
            padding: 0px;
        }

        .already_exists{
            color: #f00;
            display: none;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <div class="background-div"></div>

    <div class="form_account">
        <section class="title_page">
            <h2 class="title">Cadastre-se</h2>
            <p class="subtitle">Crie sua conta para criar um futuro</p>
        </section>
        <div class="content">
            <form action="new-reg-create.php" method="POST" id="formulario-geral" enctype="multipart/form-data">
                <div class="form_area" id="doador">
                    <div class="input_form">
                        <input type="text" class="input-required" name="usuario" name="input_form" id="nome" placeholder="Nome Completo">
                        <span class="error-message" id="0"></span>
                    </div>
                    <div class="input_form">
                        <input type="text" class="input-required" name="email" id="email" placeholder="E-Mail" required>
                        <span class="error-message" id="1"></span>
                        <span class="already_exists">Email já cadastrado</span>
                        <script>
                            $('#email').get()[0].addEventListener('focusout', e =>{
                                var email = e.target.value;

                                if(email == '') return false;

                                $.post("email_already_exists_ajax.php", `email=${email}`, function( response ) {

                                    if(response.already_exists == true){
                                        inputStatus[1] = 'invalid';
                                        $(e.target).focus();
                                        $('.already_exists').show();
                                    }
                                    else inputStatus[1] = 'valid';
                                });
                            })

                            $('#email').get()[0].addEventListener('input', () =>{
                                $('.already_exists').hide();
                            })
                        </script>
                    </div>
                    <div class="input_form">
                        <input type="password" class="input-required" name="senha" id="senha" placeholder="Senha">
                        <span class="error-message" id="2"></span>
                    </div>
                    <div class="input_form">
                        <select name="gender" id="genero" class="input-required">
                            <option value="">Gênero</option>
                            <option value="F">Feminino</option>
                            <option value="M">Masculino</option>
                            <option value="O">Outro</option>
                        </select>
                        <span class="error-message" id="3"></span>
                    </div>
                    <div class="input_form">
                        <input type="text" class="input-required" name="cpf_usuario" id="cpf" placeholder="CPF" autocomplete="off" maxlength="14">
                        <script>
                            document.getElementById('cpf').addEventListener('keyup', function(e){
                                if(e.key == 'Backspace' || e.key == 'Delete') return false;

                                var cpf = document.getElementById('cpf');
                                if (cpf.value.length == 3 || cpf.value.length == 7) {
                                    cpf.value += ".";
                                }else if(cpf.value.length == 11) {
                                    cpf.value += "-";
                                }
                            })
                        </script>
                        <span class="error-message" id="4"></span>
                    </div>
                    <div class="input_form">
                        <input type="date" class="input-required" name="birthday" id="date_birth" placeholder="Data de Aniversário">
                        <span class="error-message" id="5"></span>
                    </div>
                    <div class="input_form">
                        <label class="container-checkbox">Sou uma ONG!
                            <input type="checkbox" name="sou-ong" id="sou-ong" onchange="mostrarOngForm(this)">
                            <span class="checkmark"></span>
                        </label>
                    </div>            
                </div>
                <div class="form_area" id="ong">
                    <div class="input_form">
                        <input type="text" class="input-required" name="name_ong" id="name_ong" placeholder="Nome da ONG">
                        <span class="error-message" id="6"></span>
                    </div>
                    <div class="input_form">
                        <input type="date" class="input-required" name="fundation_ong" id="fundation_ong" placeholder="Data de Fundação">
                        <span class="error-message" id="7"></span>
                    </div>
                    <div class="input_form">
                        <input type="text" class="input-not-required" name="tel_ong" id="tel_ong" placeholder="Telefone" autocomplete="off" minlength="12" maxlength="12">
                        <script>
                            document.getElementById('tel_ong').addEventListener('keyup', function(e){
                                if(e.key == 'Backspace' || e.key == 'Delete') return false;

                                var tel = document.getElementById('tel_ong');
                                if (tel.value.length == 2) {
                                    tel.value += " ";
                                }else if(tel.value.length == 7) {
                                    tel.value += "-";
                                }
                            })
                        </script>
                    </div>
                    <div class="input_form">
                        <input type="text" class="input-not-required" name="cel_ong" id="cel_ong" placeholder="Celular" autocomplete="off" minlength="11" maxlength="11">
                        <script>
                            document.getElementById('cel_ong').addEventListener('keyup', function(e){
                                if(e.key == 'Backspace' || e.key == 'Delete') return false;

                                var tel = document.getElementById('cel_ong');
                                if (tel.value.length == 2 ) tel.value += " "; //ENVIAR ESSA PARTE PARA O NICOLAS SE SESTIVER ERRADA LÁ
                            })
                        </script>
                    </div>
                        <div class="input_form">
                        <input type="text" class="input-required" name="cnpj_ong" id="cnpj_ong" placeholder="CNPJ" autocomplete="off" maxlength="18">
                        <script>
                            document.getElementById('cnpj_ong').addEventListener('keyup', function(e){
                                if(e.key == 'Backspace' || e.key == 'Delete') return false;

                                var cnpj = document.getElementById('cnpj_ong');
                                if (cnpj.value.length == 2 || cnpj.value.length == 6) {
                                    cnpj.value += ".";
                                }else if(cnpj.value.length == 10) {
                                    cnpj.value += "/";
                                }else if(cnpj.value.length == 15) {
                                    cnpj.value += ".";
                                }
                            })
                        </script>
                        <span class="error-message" id="8"></span>
                    </div>
                    <div class="input_form">
                        <input type="text" class="input-required" name="cep_ong" id="cep_ong" placeholder="CEP" autocomplete="off" maxlength="9">
                        <script>
                            document.getElementById('cep_ong').addEventListener('keyup', function(e){
                                if(e.key == 'Backspace' || e.key == 'Delete') return false;

                                var cep = document.getElementById('cep_ong');
                                if (cep.value.length == 5) {
                                    cep.value += ".";
                                }
                            })
                        </script>
                        <span class="error-message" id="9"></span>
                    </div>
                    <div class="files">
                        <div class="input_form">
                            <input type="file" name="estatuto" id="estatuto" onchange="validarArquivo(this, 0, 'document', 'append')">
                            <label for="estatuto" class="input-title">Estatuto Social</label>
                            <span class="error-message" id="f0"></span>
                        </div>

                        <div class="input_form">
                            <input type="file" name="cnd" id="cnd" onchange="validarArquivo(this, 1, 'document', 'append')">
                            <label for="cnd" class="input-title">CND</label>    
                            <span class="error-message" id="f1"></span>
                        </div>
                    </div>
                    <div class="input_form">
                        <textarea name="description_ong" class="input-required" id="description_ong" cols="35" rows="10" placeholder="Descrição da ONG"></textarea>
                        <span class="error-message" id="10"></span>
                    </div>  
                </div>
                  
                <div class="input_form">
                    <label class="container-checkbox">Eu li e aceito <a href="termos.php">Termos de Uso</a>
                        <input type="checkbox" id="aceito-termos" onclick="acceptTerms(this)">
                        <span class="checkmark"></span>
                        <span class="error-message" id="11"></span>
                    </label>
                </div>    
                <div class="input_form">
                    <input type="submit" name="finalizar" id="finalizar" class="btn btn-primary" value="Cadastrar">
                </div>    
            </form>
        </div>
    </div>

    <script src="./js/validateCEP.js"></script>
    <script src="./js/validateCNPJ.js"></script> 
    <script src="./js/validateCPF.js"></script>
    <script src="./js/general-validation.js"></script>
    <script src="./js/user-cad-validation.js"></script>
    <script src="./js/file-validation.js"></script>
    <script>
        // "All QUERIES ARE ON user-cad-validation.js"
        
        FileStatus = ['empty', 'empty'] // The two unique file inputs

        function mostrarOngForm(checkbox){
            if(checkbox.checked === true){
                formOng.style = 'display: block'
                $('.form_area#ong :input').attr("disabled", false);
            }else{
                formOng.style = 'display: none'
                $('.form_area#ong :input').attr("disabled", true);
            }
        }

        function acceptTerms(checkbox){
            if(checkbox.checked){
                termsAccept = true;
                $('.error-message#12').html('');
            }
            else termsAccept = false;
        }
    </script>
</body>
</html>