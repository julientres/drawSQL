function dragMoveListener(event) {
    var target = event.currentTarget,
        // keep the dragged position in the data-x/data-y attributes
        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

    // translate the element
    target.style.webkitTransform =
        target.style.transform =
            'translate(' + x + 'px, ' + y + 'px)';

    // update the posiion attributes
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
}

// this is used later in the resizing and gesture demos
window.dragMoveListener = dragMoveListener;


$(document).ready(function () {
    $(".alert-success").show("slow").delay(2000).hide("slow");

    $('#btnGenerate').on("click", function () {
        window.open("display-results.php");
    })

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

    $('#btnGenerate').on("click", function () {
        window.open("display-results.php");
    });


    $('#btdModalSelect').on('click',function (){
        var str = "from=" + $('#from').find(":selected").text();
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: str,
            success: function (data) {
                $('#test').html(data);
                if (data) {
                    $('#console').html('Enregistrement fait');
                    $('#modalSelect').modal('hide');
                }
            },
            error: function (data) {
                console.log(data);
                alert("Erreur de création")
            }
        });
    });

    $('[data-form="1"]').on("click", function () {
        var dataSelect = "select=true";
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: dataSelect,
            success: function (data) {
                $('#test').html(data);
                if (data) {
                    $('#drawing').append('<img src="../asset/img/svg/Select.svg" data-type="select" class="draggable tap-target drag1" id="">');
                }
            },
            error: function (data) {
                console.log(data);
                alert("Erreur de création")
            }
        });
    });
    interact('[data-type="select"]').on('doubletap', function (event) {
        $('#modalSelect').modal('show');
    })
    interact('[data-type="from"]').on('doubletap', function (event) {
        $('#modalFrom').modal('show');
    })




    $('[data-form="2"]').on("click", function () {
        var dataFrom = "from=true";
        $.ajax({
            url: "../asset/php/createClass.php",
            type: "POST",
            data: dataFrom,
            success: function (data) {
                $('#test').html(data);
                if (data) {
                    $('#drawing').append('<img src="../asset/img/svg/From.svg" data-type="from" class="draggable tap-target drag1">');
                }
            },
            error: function (data) {
                console.log(data);
                alert("Erreur de création")
            }
        });
    });

    $('[data-form="3"]').on("click", function () {
        $('#drawing').append('<img src="../asset/img/svg/Where.svg" class="draggable tap-target drag1">');
    });
    $('#link').on("click", function (event) {
        var x_1 = 0;
        var y_1 = 0;
        var x_2 = 0;
        var y_2 = 0;
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
                        x_1 = x + ((parseFloat(target.offsetWidth)) / 2) - 5;
                        y_1 = y + ((parseFloat(target.offsetHeight)) / 2) - 5;
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
                        console.log('Rentré 2');
                        console.log('x_1 :' + x_1);
                        console.log('y_1 :' + y_1);
                        console.log('x_2 :' + x_2);
                        console.log('y_2 :' + y_2);
                        //$('#drawing').append('<div class="point" style="left:'+x_2+'px; top:'+y_2+'px"></div>');
                        $('#line-container').append('<svg class="line" height="100%" width="100%"><line x1="' + x_1 + '" y1="' + y_1 + '" x2="' + x_2 + '" y2="' + y_2 + '" style="stroke:#000"/></svg>');
                        $('#link').data('processing', false);
                        interact('.tap-target').off("tap");
                    }
                }
            });
    });
});


interact('.draggable')
    .draggable({
        onmove: window.dragMoveListener,
        restrict: {
            restriction: 'parent',
            elementRect: {top: 0, left: 0, bottom: 1, right: 1}
        },
    })
    .on('click', function (event) {
        var target = event.target,
            x = (parseFloat(target.getAttribute('data-x')) || 0),
            y = (parseFloat(target.getAttribute('data-y')) || 0);

        target.style.webkitTransform = target.style.transform =
            'translate(' + x + 'px,' + y + 'px)';
    });