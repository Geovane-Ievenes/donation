function validateProfilePic(profileInput, editProject, cupom){
    let valid = undefined;
    
    if(!cupom) valid = validarArquivo(profileInput, null, 'both', 'popup');
    else valid = validarArquivo(profileInput, null, 'profile', 'profilePopup');

    if(valid){
        HasProfilePicture = true;
        RemoveProfile.style = 'display: inline'
        $('.error-message#profile').html('');

        //EXIBIR PREVIEW DA IMAGEM (EM OUTRAS PÁGINAS, AS QUERIES JQUERY DEVEM SER ADEQUADAS AS QUE A FUNÇÃO POSSUI)
        previewImg = undefined;

        if(!editProject){
            previewImg = $('#profile-label')[0];
        }
        else previewImg = $('.preview img').get()[0];

        const uploadedImg = $('#profile-pic').get()[0].files[0];

        if(typeof uploadedImg != 'undefined'){
            var ImageURL = URL.createObjectURL(uploadedImg);
        }
        else return false;

        if(!editProject){
            previewImg.style.backgroundImage = `url(${ImageURL})`;
        }else{
            previewImg.src = ImageURL;
        }

        if(editProject){
            saveStatus.value = 'true';
            profileChangedStatus.value = "true";
            profileRemovedStatus.value = "false";

            if(!pendingRequest) submitInput.disabled = false;
        }

        $('#profile-pic').hide();
    }
}

//(EM OUTRAS PÁGINAS, AS QUERIES JQUERY DEVEM SER ADEQUADAS AS QUE A FUNÇÃO POSSUI)
function removeProfilePic(editProject){
    $('#profile-pic').remove();

    let replaceFileInputHtmlString = `<input type="file" name="logo_projeto" class="logo_projeto" accept="image/png,image/jpeg,image/jpg" id="profile-pic" onchange="validateProfilePic(this)">`;
    let replaceFileInputDoc = new DOMParser().parseFromString(replaceFileInputHtmlString, "text/html");
    let newFileInput = replaceFileInputDoc.querySelector('.logo_projeto');
    $(newFileInput).insertBefore($('.error-message#profile')); 

    const previewImg = undefined;

    if(editProject) previewImg = $('.preview img').get()[0];
    else previewImg = $('#profile-label').get()[0];

    if(editProject){
        previewImg.src = './no-img.png';
        $('#remove-image').hide();

        saveStatus.value = 'true';
        profileChangedStatus.value = "false";
        profileRemovedStatus.value = "true";

        if(!pendingRequest) submitInput.disabled = false;
    }
    else{
        //Aqui é pra quando vai criar um novo projeto
        previewImg.style.backgroundImage = '';
    }

    HasProfilePicture = false;
    RemoveProfile.style = 'display: none'
}   