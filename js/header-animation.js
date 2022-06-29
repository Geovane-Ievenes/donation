function AlternarLogo(simplificar){
    var logoGlobo = document.querySelector('#globo');
    var logoCoracao = document.querySelector('#coracao');
    var LogoLegenda = document.querySelector('#legenda');
    

    if(simplificar){
        LogoLegenda.classList.add('oculto');
        logoGlobo.classList.add('maior');
        logoCoracao.classList.add('posicionado');
    }
    else{
        LogoLegenda.classList.remove('oculto');
        logoGlobo.classList.remove('maior');
        logoCoracao.classList.remove('posicionado');
    } 
}

$(function(){
    $(window).scroll(function(){
        var scroll = $(window).scrollTop();

        if(scroll >= 100){
            AlternarLogo(true);
            $('.slogan').fadeOut(700);
            $('.cabecalho_site nav ul li a')[0].classList.add('contracao-nav');
            $('.cabecalho_site nav')[0].classList.add('nav-subir');
            
        }
        else{
            AlternarLogo(false);
            $('.slogan').fadeIn(700);
            $('.cabecalho_site nav ul li a')[0].classList.remove('contracao-nav');
            $('.cabecalho_site nav')[0].classList.remove('nav-subir');
        }
    })
})