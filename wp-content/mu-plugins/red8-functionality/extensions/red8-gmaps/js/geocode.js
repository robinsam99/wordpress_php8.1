jQuery(document).ready(function($){
	
	var geocoder = new google.maps.Geocoder(), address, latField, longField;
	
	$('.r8gmaps_geocode').live('click', function(){
		address = $(this).parent().siblings().find('input').val();
		latField = $(this).parent().parent().parent().next('.gmap_latitude').find('input');
		longField = $(this).parent().parent().parent().next().next('.gmap_longitude').find('input');
		
		getLatLong(address, latField, longField);
	});
	
	function getLatLong(address, latField, longField) {
		geocoder.geocode({'address': address}, function(results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                
				latField.attr('value', latitude);
				longField.attr('value', longitude);
			} else {
				alert('Geocode was not successful for the following reason: ' + status);
			}
		});
	}
	
});