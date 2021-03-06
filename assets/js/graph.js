
  function drawGraph(sort = "descending", limitData = true) {
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
            if (sort == "descending") { // The names are backwards here due to the dataset
              return d3.ascending(a.value, b.value);
            }
            return d3.descending(a.value, b.value);
        })

        // keep max value
        var maxValue = d3.max(data, function (d) {
            return d.value;
        });

        if (limitData) {
          // Slice limit to 20% of dataset
          data = data.slice(data.length - (data.length * 0.2), data.length);
        }

        //set up svg using margin conventions
        // we'll need plenty of room on the left for labels
        var margin = {
            top: 15,
            right: 55,
            bottom: 15,
            left: 130
        };

        var width = 900 - margin.left - margin.right;

        var height = 2000 - margin.top - margin.bottom;
        if(limitData){
          var height = 700 - margin.top - margin.bottom;
        }

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

  }

  $("#graph-controls").on("change", function(){
    var graphSort = $('#graph-controls input:checked').val();
    var limitData = $("#graph-controls input[name='limitData']").prop('checked');

    if (graphSort == "ascending") {
      $("#graph-controls label.checkbox-inline").html('&nbsp;Limit dataset to <strong>lowest</strong> 20%');
    } else {
      $("#graph-controls label.checkbox-inline").html('&nbsp;Limit dataset to <strong>highest</strong> 20%');
    }

    d3.select("#graphid svg").remove();
    drawGraph(graphSort, limitData);
  } );


  // Get the party started
  drawGraph()
