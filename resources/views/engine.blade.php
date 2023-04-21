<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{URL('favicon.ico')}}">
    <script src="{{URL('jquery.js')}}" type="text/javascript"></script>
    <script src="{{URL('jquery.browser.js')}}"></script>
    <script src="{{URL('jquery-ui.js')}}"></script>
    <script src="{{URL('jquery.layout.js')}}"></script>
    
   
    <script src="{{URL('draw2d.js')}}" type="text/javascript"></script>

    <script src="{{URL('engine/Application.js')}}"></script>
	 <script src="{{URL('engine/View.js')}}"></script>
	 <script src="{{URL('engine/Toolbar.js')}}"></script>

<script type="text/javascript">

var jsonDocument =

    [
      {
        "type": "MySlider",
        "id": "354fa3b9-a834-0221-2009-abc2d6bd852a",
        "x": 650,
        "y": 450
      },
      {
        "type": "MySparkline",
        "id": "ebfb35bb-5767-8155-c804-14bda7759dc2",
        "x": 450,
        "y": 450
      },
      {
        "type": "draw2d.Connection",
        "id": "74ce9e7e-5f0e-8642-6bec-4ff9c54b3f0a",
        "source": {
          "node": "354fa3b9-a834-0221-2009-abc2d6bd852a",
          "port": "output0"
        },
        "target": {
          "node": "ebfb35bb-5767-8155-c804-14bda7759dc2",
          "port": "input0"
        }
      }
    ];


document.addEventListener("DOMContentLoaded",function () {

    // Everything is loaded - core and application. Now can create the
    // application
    //
   	var app  = new example.Application();

    // 10   = Grid size
    // true = consider zoom and resize the grid
    app.view.installEditPolicy(new draw2d.policy.canvas.ShowGridEditPolicy());

    app.view.installEditPolicy(new draw2d.policy.canvas.SnapToGeometryEditPolicy());
    app.view.installEditPolicy(new draw2d.policy.canvas.SnapToInBetweenEditPolicy());
    app.view.installEditPolicy(new draw2d.policy.canvas.SnapToCenterEditPolicy());

    app.view.installEditPolicy(  new draw2d.policy.connection.DragConnectionCreatePolicy({
        createConnection: function(sourcePort, targetPort){
            var c = new draw2d.Connection();
            c.setOutlineColor("#00A8F0");
            c.setOutlineStroke(1);
            c.setRadius(5);
            c.setStroke(3);
            c.setRouter(new draw2d.layout.connection.InteractiveManhattanConnectionRouter());
            return c;
        }
    }));
    /////////////////////////////////////////////////////////////////////
    // JUST ADD SOME DOCU ELEMENTS ON THE SCREEN
    /////////////////////////////////////////////////////////////////////
    var msg = new draw2d.shape.note.PostIt({text: "A canvas has per default a mouse wheel zoom support.\nPress 'SHIFT' and the mouse wheel to zoom in/out."});
    app.view.add(msg, 20,20);

    // var greenOpAmp= new draw2d.shape.analog.OpAmp({
    //        bgColor:"#a0ffa0",
    //        angle:90
    //     });
    // app.view.add(greenOpAmp,350,150);
    // app.view.add(new draw2d.shape.basic.Label({text:"draw2d.shape.analog.OpAmp (with setBackgroundColor(\"#A0ffA0\"))"}),500,155);

    // app.view.add(new draw2d.shape.analog.ResistorBridge({x:350,y:250}));
    // app.view.add(new draw2d.shape.basic.Label({text:"draw2d.shape.analog.ResistorBridge", x:500, y:250}));

    // app.view.add(new draw2d.shape.analog.VoltageSupplyHorizontal(),350,350);
    // app.view.add(new draw2d.shape.basic.Label({text:"draw2d.shape.analog.VoltageSupplyHorizontal"}),500,355);

    var rect = new LabelRectangle({width:100, height:80}); //check if its a custom thing
    app.view.add( rect, 750,200);

     
    var reader = new draw2d.io.json.Reader();
    reader.unmarshal(app.view, jsonDocument);

	 /////////////////////////////////////////////////////////////////////
	 // JUST ADD SOME DOCU ELEMENTS ON THE SCREEN
	 /////////////////////////////////////////////////////////////////////
	 var msg = new draw2d.shape.note.PostIt({text:"Drag the slider thumb to change the\nvalue and propagate these to the Sparkline"});
	 app.view.add(msg, 400,500);


     //JSON load

     displayJSON(app.view);


// add an event listener to the Canvas for change notifications.
// We just dump the current canvas document into the DIV
//
app.view.getCommandStack().addEventListener(function(e){
    if(e.isPostChangeEvent()){
        displayJSON(app.view);
    }
});

});


function displayJSON(canvas){
var writer = new draw2d.io.json.Writer();
writer.marshal(canvas,function(json){
  $("#json").text(JSON.stringify(json, null, 2));
});
}




var LabelRectangle= draw2d.shape.basic.Rectangle.extend({
    
    init:function(attr)
    {
      this._super(attr);
    
      // Create any Draw2D figure as decoration for the connection
      //
      this.label = new draw2d.shape.basic.Label({text:"I'm a Label", color:"#0d0d0d", fontColor:"#0d0d0d"});
      
      // add the new decoration to the connection with a position locator.
      //
      this.add(this.label, new draw2d.layout.locator.CenterLocator(this));
      
      this.label.installEditor(new draw2d.ui.LabelInplaceEditor());
    }
});

MySlider = draw2d.shape.widget.Slider.extend({

    NAME : "MySlider",
    
    init : function()
    {
        this._super();
        
        this.createPort("output");


        this.on("change:value", $.proxy(function(element, event){
            var connections = this.getOutputPort(0).getConnections();
            connections.each($.proxy(function(i, conn){
                var targetPort = conn.getTarget();
                targetPort.setValue(event.value);
            },this));
        },this));

        this.setDimension(120,20);
    }
});


MySparkline = draw2d.shape.diagram.Sparkline.extend({

NAME : "MySparkline",

init : function(attr)
{
    this._super(attr);
    this.maxValues = 100;
    
    this.setBackgroundColor("#FF765E");
    this.setRadius(5);
    this.createPort("input");
    this.startTimer(100);
    this.setDimension(250,50);
},

setData:function( data)
{
    this._super(data);

    this.min = 0;
    this.max = 100;
    this.cache= {};
    this.repaint();
},

/*
 * Update the chart with the current value of the input port.
 */
onTimer:function()
{
     var port = this.getInputPort(0);
     var value=port.getValue();
     this.data.push(value===null?0:value);
     if(this.data.length>this.maxValues)
         this.data.shift();
     this.setData(this.data);
}

});
</script>
</head>

<body id="container">

   	<div id="toolbar"></div>
   	<div id="canvas" class="" style="width:3000px; height:3000px;"></div>
    <div id="navigation" class=""></div>
    <pre id="json" style="overflow:auto;position:absolute; top:10px; right:10px; width:300px;height:500px;background:white;border:1px solid gray">
    </pre>

</body>
</html>