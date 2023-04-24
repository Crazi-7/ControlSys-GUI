<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{URL('favicon.ico')}}">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3.2.0/es5/tex-mml-chtml.js"></script>
    <script src="https://cdn.plot.ly/plotly-2.16.1.min.js"></script>
    <script src="{{URL('math.js')}}" type="text/javascript"></script>
    <script src="{{URL('jquery.js')}}" type="text/javascript"></script>
    <script src="{{URL('jquery.browser.js')}}"></script>
    <script src="{{URL('jquery-ui.js')}}"></script>
    <script src="{{URL('jquery.layout.js')}}"></script>
    <script src="{{URL('draw2d.js')}}" type="text/javascript"></script>
    <script src="{{URL('engine/Application.js')}}"></script>
	<script src="{{URL('engine/View.js')}}"></script>
	<script src="{{URL('engine/Toolbar.js')}}"></script>
    <script src="{{URL('engine/PropertyPane.js')}}"></script>
    <script type="text/javascript">
    var app;
    let jsontext = '{ "blocks" : [], "nets": []}';
    let simJson = JSON.parse(jsontext);

    window.addEventListener("DOMContentLoaded", () => { //check if loaded
        document.getElementById("show").addEventListener("click", toggleSideBar);
        document.getElementById("hide-button").addEventListener("click", toggleSideBar);
        document.getElementById("edit-bar-button").addEventListener("click", toggleEdit);
        
        document.getElementsByClassName("property-page-header")[0].addEventListener("click", pageFirst);
        document.getElementsByClassName("property-page-header")[1].addEventListener("click", pageSecond);
        document.getElementsByClassName("property-page-header")[2].addEventListener("click", pageThird);
        document.getElementsByClassName("property-page-container")[0].addEventListener("click", pageFirst);
        document.getElementsByClassName("property-page-container")[1].addEventListener("click", pageSecond);
        document.getElementsByClassName("property-page-container")[2].addEventListener("click", pageThird);
        const allComponents = document.getElementsByClassName("component-wrapper");
        
        Array.prototype.forEach.call(allComponents, (item) => {
            item.addEventListener('click', addComponent);
        });
        // grab to pan is something you need to import http://rob--w.github.io/grab-to-pan.js/demo.html
        // document.getElementById('hand-pan').onchange = function () {
        //     if (this.checked) g2p.activate();
        //     else g2p.deactivate();
        // };
        // var scrollableContainer = document.getElementById('scrollable-container');
        // var g2p = new GrabToPan({
        //     element: scrollableContainer, // required
        // });
        // g2p.activate();


        app  = new example.Application();
        // 10   = Grid size
        // true = consider zoom and resize the grid
        app.view.installEditPolicy(new draw2d.policy.canvas.SnapToGeometryEditPolicy());
        app.view.installEditPolicy(new draw2d.policy.canvas.SnapToInBetweenEditPolicy());
        app.view.installEditPolicy(new draw2d.policy.canvas.SnapToCenterEditPolicy());
        app.view.installEditPolicy( new draw2d.policy.connection.DragConnectionCreatePolicy({
            createConnection: function(sourcePort, targetPort){
                var c = new draw2d.Connection();
                
                c.setColor("#656565")
                c.setOutlineStroke(1);
                c.setRadius(3);
                c.setStroke(5);
                c.setRouter(new draw2d.layout.connection.InteractiveManhattanConnectionRouter());
                c.setTargetDecorator(new draw2d.decoration.connection.ArrowDecorator());
                c.getTargetDecorator().setBackgroundColor('#656565');
                c.getTargetDecorator().setDimension(30,30);
                return c;
            }
        }));
        app.view.on("figure:remove", function(emitter, event){ //make sure simulation matches view port on delete
            if (event.figure.cssClass != "draw2d_Connection")
                simJson.blocks.splice(simJson.blocks.indexOf(simJson.blocks.find(block => block.id == event.figure.id)), 1).concat(simJson.blocks.splice(simJson.blocks.indexOf(simJson.blocks.find(block => block.id == event.figure.id)), -1));
        });

    });





    function toggleSideBar()
    {
        const sidebarEl = document.getElementsByClassName("sidebar")[0]; //find element 
        sidebarEl.classList.toggle("sidebar--isHidden"); //toggle?
        if (sidebarEl.classList.length == 1)
        {
            const addButton = document.getElementsByClassName("tool")[3];
            addButton.classList.add("clicked");
            const addbar = document.getElementsByClassName("add-bar")[0];
            addbar.classList.remove("hidden");
            const editbar = document.getElementsByClassName("edit-bar")[0];
            editbar.classList.add("hidden");
        }
        else
        {
            const addButton = document.getElementsByClassName("tool")[3];
            addButton.classList.remove("clicked");
        }
        const moveButtons = document.getElementsByClassName("buttons")[0];
        moveButtons.classList.toggle("buttons--isMoved");
        const editButton = document.getElementsByClassName("tool")[2];
        editButton.classList.remove("clicked");
        //document.getElementById("toggle").innerHTML = sidebarEl.classList.contains("sidebar--isHidden")? "Show Sidebar": "Hide Sidebar";
    }
    function toggleEdit()
    {
        const sidebarEl = document.getElementsByClassName("sidebar")[0]; //find element 
        sidebarEl.classList.toggle("sidebar--isHidden"); //toggle?
        if (sidebarEl.classList.length == 1)
        {
            const editButton = document.getElementsByClassName("tool")[2];
            editButton.classList.add("clicked");
            const addbar = document.getElementsByClassName("add-bar")[0];
            addbar.classList.add("hidden");
            const editbar = document.getElementsByClassName("edit-bar")[0];
            editbar.classList.remove("hidden");
        } else
        {
            const editButton = document.getElementsByClassName("tool")[2];
            editButton.classList.remove("clicked"); 
        }
        const moveButtons = document.getElementsByClassName("buttons")[0];
        moveButtons.classList.toggle("buttons--isMoved");
        const addButton = document.getElementsByClassName("tool")[3];
        addButton.classList.remove("clicked");
        //document.getElementById("toggle").innerHTML = sidebarEl.classList.contains("sidebar--isHidden")? "Show Sidebar": "Hide Sidebar";
    }
    
    </script>
    <script src="{{URL('guiFunctions.js')}}"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <title>Design tester</title>

    <style>
        div>mjx-container[jax="CHTML"][display="true"] {
            display:inline;
        }
        body 
        {
            margin: 0px;
            background-color: #414141;
            color:#c696d8;
            font-family: Arial, sans-serif;
            height: 100vh;
            width: 100%;
        }
        p
        {
            display: inline;
        }
        .subheader
        {
            height: 60px;
            background-color: #4c4c4c;
            position: fixed;
            top: 0;
            left: 0;
            width: 650px;
            font-size: 50px;
            font-weight:bold;
            display: flex;
            flex-flow: row nowrap;
            justify-content: flex-start;
            column-gap: 0;
            align-items: center;
    
        }
        .subheader-element > *
        {
            margin: 0px 20px;
            height: 100%;

        }
        .subheader-element 
        {
            height:100%;
        }
        .toolbar
        {
            width: 60px;
            background-color: #5b5b5b;
            position: fixed;
            top: 150px;
            left: 20px;   
            border-radius: 10px;       
            display: flex;
            flex-flow: column nowrap;
            justify-content: center;
            align-items: center;
        }
        .subheader-element>span>i, #hide-button>i, .the-button>span>i, .the-button>i
        {
            font-size: 50px;
        }
        .toolbar>.tool>i 
        {
            font-size: 50px;
            width: 100%;
            margin: 10px 0;
        }
        .tool {
            width: 100%;
        }
        #first-tool 
        {
            margin-top:20px;
        }
        #last-tool
        {
            margin-bottom:20px;
        }
        .ft 
        {
            border-radius: 10px 10px 0 0;
        }
        .lt 
        {
            border-radius: 0 0 10px 10px;
        }
        .clickable:hover 
        {
            filter: brightness(0.6);
            cursor: pointer;
            background-image: linear-gradient(rgb(0 0 0/40%) 0 0);
        }
        .clickable2:hover 
        {
            cursor: pointer;
            background-image: linear-gradient(rgb(0 0 0/80%) 0 0);
        }
        .clicked
        {
            filter: brightness(0.6);
            background-image: linear-gradient(rgb(0 0 0/40%) 0 0);
            color: #c696d8;
            font-weight: bold;
        }
        .material-symbols-outlined {
        font-variation-settings:
        'FILL' 1,
        'wght' 400,
        'GRAD' 0,
        'opsz' 48
        }
        .vcentre 
        {
            display: flex;
            flex-flow: column nowrap;
            justify-content: center;
            align-items: center;
        }
        .sidebar
        {
            height: 100%;
            width: 600px;
            right: 0;
            position: fixed;
            background-color: #4c4c4c;
            transition: transform 300ms ease-out;
        }
        #hide-button
        {
            position: absolute;
            left:0;
            top: 45%;
            height: 10%;
            width: 10%;
            border-radius: 5px;
            background-color: #5b5b5b; 
        }
        .sidebar--isHidden
        {
            transform: translateX(600px);
            transition: transform 300ms ease-out;
        }
        .buttons--isMoved
        {
            transform: translateX(-600px);
            transition: transform 300ms ease-in;
        }
        .zoom-buttons
        {
            position: relative;
            bottom: 150px;
            right: 20px;
            width:70px;
            margin: 0;
            display: flex;
            flex-flow: column nowrap;
            justify-content: flex-start;
            align-items: center;
        }
        .zoom-buttons > *
        {
            height: 60px;
            width: 60px;
            background-color: #5b5b5b;
            
        }
        .zoom 
        {
            border-radius: 20px 20px 0 0;
        }
        .unzoom 
        {
            border-radius: 0px 0px 20px 20px;
        }
        .buttons
        {
            transition: transform 300ms ease-out;
            position:absolute;
            bottom:0;
            right:0;
            margin:0;
        }
        .simulate-button
        {
            position: fixed;
            padding: 15px;
            bottom: 40px;
            right: 120px;
            font-size: 50px;
            font-weight: bold;
            background-color: #5b5b5b;
            border-radius: 20px;
        }
        .add-bar, .edit-bar
        {
            margin-left:12%;
        }
        .add-bar-header 
        {
            font-size: 40px;
            color:#d9d9d9;
            background-color: #b475cc;
            font-weight: bold;
            width:300px;
            border-radius: 20px;
            margin-top:30px;
            margin-bottom:30px;
            padding:8px;

        }
        .add-bar-sinks 
        {
            color:#ded74e;
        }
        .add-bar-functions 
        {
            color:#4ae159;
        }
        .add-bar-sources
        {
            color:#41a7eb;
        }
        .add-section-head 
        {
            font-size: 30px;
        }
        .add-section-body
        {
            height:150px;
            background-color: #575757;
            width:95%;
            margin: 5px 0;
            border-radius: 10px;
            display: flex;
            flex-flow: row nowrap;
            justify-content: flex-start;
            column-gap: 10px;
            align-items: center;
            overflow-x:scroll;
            overflow-y:hidden;
        }
        .component-wrapper 
        {
            height:140px;
            width:120px;
            display: flex;
            flex-flow: column nowrap;
            justify-content:center;
            align-items: center;
        }
        .component 
        {
            width:120px;
            height:100px;

        }
        .component>i 
        {
            font-size: 70px;
        
        }
        .component-header 
        {
            height: 40px;
            text-align: center;
        }
        /* width */
        ::-webkit-scrollbar {
        
        height: 15px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
        background: #575757;
        border-radius: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
        background: #454545;
        border-radius: 15px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
        background: #404040;
        }
        #canvas 
        {
            height:100%;
            width:100%;
        }
         button, a
        {
            background: none;
            color: inherit;
            border: none;
            padding: 0;
            font: inherit;
            cursor: pointer;
            outline: inherit;
            height:100%;
            width:100%;
            text-decoration: none;
        } 
        span
        {
            background: none;
            color: inherit;
            border: none;
            padding: 0;
            font: inherit;
            cursor: pointer;
            outline: inherit;
            display: block;
            display: flex;
            flex-flow: column nowrap;
            justify-content: center;
            align-items: center;
        }
        #canvas
        {
            position:absolute;
            overflow: scroll;
            height:100%;
            width:100%;
        }
         /* width */
        #canvas::-webkit-scrollbar {
            display:none;
        }
        /* Track */
        #canvas::-webkit-scrollbar-track {
        display:none;
        }
        /* Handle */
        #canvas::-webkit-scrollbar-thumb {
        display:none;
        }
        /* Handle on hover */
        #canvas::-webkit-scrollbar-thumb:hover {
        display:none;
        }
        .hidden 
        {
            display:none;
        } 
        .property-pages
        {
            height:600px;
            color:#b1b1b1;
        }
    
        .p-headers 
        {
            display: flex;
            flex-flow: row nowrap;
            justify-content: flex-start;
            color:#b1b1b1;
        }
        .property-page-header
        {
        
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
            text-align: center;
            font-size:30px;
            font-weight: bold;
            background-color: #525252;
            width:150px;
            padding:10px 10px;
            z-index:4;
            transition: transform 300ms ease-in-out;
        }
        .property-page-container 
        {
            border-top-left-radius: 10px;
            width:100%;
          /*  background-color: #525252;*/
            height: 600px;
            
            padding: 30px 10px 10px 10px;
            display: flex;
            flex-flow: column nowrap;
            justify-content: flex-start;
            row-gap: 15px;
            position: absolute;
            width:100%; 
            transition: transform 300ms ease-in-out;
            overflow-y: scroll;
        }
        .property-category 
        {
           /* background-color:#575757;*/
            background-color: inherit;
            filter: brightness(1.1);
            width:100%;
            padding:10px;
            border-radius: 10px;
        }
        .property-category-heading 
        {
            font-size: 25px;
            text-decoration: underline;
        }
        .property-category-body 
        {
            background-color: inherit;
        }
        .property-category-body>*
        {
            font-size: 25px;
            background-color: inherit;
        }
        .property-section 
        {
            display: flex;
            flex-flow: row nowrap;
            justify-content: flex-start;
            column-gap: 15px;
            align-items: center;
            margin:10px;
            background-color: inherit;
        }
        .property-label 
        {
            width:160px;
            text-align: center;
        }
        .property-value
        {
            background-color: inherit;
        }
        .property-value>input, .property-value>div
        {
            border-radius: 10px;
            border-style: none;
            height: 30px;
         /*   background-color: #5b5b5b;*/
            background-color: inherit;
            filter: brightness(1.2);
            width: 258px;
          
            padding:5px 10px;
            color:#d9d9d9;
        }
        .value-page
        {
            z-index: 1;
            background-color: #4f4f5b;
        }
        .simulation-page 
        {
            z-index:2;  
            background-color: #4f545b;
        }
        .custom-page 
        {
            z-index: 0;
            background-color: #574e5c;
        }
        .vertical-moved 
        {
            transform: translateY(500px);
            transition: transform 300ms ease-out;
        }
        .color1[type="color"] {
        -webkit-appearance: none;
        -moz-appearance: none;     
        cursor: pointer;
        overflow:hidden;
        padding: 0;
        }
        .color1::-webkit-color-swatch {
        border-radius: 15px;
        border: none;
        }
        .color1::-moz-color-swatch {
        border-radius: 15px;
        border: none;
        }
    

.radio-section {
    height:50px;
}

.button-cover, .knobs, .layer
{
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

.button
{
    position: relative;
    
    width: 74px;
    height: 36px;
    
    overflow: hidden;
}

.button.r, .button.r .layer
{
    border-radius: 100px;
}

.button.b2
{
    border-radius: 2px;
}

.checkbox
{
    position: relative;
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
    opacity: 0;
    cursor: pointer;
    z-index: 3;
}

.knobs
{
    z-index: 2;
}

.layer
{
    width: 100%;
    background-color: inherit;
    filter: brightness(1.2);
    transition: 0.3s ease all;
    z-index: 1;
}

/* Button 1 */
#button-1 .knobs:before
{
    content: '+';
    position: absolute;
    top: 4px;
    left: 4px;
    width: 20px;
    height: 10px;
    color: #fff;
    font-size: 10px;
    font-weight: bold;
    text-align: center;
    line-height: 1;
    padding: 9px 4px;
    background-color: #8b6196;
    border-radius: 50%;
    transition: 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15) all;
}

#button-1 .checkbox:checked + .knobs:before
{
    content: '-';
    left: 42px;
    background-color: #af72b8;
}

#button-1 .checkbox:checked ~ .layer
{
    background-color: inherit;
    filter: brightness(1.2);
}

#button-1 .knobs, #button-1 .knobs:before, #button-1 .layer
{
    transition: 0.3s ease all;
}

    </style>
</head>
<body id="container">
    <div id="canvas"> </div>
        <!-- SUBHEADER-->
        <div class="subheader">
        <div class="subheader-element clickable"><a href="{{route('home')}}">Home</a></div>
            <div class="subheader-element clickable"><p>File</p></div>
            <div class="subheader-element clickable"><p>Save</p></div>
            <div class="subheader-element clickable" id="undo-button"><i class="material-symbols-outlined vcentre">undo</i></div>
            <div class="subheader-element clickable" id="redo-button"><i class="material-symbols-outlined vcentre">redo</i></div>
        </div>

        <!-- TOOL BAR-->
        <div class="toolbar">
        <div class="tool clickable ft"> <i class=" material-symbols-outlined vcentre" id="first-tool">arrow_selector_tool</i> </div>
        <div class="tool clickable" id="hand-pan"><i class="material-icons vcentre">back_hand</i></div>
        <div class="tool clickable" id="edit-bar-button"><i class="material-icons vcentre">edit</i></div>
        <div class="tool clickable" id="show"><i class=" material-icons vcentre">add_box</i></div>
        <div class="tool clickable lt"><i class="last-tool material-icons vcentre" id="last-tool">brush</i></div>
        
        </div>

        <!-- OVERLAY BUTTONS-->
        <div class="buttons">
            <div class="button-element zoom-buttons">
                <div class="clickable zoom vcentre" >
                    <button id="zoom-in-button" class="the-button"><i class="material-icons vcentre">add</i></button>
                </div>
                <div class="clickable fit-screen vcentre" id="fit-button">
                    <button id="fit-button" class="the-button"><i class="material-icons">fit_screen</i></button>
                </div>
                <div class="clickable unzoom vcentre" id="zoom-out-button">
                    <button id="zoom-out-button" class="the-button"><i class="material-icons vcentre">remove</i></button>
                </div>
            </div>
            <div class="button-element simulate-button clickable" onclick="simulate()">Simulate</div>
        </div>

        <!-- SIDEBAR-->
        <div class="sidebar sidebar--isHidden">
            <div id="hide-button" class="clickable vcentre"><i class="material-icons">chevron_right</i></div>
            <!-- ADDBAR-->
            <div class="add-bar">
                <div class="vcentre">
                    <div class="add-bar-element add-bar-header vcentre">Add Element:</div> 
                </div>

                <!-- SOURCES-->
                <div class="add-bar-element add-bar-sources">
                    <div class="add-section-head">Sources:</div>
                    <div class="add-section-body">
                        <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">escalator</i></div>
                            <div class="component-header vcentre sources">Step</div>
                        </div>
                        <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">priority_high</i></div>
                            <div class="component-header vcentre sources">Impulse</div>
                        </div>
                        <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">timeline</i></div>
                            <div class="component-header vcentre sources">Polynomial</div>
                        </div>
                        <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">waves</i></div>
                            <div class="component-header vcentre sources">Trig</div>
                        </div>
                        <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">repeat_one</i></div>
                            <div class="component-header vcentre sources">Constant</div>
                        </div>
                    </div>
                </div>

                <div></div>
                <!-- FUNCTIONS-->
                <div class="add-bar-element add-bar-functions">
                    <div class="add-section-head">Functions:</div>
                    <div class="add-section-body">
                    <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">playlist_add</i></div>
                            <div class="component-header vcentre functionsy">Adder</div>
                        </div>
                        <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">functions</i></div>
                            <div class="component-header vcentre functionsy">Integrator</div>
                        </div>
                        <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">tune</i></div>
                            <div class="component-header vcentre functionsy">Transfer Function</div>
                        </div>
                        <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">close</i></div>
                            <div class="component-header vcentre functionsy">Gain</div>
                        </div>
                        <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">input</i></div>
                            <div class="component-header vcentre functionsy">Buffer</div>
                        </div>
                        <!-- <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">waves</i></div>
                            <div class="component-header vcentre functionsy">Trig</div>
                        </div>
                        <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">timeline</i></div>
                            <div class="component-header vcentre functionsy">Polynomial</div>
                        </div> -->
                    </div>
                </div>


                <!-- SINKS-->
                <div class="add-bar-element add-bar-sinks">
                    <div class="add-section-head">Sinks:</div>
                    <div class="add-section-body">
                        <div class="component-wrapper clickable">
                            <div class="component vcentre"><i class="material-icons vcentre">desktop_windows</i></div>
                            <div class="component-header vcentre sinks">Scope</div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- EDIT BAR-->
            <div class="edit-bar">
                <div class="vcentre">
                    <div class="add-bar-element add-bar-header vcentre">Edit Element:</div> 
                </div>
                <div class="p-headers">
                    <div class="property-page-header simulation-page">Simulation</div>
                    <div class="property-page-header value-page" id="values-header">Values</div>
                    <div class="property-page-header custom-page" id="custom-header">Customise</div>
                </div>
                <div class="property-pages">

                        <div class="property-page-container simulation-page" style="border-top-left-radius: 0px;" id="simulation_page">
                            
                                <!-- <div class="property-category">
                                    <div class="property-category-heading">Transfer</div>
                                    <div class="property-category-body">
                                        <div class="property-section"><div class="property-label">num</div><div class="property-value"> <input id="" type="text" class="form-control"/></div></div>
                                        <div class="property-section"><div class="property-label">den</div><div class="property-value"> <input id="" type="text" class="form-control"/></div></div>
                                    </div>
                                </div>

                                <div class="property-category">
                                    <div class="property-category-heading">Debug</div>
                                    <div class="property-category-body">
                                        <div class="property-section"><div class="property-label">id</div><div class="property-value"> <input id="" type="text" class="form-control"/></div></div>
                                    </div>
                                </div> -->
 
                        </div>

                        <div class="property-page-container value-page">
                                <div class="property-category"  id="position_panel">
                                    <div class="property-category-heading">Position</div>
                                    <div class="property-category-body">
                                        <div class="property-section"><div class="property-label">x</div><div class="property-value"> <input id="property_position_x" type="text" class="form-control"/></div></div>
                                        <div class="property-section"><div class="property-label">y</div><div class="property-value"> <input id="property_position_y" type="text" class="form-control"/></div></div>
                                    </div>
                                </div>

                                <div class="property-category">
                                    <div class="property-category-heading">Debug</div>
                                    <div class="property-category-body">
                                        <div class="property-section"><div class="property-label">id</div><div class="property-value"> <input id="property_id" type="text" class="form-control"/></div></div>
                                        <div class="property-section radio-section"><div class="property-label">id</div>
                                            
                                                <div class="button r" id="button-1">
                                                    <input type="checkbox" class="checkbox">
                                                    <div class="knobs"></div>
                                                    <div class="layer"></div>
                                                </div>
                                            
                                        </div>
                                    
                                    
                                    </div>
                                </div>
                            </div>
                  
                
                        <div class="property-page-container custom-page" id="color_panel">
                                <div class="property-category">
                                    <div class="property-category-heading">Coloring</div>
                                    <div class="property-category-body">
                                        <div class="property-section"><div class="property-label">Background Color</div><div class="property-value"> <input id="property_bg_color" type="color" class="form-control color1"/></div></div>
                                        <div class="property-section"><div class="property-label">Border Color</div><div class="property-value"> <input id="property_border_color" type="color" class="form-control color1"/></div></div>
                                    </div>
                                </div>
    
                                <div class="property-category">
                                    <div class="property-category-heading">Graph</div>
                                    <div class="property-category-body">
                                        
                                    </div>
                                </div>
                        </div>
                    
                
                </div>
            </div>

        </div>
    
    
</body>
</html>