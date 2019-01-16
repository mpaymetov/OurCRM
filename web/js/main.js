$(document).ready(function () {
    console.log("ready!");
    cnahgeStatus();
});

function cnahgeStatus() {
    $(".status").click(function () {
            var elem = $(this).attr('id');
            console.log(elem);
            //if ($('#' + elem).attr("checked") == 'checked') {
                $.ajax(
                    {
                        type: "POST",
                        url: "/api/events/" + elem,
                        success: function (response) {
                            if (response == "OK") {
                            }
                            else
                                alert("Ошибка в запросе! Сервер вернул вот что: " + response);
                        }
                    }
                );

           // }
        }
    );
}