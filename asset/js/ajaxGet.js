function ajaxGet(data, condition) {
    $.ajax({
        url: "../asset/php/createClass.php",
        type: "GET",
        data: data,
        success: function (data) {
            if (data) {
                console.log(data);
                condition;
            }
        },
        error: function (data) {
            console.log("erreur" + data);
        }
    });
}

