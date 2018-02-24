<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">

  <title>Daniel Hookins - Pulse Lab Jakarta</title>

  <!-- JQuery -->
  <script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

  <!-- Bootstrap -->
  <link rel="stylesheet"
  href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
  integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
  crossorigin="anonymous"/>

  <!-- MapBox -->
  <script src='https://api.mapbox.com/mapbox-gl-js/v0.44.1/mapbox-gl.js'></script>
  <link href='https://api.mapbox.com/mapbox-gl-js/v0.44.1/mapbox-gl.css' rel='stylesheet' />

  <!-- Leaflet.js -->
  <link rel="stylesheet"
  href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
  integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
  integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
  crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.min.js"></script>

  <!-- Custom CSS Styling -->
  <style>
    body {
      background-color: #000;
      color: #fff;
    }

    #mapid {
      height: 500px;
      width: 100%;
    }
  </style>


</head>
<body>
  <div class="container-fluid">
    <div class="row">

      <div class="col-12">
        <h1>Test</h1>
        <div id="mapid"></div>
      </div>

    </div>

  </div>

  <!-- Custom JavaScript -->
  <script>

    // MapBox
    var mapboxAccessToken = 'pk.eyJ1IjoiZGFuaWVsaG9va2lucyIsImEiOiJjamUxMmlhejMwYWQyMndubTVxZjdzbzQ2In0.0biUD0nEuawEaTUuVOTXmQ';
    var map = L.map('mapid').setView([-2.4951303, 116.58], 5);
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + mapboxAccessToken, {
      id: 'mapbox.light',
      attribution: ''
    }).addTo(map);
    var layersControl = L.control.layers('', {}).addTo(map);

    // Disaster Dataset Layer
    var disasterDataset;
    var disasterLayer;
    $.getJSON('http://139.59.230.55/frontend/api/maps/disaster', function(data){
      disasterDataset = data.data;
      var disasterLayer = new L.GeoJSON.AJAX("/assets/geojson/KABUKOTA_ADMINISTRATIVE_AREA-SIMPLIFIED.geojson", {
        style: style
      });

      disasterLayer.addTo(map)
      layersControl.addOverlay(disasterLayer, data.name);
    });

    // Vulnerable Population Dataset Layer
    var vulnerableDataset;
    var vulnerableLayer;
    $.getJSON('http://139.59.230.55/frontend/api/maps/vulnerable', function(data){
      vulnerableDataset = data.data;
      vulnerableLayer = new L.GeoJSON.AJAX("/assets/geojson/KABUKOTA_ADMINISTRATIVE_AREA-SIMPLIFIED.geojson", {
        style: styleVulnerable
      });

      vulnerableLayer.addTo(map);
      layersControl.addOverlay(vulnerableLayer, data.name);;
    });

    // Get the color based on value provided
    function getColor(d) {
      return d > 9  ? '#662506' :
             d > 8  ? '#9934046' :
             d > 7  ? '#cc4c02' :
             d > 6  ? '#ec7014' :
             d > 5  ? '#fe9929' :
             d > 4  ? '#fec44f' :
             d > 3  ? '#fee391' :
             d > 2  ? '#fff7bc' :
             d > 1  ? '#ffffe5' :
                       '#fff';
    }

    // Set the style of the feature
    function style(feature) {
      var disasterValue = getDisasterValueForCity(disasterDataset, feature.properties.id_kabkota);

      return {
        fillColor: getColor(disasterValue),
        weight: 0,
        opacity: 0.333,
        color: '#000',
        fillOpacity: 0.333
      };
    }

    // Set the style of the feature
    function styleVulnerable(feature) {
      var vulnerableValue = getVulnerableValueForCity(vulnerableDataset, feature.properties.id_kabkota);

      return {
        fillColor: getColor(vulnerableValue),
        weight: 0,
        opacity: 0.333,
        color: '#000',
        fillOpacity: 0.333
      };
    }

    // Get the Number of Disasters for Specified City ID
    function getDisasterValueForCity(disasterDataset, city_id) {
      for(var i = 0; i < disasterDataset.length; i++) {
          if( disasterDataset[i].city_id == city_id){
            return disasterDataset[i].value;
          }
      }
    }

    // Get the Vulnerability for Specified City ID
    function getVulnerableValueForCity(vulnerableDataset, city_id) {
      for(var i = 0; i < vulnerableDataset.length; i++) {
          if( vulnerableDataset[i].city_id == city_id){
            return vulnerableDataset[i].value / 10;
          }
      }
    }

  </script>

</body>
</html>
