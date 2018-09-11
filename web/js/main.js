$(document).ready(function () {
    console.log("ready!");
    cnahgeStatus();
});

function cnahgeStatus() {
    $(".status").click(function () {

            var elem = $(this).attr('id');
            console.log($('#' + elem));
            if ($('#' + elem).attr("checked") == 'checked') {
                console.log($(this).attr('id'));
                var elem = $(this).attr('id');

                // отправляем AJAX запрос
                $.ajax(
                    {
                        type: "POST",
                        url: "index.php?r=event%2Fupdate&id=" + elem,
                        data: "",
                        success: function (response) {
                            if (response == "OK") {
                                alert("Товар " + article_title + " добавлен!");
                                location.reload();
                            }
                            else
                                alert("Ошибка в запросе! Сервер вернул вот что: " + response);
                        }
                    }
                );

            }
        }
    );
}