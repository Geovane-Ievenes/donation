const inputsCount = allInputs.length;

var projectTermsAccept = false;
var HasProfilePicture = false;

function validateProjectForm(e){
    const ThereAreEmptyInputs = (inputStatus.indexOf('empty') == -1) ? false: true;
    const ThereAreEmptyFileInputs = (FileStatus.indexOf('empty') == -1) ? false: true;

    if(ThereAreEmptyInputs || ThereAreEmptyFileInputs || globalCheked == 0 || !projectTermsAccept || !HasProfilePicture){
        e.preventDefault();
        setTimeout(() => {
            if(!HasProfilePicture){
                const errorMessageQuery = $(`.error-message#profile`);
                errorMessageQuery.html('Selecione uma identidade para seu projeto')
            }

            //Show empty Message for every empty input
            for(let i = 0; i < inputsCount; i++){
                const errorMessageQuery = $(`.error-message#${i}`);

                if(inputStatus[i] == 'empty') 
                    errorMessageQuery.html('Preencha este campo<br>');
            }

            if(globalCheked == 0){
                const errorMessageQuery = $(`.error-message#goals`);
                errorMessageQuery.html('Seu projeto precisa de ao menos um quesito para atender')
            }

            //If user did't upload any image...
            if(FileStatus[0] == 'empty'){
                const FileErrorMessageQuery = $(`.error-message#slider`);
                FileErrorMessageQuery.html('Selecione ao menos uma imagem');
            }

            if(!projectTermsAccept){
                const errorMessageQuery = $(`.error-message#terms`);
                errorMessageQuery.html('É necessário aceitar nossa política de responsabilidade para criação de projetos')
            }

            window.scrollTo(0, 0);
            return false;
        },200)
    }
    return true;
}