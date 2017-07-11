$(function(){

    $.fn.uploadPreview = function( options ) {

        $(this).change(function(){  

            // Obtengo los parametros            
            var max = options.max;
            var allow_img = options.allow_img;
            var allow_pdf = options.allow_pdf;
            var error_upload_file = "#"+options.div_error;
            var cont_preview = options.cont_preview;
            var upload_variable = options.upload_variable;
            var pdf_icon = options.pdf_icon;

            if (typeof options.upload_variable      == 'undefined'){upload_variable = "uploaded";}           
            if (typeof options.max                  == 'undefined'){max = 1;}           
            if (typeof options.allow_img            == 'undefined'){allow_img = true;}           
            if (typeof options.allow_pdf            == 'undefined'){allow_pdf = true;}           
            if (typeof options.error_upload_file    == 'undefined'){error_upload_file = "#error_upload_file";}           
            if (typeof options.cont_preview         == 'undefined'){cont_preview = "cont_preview";}           
            if (typeof options.pdf_icon             == 'undefined'){pdf_icon = "images/pdf.jpg";}           
            

            // Limpio los mensajes
            $(error_upload_file).css("display","none");
            $(error_upload_file).html("");            

            // Obtengo el proximo div que será el preview     
            var current = $(this).attr('id'); 
            var cont = $(this).next('div.'+cont_preview);
            // Valido que existan archivos enviados
            if (this.files && this.files[0]) 
            {
                var reader = new FileReader();            
                reader.onload = function (e) 
                {
                    // Valido el tipo de archivo
                    var ext = e.target.result;      
                    var valid = 0;         
                    var error = '';
                    // Valido que sea una imagen
                    if  ( ext.match('image/jpeg.*') || ext.match('image/png.*') && allow_img )
                    {   
                        // Creo el contenedor a agregar
                        var open    = '<div class="thumbnail_cont" >';
                        var hidden  = '<input type="hidden"  name="'+upload_variable+'[]" class="" value="'+ e.target.result+'" />';
                        var del     = '<span class="glyphicon glyphicon-trash trash" rel="'+e.target.result+'"></span>';
                        var html    = '<a class="fancybox"  href="'+e.target.result+'"><img src="'+e.target.result+'" width="200"></a>';
                        var close   = '</div>';
                        
                        // Obtengo la cantidad de ingresados y verifico el máximo permitido
                        var count =  $(cont).first().children().length +1;                        
                        if (count > max )
                        {
                           error = "Has llegado al máximo de archivos permitidos.";
                        } 
                        else
                        {
                           valid = 1;
                        } 
                    } 
                    if (ext.match('application/pdf.*') && allow_pdf ) 
                    {   
                        // Creo el contenedor a agregar
                        var open    = '<div class="thumbnail_cont" >';
                        var hidden  = '<input type="hidden"  name="'+upload_variable+'[]" class="" value="'+ e.target.result+'" />';
                        var del     = '<span class="glyphicon glyphicon-trash trash" rel="'+e.target.result+'"></span>';
                        var html    = '<a class="fancybox" data-fancybox-type="iframe" href="'+e.target.result+'"><img src="'+pdf_icon+'" width="200"></a>';
                        var close   = '</div>';
                        
                        // Obtengo la cantidad de ingresados y verifico el máximo permitido
                        var count =  $(cont).first().children().length +1;                       
                        if (count > max )
                        {
                           error = "Has llegado al máximo de archivos permitidos.";
                        } 
                        else 
                        {
                            valid = 1;    
                        }                       
                        
                    }    
                    if (valid==0)
                    {
                        // Muestro error
                        if (!error)
                        {
                            error = "El formato de archivo no es válido";
                        }
                        $(error_upload_file).css("display","block");
                        $(error_upload_file).html(error);
                        $("#"+current).val('');
                    }
                    else
                    {
                        // Muestro y Agrego el contenedor con la imagen
                        $(cont).css("display","block");
                        $(open+html+del+hidden+close).appendTo(cont); 

                    }
                }            
                reader.readAsDataURL(this.files[0]);
            }
        })
    
        // Elimino del preview
        $(document).on('click', '.trash', function()
        {   
            $(this).closest('.cont_preview').prev('input').val('');
            var archivo = $(this).attr('rel');
            $(this).parent('.thumbnail_cont').remove();
            $("body"+' :input[value$="'+archivo+'"]').remove();           

        });

   };
})