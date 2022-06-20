
<div id="hotel_location" style="width: 100%; height: 265px;"></div>
<!-- openstreetmap leaflet js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<!-- Load Esri Leaflet from CDN -->
<script src="https://unpkg.com/esri-leaflet"></script>

<!-- Esri Leaflet Geocoder -->
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css">
<script src="https://unpkg.com/esri-leaflet-geocoder"></script>
<script>

<?php if ( isset( $lat ) && isset( $lng )){ ?>
	var htl_map = L.map('hotel_location').setView([<?php echo $lat;?>, <?php echo $lng;?>], 5);
<?php } else { ?>
	var htl_map = L.map('hotel_location').setView([0, 0], 5);
<?php } ?>

const htl_attribution =
'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
const htl_tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const htl_tiles = L.tileLayer(htl_tileUrl, { htl_attribution });
htl_tiles.addTo(htl_map);
<?php if ( isset( $lat ) && isset( $lng )){ ?>
    var htl_marker = new L.Marker(new L.LatLng(<?php echo $lat;?>, <?php echo $lng;?>));
    htl_map.addLayer(htl_marker);
<?php } else { ?>
    var htl_marker = new L.Marker(new L.LatLng(0, 0));
    //mymap.addLayer(marker2);
<?php } ?>
var htl_searchControl = L.esri.Geocoding.geosearch().addTo(htl_map);
var results = L.layerGroup().addTo(htl_map);

htl_searchControl.on('results',function(data){
    results.clearLayers();

    for(var i= data.results.length -1; i>=0; i--) {
        htl_map.removeLayer(htl_marker);
        results.addLayer(L.marker(data.results[i].latlng));
        var htl_search_str = data.results[i].latlng.toString();
        var htl_search_res = htl_search_str.substring(htl_search_str.indexOf("(") + 1, htl_search_str.indexOf(")"));
        var htl_searchArr = new Array();
        htl_searchArr = htl_search_res.split(",");

        document.getElementById("lat").value = htl_searchArr[0].toString();
        document.getElementById("lng").value = htl_searchArr[1].toString(); 
       
    }
})
var popup = L.popup();

function onMapClick(e) {

    var htl = e.latlng.toString();
    var htl_res = htl.substring(htl.indexOf("(") + 1, htl.indexOf(")"));
    htl_map.removeLayer(htl_marker);
    results.clearLayers();
    results.addLayer(L.marker(e.latlng));   

    var htl_tmpArr = new Array();
    htl_tmpArr = htl_res.split(",");

    document.getElementById("lat").value = htl_tmpArr[0].toString(); 
    document.getElementById("lng").value = htl_tmpArr[1].toString();
}

htl_map.on('click', onMapClick);

</script>