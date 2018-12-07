$(document).ready(function () {
    //google.charts.load('current', {packages: ['corechart']});
    google.load("visualization", 1, {packages:["corechart"]});
});

$(".date-period-form").on('beforeSubmit', function(e) {
    var form = $(this);
    console.log($(this));
    var formData = form.serialize();
    console.log(formData);
    $.post("index.php?r=statistic%2Frender-chart-by-period", formData, onChartRender, "json");
    return false;
});

function onChartRender(response) {
    console.log(response);
    var containerId = response.type + "-num";
    var container = $("#" + containerId);
    var chartType;

    if(response.type == 'sale') {
        chartType = "LineChart";
    } else if (response.type == 'project') {
        chartType = "ColumnChart";
    }

    $(container).empty();
    google.setOnLoadCallback(drawChart(containerId, chartType, response.info));
}

function drawChart(containerId, chartType, info) {
    var data = google.visualization.arrayToDataTable(info);
    var options = {};
    var chart = new google.visualization[chartType](document.getElementById(containerId));
    chart.draw(data, options);
}


