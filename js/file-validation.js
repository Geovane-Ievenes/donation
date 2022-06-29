FileStatus = [];
var showErrors;

function validarArquivo(FileInput, spanIndex, fileType, errorType){
    var errors = [];

    if(errorType == 'append'){
        showErrors = function(errorsArr, FileInput, inputIndex){
            FileStatus[inputIndex] = 'invalid';
            FileInput.classList.add('invalid');
            $(`.error-message#f${inputIndex}`).html(errorsArr[0]);  
        }
    }
    if(errorType == 'popup'){
        showErrors = function(errorsArr, FileInput, inputIndex){
            FileStatus[inputIndex] = 'invalid';
            FileInput.classList.add('invalid');
            window.alert(errorsArr[0]);
        }
    }
    if(errorType == 'profilePopup'){
        showErrors = function(errorsArr, FileInput){
            HasProfilePicture = false; //guarantee that the variable is false
            FileInput.classList.add('invalid');
            window.alert(errorsArr[0]);
        }
    }
    if(errorType == 'proofPopup'){
        showErrors = function(errorsArr){
            validProof = false; //guarantee that the variable is false
            window.alert(errorsArr[0]);
        }
    }

    if(errorType != 'proofPopup'){ //It just happens in doacoes.php on donation-admin, where doesn't need a "invalid" class
        //remove invalid message and status
        FileInput.classList.remove('invalid');
    }

    if(fileType != 'profile' || errorType != 'popup' && errorType != 'proofPopup') //Filetype is SlideImage
        $(`.error-message#f${spanIndex}`).html('');    

    if(FileInput.files && FileInput.files[0]){
        if(fileType != 'profile' && errorType != 'proofPopup')
            FileStatus[spanIndex] = 'not-empty';    
        else if(errorType == 'proofPopup'){ //comprovante_pagamento.php or doacoes.php (donation-admin dir)
            proofHasBeenInserted = true;
        }

        //valiodar extensõess
        var extensoesPermitidas = undefined;

            //Permited extensions regex
        if(fileType == 'image' || fileType == 'profile') extensoesPermitidas = /(.jpg|.jpeg|.png|.gif)$/i;
        else if(fileType == 'document') extensoesPermitidas = /(.doc|.docx|.pdf)$/i;
        else if(fileType == 'both') extensoesPermitidas = /(.doc|.docx|.pdf|.jpg|.jpeg|.png|.gif)$/i;
        
            //Permited extensions string warning
        if(fileType == 'image' || fileType == 'profile') extensoesPermitidasStr = '.jpg / .jpeg / .png / .gif';
        else if(fileType == 'document') extensoesPermitidasStr = '.doc / .docx / .pdf';
        else if(fileType == 'both') extensoesPermitidasStr = '.jpg / .jpeg / .png / .gif / .doc / .docx / .pdf';

        if(!extensoesPermitidas.exec(FileInput.files[0].name))
            errors.push(`A extensão do arquivo não é permitida. Extensões válidas:<br> ${extensoesPermitidasStr}`);
        
        //validar tamanho
        if(FileInput.files[0].size > 2097152)
            errors.push('O arquivo é muito grande para envio');

        //validar
        if(errors.length > 0){
            if(errorType == 'profilePopup') showErrors(errors, FileInput);
            else if(errorType == 'proofPopup') showErrors(errors);
            else showErrors(errors, FileInput, spanIndex); //append and popuo error type
            
            return false;
        }

        return true // no error found
    }
    return false;
}