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
    var container;

    if(response.type == 'project') {
        container = $("#project-num");
    }

    if(response.type == 'sale') {
        container = $("#sale-num");
    }




}


