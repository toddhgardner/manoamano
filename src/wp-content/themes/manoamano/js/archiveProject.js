/**
 * Hanldes the displaying of the Google Map.
 * 
 * Will display markers based off posts.
 */
var archiveProject = {
	displayMap: function() {
		var mapOptions = {
			center: new google.maps.LatLng(-16.425548, -63.984375),
			zoom: 6,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
		archiveProject.getMarkers(map);
	},
	getMarkers: function(map) {
		jQuery('.archiveProject-marker').each(function(){
			archiveProject.addMarker({"map":map, "latitude":jQuery(this).data('latitude'), "longitude":jQuery(this).data('longitude'), "title":jQuery(this).data('title')});
		});
	},
	addMarker: function(options) {
		latitudeLongitude = new google.maps.LatLng(options.latitude, options.longitude);
		new google.maps.Marker({
			position: latitudeLongitude,
			map: options.map,
			title: options.title
		}); 
	}
};