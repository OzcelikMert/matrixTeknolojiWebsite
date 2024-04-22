var ChartColor = ["#5D62B4", "#54C3BE", "#EF726F", "#F9C446", "rgb(93.0, 98.0, 180.0)", "#21B7EC", "#04BCCC"];
// Ajax - get data variable
function GetDateValues(){
	 $.ajax({
		url: "./admin/pages/dashboard/functions/get_chart_values.php",
		success: function(data){
      var data = $.parseJSON(data);
      console.log(data);
      BlogChartFunction(data.blog);
      ViewChartFunction(data.view_list);
    },
		error: function(){
			alert("Error!");
		}
	});
}

// JSON FIND MAX VALUE FUNCTION
function getMax_jsonArray(jsonArray, prop) {
    var max;
    for (var i=0 ; i < jsonArray[prop].length ; i++) {
        if (max == null || parseInt(jsonArray[prop][i]) > parseInt(max)){
            max = jsonArray[prop][i];
        }
    }
    return max;
}

/* 1nd Chart Function */

// Chart Values Function View
function ViewChartFunction(dataValues) {
  // GET Array
  // GET MAX
  // week
  var weekMax = getMax_jsonArray(dataValues.week, 0);
  if(weekMax < 5){
    weekMax = 5
  }
  var week_stepSize = Math.round(weekMax / 5);
  // month
  var monthMax = getMax_jsonArray(dataValues.month, 0);
  if(monthMax < 5){
    monthMax = 5
  }
  var month_stepSize = Math.round(monthMax / 5);
  // year
  var yearMax = getMax_jsonArray(dataValues.year, 0);
  if(yearMax < 5){
    yearMax = 5
  }
  var year_stepSize = Math.round(yearMax / 5);
  // end GET MAX
  // end GET Array
  // end GET MAX
  // end GET Array
  if ($("#ViewChart").length) {
    var barChartCanvas = $("#ViewChart").get(0).getContext("2d");
    var data_2_2 = dataValues.week[0];
    var data_3_2 = dataValues.month[0];
    var data_4_2 = dataValues.year[0];
    var barChart = {
        labels: dataValues.week[1],
        datasets: [{
          label: 'Views',
          data: data_2_2,
          backgroundColor: ChartColor[3],
          borderColor: ChartColor[2],
          borderWidth: 2
        }]
      };
    var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        layout: {
          padding: {
            left: 0,
            right: 10,
            top: 0,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            display: false,
            ticks: {
              fontColor: '#bfccda',
              min: 0,
              max: parseFloat(weekMax),
              stepSize: parseFloat(week_stepSize),
              autoSkip: true,
              autoSkipPadding: 15,
              maxRotation: 0,
              maxTicksLimit: 10
            },
            gridLines: {
              color: 'transparent',
              display: true,
              drawBorder: false,
              zeroLineColor: '#eeeeee'
            }
          }],
          yAxes: [{
            display: true,
            ticks: {
              fontColor: 'blue',
              min: 0,
              max: parseFloat(weekMax),
              stepSize: parseFloat(week_stepSize),
              display: true,
              autoSkip: false,
              maxRotation: 0
            },
            gridLines: {
              color: '#e2e6ec',
              display: true,
              drawBorder: false
            }
          }]
        },
        legend: {
          display: false
        },
        legendCallback: function (chart) {
          var text = [];
          text.push('<div class="chartjs-legend"><ul>');
          for (var i = 0; i < chart.data.datasets.length; i++) {
            text.push('<li>');
            text.push('<span style="border: '+ chart.data.datasets[i].borderWidth +'px solid; border-color: '+ chart.data.datasets[i].borderColor +';border-radius:0px;background-color:' + chart.data.datasets[i].backgroundColor + '">' + '</span>');
            text.push(chart.data.datasets[i].label);
            text.push('</li>');
          }
          text.push('</ul></div>');
          return text.join("");
        },
        elements: {
          point: {
            radius: 0
          }
        }
    };
    var salesChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: barChart,
      options: areaOptions
    });
    document.getElementById('view-statistics-legend').innerHTML = salesChart.generateLegend();
    $("#view-statistics_switch_1").click(function () {
      // Week
      var data = salesChart.data;
      data.datasets[0].data = data_2_2;
      data.labels = dataValues.week[1];
      var options = salesChart.options;
      options.scales.yAxes[0].ticks.max = parseFloat(weekMax);
      options.scales.yAxes[0].ticks.stepSize = parseFloat(week_stepSize);
      salesChart.update();
    });
    $("#view-statistics_switch_2").click(function () {
      // Month
      var data = salesChart.data;
      data.datasets[0].data = data_3_2;
      data.labels = dataValues.month[1];
      var options = salesChart.options;
      options.scales.yAxes[0].ticks.max = parseFloat(monthMax);
      options.scales.yAxes[0].ticks.stepSize = parseFloat(month_stepSize);
      salesChart.update();
    });
    $("#view-statistics_switch_3").click(function () {
      // Year
      var data = salesChart.data;
      data.datasets[0].data = data_4_2;
      data.labels = dataValues.year[1];
      var options = salesChart.options;
      options.scales.yAxes[0].ticks.max = parseFloat(yearMax);
      options.scales.yAxes[0].ticks.stepSize = parseFloat(year_stepSize);
      salesChart.update();
    });
  }
}
// end Chart Values Function View

/* 2nd Chart Function */

// Chart Values Function Blog
function BlogChartFunction (dataValues){
  // GET Array
  // GET MAX
  // week
  var weekMax = getMax_jsonArray(dataValues.week, 0);
  if(weekMax < 5){
    weekMax = 5
  }
  var week_stepSize = Math.round(weekMax / 5);
  // month
  var monthMax = getMax_jsonArray(dataValues.month, 0);
  if(monthMax < 5){
    monthMax = 5
  }
  var month_stepSize = Math.round(monthMax / 5);
  // year
  var yearMax = getMax_jsonArray(dataValues.year, 0);
  if(yearMax < 5){
    yearMax = 5
  }
  var year_stepSize = Math.round(yearMax / 5);
  // end GET MAX
  // end GET Array
  if ($("#BlogChart").length) {
    var barChartCanvas = $("#BlogChart").get(0).getContext("2d");
    var data_2_2 = dataValues.week[0];
    var data_3_2 = dataValues.month[0];
    var data_4_2 = dataValues.year[0];
    var barChart = {
        labels: dataValues.week[1],
        datasets: [{
          label: 'Blogs',
          data: data_2_2,
          backgroundColor: ChartColor[5],
          borderColor: ChartColor[0],
          borderWidth: 2
        }]
      };
    var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        layout: {
          padding: {
            left: 0,
            right: 10,
            top: 0,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            display: false,
            ticks: {
              fontColor: '#bfccda',
              min: 0,
              max: parseFloat(weekMax),
              stepSize: parseFloat(week_stepSize),
              autoSkip: true,
              autoSkipPadding: 15,
              maxRotation: 0,
              maxTicksLimit: 10
            },
            gridLines: {
              color: 'transparent',
              display: true,
              drawBorder: false,
              zeroLineColor: '#eeeeee'
            }
          }],
          yAxes: [{
            display: true,
            ticks: {
              fontColor: 'blue',
              min: 0,
              max: parseFloat(weekMax),
              stepSize: parseFloat(week_stepSize),
              display: true,
              autoSkip: false,
              maxRotation: 0
            },
            gridLines: {
              color: '#e2e6ec',
              display: true,
              drawBorder: false
            }
          }]
        },
        legend: {
          display: false
        },
        legendCallback: function (chart) {
          var text = [];
          text.push('<div class="chartjs-legend"><ul>');
          for (var i = 0; i < chart.data.datasets.length; i++) {
            text.push('<li>');
            text.push('<span style="border: '+ chart.data.datasets[i].borderWidth +'px solid; border-color: '+ chart.data.datasets[i].borderColor +';border-radius:0px;background-color:' + chart.data.datasets[i].backgroundColor + '">' + '</span>');
            text.push(chart.data.datasets[i].label);
            text.push('</li>');
          }
          text.push('</ul></div>');
          return text.join("");
        },
        elements: {
          point: {
            radius: 0
          }
        }
    };
    var salesChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: barChart,
      options: areaOptions
    });
    document.getElementById('blog-statistics-legend').innerHTML = salesChart.generateLegend();
    $("#blog-statistics_switch_1").click(function () {
      // Week
      var data = salesChart.data;
      data.datasets[0].data = data_2_2;
      data.labels = dataValues.week[1];
      var options = salesChart.options;
      options.scales.yAxes[0].ticks.max = parseFloat(weekMax);
      options.scales.yAxes[0].ticks.stepSize = parseFloat(week_stepSize);
      salesChart.update();
    });
    $("#blog-statistics_switch_2").click(function () {
      // Month
      var data = salesChart.data;
      data.datasets[0].data = data_3_2;
      data.labels = dataValues.month[1];
      var options = salesChart.options;
      options.scales.yAxes[0].ticks.max = parseFloat(monthMax);
      options.scales.yAxes[0].ticks.stepSize = parseFloat(month_stepSize);
      salesChart.update();
    });
    $("#blog-statistics_switch_3").click(function () {
      // Year
      var data = salesChart.data;
      data.datasets[0].data = data_4_2;
      data.labels = dataValues.year[1];
      var options = salesChart.options;
      options.scales.yAxes[0].ticks.max = parseFloat(yearMax);
      options.scales.yAxes[0].ticks.stepSize = parseFloat(year_stepSize);
      salesChart.update();
    });
  }
}
// end Chart Values Function Blog

/* Get Function */
GetDateValues();
/* end Get Function */
