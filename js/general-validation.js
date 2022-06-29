var allInputs = document.querySelectorAll('.input-required');

//PAGE ALL INPUTs STATUS
inputStatus = [];

for(let i of allInputs){
    inputStatus.push('empty');
}

allInputs.forEach((input, index) => {
    input.addEventListener('input', (e) => { 
        let CurrentInputError = $(`.error-message#${index}`);

        if(input.value == ''){ //VERIFIY IF INPUT IS EMPTY
            setTimeout(function(){ 
                CurrentInputError.html('Preencha este campo<br>');
                CurrentInputError.addClass('invalid');
                inputStatus[index]  = 'empty'; // SET inputStatus AS empty
            }, 175)
        }
        else{ //IF NOT, THAT INPUT IS VALID
            CurrentInputError.html(''); 
            CurrentInputError.removeClass('invalid');
            inputStatus[index] = 'filled';
        }        
    })
})