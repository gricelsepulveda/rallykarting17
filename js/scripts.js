$(document).ready(function(){ "use strict";
   /*ACTIVAR MENUS*/
    $(".menu_principal > a > li").click(function(){
        $(".menu_principal > a > li").removeClass("activo");
        $(this).addClass("activo");
    });
    $(".subseccion > a > li").click(function(){
        $(".subseccion > a > li").removeClass("activo");
        $(this).addClass("activo");
    });
    $(".item > a > li").click(function(){
        $(".item > a > li").removeClass("activo");
        $(this).addClass("activo");
    });
    $(".contenedor_sede2 > nav > ul > li").click(function(){
        $(".contenedor_sede2 > nav > ul > li").removeClass("activo");
        $(this).addClass("activo");
    });
    $(".cnt_contacto > nav > ul > li").click(function(){
        $(".cnt_contacto > nav > ul > li").removeClass("activo");
        $(this).addClass("activo");
    });
    /*FUNCIONES FORMULARIOS*/
    $(".cerrar_problemas, .cerrar_formulario").click(function(){
        $(".contenedor_problemas").fadeOut("fast");
        $(".contenedor_formulario_problemas_personal").fadeOut("fast");
        $(".contenedor_formulario_problemas_kart").fadeOut("fast");
        $(".contenedor_formulario_trabaja_con_nosotros").fadeOut("fast");
        $(".contenedor_formulario_registrate").fadeOut("fast");
        $(".fondo_negro").fadeOut("fast");
        $("body").css({
                    "maxHeight":'',
                    "overflowY":''
                    });
    });
    $(".problemas_boton, .volver_formulario").click(function(){
        $("body").css({
                            "maxHeight":'100vh',
                            "overflowY":'hidden'
                        });
        $(".fondo_negro").fadeIn("fast");
        $(".contenedor_problemas").fadeIn("fast");
        $(".contenedor_formulario_problemas_kart").fadeOut("fast");
        $(".contenedor_formulario_problemas_personal").fadeOut("fast");
    });
    $(".abrir_formulario_personal").click(function(){
        $(".contenedor_problemas").fadeOut("fast");
        $(".contenedor_formulario_problemas_kart").fadeOut("fast");
        $(".contenedor_formulario_problemas_personal").fadeIn("fast");  
    });
    $(".abrir_formulario_kart").click(function(){
        $(".contenedor_problemas").fadeOut("fast");
        $(".contenedor_formulario_problemas_personal").fadeOut("fast");
        $(".contenedor_formulario_problemas_kart").fadeIn("fast");  
    });
    $("#trabaja").click(function(){
        $("body").css({
                        "maxHeight":'100vh',
                        "overflowY":'hidden'
                    });
        $(".fondo_negro").fadeIn("fast");
        $(".contenedor_problemas").fadeOut("fast");
        $(".contenedor_formulario_problemas_personal").fadeOut("fast");
        $(".contenedor_formulario_problemas_kart").fadeOut("fast");
        $(".contenedor_formulario_trabaja_con_nosotros").fadeIn("fast");
    });
    $("#registrate").click(function(){
        $("body").css({
                        "maxHeight":'100vh',
                        "overflowY":'hidden'
                    });
        $(".fondo_negro").fadeIn("fast");
        $(".contenedor_problemas").fadeOut("fast");
        $(".contenedor_formulario_problemas_personal").fadeOut("fast");
        $(".contenedor_formulario_problemas_kart").fadeOut("fast");
        $(".contenedor_formulario_registrate").fadeIn("fast");
    });
    /*MOVER SLIDER NOSOTROS*/
    $("#quienes_somos").click(function(){
        $(".contenedor_sede2 > nav").fadeOut("fast");
        $(".contenedor_sede2").animate({"marginLeft":'0vw'});
        $(".contenedor_sede2 > nav").animate({"left":'0vw'});
        $(".contenedor_sede2 > nav").fadeIn("fast");
    });
    $("#historia").click(function(){
        $(".contenedor_sede2 > nav").fadeOut("fast");
        $(".contenedor_sede2").animate({"marginLeft": '-100vw'});
        $(".contenedor_sede2 > nav").animate({"left":'100vw'});
        $(".contenedor_sede2 > nav").fadeIn("fast");
    });
    $("#mision").click(function(){
        $(".contenedor_sede2 > nav").fadeOut("fast");
        $(".contenedor_sede2").animate({"marginLeft" : '-200vw'});
        $(".contenedor_sede2 > nav").animate({"left":'200vw'});
        $(".contenedor_sede2 > nav").fadeIn("fast");
    });
    /*TITULO CONTACTO*/
    $("#sugerencias_reclamos").click(function(){
        $(".nav_contacto").animate({"marginTop":'-1.4rem'});
    });
    $("#cotizar_campeonato").click(function(){
        $(".nav_contacto").animate({"marginTop":'0rem'});
    });
    $("#contacto_comercial").click(function(){
        $(".nav_contacto").animate({"marginTop":'-3rem'});
    });
    /*ACTIVAR DROP MENU PRINCIPAL*/
    $(".btn_menu_main").click(function(){
        if($(".nav_menu_main").css("height")=='0px')
            {
                $(".nav_menu_main").css({
                                                    "height":'auto',
                                                    "position":'absolute',
                                                    "top": '3.25rem'
                                                });
            }
        else{
                $(".nav_menu_main").css({
                                                    "height":'',
                                                    "position":'',
                                                    "top": ''
                                                });
            }
    });
    $(".nav_menu_main li").click(function(){
        $(".nav_menu_main").animate({
                                        "height":'',
                                        "position":'',
                                        "top": ''
                                    });
    });
    /*ACTIVAR DROP MENU SEDES*/
     $(".btn_menu_sede").click(function(){
        if($(".menu_sedes li").css("display")=='none')
            {
                $(".menu_sedes li").css({
                                                    "display":'block'
                                                });
            }
        else{
                $(".menu_sedes li").css({
                                                    "display":'none'
                                                });
            }
    });
    $(".menu_sedes li").mouseleave(function(){
        $(".menu_sedes li").css({
                                        "display":'none'
                                    });
    });
    $(".menu_sedes li").click(function(){
        $(".menu_sedes li").css({
                                        "display":'none'
                                    });
    });
    $(".menu_sedes > ul > li > a > div").click(function(){
        $(".menu_sedes > ul > li > a > div").removeClass("activo");
        $(this).addClass("activo");
    });
});

//SCROLL NAV

$(function() { "use strict";
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});


// COVERS FACEBOOK

// CALAMA
$(function() { "use strict";
$.getJSON('https://graph.facebook.com/1669875936625049?fields=cover&access_token=EAADtrhgW99cBALYUx8Khr3VLV8uD3ZCvkNnliQgIyGFJe6eSP9efcFcy6HzqScFamG8KQREyz8sG6pfqXZCgiKLmXnpSGAUpnrxZCN8g5mrCiEwHOw5BtfPASOB1N1GuBeZAz9tGqVtwsAppo5V0rGJk9LdlYnYjpZAJaK5ftUQZDZD', { id: $(this).attr("id")}, function (data) { $('#cover-calama').css("background-image", "url(" + data.cover.source + ")");
});
});

// ANTOFAGASTA
$(function() { "use strict";
$.getJSON('https://graph.facebook.com/267106520125537?fields=cover&access_token=EAADtrhgW99cBAOlwKbifwZC0ea1IiN3R5ZCs9CwRL2RlOoDEZAGRAzPH5d9swM6Gk0aFYXtKDV8ZB9semAUsiXgdWsN7KMOEevYhiZAoX8QZCNGmkgzY8VmCUP55ZAOS9N4jMHK6W6hDAXIB3qIgEhaSrgZB53hWZAuAR6fmbaqzMnQZDZD', { id: $(this).attr("id")}, function (data) { $('#cover-antofagasta').css("background-image", "url(" + data.cover.source + ")");
});
});

// LA SERENA
$(function() { "use strict";
$.getJSON('https://graph.facebook.com/315578865306752?fields=cover&access_token=EAADtrhgW99cBAOlwKbifwZC0ea1IiN3R5ZCs9CwRL2RlOoDEZAGRAzPH5d9swM6Gk0aFYXtKDV8ZB9semAUsiXgdWsN7KMOEevYhiZAoX8QZCNGmkgzY8VmCUP55ZAOS9N4jMHK6W6hDAXIB3qIgEhaSrgZB53hWZAuAR6fmbaqzMnQZDZD', { id: $(this).attr("id")}, function (data) { $('#cover-laserena').css("background-image", "url(" + data.cover.source + ")");
});
});

// VIÑA DEL MAR
$(function() { "use strict";
$.getJSON('https://graph.facebook.com/1623296331276840?fields=cover&access_token=EAADtrhgW99cBAAFERQWrp1iSCKZBKZBNUDZAFDoDtPsXHGfZAccDWFjNnnlh1lWLAZCBsIqXrKWYOqKtSrZBZBTFYcfWwy1zBpP6MT8nyPiu5qqBxfffSafbaulZAIAKvzY7ZAWOI4eNUHRjweuyUzzW8V5lp82uHUbiCQuZBNoSM9dwZDZD', { id: $(this).attr("id")}, function (data) { $('#cover-vinadelmar').css("background-image", "url(" + data.cover.source + ")");
});
});

// SANTIAGO
$(function() { "use strict";
$.getJSON('https://graph.facebook.com/499708476821062?fields=cover&access_token=EAADtrhgW99cBAAFiBnTH1hdGJIURd5UMu2ogm09iJRAQc7g3bNftosA5BAJGCLTf6DygXwRfdr6jycN3yZBETd5qLSJPkZA4yubNHkCNCRIUMgHMMC0B6SNDxzmrFSlwaQ9JvhNSHWrEIF1bnkVvxOMX8H62J5Fyw951QGpgZDZD', { id: $(this).attr("id")}, function (data) { $('#cover-santiago').css("background-image", "url(" + data.cover.source + ")");
});
});

// SANTIAGO OESTE
$(function() { "use strict";
$.getJSON('https://graph.facebook.com/962366610545862?fields=cover&access_token=EAADtrhgW99cBACCvK1nnABCP9TsvROfjJHyEmPCzRDgY08jv5XZBvarMmNPRni4NlViEskhnX1YdtfeI9DSbtrokaX9ZBQYglEyAR9iJ5tSeyRZAJGfx8tttlWOuyDNHAbiJcXIIxQdzKZBySOSP01R0PnqKPZC4wO3bpMixj3AZDZD', { id: $(this).attr("id")}, function (data) { $('#cover-santiago').css("background-image", "url(" + data.cover.source + ")");
});
});

// CONCEPCION
$(function() { "use strict";
$.getJSON('https://graph.facebook.com/1477398122565380?fields=cover&access_token=EAADtrhgW99cBAABdq8ggWiZALp64r9ZBOpe54da1MsFDZByUkpYqKWdLdkNm79VyFyZAVETauiJVAaig3bBUoehvS9GM3gnyJC5UnZCGC0RwQBvDxWAneqbNZAYspYQ35bvgrhUcCCUGkzC8b9EgVZARdZCozfAFN6Dbcb4CT7yc7gZDZD', { id: $(this).attr("id")}, function (data) { $('#cover-concepcion').css("background-image", "url(" + data.cover.source + ")");
});
});

// PUERTO MONTT
$(function() { "use strict";
$.getJSON('https://graph.facebook.com/431130450426355?fields=cover&access_token=EAADtrhgW99cBAFArYkhIcqA44rl4BZC8Sqyz0WSwrwnSVHQpb1IF57bVbyZANg5zIXVn9t7ZBhHrGUxZCYRxks6ZC3BCCZAqoebDsVFQBsyXAYdzI0dvvsw2uqE1Gb8ZA3TOb1ijXd4v442f4fbpTRg2AwIOKAQzZARD4GWCZC5huGwZDZD', { id: $(this).attr("id")}, function (data) { $('#cover-ptomontt').css("background-image", "url(" + data.cover.source + ")");
});
});
