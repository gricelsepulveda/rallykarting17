<div class="cuadro-ranking">
    <?php
    $posicion   =   $this->ranking_model->posicion($me_id);
    $detalle    =   $this->usuarios_model->detalle_ranking_by_racetrack($me_id, $racetrack);
    //$detalle    =   $this->usuarios_model->detalle_ranking_by_racetrack($me_id);
    ?>
    <div class="listado-ranking me">
        <?php if(sizeof($detalle)): ?>
            <p class="posicion"><strong><?php echo $posicion ?></strong></p>
            <img src="<?php echo base_url();?>assets/img/icon-yo.png" class="avatar">
            <p class="nombre"><strong><?php echo $this->usuarios_model->nombre($me_id); ?></strong></p>
            <div class="cont-resultado scroller">
                <?php for ($j=0; $j < sizeof($detalle); $j++) { ?>
                    <?php
                    $lapTime = substr($detalle[$j]->mejor_tiempo, 0, 12);
                    $totalTime = substr($detalle[$j]->tiempo_total, 0, 12);

                    $lapDate = explode(' ', $detalle[$j]->fecha);
                    
                    if(!empty($lapDate[0])) {
                        $arrDate = explode('-', $lapDate[0]);
                        $lapDate = $arrDate[2].'/'.$arrDate[1].'/'.$arrDate[0];
                    }
                    ?>
                    <div class="resultado">
                        <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                        <a href="javascript: void(0)" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u=http://www.rallykarting.cl&description=He realizado una vuelta en <?php echo $best_final; ?>', 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no')">
                            <img src="<?php echo base_url();?>assets/img/fb.png" class="fb">
                        </a>
                        <?php if(!empty($lapDate)): ?>
                        <p>Fecha: <strong><?php echo $lapDate; ?></strong></p>
                        <?php endif; ?>
                        <p>Mejor Tiempo: <strong><?php echo $lapTime; ?></strong></p>
                        <p>Total Vueltas: <strong><?php echo $detalle[$j]->total_vueltas; ?></strong></p>
                        <p>Tiempo Total: <strong><?php echo $totalTime; ?></strong></p>
                    </div>
                <?php } ?>
            </div>
        <?php else: ?>
            <p class="posicion"><strong></strong></p>
            <img src="<?php echo base_url();?>assets/img/icon-yo.png" class="avatar">
            <p class="nombre"><strong><?php echo $this->usuarios_model->nombre($me_id); ?></strong></p>
            <div class="cont-resultado scroller">
                <div class="resultado">
                    <p style="padding-top: 20px;">No presentas tiempos en esta pista</p>
                </div>
            </div>
        <?php endif; ?>
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
                    $lapTime = substr($detalle[$j]->mejor_tiempo, 0, 12);
                    $totalTime = substr($detalle[$j]->tiempo_total, 0, 12);

                    $lapDate = explode(' ', $detalle[$j]->fecha);
                    
                    if(!empty($lapDate[0])) {
                        $arrDate = explode('-', $lapDate[0]);
                        $lapDate = $arrDate[2].'/'.$arrDate[1].'/'.$arrDate[0];
                    }
                	?>
                    <div class="resultado">
                        <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                        <?php if(!empty($lapDate)): ?>
                        <p>Fecha: <strong><?php echo $lapDate; ?></strong></p>
                        <?php endif; ?>
                        <p>Mejor Tiempo <strong><?php echo $lapTime; ?></strong></p>
                        <p>Total Vueltas <strong><?php echo $detalle[$j]->total_vueltas; ?></strong></p>
                        <p>Tiempo Total <strong><?php echo $totalTime; ?></strong></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
    (function($) {

        $(function() { //on DOM ready
            $(".scroller").simplyScroll({
                auto: false,
                speed: 5
            });

            $(".resultado").mouseover(function(){
                $(this).find('.fb').css("display","block");
            })

            $(".resultado").mouseleave(function(){
                $(this).find('.fb').css("display","none");
            })
        });
    })(jQuery);
</script>