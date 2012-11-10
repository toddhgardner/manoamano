/**
 * Hanldes the displaying of the Google Map.
 * 
 * Will display markers based off posts.
 */
var archiveProject = {
	displayMap: function() {
		var map = archiveProject.initMap();
		archiveProject.getMarkers(map);
	},
	initMap: function() {
		var mapOptions = {
			center: new google.maps.LatLng(-16.425548, -63.984375),
			zoom: 6,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		return new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	},
	/**
	 * 
	 * @param map google.maps.Map
	 */
	getMarkers: function(map) {
		jQuery('.archiveProject-marker').each(function(){
			var marker = archiveProject.addMarker({"map":map, "latitude":jQuery(this).data('latitude'), "longitude":jQuery(this).data('longitude'), "title":jQuery(this).data('title')});
			archiveProject.bindTooltips({"map":map, "marker":marker, "content": jQuery(this).html()});
		});
	},
	/**
	 * Displays a marker on the specified map for the given latitude and longitude.
	 * 
	 * @param options:
	 * 	map:		google.maps.Map The Google Map containing the marker
	 * 	latitude:	Latitude of the marker
	 * 	longitude:	Longitude of the marker
	 * 	title:		(Optional) On hover title of the marker
	 */
	addMarker: function(options) {
		latitudeLongitude = new google.maps.LatLng(options.latitude, options.longitude);
		return new google.maps.Marker({
			position: latitudeLongitude,
			map: options.map,
			title: options.title
		}); 
	},
	infoWindow: null,
	/**
	 * Displays content based on the clicked marker.
	 * 
	 * @param options:
	 * 	map:		google.maps.Map The Google Map containing the marker
	 * 	marker:		The marker that is clicked and realted to the tooltip content 		
	 * 	content:	HTML string content that will be displayed within the tootltip 
	 */
	bindTooltips: function(options) {
		google.maps.event.addListener(options.marker, 'click', function() {
			// close existing tooltip
			if (archiveProject.infoWindow) {
				archiveProject.infoWindow.close();
			}
			archiveProject.infoWindow = new google.maps.InfoWindow({content: options.content});
			archiveProject.infoWindow.open(options.map, options.marker);
		});
	}
};