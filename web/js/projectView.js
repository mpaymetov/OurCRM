function currDate() {
    var date = new Date();
    var dd = date.getDate();
    if (dd < 10) {
        dd = '0' + dd;
    }
    var mm = date.getMonth() + 1;
    if (mm < 10) {
        mm = '0' + mm;
    }
    var yy = date.getFullYear();
    //alert(yy + '-' + mm + '-' + dd);
    return yy + '-' + mm + '-' + dd;
}

$("[name=close-project_form]").change(function() {
    console.log($(this).parent());
});