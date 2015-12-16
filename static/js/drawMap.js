$(document).ready(function() {

	function drawMap(idEnv) {
		client = $('#'+idEnv+' .client');
		local = $('#'+idEnv+' .localServer');
		conti = $('#'+idEnv+' .continentalServer');
		inter = $('#'+idEnv+' .intercontinentalServer');
		clientCoordinate = {lat: parseFloat(client.attr('latitude')), lng: parseFloat(client.attr('longitude'))}
		localCoordinate = {lat: parseFloat(local.attr('latitude')), lng: parseFloat(local.attr('longitude'))+0.2}
		contiCoordinate = {lat: parseFloat(conti.attr('latitude')), lng: parseFloat(conti.attr('longitude'))}
		interCoordinate = {lat: parseFloat(inter.attr('latitude')), lng: parseFloat(inter.attr('longitude'))}
		var mapOptions =
		{
			//Centering the map on the middle of Russia
			center: {lat: 55.0194, lng: 82.9229},
			zoom: 2,
		};
		var map = new google.maps.Map($('#'+idEnv+' .map-canvas')[0], mapOptions);


		// Create the marker on the map
		var red = "FF0000";
		var blue = "0000FF";
	    var clientImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + blue,
    	    new google.maps.Size(21, 34),
    	    new google.maps.Point(0,0),
    	    new google.maps.Point(10, 34));

	    var serverImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + red,
    	    new google.maps.Size(21, 34),
    	    new google.maps.Point(0,0),
    	    new google.maps.Point(10, 34));

		var clientString = client.attr('hostname')+' '+client.attr('port')
		var clientMarker = new google.maps.Marker({
			position: clientCoordinate,
			map: map,
			icon: clientImage,
			title: 'Client'
		});
		var clientInfo = new google.maps.InfoWindow({
			content: clientString
		});
		google.maps.event.addListener(clientMarker, 'click', function() {
			clientInfo.open(map, clientMarker);
		});

		var localString = local.attr('hostname')+' '+local.attr('port')
		var localMarker = new google.maps.Marker({
			position: localCoordinate,
			map: map,
			icon: serverImage,
			title: 'Local Server'
		});
		var localInfo = new google.maps.InfoWindow({
			content: localString
		});
		google.maps.event.addListener(localMarker, 'click', function() {
			localInfo.open(map, localMarker);
		});

		var contiString = conti.attr('hostname')+' '+conti.attr('port')
		var contiMarker = new google.maps.Marker({
			position: contiCoordinate,
			map: map,
			icon: serverImage,
			title: 'Continental Server'
		});
		var contiInfo = new google.maps.InfoWindow({
			content: contiString
		});
		google.maps.event.addListener(contiMarker, 'click', function() {
			contiInfo.open(map, contiMarker);
		});

		var interString = inter.attr('hostname')+' '+inter.attr('port')
		var interMarker = new google.maps.Marker({
			position: interCoordinate,
			map: map,
			icon: serverImage,
			title: 'Intercontinental Server'
		});
		var interInfo = new google.maps.InfoWindow({
			content: interString
		});
		google.maps.event.addListener(interMarker, 'click', function() {
			interInfo.open(map, interMarker);
		});

		//Creating Polyline to visualize link between node
		var localLink = new google.maps.Polyline({
			path: [clientCoordinate, localCoordinate],
			strokeColor: '#000000',
			strokeOpacity: 1.0,
			strokeWeight: 2
		});
		localLink.setMap(map);

		var contiLink = new google.maps.Polyline({
			path: [clientCoordinate, contiCoordinate],
			strokeColor: '#000000',
			strokeOpacity: 1.0,
			strokeWeight: 2
		});
		contiLink.setMap(map);

		var interLink = new google.maps.Polyline({
			path: [clientCoordinate, interCoordinate],
			strokeColor: '#000000',
			strokeOpacity: 1.0,
			strokeWeight: 2
		});
		interLink.setMap(map);

	}

	function drawMaps()
	{
		$('.environment').each(function() 
		{
			drawMap($(this).attr('id'));
		});
	}

	google.maps.event.addDomListener(window, 'load', drawMaps);
});	
