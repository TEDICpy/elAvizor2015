			<!-- </div> -->
		</div>
		<!-- / main body -->

	</div>
	<!-- / wrapper -->

	</div>
	<!-- fix de algun div mal cerrado -->

	<!-- footer -->
	<footer>

		<div class="container">

			<!-- footer content -->
			<div class="row clearfix pt20 pb20">

				<!-- footer menu -->
				<div class="col-md-3 pt20 pb20">
					<?php if (Kohana::config('settings.allow_reports')): ?>
						<?php
						$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
						if($host != 'www.elavizor.org.py/reports/submit')
						{
						?>
							<a href="<?php echo url::site()."reports/submit"; ?>" class="submit-incident-footer">
								<?php echo Kohana::lang('ui_main.submit'); ?>
							</a>
						<?php
						}
						?>

					<?php endif; ?>
				</div>
				<!-- / footer menu -->
				<div class="col-md-4 pb20 loguillos">
					<h5 class="text-left">Apoyan:</h5>
					<img src="<?php echo url::site().'themes/elAvizor2015/images/icon_omidyar.png' ?>" alt="Logo de OMIDYAR">
					<img src="<?php echo url::site().'themes/elAvizor2015/images/icon_avina_america.png' ?>" alt="Logo de AVINA AMERICA">
					<img src="<?php echo url::site().'themes/elAvizor2015/images/icon_avina.png' ?>" alt="Logo de AVINA">
				</div>
				<!-- footer credits -->
				<div class="col-md-5 pt20 pb20 cred">
					<img src="<?php echo url::site().'themes/elAvizor2015/images/Tedic-Logo.png' ?>" alt="Logo de ONG TEDIC" class="tedic pull-right ml20">
					<?php if ($site_copyright_statement != ''): ?>
		      		<p><?php echo $site_copyright_statement; ?></p>
			      	<?php endif; ?>
					<p>El Avizor es un proyecto de <a href="http://www.tedic.org" target="_blank">TEDIC</a><br>
					<a href="<?php echo url::site()."privacidad"; ?>">Políticas de privacidad</a> - <a href="<?php echo url::site()."ayuda"; ?>">Ayuda</a>
					  - <a href="<?php echo url::site()."doc_api"; ?>">Documentación API</a></p>
				</div>
				<!-- / footer credits -->


			</div>
			<!-- / footer content -->

		</div>
		<!-- / footer -->

	</footer>

	<?php
	echo $footer_block;
	// Action::main_footer - Add items before the </body> tag
	Event::run('ushahidi_action.main_footer');
	?>


</body>
</html>
