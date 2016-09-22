<script type="text/javascript">
	$(function(){
		// show/hide report filters and layers boxes on home page map
		$("a.toggle").toggle(
			function() {
				$($(this).attr("href")).show();
				$(this).addClass("active-toggle");
			},
			function() {
				$($(this).attr("href")).hide();
				$(this).removeClass("active-toggle");
			}
		);
	});

	// Se obtiene los datos para el grafico 1.
	$(document).ready(function(){
		$.ajax({
			url: 'graficos/getDatos1',
			type: "GET",
			dataType: "json",
			async: true,
			success: function(p_datos) {
		        crearGrafico1(p_datos);
			},
			cache: false
		});
 	});

	// Se obtiene los datos para el grafico 2.
	$(document).ready(function(){
		$.ajax({
			url: 'graficos/getDatos2',
			type: "GET",
			dataType: "json",
			async: true,
			success: function(p_datos) {
				crearGrafico2(p_datos);
			},
			cache: false
		});
 	});

	// Se crea el grafico 1.
	function crearGrafico1(p_datos){
		var v_array_categorias = Array();
		var v_array_cantidad = Array();
		for(v_categoria_id in p_datos){
			v_array_categorias.push(p_datos[v_categoria_id].nombre);
			v_array_cantidad.push(p_datos[v_categoria_id].cantidad);
		}

	    $('#grafico1').highcharts({
        	chart: {
            	type: 'bar'
        	},
        	title: {
            	text: 'Reportes por tipo'
        	},
        	xAxis: {
            	categories: v_array_categorias,
            	title: {
                	text: null
            	}
        	},
        	yAxis: {
            	min: 0,
            	title: {
                	text: 'Cantidad',
                	align: 'high'
            	},
            	labels: {
                	overflow: 'justify'
            	}
        	},
        	plotOptions: {
            	bar: {
            		colorByPoint: true,
                	dataLabels: {
                    	enabled: true
                	}
            	}
        	},
        	legend: {
            	layout: 'vertical',
            	align: 'right',
            	verticalAlign: 'top',
            	x: 0,
            	y: 0,
            	floating: true,
            	borderWidth: 1,
            	backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            	shadow: false
        	},
        	credits: {
            	enabled: false
        	},
        	series: [{
            	name: 'Municipales 2015',
            	data: v_array_cantidad
        	}]
    	});
	}

	// Se crea el grafico 2.
	function crearGrafico2(p_datos){
		var v_array_departamentos = Array();
		var v_array_cantidad = Array();
		for(v_departamento_id in p_datos){
			v_array_departamentos.push(p_datos[v_departamento_id].nombre);
			v_array_cantidad.push(p_datos[v_departamento_id].cantidad);
		}
		$('#grafico2').highcharts({
        	chart: {
            	type: 'column'
        	},
        	title: {
            	text: 'Reportes registrados por departamento'
        	},
        	xAxis: {
            	categories: v_array_departamentos,
            	crosshair: true,
				type: 'category',
	            labels: {
	                rotation: 90,
					y: 10,
					align: 'left',
	                style: {
	                    fontSize: '14px',
	                    fontFamily: 'Verdana, sans-serif'
	                }
	            }
        	},
        	yAxis: {
            	min: 0,
            	title: {
                	text: 'Cantidad'
            	}
        	},
        	tooltip: {
            	headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            	pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}:&nbsp;</td>' +
                	'<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
            	footerFormat: '</table>',
            	shared: true,
            	useHTML: true
        	},
        	plotOptions: {
            	column: {
                	pointPadding: 0,
                	borderWidth: 0
            	}
        	},
        	series: [{
            	name: 'Reportes',
            	data: v_array_cantidad
        	}],
        	colors: [
		        '#FCD704'
		    ]
    	});
	}
</script>

<!-- main body -->
<div id="main" class="clearingfix">

	<div id="mainmiddle">

		<!-- right column -->
		<div id="report-map-filter-box" class="clearingfix" style="display:none">
			<a class="btn toggle" id="filter-menu-toggle" href="#the-filters">
				<?php echo Kohana::lang('ui_main.filter_reports_by'); ?>
				<span class="btn-icon ic-right">&raquo;</span>
			</a>

			<!-- filters box -->
			<div id="the-filters" class="map-menu-box">

				<?php
				// Action::main_sidebar_pre_filters - Add Items to the Entry Page before filters
				Event::run('ushahidi_action.main_sidebar_pre_filters');
				?>

				<!-- report category filters -->
				<div id="report-category-filter">
					<h3><?php echo Kohana::lang('ui_main.category');?></h3>

					<ul id="category_switch" class="category-filters">
					<?php
					$color_css = 'class="swatch" style="background-color:#'.$default_map_all.'"';
					$all_cat_image = '';
					if ($default_map_all_icon != NULL)
					{
						$all_cat_image = html::image(array(
							'src'=>$default_map_all_icon,
							'style'=>'float:left;padding-right:5px;'
						));
						$color_css = '';
					}
					?>
					<li>
						<a class="active" id="cat_0" href="#">
							<span <?php echo $color_css; ?>><?php echo $all_cat_image; ?></span>
							<span class="category-title"><?php echo Kohana::lang('ui_main.all_categories');?></span>
						</a>
					</li>
					<?php
						foreach ($categories as $category => $category_info)
						{
							$category_title = htmlentities($category_info[0], ENT_QUOTES, "UTF-8");
							$category_color = $category_info[1];
							$category_image = ($category_info[2] != NULL)
							    ? url::convert_uploaded_to_abs($category_info[2])
							    : NULL;
							$category_description = htmlentities(Category_Lang_Model::category_description($category), ENT_QUOTES, "UTF-8");

							$color_css = 'class="swatch" style="background-color:#'.$category_color.'"';
							if ($category_info[2] != NULL)
							{
								$category_image = html::image(array(
									'src'=>$category_image,
									'style'=>'float:left;padding-right:5px;'
									));
								$color_css = '';
							}

							echo '<li>'
							    . '<a href="#" id="cat_'. $category .'" title="'.$category_description.'">'
							    . '<span '.$color_css.'>'.$category_image.'</span>'
							    . '<span class="category-title">'.$category_title.'</span>'
							    . '</a>';

							// Get Children
							echo '<div class="hide" id="child_'. $category .'">';
							if (sizeof($category_info[3]) != 0)
							{
								echo '<ul>';
								foreach ($category_info[3] as $child => $child_info)
								{
									$child_title = htmlentities($child_info[0], ENT_QUOTES, "UTF-8");
									$child_color = $child_info[1];
									$child_image = ($child_info[2] != NULL)
									    ? url::convert_uploaded_to_abs($child_info[2])
									    : NULL;
									$child_description = htmlentities(Category_Lang_Model::category_description($child), ENT_QUOTES, "UTF-8");

									$color_css = 'class="swatch" style="background-color:#'.$child_color.'"';
									if ($child_info[2] != NULL)
									{
										$child_image = html::image(array(
											'src' => $child_image,
											'style' => 'float:left;padding-right:5px;'
										));

										$color_css = '';
									}

									echo '<li style="padding-left:20px;">'
									    . '<a href="#" id="cat_'. $child .'" title="'.$child_description.'">'
									    . '<span '.$color_css.'>'.$child_image.'</span>'
									    . '<span class="category-title">'.$child_title.'</span>'
									    . '</a>'
									    . '</li>';
								}
								echo '</ul>';
							}
							echo '</div></li>';
						}
					?>
					</ul>
					<!-- / category filters -->

				</div>
				<!-- / report category filters -->

				<!-- report type filters -->
				<div id="report-type-filter" class="filters">
					<h3><?php echo Kohana::lang('ui_main.type'); ?></h3>
						<ul>
							<li><a id="media_5" class="active" href="#"><span><?php echo Kohana::lang('ui_main.reports'); ?></span></a></li>
							<li><a id="media_4" href="#"><span><?php echo Kohana::lang('ui_main.news'); ?></span></a></li>
							<li><a id="media_1" href="#"><span><?php echo Kohana::lang('ui_main.pictures'); ?></span></a></li>
							<li><a id="media_2" href="#"><span><?php echo Kohana::lang('ui_main.video'); ?></span></a></li>
							<li><a id="media_0" href="#"><span><?php echo Kohana::lang('ui_main.all'); ?></span></a></li>
						</ul>
						<div class="floatbox">
								<?php
								// Action::main_filters - Add items to the main_filters
								Event::run('ushahidi_action.map_main_filters');
								?>
						</div>
						<!-- / report type filters -->
				</div>

				<?php
				// Action::main_sidebar_post_filters - Add Items to the Entry Page after filters
				Event::run('ushahidi_action.main_sidebar_post_filters');
				?>

			</div>
			<!-- / filters box -->

			<?php
			if ($layers)
			{
				?>
				<div id="layers-box">
					<a class="btn toggle" id="layers-menu-toggle" class="" href="#kml_switch"><?php echo Kohana::lang('ui_main.layers');?> <span class="btn-icon ic-right">&raquo;</span></a>
					<!-- Layers (KML/KMZ) -->
					<ul id="kml_switch" class="category-filters map-menu-box">
						<?php
						foreach ($layers as $layer => $layer_info)
						{
							$layer_name = $layer_info[0];
							$layer_color = $layer_info[1];
							$layer_url = $layer_info[2];
							$layer_file = $layer_info[3];
							$layer_link = (!$layer_url) ?
								url::base().Kohana::config('upload.relative_directory').'/'.$layer_file :
								$layer_url;
							echo '<li><a href="#" id="layer_'. $layer .'">
							<span class="swatch" style="background-color:#'.$layer_color.'"></span>
							<span class="layer-name">'.$layer_name.'</span></a></li>';
						}
						?>
					</ul>
				</div>
				<!-- /Layers -->
				<?php
			}
			?>


			<?php
			if (isset($shares))
			{
				?>
				<div id="other-deployments-box">
					<a class="btn toggle" id="other-deployments-menu-toggle" class="" href="#sharing_switch"><?php echo Kohana::lang('ui_main.other_ushahidi_instances');?> <span class="btn-icon ic-right">&raquo;</span></a>
					<!-- Layers (Other Ushahidi Layers) -->
					<ul id="sharing_switch" class="category-filters map-menu-box">
						<?php
						foreach ($shares as $share => $share_info)
						{
							$sharing_name = $share_info[0];
							$sharing_color = $share_info[1];
							echo '<li><a href="#" id="share_'. $share .'"><span class="swatch" style="background-color:#'.$sharing_color.'"></span>
							<span class="category-title">'.$sharing_name.'</span></a></li>';
						}
						?>
					</ul>
				</div>
				<!-- /Layers -->
				<?php
			}
			?>


			<!-- additional content -->
			<?php
			if (Kohana::config('settings.allow_reports'))
			{
				?>
				<a class="btn toggle" id="how-to-report-menu-toggle" href="#how-to-report-box"><?php echo Kohana::lang('ui_main.how_to_report'); ?> <span class="btn-icon ic-question">&raquo;</span></a>
				<div id="how-to-report-box" class="map-menu-box" style="display:none">

					<div>

						<!-- Phone -->
						<?php if (!empty($phone_array)) { ?>
						<div style="margin-bottom:10px;">
							<?php echo Kohana::lang('ui_main.report_option_1'); ?>
							<?php foreach ($phone_array as $phone) { ?>
								<strong><?php echo $phone; ?></strong>
								<?php if ($phone != end($phone_array)) { ?>
									 <br/>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>

						<!-- External Apps -->
						<?php if (count($external_apps) > 0) { ?>
						<div style="margin-bottom:10px;">
							<strong><?php echo Kohana::lang('ui_main.report_option_external_apps'); ?>:</strong><br/>
							<?php foreach ($external_apps as $app) { ?>
								<a href="<?php echo $app->url; ?>"><?php echo $app->name; ?></a><br/>
							<?php } ?>
						</div>
						<?php } ?>

						<!-- Email -->
						<?php if (!empty($report_email)) { ?>
						<div style="margin-bottom:10px;">
							<strong><?php echo Kohana::lang('ui_main.report_option_2'); ?>:</strong><br/>
							<a href="mailto:<?php echo $report_email?>"><?php echo $report_email?></a>
						</div>
						<?php } ?>

						<!-- Twitter -->
						<?php if (!empty($twitter_hashtag_array)) { ?>
						<div style="margin-bottom:10px;">
							<strong><?php echo Kohana::lang('ui_main.report_option_3'); ?>:</strong><br/>
							<?php foreach ($twitter_hashtag_array as $twitter_hashtag) { ?>
								<span>#<?php echo $twitter_hashtag; ?></span>
								<?php if ($twitter_hashtag != end($twitter_hashtag_array)) { ?>
									<br />
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>

						<!-- Web Form -->
						<div style="margin-bottom:10px;">
							<a href="<?php echo url::site() . 'reports/submit/'; ?>"><?php echo Kohana::lang('ui_main.report_option_4'); ?></a>
						</div>

					</div>

				</div>
			<?php } ?>
			<!-- / additional content -->
		</div>
		<!-- / right column -->

		<!-- content column -->
		<div id="content" class="clearingfix">
			<?php
			// Map and Timeline Blocks
			echo $div_map;
			echo $div_timeline;
			?>
		<!-- </div> -->
			<!-- GRAFICO -->
			<div class="row">
				<div class="col-md-12 col-md-offset-0 col-xs-offset-1 col-xs-10 text-center compartir">
					Compartir
					<a href="https://twitter.com/intent/tweet?url=<?php echo url::site().'reports' ?>&text=%23elavizor Viendo reportes en" title="Compartir en Twitter" target="_blank">
						<span class="icon-twitter"></span>
					</a>
					<a href="http://www.facebook.com/sharer.php?u=<?php echo url::site().'reports' ?>" title="Compartir en Facebook" target="_blank">
						<span class="icon-facebook"></span>
					</a>
					<a href="javascript:;" onclick="window.open('http://sharetodiaspora.github.io/?url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title),'das','location=no,links=no,scrollbars=no,toolbar=no,width=620,height=550'); return false;" rel="nofollow" title="Compartir en Diaspora*" target="_blank">
						<img src="<?php echo url::site().'themes/elAvizor2015/images/icon_diaspora.png' ?>" style="border: 0px solid;" alt = "Compartir en Diaspora*" title = "Compartir en Diaspora*"/>
					</a>
				</div>
			    <div class="col-md-12 col-md-offset-0 col-xs-offset-1 col-xs-10 text-center mt30">
			  <!-- Lupa: oculto gráfico por tipo 
			    <h4 class="graficos-title">Reportes por tipo</h4>
		            <div id="grafico1" style="width: 100%; height: 400px; margin: 0 auto 30px auto"></div>
                            <br/> -->
					<h4 class="graficos-title">Reportes registrados por departamento</h4>
					<div id="grafico2" style="width: 100%; height: 400px; margin: 0 auto 30px auto"></div>
			    </div>

                <br/>
			</div>

			<br/>
			<!-- GRAFICO -->
		</div>
		<!-- / content column -->

	</div>
</div>
<!-- / main body -->

<!-- content -->
<!-- <div> -->
	<!-- content blocks -->
	<div class="row">
		<?php blocks::render(); ?>
	</div>
	<!-- /content blocks -->
<!-- </div> -->
<!-- content -->
