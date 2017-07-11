<?php
	namespace seoFacebookTimeline;
    include_once('../facebook/lib/facebookFunctions.php');
    include_once('../facebook/lib/facebookTimeline.php');
    include_once('../facebook/lib/facebookItem.php');
    include_once('../facebook/lib/facebookComment.php');
    include_once('../facebook/lib/language.php');
	function shorten($string, $length) {
	$suffix = '&hellip;';
	$short_desc = trim(str_replace(array("\r","\n", "\t"), ' ', strip_tags($string)));
	$desc = trim(substr($short_desc, 0, $length));
	$lastchar = substr($desc, -1, 1);
	if ($lastchar == '.' || $lastchar == '!' || $lastchar == '?') $suffix='';
	$desc .= $suffix;
	return $desc;
	}
?>
<script src="js/script.js" type="text/javascript"></script><!--SCRIPTS PERSONALIZADOS-->
<script src="js/galeria/laserena.js" type="text/javascript"></script><!--GALERIA FACEBOOK JS-->
					<div class="contenedor_sede">
						<nav><!--BOTONERA SEDE-->
							<ul>
								<li class="activo" id="indicaciones">Indicaciones <i class="fa fa-angle-right"></i></li>
								<li id="novedades">Novedades <i class="fa fa-angle-right"></i></li>
								<li id="imagenes">En imágenes <i class="fa fa-angle-right"></i></li>
							</ul>
						</nav>
						<!--INICIO SECCION INDICACIONES-->
						<article class="seccion_indicaciones">
							<div class="lateral_left img_left"
								style="
									background: #000000 url(img/la_serena/mapa.png);
									background-blend-mode: lighten;
									background-size: cover;
									background-position: center;
									-webkit-filter: blur(1);
									-moz-filter: blur(1);
									-o-filter: blur(1);
									-ms-filter: blur(1);
									filter: blur(1);
								"
							><!--MAPA-->
								<a target="_blank" href="https://goo.gl/maps/SbKpaaUS53s">
									<figure>
										<img src="img/la_serena/mapa.png"><!--MAPA GOOGLE MAPS-->	
									</figure>
								</a>
							</div>
							<div class="lateral_right"><!--INDICACIONES MAPA-->
								<div class="indicaciones">
									<p>Horario de atención <i class="fa fa-angle-left"></i></p>
									<span>Lunes a Domingo 11:00 a 22:00hrs</span>
									<br/>
									<p>Dirección <i class="fa fa-angle-left"></i></p>
									<span>IV Region, La Serena – Francisco de Aguirre con Libertad.</span>
									<br/>
									<p>E-mail <i class="fa fa-angle-left"></i></p>
									<span>j@Rallykarting.cl</span>
									<br/>
									<p>Teléfonos <i class="fa fa-angle-left"></i></p>
									<a href="+56952340090"><span>+56 9 52340090</span></a>
									<a href="+56949151095"><span>+56 9 49151095</span></a>
									<br/>
									<p>Valores <i class="fa fa-angle-left"></i></p>
									<span>
									<h4>Test</h4>
									10 vueltas x $5.000<br/>
									<h4>Corta</h4>
									15 vueltas x $7.000<br/>
									<h4>Normal</h4>
									24 vueltas x $10.000<br/>
									<h4>Desafio</h4>
									35 vueltas x $15.000<br/>
									</span>
								</div>
							</div>
						</article>
						<!--FIN SECCION INDICACIONES-->
						<!--INICIO SECCION NOVEDADES-->
						<article class="seccion_novedades">
							<div class="lateral_left img_left"
								style="
                                	background: #F5DA81 url(http://graph.facebook.com/315578865306752/picture?width=3000);
									background-blend-mode: soft-light;
									background-size: cover;
									background-position: center; 
									-webkit-filter: blur(1);
									-moz-filter: blur(1);
									-o-filter: blur(1);
									-ms-filter: blur(1);
									filter: blur(1);
								">
                                <!--IMAGEN NOTICIA-->
                                <figure>
									<a target="_blank" href="https://www.facebook.com/Rally-Karting-La-Serena-315578865306752/">
                                    <img src="http://graph.facebook.com/315578865306752/picture?width=3000">
									</a>	
								</figure>
                                <!--FIN IMAGEN NOTICIA-->
							</div>
							<div class="lateral_right"><!--INDICACIONES MAPA-->
								<div class="noticias">
                                <!--NOVEDADES-->  
                                <?php
								$tl = new timeline (
    							 '315578865306752', // username or id
   							     '1403531783287112', // facebook tokenId
   							     'aefc31dedc867adfcb816e3b8991d1dd' // facebook tokenSecret
   							    );
   							    $tl->setMaxItems(4); //How many items (Don't use to many. preferred 30,40 or 50)
								$tl->setNewsType('posts'); //Feed or Posts
								$tl->setNewsFilter(true); //Filter only posts if it contains text (so no status updates)
								$tl->setShowImages(false); //Show images on posts
								$tl->setHrImages(true); //Higher resolution images ? Lazy loading will prevent slowing down your website
								$tl->setShowComments(false); //Show Comments
								$tl->setMaxComments(10); //Maximum comments to show (Don't use to many. preferred 10)
								$tl->setCacheLife(21600); //Cache life in seconds. Cache is disabled when set to "0".
								$tl->setCacheDirectory('../facebook/cache/'); //cache directory
								$tl->setBullets(false); //Show bullets and timeline stripe divider
								$tl->setDebug(false); //Set debug to true to see the json url. For testing only

    							# LENGUAGE
    							$lang = new language();

        							$lang->setTitle('Posts');
									$lang->setShareOnTwitter('Compartir en Twitter');
        							$lang->setShareOnLinkedIn('Compartir en LinkedIn');
									$lang->setshareOnFacebook('Compartir en Facebook');
        							$lang->setShareOnGooglePlus('Compartir en Google+');
        							$lang->setComment('¡Comenta o dale me gusta!');
        							$lang->setShowComments('Mostar comentarios');
        							$lang->setBy('por');
        							$lang->setDatePrefix('');
        							$lang->setSecondsAgo(' segundos atrás');
        							$lang->setMinuteAgo(' minuto atrás');
        							$lang->setMinutesAgo(' minutos atrás');
        							$lang->setHourAgo(' hora atrás');
        							$lang->setHoursAgo(' horas atrás');
        							$lang->setDayAgo(' día atrás');
        							$lang->setDaysAgo(' días atrás');
        							$lang->setWeekAgo(' semana atrás');
        							$lang->setWeeksAgo(' semanas atrás');

    							$tl->setLanguage($lang);
    							$items = $tl->getItems();
    							foreach($items as $item){
        							$image = $item->getImage();
        							$video = $item->getVideo();
									$mp4video = $item->getMP4Video();
									$soundcloud = $item->getSoundcloud();
        							$rtol = ($tl->is_rtl($tl->escape($item->getContent(),true)) ? ' dir="rtl"' : '');
									$rtolc = ($tl->is_rtl($tl->escape($item->getSharedStoryCaption())) ? ' dir="rtl"' : '');
									$rtoll = ($tl->is_rtl($tl->escape($item->getSharedStoryName())) ? ' dir="rtl"' : '');
									$rtold = ($tl->is_rtl($tl->escape($item->getSharedStoryDescription(),true)) ? ' dir="rtl"' : '');
        						
								echo 
									
								'<!--ENLACE AL POST-->
								<a href="https://www.facebook.com/'.$tl->getUsername().'/posts/'.$item->getId().'" title="' . $lang->getComment() . '" target="_blank">				
					            <!--ENUNCIADO-->
					            <p>' . shorten($tl->nl2br2($tl->escape($item->getContent(),true)), 142) . ' <i class="fa fa-angle-right"></i></p>							
					            <!--FECHA-->				
					            <span>' . $tl->formatDateTime($item->getCreatedAt()) . '</span>	
					            </a>
								<br/>	
					            ' . ($image != '' && $mp4video != '' ? '<div class="timeline-video">' . $mp4video . '</div>' : '') . '
                                ' . ($video != '' ? '<div class="timeline-video">' . $video . '</div>' : '') . '
					            ' . ($soundcloud != '' ? '<div class="timeline-image">' . $soundcloud . '</div>' : '') . '
                                ' . ($image != '' && $video == '' && $mp4video == '' && $soundcloud == '' ? '<div class="timeline-image"><a href="https://www.facebook.com/'.$tl->getUsername().'/posts/'.$item->getId().'" target="_blank">' . $image . '</a></div>' : '');

                                # CHEQUEO TIPO DE POST
		                        if ($item->getType() == 'photo' || $item->getType() == 'video') {
                                	$facebooklink = urlencode($item->getSharedStoryLink());
		                        } else {
                                	$facebooklink = urlencode($item->getShareURL());
		                        }
                                }
	                            ?>
								</div>
								<a target="_blank" href="https://www.facebook.com/Rally-Karting-La-Serena-315578865306752/"><span class="btn_social">Visitar fanpage</span></a>
							</div>
						</article>
						<!--FIN SECCION NOVEDADES-->
						<!--INICIO SECCION EN IMAGENES-->
						<article class="seccion_imagenes">						
                            <div class="limites" id="galeria">
							</div>
						</article>
					</div>