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

    var forms = new Array();
    var links = new Array();

    $('.draggable').css('border', '3px dashed transparent');
    $('.drop-form').css('border', '3px dashed transparent');

    $('#clear').click(function () {
        clearGrid();
    });

    $('#delete').click(function () {
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
                if (data.column == null) {
                    $('#inputSelectId').val(data.id);
                    $('#optGroupSelect option').each(function () {
                        $(this).prop("selected", false);
                    });
                    $("#divSelect input:checkbox").each(function () {
                        $(this).prop("checked", false);
                    });
                    $('#modalSelect').modal('show');
                } else {
                    $('#inputSelectId').val(data.id);
                    $("#divSelect input:checkbox").each(function () {
                        $('#inputSelectId').val(data.id);
                        if (data.column == $(this).val()) {
                            $(this).prop("checked", true);
                        }
                    });
                    $('#optGroupSelect option').each(function () {
                        if (data.table == $(this).val()) {
                            $(this).prop("selected", true);
                        }
                    });
                    $('#modalSelect').modal('show');
                }
            });
            var table = "table=true";
            var html = "";
            ajaxPost(table, function (data) {
                if (data == null) {

                } else {
                    html = '<option value="null"></option>';
                    for (var i = 0; i < data[0].length; i++) {
                        html += '<option value="' + data[1][i] + '">' + data[0][i] + '</option>';
                    }
                    $('#optGroupSelect').html(html);
                }
            });
        } else if (type == 'from') {
            var dataFrom = "from=" + id;
            ajaxPost(dataFrom, function (data) {
                if (data.table == null) {
                    $('#inputFromId').val(data.id);
                    $("#from option").each(function () {
                        $(this).prop("selected", false);
                    });
                    $('#modalFrom').modal('show');
                } else {
                    $("#from option").each(function () {
                        $('#inputFromId').val(data.id);
                        if (data.table == $(this).val()) {
                            $(this).prop("selected", true);
                        }
                    });
                    $('#modalFrom').modal('show');
                }

            });
        } else if (type == 'where') {
            var dataWhere = "where=" + id;
            ajaxPost(dataWhere, function (data) {
                console.log(data);
                if (data.table == null) {
                    $('#inputWhereId').val(data.id);
                    $('#inputFromForm').val(data.idFrom);
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
                    $('#inputFromForm').val(data.idFrom);
                    $('#table2 #optGroupTable option').each(function () {
                        if (data.table == $(this).text()) {
                            $(this).prop("selected", true);
                            $("#where1 #optGroupColonne option").each(function () {
                                if (data.column == $(this).val()) {
                                    $(this).prop("selected", true);
                                } else {
                                    $(this).prop("selected", false);
                                }
                            });
                        }
                    });

                    $('#where2 #optGroupOper option').each(function () {
                        if (data.operate == $(this).val()) {
                            $(this).prop("selected", true);
                        } else {
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
                console.log(data);
                if (data[0][0] == null) {
                } else {
                    html = '<option value="null"></option>';
                    for (var i = 0; i < data[0].length; i++) {
                        html += '<option value="' + data[1][i] + '">' + data[0][i] + '</option>';
                    }
                    $('#optGroupTable').html(html);
                }

            });
        } else if (type == 'join') {
            var dataJoin = "join=" + id;
            ajaxPost(dataJoin, function (data) {
                console.log(data);
                if (data.table == null) {
                    $('#inputJoinId').val(data.id);
                    $('#tableJoin1 #optGroupJoinTab1 option').each(function () {
                        $(this).prop("selected", false);
                    });
                    $('#tableJoin2 #optGroupJoinTab2 option').each(function () {
                        $(this).prop("selected", false);
                    });
                    $("#value1 #optGroupJoin1 option").each(function () {
                        $(this).prop("selected", false);
                    });
                    $("#value2 #optGroupJoin2 option").each(function () {
                        $(this).prop("selected", false);
                    });
                    $('#modalJoin').modal('show');
                } else {
                    console.log(data.table);
                    console.log(data.tableJoin);
                    $('#inputJoinId').val(data.id);
                    $('#tableJoin1 #optGroupJoinTab1 option').each(function () {
                        if (data.table == $(this).val()) {
                            $(this).prop("selected", true);
                        }
                    });
                    $('#tableJoin2 #optGroupJoinTab2 option').each(function () {
                        if (data.tableJoin == $(this).val()) {
                            $(this).prop("selected", true);
                        }
                    });
                    $("#value1 #optGroupJoin1 option").each(function () {
                        if (data.value1 == $(this).val()) {
                            $(this).prop("selected", true);
                        }
                    });
                    $("#value2 #optGroupJoin2 option").each(function () {
                        if (data.value2 == $(this).val()) {
                            $(this).prop("selected", true);
                        }
                    });
                    $('#modalJoin').modal('show');
                }
            });
            var table = "table3=true";
            var html = "";
            ajaxPost(table, function (data) {
                console.log(data);
                if (data[0][0] == null) {
                } else {
                    html = '<option value="null"></option>';
                    for (var i = 0; i < data[0].length; i++) {
                        html += '<option value="' + data[1][i] + '">' + data[0][i] + '</option>';
                    }
                    $('#optGroupJoinTab1').html(html);
                    $('#optGroupJoinTab2').html(html);
                }
            });
        }
    });

    //Bouton enregistrement de la modal du Select
    $('#btdModalSelect').on('click', function () {

        var dataSelect = "";
        $("input[type='checkbox']:checked").each(function () {
            dataSelect += $(this).val();
            dataSelect += ",";
        });

        var column = dataSelect.substring(0, dataSelect.length - 1);
        var id = $('#inputSelectId').val();
        var table = $('#table').find(":selected").val();
        var min = $('#selectMin').val();
        var max = $('#selectMax').val();
        var count = $('#selectCount').val();
        var avg = $('#selectAvg').val();
        var sum = $('#selectSum').val();
        var having =$('#selectHaving').val();
        var group = $('#selectGroup').val();
        var order = $('#selectOrdre').val();
        var dataSelectColumn = {"selectGenerer": column, "id": id, "table": table, "min":min,"max":max,"count":count,"avg":avg,"sum":sum,"having":having,"group":group,"order":order};

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

            var table2 = '#' + table;
            target2 = $(table2);
            x2 = (parseFloat(target2.attr('data-x')) || 0);
            y2 = (parseFloat(target2.attr('data-y')) || 0);
            x_2 = x2 + ((parseFloat(target2[0].offsetWidth)) / 2);
            y_2 = y2 + ((parseFloat(target2[0].offsetHeight)) / 2);
            id_second = $(target2).attr('id');


            var idLine = $('.line').attr("data-id");
            var test = id_premier + '-' + id_second;
            if (idLine == test) {
                var html = '#' + idLine;
                $(html).remove();
                $('#line-container').append('<svg id="' + id_premier + '-' + id_second + '" data-id="' + id_premier + '-' + id_second + '"  class="line" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');
            } else {
                $('#line-container').append('<svg id="' + id_premier + '-' + id_second + '" data-id="' + id_premier + '-' + id_second + '"  class="line" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');
            }
            nb_links++;
            links[nb_links] = {
                forme1: id_premier,
                forme2: id_second
            };
        }


        $(select + ' > .select-column').remove();
        $(select + ' > .function').remove();
        $(select).append('<p class="select-column">' + column + '</p>');

        for (i = 0; i < $("#function_select > input").length; i++) {
            label = $('#function_select label:eq(' + i + ')').text();
            input = $('#function_select input:eq(' + i + ')').val();
            console.log(label);
            console.log(input);
            $(select).append('<div class="function function_' + i + '"></div>');
            if (i == 0) {
                $('.function_' + i + '').append('<span class="function-name first">' + label + '</span>');
                $('.function_' + i + '').append('<span class="function-value first">' + input + '</span>');
            } else if (i == 1) {
                $('.function_' + i + '').append('<span class="function-name second">' + label + '</span>');
                $('.function_' + i + '').append('<span class="function-value second">' + input + '</span>');
            } else if (i == 2) {
                $('.function_' + i + '').append('<span class="function-name third">' + label + '</span>');
                $('.function_' + i + '').append('<span class="function-value third">' + input + '</span>');
            } else if (i == 3) {
                $('.function_' + i + '').append('<span class="function-name fourth">' + label + '</span>');
                $('.function_' + i + '').append('<span class="function-value fourth">' + input + '</span>');
            } else if (i == 4) {
                $('.function_' + i + '').append('<span class="function-name fifth">' + label + '</span>');
                $('.function_' + i + '').append('<span class="function-value fifth">' + input + '</span>');
            }
        }

        switch ($("#function_select > input").length) {
            case 0:
                $(select + " > .img-form").remove();
                $(select).append('<img class="img-form"src="../asset/img/svg/Select_0.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $(select).css("width", "300px");
                $(select + " > .add-button").css('left', '300px');
                break;
            case 1:
                $(select + " > .img-form").remove();
                $(select).append('<img class="img-form"src="../asset/img/svg/Select_1.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $(select).css("width", "300px");
                $(select + " > .add-button").css('left', '300px');
                break;
            case 2:
                $(select + " > .img-form").remove();
                $(select).append('<img class="img-form"src="../asset/img/svg/Select_2.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $(select + " > .img-form").css("width", "300px");
                $(select + " > .add-button").css('left', '300px');
                break;
            case 3:
                $(select + " > .img-form").remove();
                $(select).append('<img class="img-form"src="../asset/img/svg/Select_3.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $(select + " > .img-form").css("width", "300px");
                $(select + " > .add-button").css('left', '300px');
                break;
            case 4:
                $(select + " > .img-form").remove();
                $(select).append('<img class="img-form"src="../asset/img/svg/Select_4.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $(select + " > .img-form").css("width", "300px");
                $(select + " > .add-button").css('left', '300px');
                break;
            case 5:
                $(select + " > .img-form").remove();
                $(select).append('<img class="img-form"src="../asset/img/svg/Select_5.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                $(select + " > .img-form").css("width", "300px");
                $(select + " > .add-button").css('left', '300px');
                break;
        }


    });

    //Bouton enregistrement de la modal du Where
    $('#btdModalWhere').on('click', function () {
            var table = $('#table2').find(":selected").text();
            var idTable = $('#table2').find(":selected").val()
            var column = $('#modalWhere #where1').find(":selected").text();
            var operate = $('#modalWhere #where2').find(":selected").text();
            var value2 = $('#where4').val();
            var id = $('#inputWhereId').val();
            var value1 = $('#where3').val();
            var condition = column + " " + operate + " '" + value1 + "'";
            if (column != null && operate != null && value1 != null) {
                var dataWhere = {
                    "whereGenerer": table,
                    "id": id,
                    "operate": operate,
                    "value1": value1,
                    "value2": value2,
                    "columnWhere": column,
                    "idFrom": idTable
                };
                ajaxGet(dataWhere, $('#modalWhere').modal('hide'));
                console.log(dataWhere);
                var where = '#' + id;
                $(where + " > .img-form").remove();
                if (condition != null) {
                    $(where + ' > .where-condition').remove();
                    $(where).append('<p class="where-condition">' + condition + '</p>');
                }
                var heightp = $(where + ' > .where-condition').height();
                if(heightp <= 21){
                    $(where).append('<img class="img-form"src="../asset/img/svg/Where_1.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                    $(where).css("width", "250px");
                }else if(heightp <= 42){
                    $(where).append('<img class="img-form"src="../asset/img/svg/Where_2.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                    $(where).css("width", "250px");
                }else if(heightp <= 63){
                    $(where).append('<img class="img-form"src="../asset/img/svg/Where_3.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                    $(where).css("width", "250px");
                }else if(heightp <= 84){
                    $(where).append('<img class="img-form"src="../asset/img/svg/Where_4.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                    $(where).css("width", "250px");
                }else if(heightp <= 105){
                    $(where).append('<img class="img-form"src="../asset/img/svg/Where_5.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                    $(where).css("width", "250px");
                    $(where).append('<img class="img-form"src="../asset/img/svg/Where_6.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true">');
                }else{
                    $(where).css("width", "250px");
                }
                $(where + " > .add-button").css('left', '250px');

            }
            var x_1 = 0;
            var y_1 = 0;
            var y_2 = 0;
            var x_2 = 0;
            var id_second;
            var id_premier;

            if (x_1 == 0 && y_1 == 0) {
                var join = "#" + id;
                var target1 = $(join);
                x = (parseFloat(target1.attr("data-x")) || 0);
                y = (parseFloat(target1.attr('data-y')) || 0);
                y_1 = y + ((parseFloat(target1[0].offsetHeight)) / 2);
                x_1 = x + ((parseFloat(target1[0].offsetWidth)) / 2);
                id_premier = $(target1).attr('id');


                var forme = '#' + idTable;
                target2 = $(forme);
                y2 = (parseFloat(target2.attr('data-y')) || 0);
                x2 = (parseFloat(target2.attr('data-x')) || 0);
                x_2 = x2 + ((parseFloat(target2[0].offsetWidth)) / 2);
                y_2 = y2 + ((parseFloat(target2[0].offsetHeight)) / 2);
                id_second = $(target2).attr('id');

                $('#line-container').append('<svg id="' + id_premier + '-' + id_second + '" data-id="' + id_premier + '-' + id_second + '"  class="line" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');

                nb_links++;
                links[nb_links] = {
                    forme2: id_second,
                    forme1: id_premier
                };

            }
        }
    );


    $('#table').on('change', function () {
        var table = $('#table').find(":selected").text();
        if (table == null) {
            $('#boxCheckbox').html("");
        } else {
            var dataForm = "fromInput=" + $('#table').find(":selected").text();
            ajaxPost(dataForm, function (data) {
                if (data)
                    if (data[0] == "join") {
                        $('#boxCheckbox').html('<div class="form-check">' +
                            '<label class="form-check-label">' +
                            '<input class="form-check-input" type="checkbox" name="select" value="*">' +
                            '*</label></div>');
                        for (var i = 1; i < data.length; i++) {
                            $('#boxCheckbox').append('<div class="form-check">' +
                                '<label class="form-check-label">' +
                                '<input class="form-check-input" type="checkbox" name="select" value="' + data[i] + '"> ' +
                                data[i] + '</label></div>');
                        }
                    } else {
                        if (data[0].name != null) {
                            $('#boxCheckbox').html('<div class="form-check">' +
                                '<label class="form-check-label">' +
                                '<input class="form-check-input" type="checkbox" name="select" value="*">' +
                                '*</label></div>');
                            for (var i = 0; i < data.length; i++) {
                                $('#boxCheckbox').append('<div class="form-check">' +
                                    '<label class="form-check-label">' +
                                    '<input class="form-check-input" type="checkbox" name="select" value="' + data[i].name + '"> ' +
                                    data[i].name + '</label></div>');
                            }
                        }
                    }

            });
        }
    });


    //Bouton enregistrement de la modal du From
    $('#btdModalFrom').on('click', function () {
        var table = $('#from').find(":selected").text();
        var id = $('#inputFromId').val();
        var from = "#" + id;
        var dataFromTable = {"fromGenerer": table, "id": id};

        //var dataFromTable = "from=" + $('#from').find(":selected").text() + "";
        ajaxGet(dataFromTable, $('#modalFrom').modal('hide'));
        $(from + ' > .from-table').remove();
        $(from).append('<span class="from-table">' + table + '</span>');
    });

    //Bouton enregistrement de la modal du Join
    $('#btdModalJoin').on('click', function () {
        var id = $('#inputJoinId').val();
        var table = $('#modalJoin #tableJoin1').find(':selected').text();
        var tableJoin = $('#tableJoin2').find(':selected').text();
        var tableId = $('#modalJoin #tableJoin1').find(':selected').val();
        var tableJoinId = $('#modalJoin #tableJoin2').find(':selected').val();
        var value1 = $('#value1').find(':selected').val();
        var value2 = $('#value2').find(':selected').val();

        var dataJoin = {
            "joinGenerer": table,
            "id": id,
            "tableJoin": tableJoin,
            "value1": value1,
            "value2": value2,
        };
        ajaxGet(dataJoin, $('#modalJoin').modal('hide'));
        console.log(dataJoin);

        var joinForme = '#' + id;
        $(joinForme + ' > .join-tables').remove();
        $(joinForme).append('<div class="join-tables"></div>');
        $(joinForme + ' > .join-tables').append('<span class="first-join">' + table + "." + value1 + '</span>');
        $(joinForme + ' > .join-tables').append('<span class="second-join">' + tableJoin + "." + value2 + '</span>');

        var dataLink = {
            "dataLink": true,
            "tableId": tableId,
            "tableJoinId": tableJoinId,
            "idJoin": joinForme
        };
        console.log(dataLink);
        ajaxPost(dataLink, function (data) {
            console.log(data);
            var x_1 = 0;
            var y_1 = 0;
            var x_2 = 0;
            var y_2 = 0;
            var id_premier;
            var id_second;
            if (x_1 == 0 && y_1 == 0) {
                var target1 = $(data.id);
                x = (parseFloat(target1.attr("data-x")) || 0);
                y = (parseFloat(target1.attr('data-y')) || 0);
                x_1 = x + ((parseFloat(target1[0].offsetWidth)) / 2);
                y_1 = y + ((parseFloat(target1[0].offsetHeight)) / 2);
                id_premier = $(target1).attr('id');

                target2 = $('#' + data.link1);
                x2 = (parseFloat(target2.attr('data-x')) || 0);
                y2 = (parseFloat(target2.attr('data-y')) || 0);
                x_2 = x2 + ((parseFloat(target2[0].offsetWidth)) / 2);
                y_2 = y2 + ((parseFloat(target2[0].offsetHeight)) / 2);
                id_second = $(target2).attr('id');


                $('#line-container').append('<svg id="' + id_premier + '-' + id_second + '" data-id="' + id_premier + '-' + id_second + '"  class="line" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');

                /*                var idLine = $('.line').attr("data-id");
                                var test = id_premier + '-' + id_second;
                                if (idLine == test) {
                                    var html = '#' + idLine;
                                    $(html).remove();
                                    $('#line-container').append('<svg id="' + id_premier + '-' + id_second + '" data-id="' + id_premier + '-' + id_second + '"  class="line" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');
                                } else {
                                    $('#line-container').append('<svg id="' + id_premier + '-' + id_second + '" data-id="' + id_premier + '-' + id_second + '"  class="line" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');
                                }*/
                nb_links++;
                links[nb_links] = {
                    forme1: id_premier,
                    forme2: id_second
                };
            }
            var x_1_2 = 0;
            var y_1_2 = 0;
            var x_2_2 = 0;
            var y_2_2 = 0;
            var id_premier_2;
            var id_second_2;
            if (x_1_2 == 0 && y_1_2 == 0) {
                var target1 = $(data.id);
                x = (parseFloat(target1.attr("data-x")) || 0);
                y = (parseFloat(target1.attr('data-y')) || 0);
                x_1_2 = x + ((parseFloat(target1[0].offsetWidth)) / 2);
                y_1_2 = y + ((parseFloat(target1[0].offsetHeight)) / 2);
                id_premier_2 = $(target1).attr('id');

                target2 = $('#' + data.link2);
                x2 = (parseFloat(target2.attr('data-x')) || 0);
                y2 = (parseFloat(target2.attr('data-y')) || 0);
                x_2_2 = x2 + ((parseFloat(target2[0].offsetWidth)) / 2);
                y_2_2 = y2 + ((parseFloat(target2[0].offsetHeight)) / 2);
                id_second_2 = $(target2).attr('id');


                $('#line-container').append('<svg id="' + id_premier_2 + '-' + id_second_2 + '" data-id="' + id_premier_2 + '-' + id_second_2 + '"  class="line" height="100%" width="100%"><line x1="' + x_1_2 + '" y1="' + y_1_2 + '" x2="' + x_2_2 + '" y2="' + y_2_2 + '" style="stroke:#000"/></svg>');

                /*                var idLine = $('.line').attr("data-id");
                                var test = id_premier + '-' + id_second;
                                if (idLine == test) {
                                    var html = '#' + idLine;
                                    $(html).remove();
                                    $('#line-container').append('<svg id="' + id_premier_2 + '-' + id_second_2 + '" data-id="' + id_premier_2 + '-' + id_second_2 + '"  class="line" height="100%" width="100%"><line x1="' + x_1_2 + '" y1="' + y_1_2 + '" x2="' + x_2_2 + '" y2="' + y_2_2 + '" style="stroke:#000"/></svg>');
                                } else {
                                    $('#line-container').append('<svg id="' + id_premier_2 + '-' + id_second_2 + '" data-id="' + id_premier_2 + '-' + id_second_2 + '"  class="line" height="100%" width="100%"><line x1="' + x_1_2 + '" y1="' + y_1_2 + '" x2="' + x_2_2 + '" y2="' + y_2_2 + '" style="stroke:#000"/></svg>');
                                }*/
                nb_links++;
                links[nb_links] = {
                    forme1: id_premier_2,
                    forme2: id_second_2
                };
            }
        });
    });

    $('#table2').on('change', function () {
        $('#optGroupColonne').html('<option value="null"></option>');
        var dataForm = "fromInput=" + $('#table2').find(":selected").text();
        ajaxPost(dataForm, function (data) {
            console.log(data)
            for (var i = 0; i < data.length; i++) {
                $('#optGroupColonne').append('<option value="' + data[i].name + '">' + data[i].name + '</option>');
            }
        });
    });

    $('#tableJoin1').on('change', function () {
        $('#optGroupJoin1').html('<option value="null"></option>');
        var dataForm = "fromInput=" + $('#tableJoin1').find(":selected").text();
        ajaxPost(dataForm, function (data) {
            console.log(data);
            for (var i = 0; i < data.length; i++) {
                $('#optGroupJoin1').append('<option value="' + data[i].name + '">' + data[i].name + '</option>');
            }
        });
    });

    $('#tableJoin2').on('change', function () {
        $('#optGroupJoin2').html('<option value="null"></option>');
        var dataForm = "fromInput=" + $('#tableJoin2').find(":selected").text();
        ajaxPost(dataForm, function (data) {
            console.log(data);
            for (var i = 0; i < data.length; i++) {
                $('#optGroupJoin2').append('<option value="' + data[i].name + '">' + data[i].name + '</option>');
            }
        });
    });

    //Bouton pour afficher la requête SQL
    $('#btdGenerer').on('click', function () {
        var dataModal = "modal=true";
        ajaxPost(dataModal, function (data) {
            console.log(data);
            var selectText = data.select;
            var fromText = data.from;
            var whereText = data.where;
            var groupText = data.group;
            var orderText = data.order;
            var havingText = data.having;

            if(whereText != null) $('#codeWhere').html(whereText);
            if(selectText != null) $('#codeSelect').html(selectText);
            if(fromText != null) $('#codeFrom').html(fromText);
            if(orderText != null) $('#codeOrder').html(orderText);
            if(groupText != null) $('#codeGroup').html(groupText);
            if(havingText != null) $('#codeHaving').html(havingText);
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
        var id = "select" + nb_select;

        $("div[data-type='select']").each(function () {
            if ($(this).attr('id') == id) {
                nb_select++;
            }
        });

        var dataSelect = "select=select" + nb_select;
        var nom = "select" + nb_select;
        idFormSelect.push(nom);
        console.log(idFormSelect);

        ajaxGet(dataSelect,
            $('#drawing').append('<div id="select' + nb_select + '"  data-click="false" class="form draggable tap-target accept-drop" data-type="select"><img class="img-form" src="../asset/img/svg/Select.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true"></div>'),
            forms['select' + nb_select] = {
                'x': 0,
                'y': 0,
                'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
                'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
            },
            $('#select' + nb_select).append('<button class="add-button" style="left:' + (parseFloat(event.currentTarget.offsetWidth) + 24) + 'px; top:0px"><span class="fas fa-plus add-icon"></span></button>')
        );
    });

    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="2"]').on("click", function (event) {
        nb_from++;

        $("div[data-type='from']").each(function () {
            var id = "from" + nb_from;
            if ($(this).attr('id') == id) {
                nb_from++;
            }
        });

        var dataFrom = "from=from" + nb_from;
        var nom = "from" + nb_from;
        idFormFrom.push(nom);
        ajaxGet(dataFrom,
            $('#drawing').append('<div id="from' + nb_from + '" data-click="false" class="form draggable tap-target accept-drop" data-type="from"><img class="img-form" src="../asset/img/svg/From.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true"></div>'),
            forms['from' + nb_from] = {
                'x': 0,
                'y': 0,
                'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
                'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
            },
            $('#from' + nb_from).append('<button class="add-button" style="left:' + (parseFloat(event.currentTarget.offsetWidth) + 24) + 'px; top:0px"><span class="fas fa-plus add-icon"></span></button>')
        );
    });
    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="3"]').on("click", function (event) {
        nb_where++;
        var id = "where" + nb_where;
        $("div[data-type='where']").each(function () {
            if ($(this).attr('id') == id) {
                nb_where++;
            }
        });

        var dataWhere = "where=where" + nb_where;
        var nom = "where" + nb_from;
        idFormWhere.push(nom);
        ajaxGet(dataWhere,
            $('#drawing').append('<div id="where' + nb_where + '" data-click="false" class="form draggable tap-target accept-drop" data-type="where"><img class="img-form" src="../asset/img/svg/Where.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true"></div>'),
            forms['where' + nb_where] = {
                'x': 0,
                'y': 0,
                'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
                'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
            },
            $('#where' + nb_where).append('<button class="add-button" style="left:' + (parseFloat(event.currentTarget.offsetWidth) + 24) + 'px; top:0px"><span class="fas fa-plus add-icon"></span></button>')
        );
    });

    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="4"]').on("click", function (event) {
        nb_join++;
        var id = "join" + nb_join;
        $("div[data-type='join']").each(function () {
            if ($(this).attr('id') == id) {
                nb_join++;
            }
        });
        var dataJoin = "join=join" + nb_join;
        var nom = "join" + nb_join;
        idFormJoin.push(nom);
        ajaxGet(dataJoin, $('#drawing').append('<div id="join' + nb_join + '" data-click="false" class="form draggable tap-target accept-drop" data-type="join"><img class="img-form" src="../asset/img/svg/Join.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true"></div>'),
            forms['join' + nb_join] = {
                'x': 0,
                'y': 0,
                'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
                'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
            },
            $('#join' + nb_join).append('<button class="add-button" style="left:' + (parseFloat(event.currentTarget.offsetWidth) + 24) + 'px; top:0px"><span class="fas fa-plus add-icon"></span></button>')
        )
    });

    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="5"]').on("click", function (event) {
        nb_subQuery++;

        var id = "subQuery" + nb_subQuery;
        $("div[data-type='subQuery']").each(function () {
            if ($(this).attr('id') == id) {
                nb_subQuery++;
            }
        });

        $('#drawing').append('<div id="subQuery' + nb_subQuery + '" data-click="false" class="form draggable tap-target drop-form accept-drop" data-type="subQuery" style="width:450px"><img class="img-form" src="../asset/img/svg/SubQuery.svg" data-container="body" data-toggle="popover" data-placement="right" data-html="true"></div>');
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
            if ($(event.relatedTarget).attr('is-child') == undefined) {
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

            // call this function on every dragmove event
            onmove: function(event) {
                if(event.clientX <= $("#drawing").width() - 10 && event.clientY <= $("#drawing").height() - 10) {
                    $('.form').each(function(){
                        if($(this).attr('is-child') == undefined) {
                            var x = (parseFloat($(this).attr('data-x')) || 0) + event.dx,
                            y = (parseFloat($(this).attr('data-y')) || 0) + event.dy;

                            if(x > 0 && y > 0) {
                                if(links.length != 0) {
                                    for (var i = 1; i < links.length; i++) {
                                        if (links[i].forme1 == $(this).attr('id')) {
                                            $('#' + links[i].forme1 + '-' + links[i].forme2 + '').find('line').attr('x1', x+50);
                                            $('#' + links[i].forme1 + '-' + links[i].forme2 + '').find('line').attr('y1', y+50);
                                        }
                                        if (links[i].forme2 == $(this).attr('id')) {
                                            $('#' + links[i].forme1 + '-' + links[i].forme2 + '').find('line').attr('x2', x+50);
                                            $('#' + links[i].forme1 + '-' + links[i].forme2 + '').find('line').attr('y2', y+50);
                                        }
                                    }
                                }

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
            $('.draggable').each(function () {
                if ($(this).attr('data-click') == 'true') {
                    $(this).css('border', '3px dashed transparent');
                    $(this).attr('data-click', 'false');
                }
            });
        })


    $(document).on('click', '.draggable', function (event) {
        event.stopImmediatePropagation();
        event.stopPropagation();
        var target = event.currentTarget,
            x = (parseFloat(target.getAttribute('data-x')) || 0),
            y = (parseFloat(target.getAttribute('data-y')) || 0);

        target.style.webkitTransform = target.style.transform =
            'translate(' + x + 'px,' + y + 'px)';

        if (target.getAttribute('data-click') == 'true') {
            $(target).css('border', '3px dashed transparent');
            target.setAttribute('data-click', 'false');
        }
        else {
            $('.draggable').each(function () {
                if ($(this).attr('data-click') == 'true') {
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

    function clearGrid() {
        if (jQuery.isEmptyObject(forms)) {
            alert('Aucune formes détectées...');
        }
        else {
            if (confirm('Voulez vous supprimer toutes les formes présentes dans la zone de dessin ?')) {
                var arrayToDelete = {};
                $('.draggable').each(function (index) {
                    arrayToDelete[index] = $(this).attr('id');
                });

                var idDeleteForm = {'idDeleteForm': arrayToDelete};
                ajaxGet(idDeleteForm, 
                    $('.draggable').each(function () {
                        $(this).remove();
                    }),

                    $('.line').each(function () {
                        $(this).remove();
                    }),

                    nb_select = 0,
                    nb_from = 0,
                    nb_where = 0,
                    nb_join = 0,
                    nb_subQuery = 0,
                    nb_links = 0,
                    forms = [],
                    links = []           
                )
            }
        }
    }

    function deleteElement() {
        var selectedForm = false;
        $('.draggable').each(function () {
            if ($(this).attr('data-click') == 'true') {
                selectedForm = true;
            }
        });

        if (jQuery.isEmptyObject(forms)) {
            alert('Aucune forme sur la zone de dessin...');
        }
        else if (!selectedForm) {
            alert('Aucune forme sélectionnée...');
        }
        else {
            $('.draggable').each(function () {
                if ($(this).attr('data-click') == 'true') {
                    if ($(this).attr('data-type') == 'subQuery') {
                        if (confirm('Voulez vous supprimer cette forme de la zone de dessin ? Cela supprimera aussi toutes les formes associées')) {
                            var id = $(this).attr('id');
                            var idDeleteForm = "idDeleteForm=" + id;
                            ajaxGet(idDeleteForm, 
                                $('.accept-drop').each(function () {
                                    if ($(this).parent(id)) {
                                        if ($(this).attr('data-type') == 'select') {
                                            $('#' + id).remove();
                                            delete forms[$(this).attr('id')];
                                            nb_select--;
                                        }
                                        else if ($(this).attr('data-type') == 'from') {
                                            $('#' + id).remove();
                                            delete forms[$(this).attr('id')];
                                            nb_from--;
                                        }
                                        else if ($(this).attr('data-type') == 'where') {
                                            $('#' + id).remove();
                                            delete forms[$(this).attr('id')];
                                            nb_where--;
                                        }
                                        else if ($(this).attr('data-type') == 'join') {
                                            $('#' + id).remove();
                                            delete forms[$(this).attr('id')];
                                            nb_join--;
                                        }
                                    }
                                }),
                                nb_subQuery--,
                                delete forms[id],
                                $(this).remove()
                            )
                        }
                    }
                    else {
                        if (confirm('Voulez vous supprimer cette forme de la zone de dessin ?')) {
                            var idDeleteForm = "idDeleteForm=" + $(this).attr('id');
                            ajaxGet(idDeleteForm, 
                                $(function() {
                                    if ($(this).attr('data-type') == 'select')
                                        nb_select--;
                                    else if ($(this).attr('data-type') == 'from')
                                        nb_from--;
                                    else if ($(this).attr('data-type') == 'where')
                                        nb_where--;
                                    else if ($(this).attr('data-type') == 'join')
                                        nb_join--;

                                    if (links.length != 0) {
                                        for (var i = 1; i < links.length; i++) {
                                            if (links[i].forme1 == $(this).attr('id') || links[i].forme2 == $(this).attr('id')) {
                                                $('#' + links[i].forme1 + '-' + links[i].forme2 + '').remove();
                                                nb_links--;
                                            }
                                        }
                                    } 
                                }),
                                delete forms[$(this).attr('id')],
                                $(this).remove()                              
                            )
                        }
                    }
                }
            });
        }
    }


    var numMin = 0;
    var numMax = 0;
    var numCount = 0;
    var numAvg = 0;
    var numSum = 0;
    var numHaving = 0;
    var numGroupBy = 0;
    var numOrderBy = 0;

    tabAgregat = [];

    $('#min').on("click", function () {
        numMin ++;
        var id = "min" + numMin;
        tabAgregat.push(id);
        if ($("#function_select > input").length < 5) {
            $("#function_select").append('<label for="min">MIN </label>' +
                '<input class="form-control function-form" id="selectMin" data-agre="'+ id + '" type="text">' +
                '<button type="button" class="close" id="btdAgrega" data-adrebtd="'+ id + '">' +
                '<span  aria-hidden="true">×</span>' +
                '</button>');
        }
    });

    $('#max').on("click", function () {
        numMax ++;
        var id = "max" + numMax;
        tabAgregat.push(id);
        if ($("#function_select > input").length < 5) {
            $("#function_select").append('<label for="max">MAX </label>' +
                '<input class="form-control function-form" id="selectMax" data-agre="'+ id + '" type="text">' +
                '<button type="button" class="close" id="btdAgrega" data-adrebtd="'+ id + '" aria-label="Close">' +
                '<span aria-hidden="true">×</span>' +
                '</button>');
        }
    });

    $('#count').on("click", function () {
        numCount ++;
        var id = "count" + numCount;
        tabAgregat.push(id);
        if ($("#function_select > input").length < 5) {
            $("#function_select").append('<label  for="count">COUNT </label>' +
                '<input class="form-control function-form" id="selectCount" data-agre="'+ id + '" type="text">' +
                '<button type="button" class="close" id="btdAgrega" data-adrebtd="'+ id + '" aria-label="Close">' +
                '<span aria-hidden="true">×</span>' +
                '</button>');
        }
    });

    $('#avg').on("click", function () {
        numAvg ++;
        var id = "avg" + numAvg;
        tabAgregat.push(id);
        if ($("#function_select > input").length < 5) {
            $("#function_select").append('<label for="avg">AVG </label>' +
                '<input class="form-control function-form" id="selectAvg" data-agre="'+ id + '" type="text">' +
                '<button type="button" class="close" id="btdAgrega" data-adrebtd="'+ id + '" aria-label="Close">' +
                '<span aria-hidden="true">×</span>' +
                '</button>');
        }
    });

    $('#sum').on("click", function () {
        numSum ++;
        var id = "sum" + numSum;
        tabAgregat.push(id);
        if ($("#function_select > input").length < 5) {
            $("#function_select").append('<label for="sum">SUM </label>' +
                '<input class="form-control function-form" id="selectSum" data-agre="'+ id + '" type="text">' +
                '<button type="button" class="close" id="btdAgrega" data-adrebtd="'+ id + '" aria-label="Close">' +
                '<span aria-hidden="true">×</span>' +
                '</button>');
        }
    });

    $('#having').on("click", function () {
        if (numHaving < 1) {
            numHaving ++;
            var id = "having" + numHaving;
            tabAgregat.push(id);
            if ($("#function_select > input").length < 5) {
                $("#function_select").append('<label for="having">HAVING </label>' +
                    '<input class="form-control function-form" id="selectHaving" data-agre="'+ id + '" type="text">' +
                    '<button type="button" class="close" id="btdAgrega" data-adrebtd="'+ id + '" aria-label="Close">' +
                    '<span aria-hidden="true">×</span>' +
                    '</button>');
            }
        }
    });

    $('#groupby').on("click", function () {
        if (numGroupBy < 1) {
            numGroupBy ++;
            var id = "group" + numGroupBy;
            tabAgregat.push(id);
            if ($("#function_select > input").length < 5) {
                $("#function_select").append('<label for="groupby">GROUPBY </label>' +
                    '<input class="form-control function-form" id="selectGroup" data-agre="'+ id + '" type="text">' +
                    '<button type="button" class="close" id="btdAgrega" data-adrebtd="'+ id + '" aria-label="Close">' +
                    '<span aria-hidden="true">×</span>' +
                    '</button>');
            }
        }
    });

    $('#orderby').on("click", function () {
        if (numOrderBy < 1) {
            numOrderBy ++;
            var id = "order" + numOrderBy;
            tabAgregat.push(id);
            if ($("#function_select > input").length < 5) {
                $("#function_select").append('<label  for="orderby">ORDERBY </label>' +
                    '<input class="form-control function-form" id="selectOrder" data-agre="'+ id + '" type="text">' +
                    '<button type="button" class="close" id="btdAgrega" data-adrebtd="'+ id + '" aria-label="Close">' +
                    '<span aria-hidden="true">×</span>' +
                    '</button>');
            }
        }
    });

    $('#function_select #btdAgrega').on('click', function (){
        console.log("click !");
        var btd = $(this).attr('data-adrebtd');
        $('#selectOrder').find('[data-agre="' + btd + '"').val("");
        $('#selectOrder').find('[data-agre="' + btd + '"').remove();
    });

});