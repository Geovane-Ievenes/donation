function validateCPNJ(strCNPJ){
    strCNPJ = strCNPJ.replace(/[^\d]+/g,'');

    if(strCNPJ == '') return false;
    
    if (strCNPJ.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (strCNPJ == "00000000000000" || 
        strCNPJ == "11111111111111" || 
        strCNPJ == "22222222222222" || 
        strCNPJ == "33333333333333" || 
        strCNPJ == "44444444444444" || 
        strCNPJ == "55555555555555" || 
        strCNPJ == "66666666666666" || 
        strCNPJ == "77777777777777" || 
        strCNPJ == "88888888888888" || 
        strCNPJ == "99999999999999")
        return false; //INVÁLIDO
        
    // Valida DVs
    tamanho = strCNPJ.length - 2
    numeros = strCNPJ.substring(0,tamanho);
    digitos = strCNPJ.substring(tamanho);
    soma = 0; 
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false; //INVÁLIDO
        
    tamanho = tamanho + 1;
    numeros = strCNPJ.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
                pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false; //INVÁLIDO
        
    return true; //CNPJ VÁLIDO
}