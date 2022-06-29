function validateCEP(strCEP){
    return new Promise((resolve, reject) => {
        let encontrado = undefined;
        const url = `https://viacep.com.br/ws/${strCEP}/json/`;
    
        fetch(url)
            .then(() => resolve())
            .catch(() => reject())
    })
}