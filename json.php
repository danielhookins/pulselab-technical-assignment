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

  <!-- Leaflet.js -->
  <link rel="stylesheet"
  href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
  integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
  integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
  crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.min.js"></script>

  <!--Custom JS -->
  <script>

  // Disaster Dataset Layer
  var disasterDataset;
  $.getJSON('http://139.59.230.55/frontend/api/maps/disaster', function(data){
    disasterDataset = data.data;
    var disasterLayer = new L.GeoJSON.AJAX("/assets/geojson/KABUKOTA_ADMINISTRATIVE_AREA-SIMPLIFIED.geojson", {
      style: style
    });
    disasterLayer.addTo(map);
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
      weight: 2,
      opacity: 1,
      color: '#000',
      fillOpacity: 0.7
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


  </script>

</head>
<body>

</body>
</html>
