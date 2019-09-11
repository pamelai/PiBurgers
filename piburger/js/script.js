var d=document, c=console.log, menu, ac, selec=null, aA, user, aBtnEditarDatos, ulDatos, btnGuardarDatos, fotoPerfil, otraDirec, otroTel, otroMetodo, datosTarjeta, aSelectsCheckout, aInputs, aumentar, restar,  aFormSeguimientpo;

ac=d.querySelector('nav>p');
user=d.querySelector('header>div>p');
menu=d.querySelector('header nav .botones');
aA=d.querySelectorAll('footer a');
divModificarDatos=d.querySelector('#editar_datos');
aBtnEditarDatos=d.querySelectorAll('.abrir_form, .cerrar');
ulDatos=d.querySelector('#perfil+section ul');
fotoPerfil=d.querySelector('#perfil+section> :nth-child(3)');
otraDirec=d.querySelector('#otra_direc');
otroTel=d.querySelector('#otro_tel');
otroMetodo=d.querySelector('#otro_metodo');
datosTarjeta=d.querySelector('#tarjeta');
aSelectsCheckout=d.querySelectorAll('select[name="domicilio"], select[name="tel"], select[name="tc"]');
aH3Seguimientpo=d.querySelectorAll('#seguimiento h3')

ac.onclick=function(){
   
    if(selec==null){
        
        selec=this;
        menu.style.height='calc(100vh - 60px)';
        this.style.backgroundPosition='0 -25px';
        
    }else if(selec==this){

        menu.style.height='0';
        this.style.backgroundPosition='0 0';
        selec=null;
    }
}

$(document).ready(function(){
    $('.especial').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4500,
        arrows: false,
        pauseOnHover: true,
        responsive: [
            {
              breakpoint: 850,
              settings: {
                slidesToShow: 1
              }
            },
            {
              breakpoint: 2000,
              settings: "unslick"
            }
        ]
    });
    
    $('.reviews').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 6000,
        arrows: false,
        slidesToShow: 1
    });


    for(var i=0; i<aSelectsCheckout.length;i++){

        if(aSelectsCheckout[i] === null || aSelectsCheckout[i].value === 'otro'){
            aSelectsCheckout[i].parentElement.nextElementSibling.style.display='grid';

        }else{
            aSelectsCheckout[i].parentElement.nextElementSibling.style.display='none';

        }
    }

    for(var i=0; i<aBtnEditarDatos.length; i++){

        if(aBtnEditarDatos[i].className === 'cerrar'){ 
            if(aBtnEditarDatos[i].parentElement.parentElement.style.display === 'block'){
                aInputs=aBtnEditarDatos[i].parentElement.parentElement.querySelectorAll('input, select');
                for(var j=0;j<aInputs.length;j++){
                    aInputs[j].disabled=false
                }

            }else{
                aInputs=aBtnEditarDatos[i].parentElement.parentElement.querySelectorAll('input, select');
                for(var j=0;j<aInputs.length;j++){
                    aInputs[j].disabled=true
                }
            }
        }
    }

    for(var i=0; i<aH3Seguimientpo.length; i++){
        if(aH3Seguimientpo[i].previousElementSibling === null){
            aH3Seguimientpo[i].style.cssText='padding-right: 0;'
        }
    }
    
});

for(var i=0; i<aBtnEditarDatos.length; i++){
    aBtnEditarDatos[i].onclick=function(){

        if(this.className === 'cerrar'){
            this.parentElement.parentElement.previousElementSibling.querySelector('.abrir_form').style.display='block';
            this.parentElement.parentElement.style.display='none';
            aInputs=this.parentElement.parentElement.querySelectorAll('input, select');

            for(var j=0;j<aInputs.length;j++){
                aInputs[j].disabled=true
            }

            if(this.previousElementSibling.value === 'Guardar cambios'){
                ulDatos.style.display='grid';
            }

        }else if(this.innerHTML === 'Editar datos'){
            ulDatos.style.display='none';
            this.style.display='none';
            this.parentElement.nextElementSibling.style.display='grid';
            fotoPerfil.style.display='block';
            aInputs=this.parentElement.nextElementSibling.querySelectorAll('input, select');

            for(var j=0;j<aInputs.length;j++){
                aInputs[j].disabled=false
            }

        }else if(this.className === 'abrir_form'){ 
            this.style.display='none';
            this.parentElement.nextElementSibling.style.display='grid';
            aInputs=this.parentElement.nextElementSibling.querySelectorAll('input, select');

            for(var j=0;j<aInputs.length;j++){
                aInputs[j].disabled=false
            }
        }
    }
}

function MetodoOtro(name, valor){

    if(name === 'metodo' && valor=== 'efectivo'){
        datosTarjeta.style.display='none';

    }else{
        datosTarjeta.style.display='grid';
    } 

    if(valor=== 'otro'){
        if(name === 'domicilio'){
            otraDirec.style.display='grid';

        }else if(name === 'tel'){
            otroTel.style.display='grid';

        }else if(name === 'tc'){
            otroMetodo.style.display='grid';

        }

    }else{
        if(name === 'domicilio'){
            otraDirec.style.display='none';

        }else if(name === 'tel'){
            otroTel.style.display='none';

        }else if(name === 'tc'){
            otroMetodo.style.display='none';

        }
    }
}