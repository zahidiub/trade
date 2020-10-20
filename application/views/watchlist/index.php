<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>

<div id="container" style="height: 400px; min-width: 310px"></div>


<script type="text/javascript">
	
Highcharts.getJSON('<?= base_url() ?>watchlist/chart_json', function (data) {
  // Create the chart
  Highcharts.stockChart('container', {


    rangeSelector: {
      selected: 1
    },

    title: {
      text: 'My Watchlist'
    },
    xAxis: {
    type: "datetime",
    ordinal: false,
    labels: {
      format: "{value:%Y-%m-%d}"
    },
    minTickInterval: 28 * 24 * 3600 * 1000
  },

    series: [{
      name: 'Pairs',
      data: data,
      tooltip: {
        valueDecimals: 2
      }
    }]
  });
});


</script>