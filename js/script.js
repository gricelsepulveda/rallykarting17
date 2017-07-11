$(document).ready(function(){
  /*MOVER SLIDE SEDE */
    $("#indicaciones").click(function(){
        $(".contenedor_sede > nav").fadeOut("fast");
        $(".contenedor_sede").animate({"marginLeft":'0vw'});
        $(".contenedor_sede > nav").animate({"left":'0vw'});
        $(".contenedor_sede > nav").fadeIn("fast");
    });
    $("#novedades").click(function(){
        $(".contenedor_sede > nav").fadeOut("fast");
        $(".contenedor_sede").animate({"marginLeft": '-100vw'});
        $(".contenedor_sede > nav").animate({"left":'100vw'});
        $(".contenedor_sede > nav").fadeIn("fast");
    });
    $("#imagenes").click(function(){
        $(".contenedor_sede > nav").fadeOut("fast");
        $(".contenedor_sede").animate({"marginLeft" : '-200vw'});
        $(".contenedor_sede > nav").animate({"left":'200vw'});
        $(".contenedor_sede > nav").fadeIn("fast");
    });
    $(".contenedor_sede > nav > ul > li").click(function(){
        $(".contenedor_sede > nav > ul > li").removeClass("activo");
        $(this).addClass("activo");
    });
});
