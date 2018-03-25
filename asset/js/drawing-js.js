$(document).ready(function () {

    var nb_select = 0;
    var nb_from = 0;
    var nb_where = 0;
    var nb_links = 0;

    var coefZoom = 1.0;

    var forms = new Array();
    var links = new Array();

    $(".alert-success").show("slow").delay(2000).hide("slow");

    $('#grille').css('zoom', coefZoom);
    $('.draggable').css('border', '3px dashed transparent');

    $('#zoomIn').click(function() {
        zoomIn();          
    });

    $('#zoomOut').click(function() {
        zoomOut();
    });

    $('#zoomReset').click(function() {
        zoomReset();
    });

    $('#clear').click(function() {
        clearGrid();       
    });

    $('#delete').click(function(event) {                          
        deleteElement();            
    });    

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })

    if (!SVG.supported) {
        alert('SVG not supported');
    }

    $('#btnGenerate').on("click", function () {
        window.open("display-results.php");
    });

    interact('[data-type="select"]').on('doubletap', function (event) {
        $('#modalSelect').modal('show');
    })
    interact('[data-type="from"]').on('doubletap', function (event) {
        $('#modalFrom').modal('show');
    })

    $('[data-form="1"]').on("click", function (event) {
        var dataSelect = "select=true";
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: dataSelect,
            success: function (data) {
                $('#test').html(data);
                if (data) {
                    nb_select++;
                    $('#drawing').append('<img src="../asset/img/svg/Select.svg" data-type="select" data-click="false" id="select' + nb_select + '" class="draggable tap-target form">');
                    forms['select' + nb_select] = {
                        'x': 0,
                        'y': 0,
                        'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
                        'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
                    };
                }
            },
            error: function (data) {
                console.log(data);
                alert("Erreur de création")
            }
        });
    });

    $('[data-form="2"]').on("click", function (event) {

        var dataFrom = "from=true";
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: dataFrom,
            success: function (data) {
                $('#test').html(data);
                if (data) {
                    nb_from++;
                    $('#drawing').append('<img src="../asset/img/svg/From.svg" data-type="from" data-click="false" id="from' + nb_from + '" class="draggable tap-target form">');
                    forms['from' + nb_from] = {
                        'x': 0,
                        'y': 0,
                        'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
                        'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
                    };}
            },
            error: function (data) {
                console.log(data);
                alert("Erreur de création")
            }
        });
    });

    $('[data-form="3"]').on("click", function (event) {

        var dataWhere = "where=true";
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: dataWhere,
            success: function (data) {
                $('#test').html(data);
                if (data) {
                    nb_where++;
                    $('#drawing').append('<img src="../asset/img/svg/Where.svg" data-type="where" data-click="false" id="where' + nb_where + '" class="draggable tap-target form">');
                    forms['where' + nb_where] = {
                        'x': 0,
                        'y': 0,
                        'x_center': 0 + ((parseFloat(event.currentTarget.offsetWidth)) / 2),
                        'y_center': 0 + ((parseFloat(event.currentTarget.offsetHeight)) / 2)
                    };              }
            },
            error: function (data) {
                console.log(data);
                alert("Erreur de création")
            }
        });
    });

    $('#link').on("click", function (event) {
        var x_1 = 0;
        var y_1 = 0;
        var x_2 = 0;
        var y_2 = 0;
        var id_premier;
        var id_second;
        $('#link').data('processing', true);
        console.log("exterieur");
        interact('.tap-target')
            .on('tap', function (event) {
                console.log('processing : ' + $('#link').data('processing'));
                if ($('#link').data('processing') == true) {
                    if (x_1 == 0 & y_1 == 0) {
                        var target = event.currentTarget,
                            x = (parseFloat(target.getAttribute('data-x')) || 0),
                            y = (parseFloat(target.getAttribute('data-y')) || 0);
                        x_1 = x + ((parseFloat(target.offsetWidth)) / 2);
                        y_1 = y + ((parseFloat(target.offsetHeight)) / 2);
                        id_premier = $(target).attr('id')
                        console.log('Rentré 1');
                        console.log('x_1 :' + x_1);
                        console.log('y_1 :' + y_1);
                        console.log('x_2 :' + x_2);
                        console.log('y_2 :' + y_2);
                        //$('#drawing').append('<div class="point" style="left:'+x_1+'px; top:'+y_1+'px"></div>');
                    } else {
                        target = event.currentTarget,
                            x = (parseFloat(target.getAttribute('data-x')) || 0),
                            y = (parseFloat(target.getAttribute('data-y')) || 0);
                        x_2 = x + ((parseFloat(target.offsetWidth)) / 2) - 5;
                        y_2 = y + ((parseFloat(target.offsetHeight)) / 2) - 5;
                        id_second = $(target).attr('id');
                        console.log('Rentré 2');
                        console.log('x_1 :' + x_1);
                        console.log('y_1 :' + y_1);
                        console.log('x_2 :' + x_2);
                        console.log('y_2 :' + y_2);
                        //$('#drawing').append('<div class="point" style="left:'+x_2+'px; top:'+y_2+'px"></div>');
                        $('#line-container').append('<svg class="line ' + id_premier + ' ' + id_second + '" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');
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

    interact('.draggable')
        .draggable({
            snap: {
                targets: [
                    interact.createSnapGrid({ x: 40, y: 40 })
                ],
                  range: Infinity,
                  relativePoints: [ { x: 0, y: 0 } ]
            },
            inertia: true,
            onmove: dragMoveListener,
            restrict: {
                restriction: 'parent',
                elementRect: {top: 0, left: 0, bottom: 1, right: 1}
            },
            onend: function (event) {
                // On récupère l'ID de la forme qui est déplacé
                var id_forms = $(event.target).attr('id');
                // On modifie les coordonnées de la forme qui a été bougée
                forms[id_forms].x = (parseFloat(event.target.getAttribute('data-x')) || 0);
                forms[id_forms].y = (parseFloat(event.target.getAttribute('data-y')) || 0);
                forms[id_forms].x_center = forms[id_forms].x + ((parseFloat(event.target.offsetWidth)) / 2) - 5;
                forms[id_forms].y_center = forms[id_forms].y + ((parseFloat(event.target.offsetHeight)) / 2) - 5;
                // On fait suivre les liens
                if (links.length != 0) {
                    for (var i = 1; i < links.length; i++) {
                        if (links[i].forme1 == id_forms) {
                            $('.' + id_forms + '').find('line').attr('x1', forms[id_forms].x_center);
                            $('.' + id_forms + '').find('line').attr('y1', forms[id_forms].y_center);
                        }
                        if (links[i].forme2 == id_forms) {
                            $('.' + id_forms + '').find('line').attr('x2', forms[id_forms].x_center);
                            $('.' + id_forms + '').find('line').attr('y2', forms[id_forms].y_center);
                        }
                    }
                }

                $(event.target).css('border', '3px dashed transparent');
                event.target.setAttribute('data-click', 'true');
            }
        })
        .on('click', function (event) {
            var target = event.target,
                x = (parseFloat(target.getAttribute('data-x')) || 0),
                y = (parseFloat(target.getAttribute('data-y')) || 0);

            target.style.webkitTransform = target.style.transform =
                'translate(' + x + 'px,' + y + 'px)';

            if(event.target.getAttribute('data-click') == 'true') {
                $(event.target).css('border', '3px dashed transparent');
                event.target.setAttribute('data-click', 'false');
            }
            else {
                $('.draggable').each(function() {
                    if($(this).attr('data-click') == 'true') {
                        $(this).css('border', '3px dashed transparent');
                        $(this).attr('data-click', 'false');
                    }
                });

                event.target.setAttribute('data-click', 'true');
                $(event.target).css('border', '3px dashed red');
            }
        });
        
        $(document).keydown(function(e) {            
            switch(e.which) {
                case 46://suppr => delete
                    deleteElement();   
                break; 

                case 32://space => clear
                    zoomReset();
                break;

                case 107://numpad + => zoom +
                   zoomIn();
                break;

                case 109://numpad - => zoom -
                    zoomOut();
                break;             

                default: return; // exit this handler for other keys
            }
            e.preventDefault(); // prevent the default action (scroll / move caret)                        
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

        $('.draggable').each(function() {
            if($(this).attr('data-click') == 'true') {
                $(this).css('border', '3px dashed transparent');
                $(this).attr('data-click', 'false');
            }
        });

        $(event.target).css('border', '3px dashed red');
    }

    // this is used later in the resizing and gesture demos
    window.dragMoveListener = dragMoveListener;

    function zoomIn() {
        if(coefZoom < 2.0) {
            coefZoom += 0.2;
            $('.draggable').each(function() {
                $(this).css('zoom', coefZoom);
            });
            $('.line').each(function() {
                $(this).css('zoom', coefZoom);
            });
            $('#grille').css('zoom', coefZoom);
        }
        else {
            alert('zoom + max atteint');
        } 
    }

    function zoomOut() {
        if(coefZoom > 0.5) {
            coefZoom -= 0.2;
            $('.draggable').each(function() {
                $(this).css('zoom', coefZoom);
            });
            $('.line').each(function() {
                $(this).css('zoom', coefZoom);
            });
            $('#grille').css('zoom', coefZoom);
        }
        else {
            alert('zoom - max atteint');
        }
    }

    function zoomReset() {
        coefZoom = 1.0;
        $('.draggable').each(function() {
            $(this).css('zoom', coefZoom);
        });
        $('.line').each(function() {
            $(this).css('zoom', coefZoom);
        });
        $('#grille').css('zoom', coefZoom);
    }

    function clearGrid() {
        $('.draggable').each(function() {
            $(this).remove();
        });

        $('.line').each(function() {
            $(this).remove();
        });

        nb_select = 0;
        nb_from = 0;
        nb_where = 0;
        forms = [];
        links = [];
    }

    function deleteElement() {
        $('.draggable').each(function() {
            if($(this).attr('data-click') == 'true') {
                if(confirm('sure to delete ?')) {
                    $(this).remove();                    
                    delete forms[$(this).attr('id')];
                    //need : delete element form array "links" & nb_links--

                    if($(this).attr('data-type') == 'select')
                        nb_select--;
                    else if($(this).attr('data-type') == 'from')
                        nb_from--;
                    else if($(this).attr('data-type') == 'where')
                        nb_where--;                  
                }                  
            }            
        });
    }
});