<div id="content">
	<div class="content-bg">
		<!-- start block -->
		<div class="big-block">
			<h1><?php echo Kohana::lang('ui_main.alerts_get') ?></h1>
			<!-- green-box/ red-box depending on verification result -->
			<?php
			// SWITCH based on the value of the $errno
			switch ($errno)
			{
				// IF the code provided was not found ...
				case ER_CODE_NOT_FOUND:
				?>
					<div class="alert alert-warning col-md-6 col-md-push-3" role="alert">
						<h4 align="center">
            				<?php echo Kohana::lang('alerts.code_not_found'); ?>
						</h4>
					</div>
					<?php
					break;
				// IF the code provided means the alert has already been verified ...
				case ER_CODE_ALREADY_VERIFIED:
				?>
					<div class="alert alert-warning col-md-6 col-md-push-3" role="alert">
						<h4 align="center">
							<?php echo Kohana::lang('alerts.code_already_verified'); ?>
						</h4>
					</div>
					<?php
					break;
				// IF the code provided means the code is now verified ...
				case ER_CODE_VERIFIED:
				?>
					<div class="alert alert-warning col-md-6 col-md-push-3" role="alert">
						<h4 align="center">
							<?php echo Kohana::lang('alerts.code_verified'); ?>
						</h4>
					</div>
					<?php
					break;
			} // End switch
			?>
      </div>
	<!-- end block -->
	</div>
</div>
