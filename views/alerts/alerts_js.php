<?php
/**
 * Alerts js file.
 *
 * Handles javascript stuff related  to alerts function
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - https://github.com/ushahidi/Ushahidi_Web
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
?>

// Map reference
var map = null;
var latitude = <?php echo Kohana::config('settings.default_lat') ?>;
var longitude = <?php echo Kohana::config('settings.default_lon'); ?>;
//var zoom = <?php echo Kohana::config('settings.default_zoom'); ?>;
var zoom = 10;

var v_marcador;
var v_circulo_radio;

jQuery(function($) {
	$(window).load(function(){
		// Mapa con Leaflet.
		map = L.map('divMap').setView([latitude, longitude], zoom);
		map.setMaxBounds([
            [-28.000, -62.999],
            [-18.900, -53.900]
        ]);

		// Capa principal.
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    	    		attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);

		// Don't show the 'Powered by Leaflet' text. Attribution overload.
		map.attributionControl.setPrefix('');

		// Icono.
		var v_icono_marcador = L.icon({
		    iconUrl: "<?php echo url::site().'media/img/openlayers/marker.png' ?>",
			iconSize: [21, 25]
		});

		// Marcador.
		v_marcador = L.marker(new L.LatLng(latitude, longitude), {
    		icon: v_icono_marcador,
    		draggable: true
		});
		v_marcador.addTo(map);

		// Radio.
		var v_multiplicador_radius = 1000;
		var v_radius = 20 * v_multiplicador_radius;
		v_circulo_radio = L.circle([latitude, longitude], v_radius, {
			color: 'red',
			fillColor: '#f03',
			fillOpacity: 0.5
		}).addTo(map);

		// Cuando el marcador se mueve.
		// se actualiza la posicion del
		// marcador como tambien el
		// radio.
		v_marcador.on('dragend', function(event){
			var v_marker = event.target;
			var v_posicion = v_marker.getLatLng();
			v_marker.setLatLng(v_posicion);
			v_circulo_radio.setLatLng(v_posicion);
		});




		$('.btn_find').on('click', function () {
			geoCode();
		});

		$('#location_find').bind('keypress', function(e) {
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code == 13) { //Enter keycode
				geoCode();
				return false;
			}
		});

		// Alerts Slider
		$("select#alert_radius").selectToUISlider({
			labels: 6,
			labelSrc: 'text',
			sliderOptions: {
				change: function(e, ui) {
					var newRadius = $("#alert_radius").val();

					// Convert to Meters
					radius = newRadius * 1000;

					// Redraw Circle
					//map.updateRadius({radius: radius});
					v_circulo_radio.setRadius(radius);
				}
			}
		}).hide();


	// Some Default Values
	$("#alert_mobile").focus(function() {
		$("#alert_mobile_yes").attr("checked",true);
	}).blur(function() {
		if(!this.value.length) {
			$("#alert_mobile_yes").attr("checked",false);
		}
	});

	$("#alert_email").focus(function() {
		$("#alert_email_yes").attr("checked",true);
	}).blur(function() {
		if( !this.value.length ) {
			$("#alert_email_yes").attr("checked",false);
		}
	});

	// Category treeview
    $(".category-column").treeview({
      persist: "location",
	  collapsed: true,
	  unique: false
	});

	/*
	$("#treeCategory").dynatree();
	*/




	});
});

/**
 * Google GeoCoder
 */
function geoCode() {
	$('#find_loading').html('<img src="<?php echo url::file_loc('img')."media/img/loading_g.gif"; ?>">');
	address = $("#location_find").val();
	$.post("<?php echo url::site(); ?>reports/geocode/", { address: address },
		function(data){
			if (data.status == 'success') {

				map.updateRadius({
					longitude: data.longitude,
					latitude: data.latitude
				});

				// Update form values
				$("#alert_lat").val(data.latitude);
				$("#alert_lon").val(data.longitude);
			} else {
				// Alert message to be displayed
				var alertMessage = address + " not found!\n\n***************************\n" +
				    "Enter more details like city, town, country\nor find a city or town " +
				    "close by and zoom in\nto find your precise location";

				alert(alertMessage)
			}
			$('#find_loading').html('');
		}, "json");
	return false;
}
