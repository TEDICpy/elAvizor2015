<!-- <div class="clearfix filtros">
	<div class="widget-content"> -->
		<div class="clearfix filtros" style="display: none;">
			<div class="col-md-6">
				<?php echo form::open(NULL, array('method' => 'get', 'class' => 'form-inline', 'style' => 'padding:20px')); ?>
					<input type="hidden" value="0" name="currentCat" id="currentCat"/>
					<div style="text-align:center">
						<label for="startDate"><?php echo Kohana::lang('ui_main.from'); ?>:</label>
						<select name="startDate" id="startDate" style="width:auto"><?php echo $startDate; ?></select>
						<label for="endDate"><?php echo Kohana::lang('ui_main.to'); ?>:</label>
						<select name="endDate" id="endDate" style="width:auto"><?php echo $endDate; ?></select>
					</div><br />
				<?php echo form::close(); ?>
			</div>
			<div class="col-md-6">
				<div id="graph" class="graph-holder"></div>
			</div>
		</div>
<!-- 	</div>
</div> -->