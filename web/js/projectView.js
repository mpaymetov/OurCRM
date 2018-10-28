
$(".status-item").click(function(e) {
    e.preventDefault();
    var stateName = $(this).attr('class');
    var par = $(this).parent();
    var setName = par.attr('class');
    var message = {
        "stateNameString": stateName,
        "setNameString": setName
    };
    $.post("index.php?r=serviceset%2Fchange-state", message, onProjectStateChange, "json");
});

function onProjectStateChange(response)
{
    if(response.success)
    {
        var set = 'status-bar-' + response.success.set;
        var arr = $("." + set).children();
        arr.each(function(i, elem) {
            if(i <= response.success.status) {
                $(this).addClass('btn-success');
                $(this).removeClass('btn-warning');
            } else {
                $(this).addClass('btn-warning');
                $(this).removeClass('btn-success');
            }
        });

        if (response.success.status < response.success.payment) {
            $("." + 'payment-' + response.success.set).html('Дата оплаты: --');
        }

        if (response.success.status < response.success.delivery) {
            $("." + 'delivery-' + response.success.set).html('Дата поставки: --');
        }

        if(response.success.payment_date) {
            $("." + 'payment-' + response.success.set).html('Дата оплаты: ' + response.success.payment_date);
        }

        if(response.success.delivery_date) {
            $("." + 'delivery-' + response.success.set).html('Дата поставки: ' + response.success.delivery_date);
        }
    }
}