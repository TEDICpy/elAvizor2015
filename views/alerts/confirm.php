<div id="content">
	<div class="content-bg">


		<div class="widget-box">
			<!-- <div class="widget-title">
				<table class="table" style="margin:0">
				<tr>
					<td class="truncate"><i class="icon-cloud"></i> <?php //echo Kohana::lang('ui_main.alerts_get') ?></td>
					<td width="75">
						<div class="widget-toolbar pull-right btn-group">
							<a href="javascript:void(0)" class="btn btn-inverse"><i class="icon-chevron-up"></i></a>
						</div>
					</td>
				</tr>
			</table>
			</div> -->

			<h1><?php echo Kohana::lang('ui_main.alerts_get') ?></h1>

			<div class="widget-content">


				<div class="alert alert-warning col-md-8 col-md-push-2" role="alert">
					<?php if($show_mobile == TRUE): ?>
					<!-- Mobile Alert -->
					<div>
						<?php if ($alert_mobile): ?>
						<?php	echo "<h3 class='m0 mb20'>".Kohana::lang('alerts.mobile_ok_head')."</h3>"; ?>
						<?php endif; ?>
						<div>
							<?php
							if ($alert_mobile){
								echo Kohana::lang('alerts.mobile_alert_request_created')." <strong>".
									$alert_mobile."</strong>. ".
									Kohana::lang('alerts.verify_code');
							}
							?>
							<div class="alert_confirm mt20">
								<h4 class="pb10"><?php echo Kohana::lang('alerts.mobile_code'); ?></h4>
								<?php
								print form::open('/alerts/verify');
								print "<div class='row'><div class='col-md-4'>";
								print "Verification Code:<BR>".form::input('alert_code', '', ' class="text"');
								print "</div><div class='col-md-4'>";
								print "Mobile Phone:<BR>".form::input('alert_mobile', $alert_mobile, ' class="text"');
								print "</div><div class='col-md-4'>";
								print form::submit('button', 'Confirmar mi solicitud de alerta', ' class="btn_submit"');
								print "</div></div>";
								print form::close();
								?>
							</div>
						</div>
					</div>
					<!-- / Mobile Alert -->
					<?php endif; ?>


					<!-- Email Alert -->
					<div>
						<?php
						if ($alert_email)
						{
							echo "<h3>".Kohana::lang('alerts.email_ok_head')."</h3>";
						}
						?>

						<div>
							<?php
							if ($alert_email){
								echo Kohana::lang('alerts.email_alert_request_created')." <strong>".
									$alert_email."</strong>. ".
									Kohana::lang('alerts.verify_code');
							}
							?>
							<div class="mt20">
								<h4 class="pb10"><?php echo Kohana::lang('alerts.email_code'); ?></h4>
								<?php
								print form::open('/alerts/verify');
								print "<div class='row'><div class='col-md-4'>";
								print "Verification Code:<BR>".form::input('alert_code', '', ' class="text"');
								print "</div><div class='col-md-4'>";
								print "Email Address:<BR>".form::input('alert_email', $alert_email, ' class="text"');
								print "</div><div class='col-md-4'>";
								print form::submit('button', 'Confirmar mi solicitud de alerta', ' class="btn_submit"');
								print "</div></div>";
								print form::close();
								?>
							</div>
						</div>
					</div>
					<!-- / Email Alert -->

					<!-- Return -->
					<br />
					<div class="">
						<div>
							<a href="<?php echo url::site().'alerts'?>"><?php echo Kohana::lang('alerts.create_more_alerts'); ?></a>
						</div>
					</div>
					<!-- / Return -->


				</div>
			</div>



		</div>
	</div>
</div>
