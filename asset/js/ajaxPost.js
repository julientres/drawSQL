function ajaxPost(data, handleData) {
    return $.ajax({
        url: "../asset/php/createClass.php",
        type: "POST",
        data: data,
        success: function (res) {
            handleData(JSON.parse(res));
        },
        error: function (res) {
            console.log("erreur" + res);
        }
    });
}

