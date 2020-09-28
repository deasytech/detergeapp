
$(function() {
  "use strict";
  // ==============================================================
  // Total Sale
  // ==============================================================
  var ctx = document.getElementById("total-sale").getContext('2d');
  
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ["Cleaning", " Repair"],
      datasets: [{
        backgroundColor: [
          "#5969ff",
          "#ff407b",
        ],
        data: [350.56, 135.18]
      }]
    },
    options: {
      legend: {
        display: false
      }
    }
  });

  // ==============================================================
  // Location Map
  // ==============================================================
  jQuery('#locationmap').vectorMap({
    map: 'africa_mill',
    backgroundColor: 'transparent',
    borderColor: '#000',
    borderOpacity: 0,
    borderWidth: 0,
    zoomOnScroll: false,
    color: '#25d5f2',
    focusOn: {
      x: 0.5,
      y: 0.3,
      scale: 5,
      animate: true
    },
    regionStyle: {
      initial: {
        fill: "#e3eaef"
      }
    },
    markerStyle: {
      initial: {
        r: 9,
        fill: "#25d5f2",
        "fill-opacity": .9,
        stroke: "#fff",
        "stroke-width": 7,
        "stroke-opacity": .4
      },
      hover: {
        stroke: "#fff",
        "fill-opacity": 1,
        "stroke-width": 1.5
      }
    },

    markers: [{
      latLng: [6.523824, 3.374563],
      name: "Lagos"
    }, {
      latLng: [9.076703, 7.397444],
      name: "Abuja"
    }],

    hoverOpacity: null,
    normalizeFunction: 'linear',
    scaleColors: ['#25d5f2', '#25d5f2'],
    selectedColor: '#c9dfaf',
    selectedRegions: [],
    showTooltip: true,
    onRegionClick: function(element, code, region) {
      var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
      alert(message);
    }

  });

  // ==============================================================
  // Revenue Cards
  // ==============================================================
  $("#sparkline-1").sparkline([5, 5, 7, 7, 9, 5, 3, 5, 2, 4, 6, 7], {
    type: 'line',
    width: '99.5%',
    height: '100',
    lineColor: '#5969ff',
    fillColor: '#dbdeff',
    lineWidth: 2,
    spotColor: undefined,
    minSpotColor: undefined,
    maxSpotColor: undefined,
    highlightSpotColor: undefined,
    highlightLineColor: undefined,
    resize:true
  });

  $("#sparkline-2").sparkline([3, 7, 6, 4, 5, 4, 3, 5, 5, 2, 3, 1], {
    type: 'line',
    width: '99.5%',
    height: '100',
    lineColor: '#ff407b',
    fillColor: '#ffdbe6',
    lineWidth: 2,
    spotColor: undefined,
    minSpotColor: undefined,
    maxSpotColor: undefined,
    highlightSpotColor: undefined,
    highlightLineColor: undefined,
    resize:true
  });

  $("#sparkline-3").sparkline([5, 3, 4, 6, 5, 7, 9, 4, 3, 5, 6, 1], {
    type: 'line',
    width: '99.5%',
    height: '100',
    lineColor: '#25d5f2',
    fillColor: '#dffaff',
    lineWidth: 2,
    spotColor: undefined,
    minSpotColor: undefined,
    maxSpotColor: undefined,
    highlightSpotColor: undefined,
    highlightLineColor: undefined,
    resize:true
  });

  $("#sparkline-4").sparkline([6, 5, 3, 4, 2, 5, 3, 8, 6, 4, 5, 1], {
    type: 'line',
    width: '99.5%',
    height: '100',
    lineColor: '#fec957',
    fillColor: '#fff2d5',
    lineWidth: 2,
    spotColor: undefined,
    minSpotColor: undefined,
    maxSpotColor: undefined,
    highlightSpotColor: undefined,
    highlightLineColor: undefined,
    resize:true,
  });
});
