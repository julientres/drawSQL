$(document).ready(function () {

    var nb_select = 0;
    var nb_from = 0;
    var nb_where = 0;
    var nb_join = 0;
    var nb_subQuery = 0;
    var nb_links = 0;


    var idFormSelect = new Array();
    var idFormFrom = new Array();
    var idFormWhere = new Array();
    var idFormJoin = new Array();

    var coefZoom = 1.0;
    var forms = new Array();
    var links = new Array();

    $('.draggable').css('border', '3px dashed transparent');
    $('.drop-form').css('border', '3px dashed transparent');

    $('#clear').click(function () {
        clearGrid();
    });

    $('#delete').click(function (event) {
        deleteElement();
    });

    $(".alert-success").show("slow").delay(2000).hide("slow");

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    });

    //SVG JS
    if (!SVG.supported) {
        alert('SVG not supported');
    }

    $('#where2').on('change', function () {
        if ($(this).find(":selected").text() == "BETWEEN") {
            $('#divBetween').show();
            $('#where3').show();
            $('#where3').val(null);
            $('#where4').val(null);
        } else if ($(this).find(":selected").text() == "IS NULL" || $(this).find(":selected").text() == "IS NOT NULL") {
            $('#divBetween').hide();
            $('#where3').hide();
            $('#where3').val(null);
            $('#where4').val(null);
        } else {
            $('#divBetween').hide();
            $('#where3').show();
            $('#where3').val(null);
            $('#where4').val(null);
        }
    });


    //Clic sur le bouton Ajout '+' d'une forme
    interact('.add-button').on('tap', function (event) {
        var type = $(event.target).parent().closest('div').attr('data-type');
        var id = $(event.target).parent().closest('div').attr('id');
        if (type == 'select') {
            var dataSelect = "select=" + id;
            ajaxPost(dataSelect, function (data) {
                console.log(data);
                if (data.column == null) {
                    $('#inputSelectId').val(data.id);
                    $('#table #optGroupSelect option').each(function () {
                        $(this).prop("selected", false);
                    });
                    $("#divSelect input:checkbox").each(function () {
                        $(this).prop("checked", false);
                    });
                } else {
                    $("#divSelect input:checkbox").each(function () {
                        $('#inputSelectId').val(data.id);
                        if (data.column === $(this).val()) {
                            $(this).prop("checked", true);
                        }
                    });
                    $('#table #optGroupSelect option').each(function () {
                        if (data.table === $(this).val()) {
                            $(this).prop("selected", true);
                        }
                    });
                }
                $('#modalSelect').modal('show');
            });
            var table = "table=true";
            var html = "";
            ajaxPost(table, function (data) {
                console.log(data);
                html = '<option value="null"></option>';
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[1][i] + '">' + data[0][i] + '</option>';
                }
                $('#optGroupSelect').html(html);
            });
        } else if (type == 'from') {
            var dataFrom = "from=" + id;
            ajaxPost(dataFrom, function (data) {
                if (data.table == null) {
                    $('#inputFromId').val(data.id);
                    $("#from option").each(function () {
                        $(this).prop("selected", false);
                    });
                } else {
                    $("#from option").each(function () {
                        $('#inputFromId').val(data.id);
                        if (data.table == $(this).val()) {
                            $(this).prop("selected", true);
                        }
                    });
                }
                $('#modalFrom').modal('show');
            });
        } else if (type == 'where') {
            var dataWhere = "where=" + id;
            ajaxPost(dataWhere, function (data) {
                if (data.table == null) {
                    $('#inputWhereId').val(data.id);
                    $('#table2 #optGroupTable option').each(function () {
                        $(this).prop("selected", false);
                    });
                    $("#where1 #optGroupColonne option").each(function () {
                        $(this).prop("selected", false);
                    });
                    $('#where2 #optGroupOper option').each(function () {
                        $(this).prop("selected", false);
                    });
                    $('#where3').val("");
                    $('#where4').val("");
                } else {
                    $('#inputWhereId').val(data.id);
                    $('#table2 #optGroupTable option').each(function () {
                        if (data.table == $(this).text()) {
                            $(this).prop("selected", true);
                        }
                    });
                    $("#where1 #optGroupColonne option").each(function () {
                        if (data.column == $(this).val()) {
                            $(this).prop("selected", true);
                        }else{
                            $(this).prop("selected", false);
                        }
                    });
                    $('#where2 #optGroupOper option').each(function () {
                        if (data.operate == $(this).val()) {
                            $(this).prop("selected", true);
                        }else{
                            $(this).prop("selected", false);
                        }
                    });
                    $('#where3').val(data.value1);
                    $('#where4').val(data.value2);
                }
                $('#modalWhere').modal('show');
            });
            var table = "table2=true";
            var html = "";
            ajaxPost(table, function (data) {
                html = '<option value="null"></option>';
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i] + '">' + data[i] + '</option>';
                }
                $('#optGroupTable').html(html);
            });
        } else if (type == 'join') {
            $('#modalJoin').modal('show');
        }
        /*else if (type == 'subquery') {
            $('#modalJoin').modal('show');
        }*/
    });

    //Bouton enregistrement de la modal du Select
    $('#btdModalSelect').on('click', function () {
        var dataSelect = "select=";
        var column= "";

        var dataSelect = "";
        $("input[type='checkbox']:checked").each(
            function () {
                dataSelect += $(this).val();
                dataSelect += "%2C";
                if(column == ""){
                    column += $(this).val();
                }else{
                    column += ', '+$(this).val();
                }
            });

        var str = dataSelect.substring(0, dataSelect.length - 3);
        ajaxGet(str, $('#modalSelect').modal('hide'));
        
        $('#select1 > .select-column').remove(); 
        $('#select1 > .function').remove(); 
        $('#select1').append('<p class="select-column">'+column+'</p>');

        for(i = 0; i < $("#function_select > input").length; i++){
            label = $('#function_select label:eq('+i+')').text();
            input = $('#function_select input:eq('+i+')').val();
            console.log(label);
            console.log(input);
            $('#select1').append('<div class="function function_'+i+'"></div>');
            if(i == 0){
                $('.function_'+i+'').append('<span class="function-name first">'+label+'</span>');
                $('.function_'+i+'').append('<span class="function-value first">'+input+'</span>');
            }else if(i == 1){
                $('.function_'+i+'').append('<span class="function-name second">'+label+'</span>');
                $('.function_'+i+'').append('<span class="function-value second">'+input+'</span>');
            }else if(i == 2){
                $('.function_'+i+'').append('<span class="function-name third">'+label+'</span>');
                $('.function_'+i+'').append('<span class="function-value third">'+input+'</span>');
            }else if(i == 3){
                $('.function_'+i+'').append('<span class="function-name fourth">'+label+'</span>');
                $('.function_'+i+'').append('<span class="function-value fourth">'+input+'</span>');
            }else if(i == 4){
                $('.function_'+i+'').append('<span class="function-name fifth">'+label+'</span>');
                $('.function_'+i+'').append('<span class="function-value fifth">'+input+'</span>');
            }
        }

        switch($("#function_select > input").length){
            case 0:
                $("#select1 > .img-form").remove();
                $("#select1").append('<img class="img-form"src="../asset/img/svg/Select_0.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $("#select1").css("width", "300px");
                $("#select1 > .add-button").css('left', '300px');
                break;
            case 1:
                $("#select1 > .img-form").remove();
                $("#select1").append('<img class="img-form"src="../asset/img/svg/Select_1.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $("#select1").css("width", "300px");
                $("#select1 > .add-button").css('left', '300px');
                break;
            case 2:
                $("#select1 > .img-form").remove();
                $("#select1").append('<img class="img-form"src="../asset/img/svg/Select_2.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $("#select1 > .img-form").css("width", "300px");
                $("#select1 > .add-button").css('left', '300px');
                break;
            case 3:
                $("#select1 > .img-form").remove();
                $("#select1").append('<img class="img-form"src="../asset/img/svg/Select_3.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $("#select1 > .img-form").css("width", "300px");
                $("#select1 > .add-button").css('left', '300px');
                break;
            case 4:
                $("#select1 > .img-form").remove();
                $("#select1").append('<img class="img-form"src="../asset/img/svg/Select_4.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $("#select1 > .img-form").css("width", "300px");
                $("#select1 > .add-button").css('left', '300px');
                break;
            case 5:
                $("#select1 > .img-form").remove();
                $("#select1").append('<img class="img-form"src="../asset/img/svg/Select_5.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $("#select1 > .img-form").css("width", "300px");
                $("#select1 > .add-button").css('left', '300px');
                break;
        }
    });
        var column = dataSelect.substring(0, dataSelect.length - 3);
        var id = $('#inputSelectId').val();
        var table = $('#table').find(":selected").val();
        var dataSelectColumn = {"selectGenerer": column, "id": id, "table": table};
        ajaxGet(dataSelectColumn, $('#modalSelect').modal('hide'));

        var x_1 = 0;
        var y_1 = 0;
        var x_2 = 0;
        var y_2 = 0;
        var id_premier;
        var id_second;


        if (x_1 == 0 && y_1 == 0) {

            var select = "#" + id;
            var target1 = $(select);
            x = (parseFloat(target1.attr("data-x")) || 0);
            y = (parseFloat(target1.attr('data-y')) || 0);
            x_1 = x + ((parseFloat(target1[0].offsetWidth)) / 2);
            y_1 = y + ((parseFloat(target1[0].offsetHeight)) / 2);
            id_premier = $(target1).attr('id');

            var table = '#' + $('#table').find(":selected").val();
            target2 = $(table);
            x2 = (parseFloat(target2.attr('data-x')) || 0);
            y2 = (parseFloat(target2.attr('data-y')) || 0);
            x_2 = x2 + ((parseFloat(target2[0].offsetWidth)) / 2);
            y_2 = y2 + ((parseFloat(target2[0].offsetHeight)) / 2);
            id_second = $(target2).attr('id');


            var idLine = $('.line').attr("data-id");
            var test = id_premier + '-' +  id_second;
            if(idLine == test){
                var html = '#' + idLine;
                $(html).remove();
                $('#line-container').append('<svg id="' + id_premier + '-' + id_second + '" data-id="' + id_premier + '-' + id_second + '"  class="line" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');
            }else{
                $('#line-container').append('<svg id="' + id_premier + '-' + id_second + '" data-id="' + id_premier + '-' + id_second + '"  class="line" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');
            }
            nb_links++;
            links[nb_links] = {
                forme1: id_premier,
                forme2: id_second
            };
    //Bouton enregistrement de la modal du Where
    $('#btdModalWhere').on('click', function () {
        dataWhere = "";
        condition = "";
        where1 = $('#modalWhere #where1').find(":selected").text();
        where2 = $('#where2').find(":selected").text();
        where3 = $('#where3').val();
        if ($('#modalWhere #where1').find(":selected").text() != "" && $('#where2').find(":selected").text() != "" && $('#where3').val() != "") {
            dataWhere += "where1=" + $('#modalWhere #where1').find(":checked").text();
            dataWhere += "&where2=" + $('#where2').find(":checked").text();
            dataWhere += "&where3=" + $('#where3').val();
            condition = $('#modalWhere #where1').find(":checked").text()+' '+
                $('#where2').find(":checked").text()+' '+$('#where3').val();
            $("#where1 > .img-form").remove();
            $("#where1").append('<img class="img-form"src="../asset/img/svg/Where_b.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
            $("#where1").css("width", "250px");
            $("#where1").css("height", "100px");
            $("#where1 > .add-button").css('left', '250px');
        }
        if ($('#where4').val() != "") {
            dataWhere += "&where4=" + $('#where4').val();
        }
        if ($('#where2').val() == "IS NULL" || $('#where2').val() == "IS NOT NULL") {
            dataWhere += "where1=" + $('#modalWhere #where1').find(":checked").text();
            dataWhere += "&where2=" + $('#where2').find(":checked").text();
        }
        console.log(dataWhere);
        ajaxGet(dataWhere, $('#modalWhere').modal('hide'));
        $('#where1 > .where-condition').remove(); 
        $('#where1').append('<p class="where-condition">'+condition+'</p>');
    });


    $('#table').on('change', function () {
        //$('#modalWhere #optGroup').html('<option value="null"></option>');
        $('#divSelect').html('<div class="form-check">' +
            '<label class="form-check-label">' +
            '<input class="form-check-input" type="checkbox" name="select" value="*">' +
            '*</label></div>');
        //$('#join3').html('<option value="null"></option>');
        var dataForm = "fromInput=" + $('#table').find(":selected").text();
        ajaxPost(dataForm, function (data) {
            for (var i = 0; i < data.length; i++) {
                //$('#modalWhere #optGroup').append('<option value="' + data[i].name + '">' + data[i].name + '</option>');
                $('#divSelect').append('<div class="form-check">' +
                    '<label class="form-check-label">' +
                    '<input class="form-check-input" type="checkbox" name="select" value="' + data[i].name + '"> ' +
                    data[i].name + '</label></div>');
                //$('#join3').append('<option value="' + data[i].name + '">' + data[i].name + '</option>');
            }
        });
    });


    //Bouton enregistrement de la modal du From
    $('#btdModalFrom').on('click', function () {
        var table = $('#from').find(":selected").text();
        var id = $('#inputFromId').val();
        var dataFromTable = {"fromGenerer": table, "id": id};

        var dataFromTable = "from=" + $('#from').find(":selected").text() + "";
        ajaxGet(dataFromTable, $('#modalFrom').modal('hide'));
        $('#from1 > .from-table').remove(); 
        $('#from1').append('<span class="from-table">'+$('#from').find(":selected").text()+'</span>');
    });

    //Bouton enregistrement de la modal du Join
    $('#btdModalJoin').on('click', function () {
        var dataJoin = "join=";
        dataJoin += $('#modalJoin #join1').find(':selected').text() + ",";
        dataJoin += $('#join2').find(':selected').val() + ",";
        dataJoin += $('#join3').find(':selected').val() + ",";
        dataJoin += $('#join4').find(':selected').val();
        ajaxGet(dataJoin, $('#modalJoin').modal('hide'));
        console.log(dataJoin);
        $('#join1 > .join-tables').remove(); 
        $('#join1').append('<div class="join-tables"></div>'); 
        $('#join1 > .join-tables').append('<span class="first-join">'+$('#join3').find(':selected').val()+'</span>');
        $('#join1 > .join-tables').append('<span class="second-join">'+$('#join4').find(':selected').val()+'</span>');
    //Bouton enregistrement de la modal du Where
    $('#btdModalWhere').on('click', function () {
        var table = $('#table2').find(":selected").text();
        var column = $('#modalWhere #where1').find(":selected").text();
        var operate = $('#where2').find(":selected").text();
        var value1 = $('#where3').val();
        var value2 = $('#where4').val();
        var id = $('#inputWhereId').val();
        if (column != null && operate != null && value1 != null) {
            var dataWhere = {
                "whereGenerer": table,
                "id": id,
                "columnWhere": column,
                "operate": operate,
                "value1": value1,
                "value2": value2
            };
            ajaxGet(dataWhere, $('#modalWhere').modal('hide'));
        }
    });

    $('#table2').on('change', function () {
        $('#optGroupColonne').html('<option value="null"></option>');
        var dataForm = "fromInput=" + $('#table2').find(":selected").val();
        ajaxPost(dataForm, function (data) {
            console.log(data)
            for (var i = 0; i < data.length; i++) {
                $('#optGroupColonne').append('<option value="' + data[i].name + '">' + data[i].name + '</option>');
            }
        });
    });

    //Bouton enregistrement de la modal du Join
    /* $('#btdModalJoin').on('click', function () {
         var dataJoin = "join=";
         dataJoin += $('#modalJoin #join1').find(':selected').text() + ",";
         dataJoin += $('#join2').find(':selected').val() + ",";
         dataJoin += $('#join3').find(':selected').val() + ",";
         dataJoin += $('#join4').find(':selected').val();
         ajaxGet(dataJoin, $('#modalJoin').modal('hide'));
     });
     */

    //Au changement de la table de la jointure --> on affiche les colonnes
    /*$('#join2').on('change', function () {
        $('#join4').html('<option value="null"></option>');
        var dataJoin = "joinInput=" + $('#join2').find(":selected").val();
        $.ajax({
            url: "../asset/php/createClass.php",
            type: 'POST',
            data: dataJoin,
            success: function (data) {
                data = JSON.parse(data);
                for (var i = 0; i < data.length; i++) {
                    $('#join4').append('<option value="' + data[i] + '">' + data[i] + '</option>');
                    $('#where1').append('<option value="' + data[i] + '">' + data[i] + '</option>');
                }
            },
            error: function (data) {
                console.log("erreur");
            }
        });
    })*/

    //Au changement du from récupére le nom des colonnes
    $('#from').on('change', function () {
        $('#modalWhere #optGroup').html('<option value="null"></option>');
        $('#divSelect').html('<div class="form-check">' +
            '<label class="form-check-label">' +
            '<input class="form-check-input" type="checkbox" name="select" value="*">'+
            '*</label></div>');
        $('#join3').html('<option value="null"></option>');
        var dataForm = "fromInput=" + $('#from').find(":selected").val();
        ajaxPost(dataForm, function (data) {
            for (var i = 0; i < data.length; i++) {
                $('#modalWhere #optGroup').append('<option value="' + data[i].name + '">' + data[i].name + '</option>');
                $('#divSelect').append('<div class="form-check">' +
                    '<label class="form-check-label">' +
                    '<input class="form-check-input" type="checkbox" name="select" value="' + data[i].name + '"> ' +
                    data[i].name + '</label></div>');
                $('#join3').append('<option value="' + data[i].name + '">' + data[i].name + '</option>');
            }
        });
    });*/


    $('#min').on("click", function(){
        if($("#function_select > input").length < 5){
            $("#function_select").append('<label for="min">MIN </label>'+
            '<input class="form-control function-form" type="text"></input>');
        }
    });

    $('#max').on("click", function(){
        if($("#function_select > input").length < 5){
            $("#function_select").append('<label for="max">MAX </label>'+
            '<input class="form-control function-form" type="text"></input>');
        }
    });

    $('#count').on("click", function(){
        if($("#function_select > input").length < 5){
            $("#function_select").append('<label  for="count">COUNT </label>'+
            '<input class="form-control function-form" type="text"></input>');
        }
    });

    $('#avg').on("click", function(){
        if($("#function_select > input").length < 5){
            $("#function_select").append('<label for="avg">AVG </label>'+
            '<input class="form-control function-form" type="text"></input>');
        }
    });

    $('#sum').on("click", function(){
        if($("#function_select > input").length < 5){
            $("#function_select").append('<label for="sum">SUM </label>'+
            '<input class="form-control function-form" type="text"></input>');
        }
    });

    $('#having').on("click", function(){
        if($("#function_select > input").length < 5){
            $("#function_select").append('<label for="having">HAVING </label>'+
            '<input class="form-control function-form" type="text"></input>');
        }
    });

    $('#groupby').on("click", function(){
        if($("#function_select > input").length < 5){
            $("#function_select").append('<label for="groupby">GROUPBY </label>'+
            '<input class="form-control function-form" type="text"></input>');
        }
    });

    $('#orderby').on("click", function(){
        if($("#function_select > input").length < 5){
            $("#function_select").append('<label  for="orderby">ORDERBY </label>'+
            '<input class="form-control function-form" type="text"></input>');
        }
    });


    //Bouton pour afficher la requête SQL
    $('#btdGenerer').on('click', function () {
        var dataModal = "modal=true";
        ajaxPost(dataModal, function (data) {
            var selectText = data.select;
            var fromText = data.from;
            if (data.where != null) {
                var whereText = data.where;
                $('#codeWhere').html(whereText);
            }
            if (data.join != null) {
                $('#divCodeJoin').show();
                var joinText = data.join;
                $('#codeJoin').html(joinText);
            }
            $('#codeSelect').html(selectText);
            $('#codeFrom').html(fromText);
            $('#generateCodeModal').modal('show');
        });
    });

    //Bouton qui va envoyé l'execution de la requete pour nous rediriger vers la page de résultat
    $('#btdSql').on('click', function () {
        var dataGenerer = "generer=true";
        ajaxGet(dataGenerer, window.location.replace("./display-results.php"));
    });


    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="1"]').on("click", function (event) {
        nb_select++;
        var dataSelect = "select=select" + nb_select;
        var nom = "select" + nb_select;
        idFormSelect.push(nom);
        console.log(idFormSelect);
        ajaxGet(dataSelect,
            $('#drawing').append('<div id="select' + nb_select + '" data-click="false" class="form draggable tap-target" data-type="select"><img class="img-form" src="../asset/img/svg/Select.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true"></div>'),
            forms['select' + nb_select] = {
                'x': 0,
                'y': 0,
                'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
                'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
            },
            $('#select' + nb_select).append('<button class="add-button" style="left:53px; top:18px"><span class="fas fa-plus add-icon"></span></button>')
        );
        });
            }
                nb_select++;
        $("div[data-type='select']").each(function() {
            if($(this).attr('id') == id) {
        var id = "select"+nb_select;
    });

    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="2"]').on("click", function (event) {
        nb_from++;
            if($(this).attr('id') == id) {
        $("div[data-type='from']").each(function() {
        var id = "from"+nb_from;
                nb_from++;
            }
        });
        var dataFrom = "from=from" + nb_from;
        var nom = "from" + nb_from;
        idFormFrom.push(nom);
        ajaxGet(dataFrom,
            $('#drawing').append('<div id="from' + nb_from + '" data-click="false" class="form draggable tap-target" data-type="from"><img class="img-form"src="../asset/img/svg/From.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true"></div>'),
            forms['from' + nb_from] = {
                'x': 0,
                'y': 0,
                'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
                'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
            },
            $('#from' + nb_from).append('<button class="add-button" style="left:53px; top: 53px"><span class="fas fa-plus add-icon"></span></button>')
        );
    });
    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="3"]').on("click", function (event) {
        nb_where++;
        var id = "where"+nb_where;
        $("div[data-type='where']").each(function() {
            if($(this).attr('id') == id) {
                nb_where++;
        });
            }
        var dataWhere = "where=where" + nb_where;
        var nom = "where" + nb_from;
        idFormWhere.push(nom);
        ajaxGet(dataWhere,
            $('#drawing').append('<div id="where' + nb_where + '" data-click="false" class="form draggable tap-target" data-type="where"><img class="img-form" src="../asset/img/svg/Where.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true"></div>'),
            forms['where' + nb_where] = {
                'x': 0,
                'y': 0,
                'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
                'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
            },
            $('#where' + nb_where).append('<button class="add-button" style="left:53px; top:18px"><span class="fas fa-plus add-icon"></span></button>')
        );
    });

    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="4"]').on("click", function (event) {
        nb_join++;
        var dataJoin = "join=join" + nb_join;
        var nom = "join" + nb_join;
        idFormJoin.push(nom);
        ajaxGet(dataJoin,
            $('#drawing').append('<div id="join' + nb_join + '" data-click="false" class="form draggable tap-target" data-type="join"><img class="img-form" src="../asset/img/svg/Join.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true"></div>'),
        });
            }
                nb_join++;
            if($(this).attr('id') == id) {
        $("div[data-type='join']").each(function() {
        var id = "join"+nb_join;
        forms['join' + nb_join] = {
            'x': 0,
            'y': 0,
            'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
            'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
        },
        $('#join' + nb_join).append('<button class="add-button" style="left:6px; top:17px"><span class="fas fa-plus add-icon"></span></button>')
    );

    });

    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="5"]').on("click", function (event) {
        nb_subQuery++;

        var id = "subQuery"+nb_subQuery;
        $("div[data-type='subQuery']").each(function() {
            if($(this).attr('id') == id) {
                nb_subQuery++;
            }
        });

        $('#drawing').append('<div id="subQuery' + nb_subQuery + '" data-click="false" class="form draggable tap-target drop-form drop-form" data-type="subQuery" style="width:450px"><img class="img-form" src="../asset/img/svg/SubQuery.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true"></div>');
        forms['subQuery' + nb_subQuery] = {
            'x': 0,
            'y': 0,
            'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
            'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
        };
    });

    interact('.drop-form').dropzone({
      // only accept elements matching this CSS selector
      accept: '.accept-drop',
      // Require a 75% element overlap for a drop to be possible
      overlap: 0.75,

      // listen for drop related events:

      ondropactivate: function (event) {
        $(event.target).addClass('drop-active');
      },
      ondragenter: function (event) {
        $(event.relatedTarget).addClass('can-drop');
      },
      ondragleave: function (event) {
        $(event.relatedTarget).removeClass('can-drop');
      },
      ondrop: function (event) {
        $(event.target).append($(event.relatedTarget));
        if($(event.relatedTarget).attr('is-child') == undefined) {
            $(event.relatedTarget).css({
                position: 'absolute',
                top: 0,
                left: 0,
                transform: 'none'
            });
            $(event.relatedTarget).attr('data-x', '0');
            $(event.relatedTarget).attr('data-y', '0');
            $(event.relatedTarget).attr('is-child', true);
            $(event.relatedTarget).attr('data-click', "false");
        } else {
            $(event.relatedTarget).attr('data-click', "false");
        }
      },
      ondropdeactivate: function (event) {
        $(event.target).removeClass('drop-active');
        $(event.relatedTarget).removeClass('can-drop');
      }
    });

    //Créer les liens entre formes
    /* $('#link').on("click", function (event) {
         var x_1 = 0;
         var y_1 = 0;
         var x_2 = 0;
         var y_2 = 0;
         var id_premier;
         var id_second;
         var form1;
         var form2;
         $('#link').data('processing', true);
         interact('.tap-target')
             .on('tap', function (event) {

                 if ($('#link').data('processing') == true) {
                     if (x_1 == 0 & y_1 == 0) {
                         var target = event.currentTarget,
                             x = (parseFloat(target.getAttribute('data-x')) || 0),
                             y = (parseFloat(target.getAttribute('data-y')) || 0);
                         x_1 = x + ((parseFloat(target.offsetWidth)) / 2);
                         y_1 = y + ((parseFloat(target.offsetHeight)) / 2);
                         id_premier = $(target).attr('id');
                         console.log('premier click');
                         console.log(id_premier);
                         //form1 = target.getAttribute('data-type');
                         //$('#drawing').append('<div class="point" style="left:'+x_1+'px; top:'+y_1+'px"></div>');
                     } else {
                         target = event.currentTarget,
                             x = (parseFloat(target.getAttribute('data-x')) || 0),
                             y = (parseFloat(target.getAttribute('data-y')) || 0);
                         x_2 = x + ((parseFloat(target.offsetWidth)) / 2) - 5;
                         y_2 = y + ((parseFloat(target.offsetHeight)) / 2) - 5;
                         id_second = $(target).attr('id');
                         console.log('second click');
                         console.log(id_second);
                         //form2 = target.getAttribute('data-type');
                         //$('#drawing').append('<div class="point" style="left:'+x_2+'px; top:'+y_2+'px"></div>');
                         $('#line-container').append('<svg id="' + id_premier + '-' + id_second + '" class="line" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');
                         nb_links++;
                         links[nb_links] = {
                             forme1: id_premier,
                             forme2: id_second
                         };

                         //console.log(form1);
                         //console.log(form2);

                         $('#link').data('processing', false);
                         interact('.tap-target').off("tap");
                     }
                 }
             });
     });
 */

    //Permettre le drag & drop de l'application
    interact('.draggable')
        .draggable({
            inertia: true,
            onend: function (event) {
                $(event.currentTarget).css('border', '3px dashed transparent');
                event.currentTarget.setAttribute('data-click', 'true');
            },
            onmove: function (event) {
                var target = event.currentTarget,
                    // keep the dragged position in the data-x/data-y attributes
                    x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
                    y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                // translate the element
                target.style.webkitTransform =
                    target.style.transform =
                        'translate(' + x + 'px, ' + y + 'px)';

                // Update the position attributes
                target.setAttribute('data-x', x);
                target.setAttribute('data-y', y);

                // On récupère l'ID de la forme qui est déplacé
                var id_forms = $(target).attr('id');
                // On modifie les coordonnées de la forme qui a été bougée
                forms[id_forms].x = x;
                forms[id_forms].y = y;
                forms[id_forms].x_center = x + ((parseFloat(event.target.offsetWidth)) / 2) + 3; // 3 sert à décaler à droite pour le JOIN
                forms[id_forms].y_center = y + ((parseFloat(event.target.offsetHeight)) / 2);

                if (links.length != 0) {
                    // On fait suivre les liens
                    for (var i = 1; i < links.length; i++) {
                        if (links[i].forme1 == id_forms) {
                            $('#' + id_forms + '-' + links[i].forme2 + '').find('line').attr('x1', forms[id_forms].x_center);
                            $('#' + id_forms + '-' + links[i].forme2 + '').find('line').attr('y1', forms[id_forms].y_center);
                        }
                        if (links[i].forme2 == id_forms) {
                            $('#' + links[i].forme1 + '-' + id_forms + '').find('line').attr('x2', forms[id_forms].x_center);
                            $('#' + links[i].forme1 + '-' + id_forms + '').find('line').attr('y2', forms[id_forms].y_center);
                        }
                    }
                }

                $('.draggable').each(function () {
                    if ($(this).attr('data-click') == 'true') {
                        $(this).css('border', '3px dashed transparent');
                        $(this).attr('data-click', 'false');
                    }
                });

                $(target).css('border', '3px dashed red');
            },
            restrict: {
                restriction: 'parent',
                elementRect: {top: 0, left: 0, bottom: 1, right: 1}
            }
        })

    $(document).on('click', '.draggable', function(event){
        event.stopImmediatePropagation();
        event.stopPropagation();
        var target = event.currentTarget,
            x = (parseFloat(target.getAttribute('data-x')) || 0),
            y = (parseFloat(target.getAttribute('data-y')) || 0);

        target.style.webkitTransform = target.style.transform =
            'translate(' + x + 'px,' + y + 'px)';

        if(target.getAttribute('data-click') == 'true') {
            $(target).css('border', '3px dashed transparent');
            target.setAttribute('data-click', 'false');
        }
        else {
            $('.draggable').each(function() {
                if($(this).attr('data-click') == 'true') {
                    $(this).css('border', '3px dashed transparent');
                    $(this).attr('data-click', 'false');
                }
            });

            target.setAttribute('data-click', 'true');
            $(target).css('border', '3px dashed red');
        }
    });

    $(document).keydown(function (event) {
        switch (event.which) {
            case 46://suppr => delete
                deleteElement();
                break;

            default:
                return; // exit this handler for other keys
        }
        event.preventDefault(); // prevent the default action (scroll / move caret)
    });
// Informations sur la forme au passage de la souris
    /*    $("#drawing")
            .on("mouseover", "img", function () {
                var hover = $(this).parent().attr("data-type");
                var current_element = $(this);
                $.ajax({
                    url: "../asset/php/createClass.php",
                    type: "POST",
                    data: "hover=" + hover,
                    success: function (data) {
                        if (data !== "") {
                            var local_data = JSON.parse(data);
                            if (hover == 'select') {
                                $(current_element).attr("data-content", '<b>SELECT</b><br>Colonne : ' + local_data.column + '<br>Table : ' + local_data.table);
                            } else if (hover == 'from') {
                                $(current_element).attr("data-content", '<b>FROM</b><br>Table : ' + local_data.table);
                            } else if (hover == 'where') {
                                $(current_element).attr("data-content", '<b>WHERE</b><br>' + local_data.column + ' ' + local_data.operate + ' ' + local_data.value);
                            }
                            $(current_element).popover('show');
                        }
                    },
                    error: function (data) {
                        alert("Erreur de création")
                    }
                });
            })
            .on("mouseleave", "img", function () {
                $(this).popover('hide');
            });
        })
        .on("mouseleave", "img", function () {
            $(this).popover('hide');
        });

    //drag grid
    var el = $('#drawing');
    interact('#drawing')
        .draggable({
            // enable inertial throwing
            inertia: true,
            // keep the element within the area of it's parent
            restrict: {
              restriction: el,
              endOnly: true,
              elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
            },
            // enable autoScroll
            autoScroll: true,
    */

            // call this function on every dragmove event
            onmove: function(event) {                  
                if(event.clientX <= $("#drawing").width() - 10 && event.clientY <= $("#drawing").height() - 10) {
                    $('.form').each(function(){
                        if($(this).attr('is-child') == undefined) { 
                            var x = (parseFloat($(this).attr('data-x')) || 0) + event.dx,
                            y = (parseFloat($(this).attr('data-y')) || 0) + event.dy;

                            if(x > 0 && y > 0) {
                                $(this).css('transform', 'translate(' + x + 'px, ' + y + 'px)');

                                $(this).attr('data-x', x);
                                $(this).attr('data-y', y);
                            }
                        }      
                    });
                }
            }
        })
        .on('click', function() {
            $('.draggable').each(function() {
                if($(this).attr('data-click') == 'true') {
                    $(this).css('border', '3px dashed transparent');
                    $(this).attr('data-click', 'false');
                }
            })
        })

    function clearGrid() {
        if(jQuery.isEmptyObject(forms)) {                      
            alert('Aucune formes détectées...');
        }
        else {
            if(confirm('Voulez vous supprimer toutes les formes présentes dans la zone de dessin ?')) {
                var arrayToDelete = {};
                $('.draggable').each(function(index) {
                    arrayToDelete[index] = $(this).attr('id');
                })

                var idDeleteForm = {'idDeleteForm':arrayToDelete}
                ajaxGet(idDeleteForm, function() {
                    $('.draggable').each(function() {
                        $(this).remove();
                    });

                    $('.line').each(function() {
                        $(this).remove();
                    });

                    nb_select = 0;
                    nb_from = 0;
                    nb_where = 0;
                    nb_join = 0;
                    nb_subQuery = 0;
                    nb_links = 0;
                    forms = [];
                    links = [];
                })                
            }  
        }        
    }

    function deleteElement() {
        var selectedForm = false;
        $('.draggable').each(function() {
            if($(this).attr('data-click') == 'true') {
                selectedForm = true;
            }
        })

        if(jQuery.isEmptyObject(forms)) {
            alert('Aucune forme sur la zone de dessin...');
        }  
        else if(!selectedForm) {
            alert('Aucune forme sélectionnée...');
        }   
        else {  
            $('.draggable').each(function() {
                if($(this).attr('data-click') == 'true') {
                    if($(this).attr('data-type') == 'subQuery') {
                        if(confirm('Voulez vous supprimer cette forme de la zone de dessin ? Cela supprimera aussi toutes les formes associées')) {                            
                            var id = $(this).attr('id');
                            var idDeleteForm = "idDeleteForm=" + id;
                            ajaxGet(idDeleteForm, function() {
                                $('.accept-drop').each(function() { 
                                    if($(this).parent(id)) {
                                        if($(this).attr('data-type') == 'select') {
                                            delete forms[$(this).attr('id')];
                                            nb_select--;
                                        }
                                        else if($(this).attr('data-type') == 'from') {
                                            delete forms[$(this).attr('id')];
                                            nb_from--;
                                        }
                                        else if($(this).attr('data-type') == 'where') {
                                            delete forms[$(this).attr('id')];
                                            nb_where--;
                                        }
                                        else if($(this).attr('data-type') == 'join') {
                                            delete forms[$(this).attr('id')];
                                            nb_join--;
                                        }
                                    }
                                })

                                nb_subQuery--;
                                delete forms[id];                
                                $(this).remove();

                                //delete links ?
                            })
                        }
                    }
                    else {
                        if(confirm('Voulez vous supprimer cette forme de la zone de dessin ?')) {
                            var idDeleteForm = "idDeleteForm=" + $(this).attr('id');
                            ajaxGet(idDeleteForm, function() {
                                if($(this).attr('data-type') == 'select')
                                    nb_select--;
                                else if($(this).attr('data-type') == 'from')
                                    nb_from--;
                                else if($(this).attr('data-type') == 'where')
                                    nb_where--;
                                else if($(this).attr('data-type') == 'join')
                                    nb_join--;

                                delete forms[$(this).attr('id')];
                                $(this).remove();

                                if (links.length != 0) {
                                    for (var i = 1; i < links.length; i++) {
                                        if (links[i].forme1 == $(this).attr('id') || links[i].forme2 == $(this).attr('id')) {
                                            $('#' + links[i].forme1 + '-' + links[i].forme2 + '').remove();
                                            nb_links--;
                                        }
                                    }                        
                                }
                            })                            
                        }
                    }
                }
            });
        }
    }
});