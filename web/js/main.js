$(document).ready(function () {
    console.log("ready!");
    cnahgeStatus();
    getDate();
});

function cnahgeStatus() {
    $('body').on('click', '.status', function () {
            var elem = this.id;
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

function getDate() {
    $('body').on('click', '.datepicker_click', function () {
        $('.datepicker_click').addClass('datepicker-here');
        console.log('in get date');
    });
}