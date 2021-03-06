
<div id="main" class="report_detail row">
	<div class="col-md-7">
  		<div class="widget-box">
  			<h1><?php echo htmlentities($incident_title, ENT_QUOTES, "UTF-8"); ?></h1>
			<!-- <div class="widget-title">
				<table class="table" style="margin:0">
					<tr>
						<td class="truncate"><i class="icon-credit-card"></i> </td>
						<td width="38">
							<div class="widget-toolbar pull-right btn-group">
								<a href="javascript:void(0)" class="btn btn-inverse"><i class="icon-chevron-up"></i></a>
							</div>
						</td>
					</tr>
				</table>
			</div> -->

			<div class="widget-content">
				<h6 class="report-when-where">
					<span class="r_date"><?php echo $incident_date .' '. $incident_time; ?> </span>
					<span class="r_location"><?php echo html::specialchars($incident_location); ?></span>
					<?php Event::run('ushahidi_action.report_meta_after_time', $incident_id); ?>
				</h6>
				<p><?php echo htmlentities($incident_title, ENT_QUOTES, "UTF-8");
					// If Admin is Logged In - Allow For Edit Link
					if ($logged_in){
						echo " <i class='icon-edit'></i><a href=\"".url::site()."admin/reports/edit/".$incident_id."\">".Kohana::lang('ui_main.edit')."</a>";
					}
				?>
				</p>

				<?php
				if ($incident_verified){
					echo '<p class="r_verified"><i class="icon-ok"></i> '.Kohana::lang('ui_main.verified').'</p>';
				}else{
					echo '<p class="r_unverified">'.Kohana::lang('ui_main.unverified').'</p>';
				}
			?>

			<div class="report-category-list">
				<p>
				<?php
					foreach ($incident_category as $category){
						// don't show hidden categories
						if ($category->category->category_visible == 0){
							continue;
						}
						if ($category->category->category_image_thumb){
							$style = "background:transparent url(".url::convert_uploaded_to_abs($category->category->category_image_thumb).") 0 0 no-repeat";
						}else{
							$style = "background-color:#".$category->category->category_color;
						}

						?>
						<a href="<?php echo url::site()."reports/?c=".$category->category->id; ?>" title="<?php echo Category_Lang_Model::category_description($category->category_id);; ?>">
							<span class="r_cat-box" style="<?php echo $style ?>">&nbsp;</span>
							<?php echo Category_Lang_Model::category_title($category->category_id); ?>
						</a>
						<?php
					}
				?>
				</p>
				<?php
				// Action::report_meta - Add Items to the Report Meta (Location/Date/Time etc.)
				Event::run('ushahidi_action.report_meta', $incident_id);
				?>
			</div>

			<?php
			// Action::report_display_media - Add content just above media section
			Event::run('ushahidi_action.report_display_media', $incident_id);
			?>

			<!-- start report media -->
			<div class="<?php if( count($incident_photos) > 0 || count($incident_videos) > 0){ echo "report-media";}?>">
			<?php
			// if there are images, show them
			if( count($incident_photos) > 0 )
			{
				echo '<div id="report-images">';
				foreach ($incident_photos as $photo)
				{
					echo '<a class="photothumb" rel="lightbox-group1" href="'.$photo['large'].'"><img alt="'.htmlentities($incident_title, ENT_QUOTES, "UTF-8").'" src="'.$photo['thumb'].'"/></a> ';
				};
				echo '</div>';
			}

			// if there are videos, show those too
			if( count($incident_videos) > 0 )
			{
			  echo '<div id="report-video"><ol>';

			  // embed the video codes
			  foreach( $incident_videos as $incident_video)
			  {
				echo '<li>';
				$videos_embed->embed($incident_video,'');
				echo '</li>';
			  };
				echo '</ol></div>';

			}
			?>
			</div>

			<!-- start report description -->
			<div class="report-description-text">
				<h5><?php echo Kohana::lang('ui_main.reports_description');?></h5>
				<p style="text-align:justify"><?php echo nl2br($incident_description); ?></p>
				<br/>

				<div class="pull-right" style="margin-top: 13px;">
					Compartir
					<a href="#" onclick="javascript:window.open('https://twitter.com/share?url=<?php echo url::site().url::current() ?>&amp;text=%23elijopy ' + encodeURIComponent(document.title), 'twitter-share-dialog', 'menubar=no, toolbar=no, resizable=yes, scrollbars=yes, width=626, height=436'); return false;">
						<span class="icon-twitter"></span>
					</a>
					<a href="http://www.facebook.com/sharer.php?u=<?php echo url::site().url::current() ?>" title="Compartir en Facebook" target="_blank">
						<span class="icon-facebook"></span>
					</a>
					<a href="javascript:;" onclick="window.open('http://sharetodiaspora.github.io/?url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title),'das','location=no,links=no,scrollbars=no,toolbar=no,width=620,height=550'); return false;" rel="nofollow" title="Compartir en Diaspora*" target="_blank">
						<img src="<?php echo url::site().'themes/elAvizor2015/images/icon_diaspora.png' ?>" style="border: 0px solid;" alt = "Compartir en Diaspora*" title = "Compartir en Diaspora*"/>
					</a>
				</div>

				<!-- start news source link -->
				<?php if( count($incident_news) > 0 ) { ?>
				<div class="credibility">
				<h5><?php echo Kohana::lang('ui_main.reports_news');?></h5>
						<?php
							foreach( $incident_news as $incident_new){
								?>
								<a href="<?php echo $incident_new; ?> " target="_blank"><?php
								echo $incident_new;?></a>
								<br/>
								<?php
							}
				?>
				</div>
				<?php } ?>
				<!-- end news source link -->

				<!-- start additional fields -->
				<?php if(strlen($custom_forms) > 0) { ?>
				<div class="credibility">
					<h5><?php echo Kohana::lang('ui_main.additional_data');?></h5>
					<?php echo $custom_forms; ?>
					<br/>
				</div>
				<?php } ?>
				<!-- end additional fields -->

				<?php if ($features_count)
				{
					?>
					<br /><br /><h5><?php echo Kohana::lang('ui_main.reports_features');?></h5>
					<?php
					foreach ($features as $feature){
						echo ($feature->geometry_label) ?
							"<div class=\"feature_label\"><a href=\"javascript:getFeature($feature->id)\">$feature->geometry_label</a></div>" : "";
						echo ($feature->geometry_comment) ?
							"<div class=\"feature_comment\">$feature->geometry_comment</div>" : "";
					}
				}?>

				<div class="credibility">
					<table class="rating-table" cellspacing="0" cellpadding="0" border="0">
			  <tr>
				<td><?php echo Kohana::lang('ui_main.credibility');?>:</td>
				<td><a href="javascript:rating('<?php echo $incident_id; ?>','add','original','oloader_<?php echo $incident_id; ?>')"><img id="oup_<?php echo $incident_id; ?>" src="<?php echo url::file_loc('img'); ?>media/img/up.png" alt="UP" title="UP" border="0" /></a></td>
				<td><a href="javascript:rating('<?php echo $incident_id; ?>','subtract','original')"><img id="odown_<?php echo $incident_id; ?>" src="<?php echo url::file_loc('img'); ?>media/img/down.png" alt="DOWN" title="DOWN" border="0" /></a></td>
				<td><a href="" class="rating_value" id="orating_<?php echo $incident_id; ?>"><?php echo $incident_rating; ?></a></td>
				<td><a href="" id="oloader_<?php echo $incident_id; ?>" class="rating_loading" ></a></td>
			  </tr>
			</table>
				</div>
			</div>

			<?php
				// Action::report_extra - Allows you to target an individual report right after the description
				Event::run('ushahidi_action.report_extra', $incident_id);

				// Filter::comments_block - The block that contains posted comments
				Event::run('ushahidi_filter.comment_block', $comments);
				echo $comments;
			?>

			<?php
				// Filter::comments_form_block - The block that contains the comments form
				Event::run('ushahidi_filter.comment_form_block', $comments_form);
				echo $comments_form;
			?>

			</div>
		</div>
	</div>




	<div class="col-md-5">

		<div class="widget-box">
			<div class="widget-title">
				<table class="table" style="margin:0">
					<tr>
						<td class="truncate"><i class="icon-globe"></i> <?php echo Kohana::lang('ui_main.map');?></td>
						<td width="75">
							<div class="widget-toolbar pull-right btn-group">
								<a href="javascript:void(0)" class="btn btn-inverse"><i class="icon-chevron-up"></i></a>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="widget-content">
				<div class="report-media-box-content">
					<div id="report-map" class="report-map">
						<div class="map-holder" id="map"></div>
					</div>
				</div>
			</div>
		</div>

		<?php
			// Action::report_view_sidebar - This gives plugins the ability to insert into the sidebar (below the map and above additional reports)
			Event::run('ushahidi_action.report_view_sidebar', $incident_id);
		?>

		<div class="widget-box">
			<div class="widget-title">
				<table class="table" style="margin:0">
					<tr>
						<td class="truncate"><i class="icon-globe"></i> <?php echo Kohana::lang('ui_main.additional_reports');?></td>
						<td width="75">
							<div class="widget-toolbar pull-right btn-group">
								<a href="javascript:void(0)" class="btn btn-inverse"><i class="icon-chevron-up"></i></a>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="widget-content">
				<div class="report-additional-reports">
					<?php foreach($incident_neighbors as $neighbor) { ?>
						<div class="rb_report">
							<h5><a href="<?php echo url::site(); ?>reports/view/<?php echo $neighbor->id; ?>"><?php echo $neighbor->incident_title; ?></a></h5>
							<p class="r_date r-3 bottom-cap m0"><?php echo date('d/m/Y H:i', strtotime($neighbor->incident_date)); ?></p>
							<p class="r_location"><?php echo $neighbor->location_name.", ".round($neighbor->distance, 2); ?> Kms</p>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>



	</div>


</div>
