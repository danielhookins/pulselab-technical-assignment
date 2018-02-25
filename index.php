<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">

  <title>Daniel Hookins Technical Assignment - Pulse Lab Jakarta</title>

  <!-- JQuery -->
  <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
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
        <p><strong>This chart shows the impact of disasters on specific regions in Indonesia.</strong> The darker and more red the area the more affected it is by disasters.</strong> Use the layer selector in the top right to adjust the layer information shown.</p>
        <div id="mapid"></div>
      </div>

    </div>

  </div>

  <div id="graph-section" class="container">
    <h2>Line Utilisation for Jakarta</h2>
    <p><strong>This chart shows the utilisation of transit lines in Jakarta.</strong> Results can be ordered in ascending or descending order. For brevity the graph can be limited to the top or bottom 20% of results.  Use the controls below to adjust the graph information shown.</p>
    <div id="graph-controls">
      <label class="radio-inline"><input type="radio" name="graphSort" value="descending" checked="" > Descending</label>
      <label class="radio-inline"><input type="radio" name="graphSort" value="ascending" > Ascending</label>
      <span>|</span>
      <input id="limitDataCheckbox" type="checkbox" name="limitData" checked=""><label for="limitDataCheckbox" class="checkbox-inline">&nbsp;Limit dataset to <strong>highest</strong> 20%</label>
    </div>
    <div id="graphid"></div>
  </div>


  <!-- Choropleth Visualisation -->
  <script src="/assets/js/map.js"></script>

  <!-- OD Pair Data Visualisation -->
  <script src="/assets/js/graph.js"></script>

</body>
</html>
