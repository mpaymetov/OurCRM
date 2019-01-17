$(document).ready(function () {
    console.log("ready!");
    cnahgeStatus();
});

function cnahgeStatus() {
    console.log("in change");
    $('body').on('click', '.status', function () {
        console.log("click!");
            var elem = this.id;
            console.log("click", elem);
            $.ajax(
                {
                    type: "PUT",
                    url: "/api/events/" + elem,
                    success: function (response) {
                        if (response == "OK") {
                        } else
                            alert("Ошибка в запросе! Сервер вернул вот что: " + response);
                    }
                }
            );
        }
    );
}