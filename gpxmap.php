<html>
<head>
	<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
	<script src="http://www.openstreetmap.org/openlayers/OpenStreetMap.js"></script>
 	<?php
 		$runid = $_GET["runid"];
 		$lon = $_GET["lon"];
 		$lat = $_GET["lat"];

 	?>
	<script type="text/javascript">
		// Start position for the map (hardcoded here for simplicity,
		// but maybe you want to get this from the URL params)
		var runid = <? echo $runid; ?>;
		var lon = <? echo $lon; ?>;
		var lat = <? echo $lat; ?>;
		var zoom=12
 
		var map;
 
		function init() {
			map = new OpenLayers.Map ("map", {
				controls:[
					new OpenLayers.Control.Navigation(),
					new OpenLayers.Control.PanZoomBar(),
					new OpenLayers.Control.LayerSwitcher(),
					new OpenLayers.Control.Attribution()],
				maxExtent: new OpenLayers.Bounds(-20037508.34,-20037508.34,20037508.34,20037508.34),
				maxResolution: 15654,
				numZoomLevels: 19,
				units: 'm',
				projection: new OpenLayers.Projection("EPSG:900913"),
				displayProjection: new OpenLayers.Projection("EPSG:4326")
			} );
 
			// Define the map layer
			// Here we use a predefined layer that will be kept up to date with URL changes
			//layerMapnik = new OpenLayers.Layer.OSM.Mapnik("Mapnik");
			//map.addLayer(layerMapnik);
			layerCycleMap = new OpenLayers.Layer.OSM.CycleMap("CycleMap");
			map.addLayer(layerCycleMap);
			//layerMarkers = new OpenLayers.Layer.Markers("Markers");
			//map.addLayer(layerMarkers);
 
			// Add the Layer with the GPX Track
			
			var lgpx = new OpenLayers.Layer.Vector("Test GPX", {
				strategies: [new OpenLayers.Strategy.Fixed()],
				protocol: new OpenLayers.Protocol.HTTP({
					url: "gpxuploads/"+runid+".gpx",
					format: new OpenLayers.Format.GPX()
				}),
				style: {strokeColor: "red", strokeWidth: 5, strokeOpacity: 0.5},
				projection: new OpenLayers.Projection("EPSG:4326")
			});
			map.addLayer(lgpx);
 			
			var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
			map.setCenter(lonLat, zoom);
 
			var size = new OpenLayers.Size(21, 25);
			var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
			var icon = new OpenLayers.Icon('http://www.openstreetmap.org/openlayers/img/marker.png',size,offset);
			layerMarkers.addMarker(new OpenLayers.Marker(lonLat,icon));
		}
	</script>
 
</head>
<!-- body.onload is called once the page is loaded (call the 'init' function) -->
<body onload="init();">
	<!-- define a DIV into which the map will appear. Make it take up the whole window -->
	<div style="width:100%; height:100%" id="map"></div>
</body>
</html>
