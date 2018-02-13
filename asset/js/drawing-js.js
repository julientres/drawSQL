$(".alert-success").show("slow").delay(2000).hide("slow");
//zoom
var SCALE_FACTOR = 1.1;
function ZoomIn() {
	canvas.setZoom(canvas.getZoom()*SCALE_FACTOR);
	canvas.renderAll();
}

function ZoomOut() {
	canvas.setZoom(canvas.getZoom()/SCALE_FACTOR);
		canvas.renderAll();
}

function ResetZoom() {
	canvas.setZoom(1);
		canvas.renderAll();
}
	
//delete
function Delete(){
	if(canvas.getActiveObject() == null)
		alert('pick an object to delete it');
    else if (canvas.getActiveObject().get('type')!=='group') {
        if (confirm('delete object ?')) {
            //canvas.remove(canvas.getActiveObject());
            var objects = canvas.getActiveObject().getObjects();
            for (let i in objects) {
            	canvas.remove(objects[i]);
            }
            canvas.discardActiveObject();
        }
    }
    else if (canvas.getActiveObject().get('type')==='group') {
        if (confirm('delete group ?')) {		      
            canvas.remove(canvas.getActiveObject());
            canvas.discardActiveObject();
        }
    }
}

function chooseMode() {
	if(canvas.isDrawingMode===false){
		canvas.isDrawingMode=true;
	}
	else{
		canvas.isDrawingMode=false;
	}
}	

function clearCanvas() {
	var objects = canvas.getObjects();
	while(objects.length !== 0) {
		canvas.remove(objects[0]);
	}
	drawGrid();
	// var objects = canvas.getObjects();
	// var ob=[];
	// for (let i in objects) {
	//        if(objects[i].get('type')!=='line'){
	//        	//document.getElementById('oui').innerHTML="yoyoyo";
	//        	ob[i]=objects[i];
	//        }
	//    }
	//    for (let i in ob) {
	//        canvas.remove(ob[i]);
	//    }
	//    RenderCanvas();				  			
}

function showHideGrid() {
	var objects = canvas.getObjects('line');
	if(objects.length===0){
		drawGrid();
	}
	else{				
	    for (let i in objects) {
	        canvas.remove(objects[i]);
	    }
	    RenderCanvas();
	}
}

//copy paste objects
function Copy() {
	// clone what are you copying since you
	// may want copy and paste on different moment.
	// and you do not want the changes happened
	// later to reflect on the copy.
	if(canvas.getActiveObject() == null)
		alert('pick an object to copy it');
	else {
		canvas.getActiveObject().clone(function(cloned) {
			_clipboard = cloned;
		});
	}
}

function Paste() {
	// clone again, so you can do multiple copies.
	_clipboard.clone(function(clonedObj) {
		canvas.discardActiveObject();
		clonedObj.set({
			left: clonedObj.left + 20,
			top: clonedObj.top + 20,
			evented: true,
		});
		if (clonedObj.type === 'activeSelection') {
			// active selection needs a reference to the canvas.
			clonedObj.canvas = canvas;
			clonedObj.forEachObject(function(obj) {
				canvas.add(obj);
			});
			// this should solve the unselectability
			clonedObj.setCoords();
		} else {
			canvas.add(clonedObj);
		}
		_clipboard.top += 20;
		_clipboard.left += 20;
		canvas.setActiveObject(clonedObj);
		canvas.requestRenderAll();
	});
}

createListenersKeyboard();
function createListenersKeyboard() {
    document.onkeydown = onKeyDownHandler;
    //document.onkeyup = onKeyUpHandler;
}

function onKeyDownHandler(event) {
    //event.preventDefault();
    var key;
    if(window.event){
        key = window.event.keyCode;
    }
    else{
        key = event.keyCode;
    }
    
    switch(key){
        // Shortcuts
        case 67: // Ctrl+C
            if(event.ctrlKey){
                event.preventDefault();
                Copy();
            }
            break;
        // Paste (Ctrl+V)
        case 86: // Ctrl+V
            if(event.ctrlKey){
                event.preventDefault();
                Paste();
            }
            break;	
        case 46:
        	Delete();
        	break;		       	
       	case 35:
       		OriginalZoom();
       		break;            
        default:
            // TODO
            break;
    }
}	

//create canvas			
var canvas = this.__canvas = new fabric.Canvas('canvas',{selection:true, isDrawingMode:false, height:800, width:1630}), options = {distance:10, width:canvas.width, 
	height:canvas.height, param: {stroke:'#ebebeb', strokeWidth:1, selectable:false}}, gridLen = options.width / options.distance;

//draw grid (line h&v)
function drawGrid() {
	for (var i = 0; i < gridLen; i++) {
	  	var distance   = i * options.distance,
	      	horizontal = new fabric.Line([ distance, 0, distance, options.width], options.param),
	        vertical   = new fabric.Line([ 0, distance, options.width, distance], options.param);
	   	canvas.add(horizontal);
	   	canvas.add(vertical);
	   	canvas.sendToBack(horizontal);
	   	canvas.sendToBack(vertical);
	   	if(i%5 === 0){
	   		horizontal.set({stroke: '#cccccc'});
	      	vertical.set({stroke: '#cccccc'});
	   	};
	};
	}

	drawGrid();

var polySelect=[];
var indexS=0;
function createSelectObject() {
	polySelect[indexS] = new fabric.Path('M10 30L40 80L120 80L150 30z');
	polySelect[indexS].set({left:500, top:100, fill:'white', stroke:'black', strokeWidth: 2});
	canvas.add(polySelect[indexS]);
	indexS++;
}

var circleFrom=[];
	var indexF=0;
	function createFromObject() {
		circleFrom[indexF] = new fabric.Circle({radius:50, fill:'white', left:50, top:50, stroke:'black', strokeWidth: 2});
		canvas.add(circleFrom[indexF]);
		indexF++;
	}	

	var polyWhere=[];
	var indexW=0;
	function createWhereObject() {
		polyWhere[indexW] = new fabric.Path('M10 30L10 120L110 90L110 60z');
		polyWhere[indexW].set({left:100, top:100, fill:'white', stroke:'black', strokeWidth: 2});
		canvas.add(polyWhere[indexW]);
		indexW++;
	}	

	var polyJoin=[];
	var indexJ=0;
	function createJoinObject() {
		polyJoin[indexJ] = new fabric.Path('M10 30L10 80L60 30L60 80z');
		polyJoin[indexJ].set({left:200, top:50, fill:'white', stroke:'black', strokeWidth: 2});
		canvas.add(polyJoin[indexJ]);
		indexJ++;
	}		

canvas.on('mouse:wheel', function (options){
	if(options.e.deltaY<0){
		ZoomIn();
	}	
	else if(options.e.deltaY>0){
		ZoomOut();
	}
});

circle1 = new fabric.Circle({radius:50, fill:'white', left:50, top:150, stroke:'black', strokeWidth: 2});
circle2 = new fabric.Circle({radius:50, fill:'white', left:50, top:250, stroke:'black', strokeWidth: 2});
circle3 = new fabric.Circle({radius:50, fill:'white', left:50, top:350, stroke:'black', strokeWidth: 2});
circle4 = new fabric.Circle({radius:50, fill:'white', left:50, top:450, stroke:'black', strokeWidth: 2});
var group=new fabric.Group([circle1,circle2,circle3,circle4]);
canvas.add(group);

canvas.renderAll();		
//panning