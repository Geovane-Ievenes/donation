//INPUTS
const ongSwitch = document.getElementById('sou-ong');
const telInput = document.getElementById('tel_ong');
const cnpjInput = document.getElementById('cnpj_ong');
const cepInput = document.getElementById('cep_ong');
const cpfInput = document.getElementById('cpf');
const submitButton = document.getElementById('finalizar');
const formOng = document.querySelector('.form_area#ong');
const formCadastrar = document.getElementById('formulario-geral');


//ERROR INPUTS
const cnpjError = document.querySelector('#cnpj-error');
const cpfError = document.querySelector('#cpf-error');
const cepError = document.querySelector('#cep-error');

termsAccept = false;

//Validate CNPJ on Focusout
cnpjInput.addEventListener('focusout', (e) => { 
    const CNPJ = cnpjInput.value.replaceAll(".", '').replace("/", '');
    const cnpjInputError = $(`.error-message#8`); //eoor output for the cnpj input
    
    let cnpjIsValid = validateCPNJ(CNPJ);

    if(!cnpjIsValid && cnpjInput.value != '') {
        setTimeout(function(){
            inputStatus[8] = 'invalid';

            cnpjInput.classList.add('invalid');
            cnpjInputError.html('CNPJ inválido<br>');
        }, 175)
    }
    else inputStatus[8] = 'valid';
})

//Validate CPF on Focusout
cpfInput.addEventListener('focusout', (e) => { 
    const CPF = cpfInput.value.replaceAll(".", '').replace("-", '');
    const cpfInputError = $(`.error-message#4`);

    let cpfIsValid = validateCPF(CPF);

    if(!cpfIsValid && cpfInput.value != '') {
        setTimeout(function(){
            inputStatus[9] = 'invalid';

            cpfInput.classList.add('invalid');
            cpfInputError.html('CPF inválido<br>');
        }, 175)
    }
    else inputStatus[9] = 'valid';
})

//Validate CEP on Focusout
cepInput.addEventListener('focusout', async (e) => { 
    const CEP = cepInput.value.replaceAll(".", '');
    const cepInputError = $(`.error-message#9`);
    let cepIsValid;

    //IF IS EMPTY, DON'T VERIFY
    if(cepInput.value == ''){
        inputStatus[10] = 'empty';

        cepInput.classList.add('invalid');
        cepInputError.html('Preencha este campo<br>');

        return false;
    }

    //VERIFY CEP ON WEB
    e.target.disabled = true;

    await validateCEP(CEP)
        .then(() => cepIsValid = true)
        .catch(() => cepIsValid = false) //CEP DOESN'T EXIST

    if(!cepIsValid) {
        setTimeout(function(){
            inputStatus[10] = 'invalid';

            cepInput.classList.add('invalid');
            cepInputError.html('CEP não encontrado<br>');
        }, 230)
    }

    e.target.disabled = false;
})

//FORM CONFIRMATION

formCadastrar.addEventListener('submit', async (e) =>{
    const ThereAreEmptyInputs = (inputStatus.indexOf('empty') == -1) ? false: true;
    const ThereAreInvalidInputs = (inputStatus.indexOf('invalid') == -1) ? false: true;
    const ThereAreEmptyFileInputs = (FileStatus.indexOf('empty') == -1) ? false: true;
    const ThereAreInvalidFileInputs = (FileStatus.indexOf('invalid') == -1) ? false: true;

    function validateDonor(){
        let donorEmptyInputs = 0;

        for(let i = 0; i < 5; i++){
            donorEmptyInputs += (inputStatus[i] == 'empty') ? 1 : 0;
        }
        if(donorEmptyInputs > 0 || !termsAccept){
            e.preventDefault();
            setTimeout(() => {
                //Show Empty Message for every empty input
                for(let i = 0; i < 5; i++){
                    const errorMessageQuery = $(`.error-message#${i}`);

                    if(inputStatus[i] == 'empty') errorMessageQuery.html('Preencha este campo<br>');
                }

                if(!termsAccept){
                    const errorMessageQuery = $(`.error-message#12`);
                    errorMessageQuery.html('<br>É necessário aceitar os termos de uso da plataforma')
                }

                window.scrollTo(0, 0);
            },200)
        }
    }

    function validateONG(){
        if(ThereAreEmptyInputs || ThereAreInvalidInputs || ThereAreEmptyFileInputs || ThereAreInvalidFileInputs || !termsAccept){
            e.preventDefault();
            setTimeout(() => {
                //Show empty Message for every empty input
                for(let i = 0; i <= 11; i++){
                    const errorMessageQuery = $(`.error-message#${i}`);

                    if(inputStatus[i] == 'empty') 
                        errorMessageQuery.html('Preencha este campo<br>');
                }

                for(let i = 0; i <= 1 ; i++){
                    const FileErrorMessageQuery = $(`.error-message#f${i}`);

                    if(FileStatus[i] == 'empty')
                        FileErrorMessageQuery.html('Nenhum arquivo foi enviado');
                }

                if(!termsAccept){
                    const errorMessageQuery = $(`.error-message#12`);
                    errorMessageQuery.html('É necessário aceitar os termos de uso da plataforma')
                }

                window.scrollTo(0, 0);
            },200)
        }
    }
   
    if(ongSwitch.checked) {
        validateONG();
    }
    else {
        validateDonor();
    }
})

//Inputs Mask
cnpjInput.addEventListener('keyup', function(e){
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

