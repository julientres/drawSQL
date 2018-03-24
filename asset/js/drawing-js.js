$(document).ready(function () {

    var nb_select = 0;
    var nb_from = 0;
    var nb_where = 0;
    var nb_join = 0;
    var nb_links = 0;

    var forms = new Array();
    var links = new Array();

    $(".alert-success").show("slow").delay(2000).hide("slow");


    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })

    //SVG JS
    if (SVG.supported) {
        // var draw = SVG('drawing').size('100%', '100%');
        // var polySelect = draw.path('M10 30L40 80L120 80L150 30z').attr({fill: '#FFFFFF', stroke: '#000', 'stroke-width': 2});
        // var polyFrom = draw.circle(100).attr({fill: '#FFFFFF', stroke:'#000', 'stroke-width': 2});
        // var polyWhere = draw.path('M10 30L10 120L110 90L110 60z').attr({fill: '#FFFFFF', stroke: '#000', 'stroke-width': 2});
        // var polyJoin = draw.path('M10 30L10 80L60 30L60 80z').attr({fill: '#FFFFFF', stroke: '#000', 'stroke-width': 2});
        // var polySubQuery = draw.path('M20 40L35 33L35 10L80 10L80 70L35 70L35 48z').attr({fill: '#FFFFFF', stroke: '#000', 'stroke-width': 2});
        // var polyLine = draw.polyline([[50,50], [100,50]]).attr({fill: '#FFFFFF', stroke: '#000', 'stroke-width': 2});
    }
    else {
        alert('SVG not supported');
    }

    //Double clic sur la forme affiche la modal Select
    interact('[data-type="select"]').on('doubletap', function () {
        $('#modalSelect').modal('show');
    });
    //Double clic sur la forme affiche la modal From
    interact('[data-type="from"]').on('doubletap', function () {
        $('#modalFrom').modal('show');
    });
    //Double clic sur la forme affiche la modal Where
    interact('[data-type="where"]').on('doubletap', function () {
        $('#modalWhere').modal('show');
    });
    //Double clic sur la forme affiche la modal Where
    interact('[data-type="join"]').on('doubletap', function () {
        $('#modalJoin').modal('show');
    });


    $('#where2').on('change',function(){
        if($(this).find(":selected").text() == "BETWEEN"){
            $('#divBetween').show();
        }else{
            $('#divBetween').hide();
            $('#where3').val(null);
            $('#where4').val(null);
        }
    })

    //Bouton enregistrement de la modal du Where
    $('#btdModalWhere').on('click', function () {
        dataWhere = "";
        where1 = $('#modalWhere #where1').find(":selected").text();
        where2 = $('#where2').find(":selected").text();
        where3 = $('#where3').val();
        if ($('#modalWhere #where1').find(":selected").text() != "" && $('#where2').find(":selected").text() != "" && $('#where3').val() != "") {
            dataWhere += "where1=" + $('#modalWhere #where1').find(":checked").text();
            dataWhere += "&where2=" + $('#where2').find(":checked").text();
            dataWhere += "&where3=" + $('#where3').val();
        }
        if ($('#where4').val() != "") {
            dataWhere += "&where4=" + $('#where4').val();
        }
        console.log(dataWhere);
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: dataWhere,
            success: function (data) {
                $('#test').html(data);
                if (data) {
                    $('#modalWhere').modal('hide');
                }
            },
            error: function (data) {
                alert("Erreur de création")
            }
        });
    });

    //Bouton enregistrement de la modal du From
    $('#btdModalFrom').on('click', function () {
        var dataFromTable = "from=" + $('#from').find(":selected").text() + "";
        console.log(dataFromTable);
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: dataFromTable,
            success: function (data) {
                $('#test').html(data);
                if (data) {
                    $('#modalFrom').modal('hide');

                }
            },
            error: function (data) {
                alert("Erreur de création")
            }
        });
    });

    //Bouton enregistrement de la modal du Join
    $('#btdModalJoin').on('click', function () {
        var dataJoin = "join=";
        dataJoin += $('#modalJoin #join1').find(':selected').text() + ",";
        dataJoin += $('#join2').find(':selected').val() + ",";
        dataJoin += $('#join3').find(':selected').val() + ",";
        dataJoin += $('#join4').find(':selected').val();
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: dataJoin,
            success: function (data) {
                if (data) {
                    $('#modalSelect').modal('hide');
                }
            },
            error: function (data) {
                alert("Erreur de création")
            }
        });
    });

    //Bouton enregistrement de la modal du Select
    $('#btdModalSelect').on('click', function () {
        var dataSelect = "select=";
        $("input[type='checkbox']:checked").each(
            function () {
                dataSelect += $(this).val();
                dataSelect += "%2C";
            });
        var str = dataSelect.substring(0, dataSelect.length - 3);
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: str,
            success: function (data) {
                $('#test').html(data);
                if (data) {
                    $('#modalSelect').modal('hide');
                }
            },
            error: function (data) {
                alert("Erreur de création")
            }
        });
    });
    //Au changement de la table de la jointure --> on affiche les colonnes
    $('#join2').on('change',function () {
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
                }
            },
            error: function (data) {
                console.log("erreur");
            }
        });
    })
    //Au changement du from récupére le nom des colonnes
    $('#from').on('change', function () {
        $('#modalWhere #where1').html('<option value="null"></option>');
        $('#divSelect').html('<input type="checkbox" value="*">*<br>');
        $('#join3').html('<option value="null"></option>');
        var dataForm = "fromInput=" + $('#from').find(":selected").val();
        $.ajax({
            url: "../asset/php/createClass.php",
            type: 'POST',
            data: dataForm,
            success: function (data) {
                data = JSON.parse(data);
                for (var i = 0; i < data.length; i++) {
                    $('#modalWhere #where1').append('<option value="' + data[i] + '">' + data[i] + '</option>');
                    $('#divSelect').append('<input type="checkbox" name="select" value="' + data[i] + '">' + data[i] + '<br>');
                    $('#join3').append('<option value="' + data[i] + '">' + data[i] + '</option>');
                }
            },
            error: function (data) {
                console.log("erreur");
            }
        });
    });

    //Bouton pour afficher la requête SQL
    $('#btdGenerer').on('click', function () {
        var dataModal = "modal=true";
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: dataModal,
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                var selectText = data.select;
                var fromText = data.from;
                if (data.where != null) {
                    var whereText = data.where;
                    $('#codeWhere').html(whereText);
                }
                $('#codeSelect').html(selectText);
                $('#codeFrom').html(fromText);
                $('#generateCodeModal').modal('show');

            },
            error: function (data) {
                console.log("erreur");
            }
        });
    });

    //Bouton qui va envoyé l'execution de la requete pour nous rediriger vers la page de résultat
    $('#btdSql').on('click', function () {
        var dataGenerer = "generer=true";
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: dataGenerer,
            success: function (data) {
                if (data) {
                    window.location.replace("./display-results.php");
                }
            },
            error: function (data) {
                console.log("erreur");
            }
        });
    });

    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="1"]').on("click", function (event) {
        nb_select++;
        $('#drawing').append('<img src="../asset/img/svg/Select.svg" data-type="select" id="select' + nb_select + '" class="draggable tap-target form">');
        forms['select' + nb_select] = {
            'x': 0,
            'y': 0,
            'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
            'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
        };
    });
    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="2"]').on("click", function (event) {
        nb_from++;
        $('#drawing').append('<img src="../asset/img/svg/From.svg" data-type="from" id="from' + nb_from + '" class="draggable tap-target form">');
        forms['from' + nb_from] = {
            'x': 0,
            'y': 0,
            'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
            'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
        };
    });
    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="3"]').on("click", function (event) {
        nb_where++;
        $('#drawing').append('<img src="../asset/img/svg/Where.svg" data-type="where" id="where' + nb_where + '" class="draggable tap-target form">');
        forms['where' + nb_where] = {
            'x': 0,
            'y': 0,
            'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
            'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
        };
    });

    //Quand on click sur la forme --> affiche la forme sur le dessin
    $('[data-form="4"]').on("click", function (event) {
        nb_join++;
        $('#drawing').append('<img src="../asset/img/svg/Join.svg" data-type="join" id="join' + nb_join + '" class="draggable tap-target form">');
        forms['join' + nb_join] = {
            'x': 0,
            'y': 0,
            'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
            'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
        };
    });

    //Créer les liens entre formes
    $('#link').on("click", function (event) {
        var x_1 = 0;
        var y_1 = 0;
        var x_2 = 0;
        var y_2 = 0;
        var id_premier;
        var id_second;
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
                        //$('#drawing').append('<div class="point" style="left:'+x_1+'px; top:'+y_1+'px"></div>');
                    } else {
                        target = event.currentTarget,
                            x = (parseFloat(target.getAttribute('data-x')) || 0),
                            y = (parseFloat(target.getAttribute('data-y')) || 0);
                        x_2 = x + ((parseFloat(target.offsetWidth)) / 2) - 5;
                        y_2 = y + ((parseFloat(target.offsetHeight)) / 2) - 5;
                        id_second = $(target).attr('id');
                        //$('#drawing').append('<div class="point" style="left:'+x_2+'px; top:'+y_2+'px"></div>');
                        $('#line-container').append('<svg id="' + id_premier + '-' + id_second + '" class="line" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');
                        nb_links++;
                        links[nb_links] = {
                            forme1: id_premier,
                            forme2: id_second
                        }
                        $('#link').data('processing', false);
                        interact('.tap-target').off("tap");
                    }
                }
            });
    });

    //Permettre le drag & drop de l'application
    interact('.draggable')
        .draggable({
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
                forms[id_forms].x_center = x + ((parseFloat(event.target.offsetWidth)) / 2) - 5;
                forms[id_forms].y_center = y + ((parseFloat(event.target.offsetHeight)) / 2) - 5;

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
            },
            restrict: {
                restriction: 'parent',
                elementRect: {top: 0, left: 0, bottom: 1, right: 1}
            }
        })
        .on('click', function (event) {
            var target = event.target,
                x = (parseFloat(target.getAttribute('data-x')) || 0),
                y = (parseFloat(target.getAttribute('data-y')) || 0);

            target.style.webkitTransform = target.style.transform =
                'translate(' + x + 'px,' + y + 'px)';

        });


    function dragMoveListener(event) {
        var target = event.currentTarget,
            // keep the dragged position in the data-x/data-y attributes
            x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
            y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

        // translate the element
        target.style.webkitTransform =
            target.style.transform =
                'translate(' + x + 'px, ' + y + 'px)';

        // update the position attributes
        target.setAttribute('data-x', x);
        target.setAttribute('data-y', y);
    }


});