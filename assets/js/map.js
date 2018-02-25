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

  addToGlobalDataset(data)
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
  layersControl.addOverlay(vulnerableLayer, data.name);

  addToGlobalDataset(data)
});

// Damage Area Dataset Layer
var areaDataset;
var areaLayer;
$.getJSON('http://139.59.230.55/frontend/api/maps/area', function(data){
  areaDataset = data.data;
  areaLayer = new L.GeoJSON.AJAX("/assets/geojson/KABUKOTA_ADMINISTRATIVE_AREA-SIMPLIFIED.geojson", {
    style: styleArea
  });

  areaLayer.addTo(map);
  layersControl.addOverlay(areaLayer, data.name);

  addToGlobalDataset(data)
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

// Set the style of the feature
function styleArea(feature) {
  var areaValue = getAreaValueForCity(areaDataset, feature.properties.id_kabkota);

  return {
    fillColor: getColor(areaValue),
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

// Get the Area for Specified City ID
function getAreaValueForCity(areaDataset, city_id) {
  for(var i = 0; i < areaDataset.length; i++) {
      if( areaDataset[i].city_id == city_id){
        return areaDataset[i].value / 10;
      }
  }
}

// Add to global Dataset
var globalDataset = {};
function addToGlobalDataset(data) {
  for(var i = 0; i < data.data.length; i++) {
      //
  }
}
