/**
 * Hanldes the displaying of the Google Map.
 * 
 * Will display markers based off posts.
 */
var archiveProject = {
	displayMap: function() {
		var map = archiveProject.initMap();
		archiveProject.getMarkers(map);
		jQuery('#archiveProject-filter').bind('change', archiveProject.filterMarkers);
	},
	initMap: function() {
		var mapOptions = {
			center: new google.maps.LatLng(-16.425548, -63.984375),
			disableDefaultUI: true,
			zoom: 6,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		archiveProject.map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
		return archiveProject.map;
	},
	filterMarkers: function(event) {
		// called when dropdown changes
		archiveProject.getMarkers(archiveProject.map);
	},
	/**
	 * 
	 * @param map google.maps.Map
	 */
	getMarkers: function(map) {
		
		// clear out existing markers
		jQuery(archiveProject.currentMarkers).each(function(){
			this.setMap(null);
		});
		
		// selected category filter
		var category = jQuery('#archiveProject-filter').val();
		
		jQuery('.archiveProject-marker').each(function(){
			// only display marker if its type is selected in the filter
			if (jQuery(this).data('category').indexOf(category) != -1) {
				var marker = archiveProject.addMarker({"map":map, "latitude":jQuery(this).data('latitude'), "longitude":jQuery(this).data('longitude'), "title":jQuery(this).data('title')});
				archiveProject.currentMarkers.push(marker);
				archiveProject.bindTooltips({"map":map, "marker":marker, "content": jQuery(this).html()});
			}
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
	},
	map: null,
	currentMarkers: []
};