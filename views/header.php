<!DOCTYPE html>
<html lang="es">
<head>
	<title><?php echo $page_title.$site_name; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?php echo Kohana::config('core.site_protocol'); ?>://fonts.googleapis.com/css?family=Asap:400,700,400italic,700italic" rel="stylesheet" type="text/css">
	<link href="<?php echo url::site().'themes/elAvizor2015/css/bootstrap-combined.no-icons.min.css' ?>"  rel="stylesheet" type="text/css" />

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo url::site().'themes/elAvizor2015/favicon.ico' ?>">

	<?php echo $header_block; ?>
	<?php Event::run('ushahidi_action.header_scripts'); // Action::header_scripts - Additional Inline Scripts from Plugins ?>

	<link href="<?php echo url::site().'themes/elAvizor2015/css/dynatree/skin-vista/ui.dynatree.css' ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo url::site().'themes/elAvizor2015/css/bootstrap.css' ?>"  rel="stylesheet" type="text/css" />
	<link href="<?php echo url::site().'themes/elAvizor2015/css/mood.css' ?>"  rel="stylesheet" type="text/css" />
	<link href="<?php echo url::site().'themes/elAvizor2015/css/bootstrap-overwrite.css' ?>"  rel="stylesheet" type="text/css" />
	<link href="<?php echo url::site().'themes/elAvizor2015/css/bootstrap-fileupload.css' ?>"  rel="stylesheet" type="text/css" />

	<link href="<?php echo url::site().'themes/elAvizor2015/css/flexslider.css' ?>"  rel="stylesheet" type="text/css" />
	<link href="<?php echo url::site().'themes/elAvizor2015/css/tablecloth.css' ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo url::site().'themes/elAvizor2015/css/madev.css' ?>" rel="stylesheet" type="text/css" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet" type="text/css" />

	<script src="<?php echo url::site().'themes/elAvizor2015/js/highchart/highcharts.js' ?>" type="text/javascript"></script>
	<script src="<?php echo url::site().'themes/elAvizor2015/js/highchart/themes/elAvizor.js' ?>" type="text/javascript"></script>
	<script src="<?php echo url::site().'themes/elAvizor2015/js/jquery.dynatree.min.js' ?>" type="text/javascript"></script>
	<script src="<?php echo url::site().'themes/elAvizor2015/js/jquery.flexslider-min.js' ?>" type="text/javascript"></script>
	<script src="<?php echo url::site().'themes/elAvizor2015/js/bootstrap.2.3.2.min.js' ?>" type="text/javascript"></script>
	<script src="<?php echo url::site().'themes/elAvizor2015/js/bootstrap-fileupload.min.js' ?>" type="text/javascript"></script>

    <!-- Leaftlet -->
	<link href="<?php echo url::site().'themes/elAvizor2015/js/leaflet/leaflet.css' ?>" rel="stylesheet" type="text/css" />
	<script src="<?php echo url::site().'themes/elAvizor2015/js/leaflet/leaflet.js' ?>" type="text/javascript"></script>

	<!-- Ayuda interactiva Intro.js -->
	<link href="<?php echo url::site().'themes/elAvizor2015/js/introjs/introjs.css' ?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo url::site().'themes/elAvizor2015/js/introjs/intro.js' ?>" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.tltp').tooltip();

			/* bar notification */
			$('.downbar').show();
			$('.jquery-bar').hide();
			$('.jquery-arrow').click(function(){
				$('.downbar').toggleClass('up', 500);
				if($("#downbar").hasClass("up")) $('#topheader').css("margin-top", "0");
				else $('#topheader').css("margin-top", "38px");
				$('.jquery-bar').slideToggle();
			});

			/* Box widget Head Buttons */
			$('.widget-title .btn').live("click",function(){
				var check = 0;
				var parentTemp = $(this);
				while(check == 0){
					if(parentTemp.parent().attr("class") != "widget-box"){
						parentTemp = parentTemp.parent();
					}else{
						parentTemp = parentTemp.parent();
						check = 1;
					}
				}

				var cls = $(this).find('i')[0].className;
				if(cls == 'icon-chevron-up'){
					var icon = $(this).find('i')[0];
					parentTemp.find('.widget-content').slideUp(500);
					$(icon).removeClass(cls);
					$(icon).addClass("icon-chevron-down");
				}else if(cls == 'icon-chevron-down'){
					var icon = $(this).find('i')[0];
					parentTemp.find('.widget-content').slideDown(500);
					$(icon).removeClass(cls);
					$(icon).addClass("icon-chevron-up");
				}
			});

			/* Dropdown with form */
			$('.dropdown-menu').find('form').click(function (e) {
				e.stopPropagation();
			});

			$('.flexslider').flexslider({
				animation: "fade",              //String: Select your animation type, "fade" or "slide"
				slideDirection: "vertical",   //String: Select the sliding direction, "horizontal" or "vertical"
				slideshowSpeed: 2000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
				animationDuration: 2000
			});

			$("input:submit").addClass("btn btn-danger");
		});
	</script>

<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["setCookieDomain", "*.elavizor.org.py"]);
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//piwik.tedic.net/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 57]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->

</head>

<?php
  // Add a class to the body tag according to the page URI
  // we're on the home page
  if (count($uri_segments) == 0){ $body_class = "page-main"; }
  // 1st tier pages
  elseif (count($uri_segments) == 1){$body_class = "page-".$uri_segments[0];}
  // 2nd tier pages... ie "/reports/submit"
  elseif (count($uri_segments) >= 2){$body_class = "page-".$uri_segments[0]."-".$uri_segments[1];}
?>

<body id="page" class="<?php echo $body_class; ?>">

<!-- Piwik -->
<noscript><p><img src="//piwik.tedic.net/piwik.php?idsite=57" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

	<div class="jquery-bar navbar navbar-fixed-top">
		<span class="notification">

			<div class="container">
				<div class="pl10 pr10">
					<div class="col-md-9 hidden-xs pt10">
						<a href="<?php echo url::site();?>"><i class="icon-cogs"></i> <?php echo $site_name; ?></a>
					</div>
					<!-- <div class="col-md-2 col-xs-12">
						<?php //echo $languages;?>
					</div> -->
					<div class="col-md-3 col-xs-12 pt10">
						<ul>
						<?php if(isset(Auth::instance()->get_user()->id)){ ?>
							<li class="parent">
								<a data-toggle="dropdown" href="#">
									<i class="icon-user"></i>
									<span><?php echo htmlentities(Auth::instance()->get_user()->username, ENT_QUOTES, "UTF-8"); ?></span>
								</a>
								<ul class="dropdown-menu">
									<?php if(Auth::instance()->get_user()->dashboard() != ""){ ?>
										<?php $adminLink = Auth::instance()->get_user()->dashboard(); ?>
										<li><a href="<?php echo $adminLink."/profile";?>"><?php echo Kohana::lang('ui_main.manage_your_account'); ?></a></li>
										<li><a href="<?php echo $adminLink;?>"><?php echo Kohana::lang('ui_main.your_dashboard'); ?></a></li>
									<?php } ?>
									<li><a href="<?php echo url::site();?>profile/user/<?php echo Auth::instance()->get_user()->username; ?>">
										<?php echo Kohana::lang('ui_main.view_public_profile'); ?></a>
									</li>
									<li><a href="<?php echo url::site();?>logout"><em><?php echo Kohana::lang('ui_admin.logout');?></em></a></li>
								</ul>
							</li>
						<?php }else{ ?>
							<li>
								<a href="#modalLogin" data-toggle="modal">
									<i class="icon-user"></i>
									<span><?php echo Kohana::lang('ui_main.login'); ?></span>
								</a>
							</li>
						<?php }	?>
						</ul>
					</div>
				</div>
			</div>

			<p class="jquery-arrow down"><i class="icon-circle-arrow-up" style="cursor:pointer;"></i></p>
		</span>
	</div>
	<span id="downbar" class="downbar jquery-arrow"><i class="icon-plus-sign" style="cursor:pointer;"></i></span>

	<header>

		<div class="container">
			<div class="row clearfix">

				<div class="col-md-4 col-xs-12">
					<!-- logo -->
					<div class="logo">
						<h1><a href="<?php echo url::site();?>"><?php echo $site_name; ?></a></h1>
						<span><?php echo $site_tagline; ?></span>
						<p>Poder ciudadano</p>
					</div>
					<!-- / logo -->
				</div>

				<div class="col-md-3 col-md-offset-4 col-xs-9 col-xs-offset-0 mt40 respFix">
					<?php
						$host = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
						if($host != 'www.elavizor.org.py/reports/submit')
						{
							echo $submit_btn;
						}
					?>
					<!-- submit incident -->
					<?php //echo $submit_btn; ?>
					<!-- / submit incident -->
				</div>

				<div class="col-md-1 col-xs-3 mt40 respFix">

					<div id="navbar" class="navbar-right">
						<ul class="nav navbar-nav">
							<li class="dropdown">
			                <a href="#" class="dropdown-toggle icon-reorder" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
				                <ul class="dropdown-menu">
				                	<?php nav::main_tabs($this_page); ?>
				                	<li><a href="<?php echo url::site()."ayuda"; ?>">Ayuda</a></li>
				                </ul>
			              	</li>
			            </ul>
		            </div>
				</div>

			</div>
		</div>
	</header>


	<!-- wrapper -->
	<div class="container floatholder">

		<?php Event::run('ushahidi_action.header_item'); // Action::header_item - Additional items to be added by plugins ?>
        <?php if(isset($site_message) AND $site_message != '') { ?>
			<div class="alert alert-warning">
   				<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
   				<i class="icon-info-sign"></i> <?php echo $site_message; ?>
    		</div>
		<?php } ?>

		<!-- main body -->
		<div id="middle" class="row" style="min-height: 450px;">
			<!-- <div class="background layoutleft span12"> -->



				<div id="modalLogin" class="modal hide fade">
					 <div class="modal-header">
						<button class="close" onclick="closeModal('modalLogin')">
							<i class="icon-remove"></i>
						</button>
						<h3 id="myModalLabel"><?php echo Kohana::lang('ui_main.login'); ?></h3>
					</div>
					<div class="modal-body">
						<?php echo form::open('login/', array('id' => 'userpass_form')); ?>
							<input type="hidden" name="action" value="signin" />
							<div class="control-group pull-left mr50">
								<label class="control-label" for="username"><?php echo Kohana::lang('ui_main.email');?></label>
								<div class="controls"><input type="text" name="username" id="username" class="" /></div>
							</div>

							<div class="control-group pull-left">
								<label class="control-label" for="password"><?php echo Kohana::lang('ui_main.password');?></label>
								<div class="controls"><input name="password" type="password" class="" id="password" /></div>
							</div>
							<div class="clear">
								<input class="btn header_nav_login_btn" type="submit" name="submit" value="<?php echo Kohana::lang('ui_main.login'); ?>"/>
							</div>

						<?php echo form::close(); ?>

						<!-- <ul>
							<li><a href="<?php //echo url::site()."login/?newaccount";?>"><?php //echo Kohana::lang('ui_main.login_signup_click'); ?></a></li>
							<li><a href="#" id="header_nav_forgot" onclick="return false"><?php //echo Kohana::lang('ui_main.forgot_password');?></a></li>
						</ul> -->
					</div>
				</div>
