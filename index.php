<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">

  <title>Daniel Hookins Technical Assignment - Pulse Lab Jakarta</title>

  <!-- JQuery -->
  <script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

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

  <!-- D3 -->
  <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>

  <!-- Bootstrap -->
  <link rel="stylesheet"
  href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
  integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
  crossorigin="anonymous"/>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

  <!-- Custom CSS Styling -->
  <style>

    /*
     * General Styling
     */

    body {
      background-color: #fff;
      color: rgba(0,0,0,0.87);
      font-family: "Open Sans", sans-serif;
    }

    h1, h2 {
      text-transform: uppercase;
      font-weight: 800;
      font-family: 'Oswald', sans-serif;
    }

    /*
     * Header Section
     */

    #header-section {
      background-color: #00aeef;
      color: #fff;
      padding: 20px 0;
    }
    #header-section .un-logo {
      width: 100px;
      height: auto;
    }
    #header-section p {
      padding-bottom: 0;
    }

    /*
     * Map Section
     */

    #map-section {
      margin-top: 60px;
    }

    #mapid {
      height: 500px;
      width: 100%;
    }

    /*
     * Graph Section
     */

    #graph-section {
      margin-top: 60px;
    }
    #graph-section #graphid .bar {
      fill: #5f89ad;
    }
    #graph-section #graphid text {
      font-size: 14px;
    }
    #graph-section #graphid .axis path,
    #graph-section #graphid .axis line {
        fill: none;
        display: none;
    }
  </style>


</head>
<body>
  <div id="header-section" class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-2">
          <img class="un-logo" src="https://www.unglobalpulse.org/sites/all/themes/globalpulse2014/logo.png" alt="United Nations Global Pulse">
        </div>
        <div class="col-10">
          <h1>United Nations Global Pulse</h1>
          <p>Technical Assignment - Daniel Hookins</p>
        </div>
      </div>
    </div>
  </div>
  <div id="map-section" class="container">
    <div class="row">

      <div class="col-12">
        <h2>Number of Disasters, Vulnerable Population and Damage Area in Indonesia</h2>
        <p><strong>The darker and more red the area the more affected it is by disasters.</strong> Use the layer selector in the top right to adjust the layer information shown.</p>
        <div id="mapid"></div>
      </div>

    </div>

  </div>

  <div id="graph-section" class="container">
    <h2>OD Pair Graph for Jakarta</h2>
    <div id="graphid"></div>
  </div>


  <!-- Choropleth Visualisation -->
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
  </script>

  <!-- OD Pair Data Visualisation -->
  <script>
  // get the data from the API
  $.getJSON('http://139.59.230.55/frontend/api/odpair', function(data){

      var sortable = [];
      data.forEach( function (arrayItem)
      {
          var valueToPush = {};
          valueToPush['name'] = arrayItem.from + " to " + arrayItem.to;
          valueToPush['value'] = arrayItem.count;
          sortable.push(valueToPush);
      });

      //sort bars based on value
      data = sortable.sort(function (a, b) {
          return d3.ascending(a.value, b.value);
      })

      // keep max value
      var maxValue = d3.max(data, function (d) {
          return d.value;
      });

      // Slice limit to 20% of dataset
      data = data.slice(data.length - (data.length * 0.2), data.length);

      //set up svg using margin conventions
      // we'll need plenty of room on the left for labels
      var margin = {
          top: 15,
          right: 55,
          bottom: 15,
          left: 130
      };

      var width = 900 - margin.left - margin.right,
          height = 700 - margin.top - margin.bottom;

      var svg = d3.select("#graphid").append("svg")
          .attr("width", width + margin.left + margin.right)
          .attr("height", height + margin.top + margin.bottom)
          .append("g")
          .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

      var x = d3.scale.linear()
          .range([0, width])
          .domain([0, maxValue]);

      var y = d3.scale.ordinal()
          .rangeRoundBands([height, 0], .1)
          .domain(data.map(function (d) {
              return d.name;
          }));

      //make y axis to show bar names
      var yAxis = d3.svg.axis()
          .scale(y)
          //no tick marks
          .tickSize(0)
          .orient("left");

      var gy = svg.append("g")
          .attr("class", "y axis")
          .call(yAxis)

      var bars = svg.selectAll(".bar")
          .data(data)
          .enter()
          .append("g")

      //append rects
      bars.append("rect")
          .attr("class", "bar")
          .attr("y", function (d) {
              return y(d.name);
          })
          .attr("height", y.rangeBand())
          .attr("x", 0)
          .attr("width", function (d) {
              return x(d.value);
          });

      //add a value label to the right of each bar
      bars.append("text")
          .attr("class", "label")
          //y position of the label is halfway down the bar
          .attr("y", function (d) {
              return y(d.name) + y.rangeBand() / 2 + 4;
          })
          //x position is 3 pixels to the right of the bar
          .attr("x", function (d) {
              return x(d.value) + 3;
          })
          .text(function (d) {
              return d.value;
          });
  });
  </script>

</body>
</html>
