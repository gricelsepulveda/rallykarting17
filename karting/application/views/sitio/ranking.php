<div class="login-usuario">
    <div class="container">
        <div class="row">
            <div class="col-md-13" style="text-align:center">
                <br>
                <img src="<?php echo base_url();?>assets/img/titulo-ranking.png" class="titulo">
                <div class="clear"></div>

                <div class="row">
                    <div class="col-md-9">
                        <div id="inst_fb">
                            <i class="fa fa-facebook-official" aria-hidden="true"></i> <span>¡Comparte tu resultado en Facebook!. Lleva el mouse hasta tu mejor tiempo y haz click en el ícono que aparecerá en la esquina.</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="selectRacetrack">
                            <?php echo $racetracks; ?>
                        </select>
                    </div>
                </div>
                
                <div id="loader-container" style="display:none;">
                    <div class='uil-default-css loader'>
                        <div class='general-loader loader-0'></div>
                        <div class='general-loader loader-30'></div>
                        <div class='general-loader loader-60'></div>
                        <div class='general-loader loader-90'></div>
                        <div class='general-loader loader-120'></div>
                        <div class='general-loader loader-150'></div>
                        <div class='general-loader loader-180'></div>
                        <div class='general-loader loader-210'></div>
                        <div class='general-loader loader-240'></div>
                        <div class='general-loader loader-270'></div>
                        <div class='general-loader loader-300'></div>
                        <div class='general-loader loader-330'></div>
                    </div>
                </div>

                <div class="ranking-container" style="display:none;">
                    <?php if(0 == 1): ?>
                    <div class="cuadro-ranking">

                        <?php
                        $posicion   =   $this->ranking_model->posicion($me_id);
                        $detalle    =   $this->usuarios_model->detalle_ranking($me_id);
                        ?>
                        <div class="listado-ranking me">
                            <p class="posicion"><strong><?php echo $posicion ?></strong></p>
                            <img src="<?php echo base_url();?>assets/img/icon-yo.png" class="avatar">
                            <p class="nombre"><strong><?php echo $this->usuarios_model->nombre($me_id); ?></strong></p>
                            <div class="cont-resultado scroller">
                                <?php for ($j=0; $j < sizeof($detalle); $j++) { ?>
                                    <?php
                                    $best_explode   =   explode('.', $detalle[$j]->mejor_tiempo);
                                    $best_total     =   $best_explode[0];
                                    $best_explode   =   explode(':', $best_total);
                                    $best_final     =   (isset($best_explode[2])) ? $best_total : '00:'.$best_total;

                                    $total_explode  =   explode('.', $detalle[$j]->tiempo_total);
                                    $total_total    =   $total_explode[0];
                                    $total_explode  =   explode(':', $total_total);
                                    $total_final    =   (isset($total_explode[2])) ? $total_total : '00:' . $total_total;
                                    ?>
                                    <div class="resultado">
                                        <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                                        <!--<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link; ?>" target="_blank">-->
                                        <a href="javascript: void(0)" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u=http://www.rallykarting.cl&description=He realizado una vuelta en <?php echo $best_final; ?>', 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no')">
                                            <img src="<?php echo base_url();?>assets/img/fb.png" class="fb">
                                        </a>
                                        <p>Mejor Tiempo <strong><?php echo $best_final; ?></strong></p>
                                        <p>Total Vueltas <strong><?php echo $detalle[$j]->total_vueltas; ?></strong></p>
                                        <p>Tiempo Total <strong><?php echo $total_final; ?></strong></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>


                        <?php for ($i=0; $i < sizeof($ranking); $i++) {
                        $detalle = $this->usuarios_model->detalle_ranking($ranking[$i]->id_usuario);

                        if($this->session->userdata['id_usuario'] == $ranking[$i]->id_usuario)
                        {
                        	$me_class = 'me';
                        }
                        else
                        {
                        	$me_class = '';
                        }

                        // Avatar
                        if($i+1 == 1):
                            $img = base_url('assets/img/icon-oro.png');
                        elseif($i+1 == 2):
                            $img = base_url('assets/img/icon-plata.png');
                        elseif($i+1 == 3):
                            $img = base_url('assets/img/icon-bronce.png');
                        else:
                            $img = base_url('assets/img/icon-todos.png');
                        endif;
                        ?>
                            <div class="listado-ranking">
                                <p class="posicion"><strong><?php echo $i+1; ?></strong></p>
                                <img src="<?php echo $img; ?>" class="avatar">
                                <p class="nombre"><strong><?php echo $this->usuarios_model->nombre($ranking[$i]->id_usuario) ?></strong></p>
                                <div class="cont-resultado scroller">
                                    <?php for ($j=0; $j < sizeof($detalle); $j++) { ?>
                                    	<?php
                                        $best_explode   =   explode('.', $detalle[$j]->mejor_tiempo);
                                        $best_total     =   $best_explode[0];
                                        $best_explode   =   explode(':', $best_total);
                                        $best_final     =   (isset($best_explode[2])) ? $best_total : '00:'.$best_total;

                                    	$total_explode 	=	explode('.', $detalle[$j]->tiempo_total);
    									$total_total    =	$total_explode[0];
                                        $total_explode  =   explode(':', $total_total);
                                        $total_final    =   (isset($total_explode[2])) ? $total_total : '00:' . $total_total;
                                    	?>
                                        <div class="resultado">
                                            <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                                            <!--<a href="javascript: void(0)" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u=http://www.rallykarting.cl&description=He realizado una vuelta en <?php echo $best_final; ?>', 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no')">
                                                <img src="<?php //echo base_url();?>assets/img/fb.png" class="fb">
                                            </a>-->
                                            <p>Mejor Tiempo <strong><?php echo $best_final; ?></strong></p>
                                            <p>Total Vueltas <strong><?php echo $detalle[$j]->total_vueltas; ?></strong></p>
                                            <p>Tiempo Total <strong><?php echo $total_final; ?></strong></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php endif; // if 0 == 1 ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cls"></div>

<div class="firma">
    <p>by youtouch</p>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.simplyscroll.js"></script>
    <script type="text/javascript">
    
    // Llamada
    function updateRanking(racetrack)
    {
        $( "#selectRacetrack" ).prop("disabled", 1);
        var selected = parseInt($( "#selectRacetrack" ).val());

        if( selected != -1) {
            route = "<?php echo site_url('inicio/change_ranking'); ?>/" + racetrack;

            $.ajax({
                method: "GET",
                url: route,
                beforeSend: function() {
                    $( ".ranking-container" ).hide();
                    $("#loader-container").show();
                }
            })
            .done(function( data ) {
                setTimeout(function() {
                    $("#loader-container").hide();
                    $( ".ranking-container" ).empty().html( data ).show();
                    $( "#selectRacetrack" ).prop("disabled", 0);
                }, 2000);
            });
        }
    }

    // Cambio de opción en select pista
    $( "#selectRacetrack" ).change(function() {
        if( parseInt($(this).val()) != -1) {
            updateRanking($(this).val());
            return false;
        }
    });

    $( document ).ready(function() {
        
        routeBestTrack =  "<?php echo site_url('inicio/my_best_racetrack'); ?>/";
        
        $.get( routeBestTrack, function( data ) {
            if (data.status !== undefined && data.status !== null) {

                if(data.status == 1) {
                    $("#selectRacetrack").val(data.data);
                    updateRanking(data.data);
                } else {
                    defaultOption = $("#selectRacetrack option:eq(0)").val();
                    $("#selectRacetrack").val( defaultOption );
                    updateRanking( defaultOption );
                }
            }
        });
    });
    </script>
    </body>
</html>