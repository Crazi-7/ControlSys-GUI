example.PropertyPane = Class.extend({
	
	init:function(elementId, view)
	{
		this.html = $("#"+elementId);
		this.view = view;

		// Databinding: helper attributes for the databinding
		this.selectedFigure = null;
		this.updateCallback = null;
		
        view.on("select", $.proxy(this.onSelectionChanged,this));
    },

	/**
	 * @method
	 * Called if the selection in the canvas has been changed. You must register this
	 * on the canvas to receive this event.
	 *
     * @param {draw2d.Canvas} emitter
     * @param {Object} event
     * @param {draw2d.Figure} event.figure
	 */
	onSelectionChanged : function(emitter, event)
	{
		// Databinding: deregister the old update listener
		if(this.selectedFigure!==null && this.updateCallback !==null){
			this.selectedFigure.off(this.updateCallback);
		}
		
		this.selectedFigure = event.figure;
		
        this.html.html("");
        if(event.figure instanceof draw2d.shape.node.Node){
        	this.showPropertiesOpAmp(event.figure);
        }
	},

	/**
	 * @method
	 * Called if the selection in the canvas has been changed. You must register this
	 * on the canvas to receive this event.
	 * 
	 * @param {draw2d.Figure} figure
	 */
	showPropertiesOpAmp : function(figure)
	{
        // Set some good defaults
        // (better you create  new class and set the defaults in the init method)
     
        
    	// Databinding: Figure --> UI
        //
        var isInUpdate=false;
    	figure.on("move",function(){
    		if(isInUpdate) return;
    		isInUpdate = true; // avoid recursion

            //values
    		$("#property_position_x").val(figure.getPosition().x);
       		$("#property_position_y").val(figure.getPosition().y);
            $("#property_id").val(figure.id);

            //style
           
            $("#property_bg_color").val(rgbToHex(figure.bgColor.red ,figure.bgColor.green, figure.bgColor.blue));
            $("#property_border_color").val(rgbToHex(figure.color.red, figure.color.green, figure.color.blue));
           
       		isInUpdate=false;

            let targetBlock = simJson.blocks.find(block => block.id === figure.id); 
            if (targetBlock == undefined) //undo and redo messes up these values with delete
            {
                targetBlock = figure.getUserData().block;
                simJson.blocks.push(targetBlock);
            }
            switch(targetBlock.type)
            {
                case "Step":
                    $("#simulation_page").empty().append(`
                    <div class="property-category">
                    <div class="property-category-heading">Input</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Type</div><div class="property-value"> <input id="" type="text" value="Step" class="form-control"/></div></div>
                    </div>
                    </div>
                    <div class="property-category input_step">
                        <div class="property-category-heading">Values</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Step Value</div><div class="property-value"> <input id="step_value" type="text" class="form-control"/></div></div>
                        <div class="property-section"><div class="property-label">Step Time</div><div class="property-value"> <input id="step_time" type="text" class="form-control"/></div></div>
                    </div>
                    </div>
                    `);
                    $("#step_value").val(targetBlock.details.input_details.step_value);
                    $("#step_time").val(targetBlock.details.input_details.step_time);
                    
                    $(".input_step input").on("change", function(){
                        targetBlock.details.input_details.step_value = parseFloat($("#step_value").val());
                        targetBlock.details.input_details.step_time = parseFloat($("#step_time").val());
                        figure.setUserData(userData={block:targetBlock});
                       });
                 
                    break;
                case "Impulse":
                    
                    $("#simulation_page").empty().append(`
                    <div class="property-category">
                    <div class="property-category-heading">Input</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Type</div><div class="property-value"> <input id="" type="text" value="Impulse" class="form-control"/></div></div>
                    </div>
                    </div>
                    <div class="property-category input_step">
                        <div class="property-category-heading">Values</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Impulse Value</div><div class="property-value"> <input id="impulse_value" type="text" class="form-control"/></div></div>
                        <div class="property-section"><div class="property-label">Impulse Time</div><div class="property-value"> <input id="impulse_time" type="text" class="form-control"/></div></div>
                    </div>
                    </div>
                    `);
                    $("#impulse_value").val(targetBlock.details.input_details.impulse_value);
                    $("#impulse_time").val(targetBlock.details.input_details.impulse_time);
                    $(".input_step input").on("change", function(){
                        targetBlock.details.input_details.impulse_value = parseFloat($("#impulse_value").val());
                        targetBlock.details.input_details.impulse_time = parseFloat($("#impulse_time").val());
                        figure.setUserData(userData={block:targetBlock});
                       });
                    break;
                case "Polynomial":
                                   
                    $("#simulation_page").empty().append(`
                    <div class="property-category">
                    <div class="property-category-heading">Input</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Type</div><div class="property-value"> <input id="" type="text" value="Polynomial" disabled="disabled" class="form-control"/></div></div>
                    </div>
                    </div>
                    <div class="property-category input_step">
                        <div class="property-category-heading">Values</div>
                    <div class="property-category-body vcentre">
                        <div class="property-section"><div class="property-label">Function</div><div class="property-value"> <input id="poly_function" type="text" class="form-control" /></div></div>
                        <button class="clickable render-button">Click to render</button>
                        <div class="property-section"><div class="property-label">Render</div><div class="property-value"> <div id="poly_function_ready" type="text" class="form-control"/></div></div></div>
                    </div>
                    </div>
                    `);
                    let polyfunc = targetBlock.details.input_details.function.reduce(
                        (accumulator, currentValue) => accumulator +=  " "+currentValue
                      );
                    $("#poly_function").val(polyfunc);
                      console.log("triggered");
                      console.log($(".input_step input"));
                      $(".input_step input").on("change", function(){
                        // targetBlock.details.input_details.impulse_value = parseFloat($("#impulse_value").val());
                        targetBlock.details.input_details.function = textToArray($("#poly_function").val());
                        $("#poly_function_ready").empty();
                        render("poly_function", "poly_function_ready"); //render text, destination id    
                        figure.setUserData(userData={block:targetBlock});
                       });

                       $(".input_step button").on("click", function(){
                        $("#poly_function_ready").empty();
                        render("poly_function", "poly_function_ready"); //render id, destination id
                       });
      
                    break;
                case "Trig":
                
                    $("#simulation_page").empty().append(`
                    <div class="property-category input_step">
                    <div class="property-category-heading">Input</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Type</div><div class="property-value"> <input id="" type="text" value="Sin" class="form-control"/></div></div>
                    </div>
                    </div>
                    <div class="property-category input_step">
                        <div class="property-category-heading">Values</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Amplitude</div><div class="property-value"> <input id="input_amplitude" type="text" class="form-control"/></div></div>
                        <div class="property-section"><div class="property-label">Frequency</div><div class="property-value"> <input id="input_frequency" type="text" class="form-control"/></div></div>
                        <div class="property-section"><div class="property-label">Phase</div><div class="property-value"> <input id="input_phase" type="text" class="form-control"/></div></div>
                        <div class="property-section"><div class="property-label">DC</div><div class="property-value"> <input id="input_dc" type="text" class="form-control"/></div></div>
                    </div>
                    </div>
                    `);
                    $("#input_amplitude").val(targetBlock.details.input_details.amplitude);
                    $("#input_frequency").val(targetBlock.details.input_details.frequency);
                    $("#input_phase").val(targetBlock.details.input_details.phase);
                    $("#input_dc").val(targetBlock.details.input_details.dc);
                    $(".input_step input").on("change", function(){
                        targetBlock.details.input_details.amplitude = parseFloat($("#input_amplitude").val());
                        targetBlock.details.input_details.frequency = parseFloat($("#input_frequency").val());
                        targetBlock.details.input_details.phase = parseFloat($("#input_phase").val());
                        targetBlock.details.input_details.dc = parseFloat($("#input_dc").val());
                        figure.setUserData(userData={block:targetBlock});
                       });
                    break;
                case "Constant":          
                    $("#simulation_page").empty().append(`
                    <div class="property-category input_step">
                    <div class="property-category-heading">Input</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Type</div><div class="property-value"> <input id="" type="text" value="Constant" class="form-control"/></div></div>
                    </div>
                    </div>
                    <div class="property-category input_step">
                        <div class="property-category-heading">Values</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Constant Value</div><div class="property-value"> <input id="constant_value" type="text" class="form-control"/></div></div>
                    
                    </div>
                    </div>
                    `);
                    $("#constant_value").val(targetBlock.details.input_details.value);
                    $(".input_step input").on("change", function(){
                        targetBlock.details.input_details.value = parseFloat($("#constant_value").val());
                        figure.setUserData(userData={block:targetBlock});
                       });
                 
                    break;
                case "Adder":
                    // details =
                    // {
                    //     inputs: 2,
                    //     input_nets: [-1,-1],
                    //     input_signs: [1,1] 
                    // };
                    $("#simulation_page").empty().append(`
                    <div class="property-category input_step">
                    <div class="property-category-heading">Function</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Type</div><div class="property-value"> <input id="" type="text" value="Adder" class="form-control"/></div></div>
                    </div>
                    </div>
                    <div class="property-category input_step">
                        <div class="property-category-heading">Values</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Number of Inputs</div><div class="property-value"> <input id="adder_inputs" type="text" class="form-control"/></div></div>
                    </div>
                    </div>
                    <div class="property-category input_step">
                        <div class="property-category-heading">Inputs</div>
                    <div class="property-category-body">
                    <div class="property-section"><div class="property-label">Number of Inputs</div><div class="property-value radio-div">
                        <div class="button r" id="button-1">
                            <input type="checkbox" class="checkbox">
                            <div class="knobs"></div>
                            <div class="layer"></div>
                        </div>
                    </div></div>
                        
                    </div>
                    </div>
                    `);
                    $("#adder_inputs").val(targetBlock.details.inputs);
                    $("#adder_signs").val(targetBlock.details.input_signs);
                    //
                    // many changes
                    //
                    break;
                case "Integrator":
                   
                    $("#simulation_page").empty().append(`
                    <div class="property-category input_step">
                    <div class="property-category-heading">Function</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Type</div><div class="property-value"> <input id="" type="text" value="Integrator" class="form-control"/></div></div>
                    </div>
                    </div>
                    <div class="property-category input_step">
                        <div class="property-category-heading">Values</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Initial Value</div><div class="property-value"> <input id="initial_value" type="text" class="form-control"/></div></div>
                    
                    </div>
                    </div>
                    `);
                    $("#initial_value").val(targetBlock.details.initial_value);
                    
                    $(".input_step input").on("change", function(){
                        targetBlock.details.initial_value = parseFloat($("#initial_value").val());
                        figure.setUserData(userData={block:targetBlock});
                       });
                 
                    break;
                case "Transfer Function":
                    $("#simulation_page").empty().append(`
                    <div class="property-category">
                    <div class="property-category-heading">Input</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Type</div><div class="property-value"> <input id="" type="text" value="Step" class="form-control"/></div></div>
                    </div>
                    </div>
                    <div class="property-category input_step">
                        <div class="property-category-heading">Values</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Numerator</div><div class="property-value"> <input id="num_function" type="text" class="form-control"/></div></div>
                        <hr>
                        <div class="property-section"><div class="property-label">Denominator</div><div class="property-value"> <input id="den_function" type="text" class="form-control"/></div></div>
                    </div>
                    </div>
                   <div class="vcentre rendoor"> <button class="clickable render-button">Click to render</button> </div>
                    <div class="property-category input_step" style="margin-bottom:200px;">
                        <div class="property-category-heading">Rendered</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Numerator</div><div class="property-value"> <div id="num_function_ready" class="form-control"/></div></div>
                        <hr>
                        <div class="property-section"><div class="property-label">Denominator</div><div class="property-value"> <div id="den_function_ready" class="form-control"/></div></div>
                    </div>
                    </div>
                  
                    `);

                    $("#num_function").val(targetBlock.details.transfer_function[0].reduce(
                        (accumulator, currentValue) => accumulator +=  " "+currentValue
                    ));
                    $("#den_function").val(targetBlock.details.transfer_function[1].reduce(
                        (accumulator, currentValue) => accumulator +=  " "+currentValue
                    ));

                    
                      $(".input_step input").on("change", function(){
                        // targetBlock.details.input_details.impulse_value = parseFloat($("#impulse_value").val());
                        targetBlock.details.transfer_function[0] = textToArray($("#num_function").val());
                        targetBlock.details.transfer_function[1] = textToArray($("#den_function").val());
                        $("#num_function_ready").empty();
                        render("num_function", "num_function_ready"); //render text, destination id    
                        setTimeout(function(){}, 50); 
                        $("#den_function_ready").empty();
                        render("den_function", "den_function_ready"); //render text, destination id   
                        figure.setUserData(userData={block:targetBlock});
                       });

                       $(".rendoor button").on("click", function(){
                        $("#num_function_ready").empty();
                        render("num_function", "num_function_ready"); //render text, destination id 
                        setTimeout(function(){}, 50);   
                        $("#den_function_ready").empty();
                        render("den_function", "den_function_ready"); //render text, destination id   
                       });
      

                    break;
                case "Gain":
                  
                    $("#simulation_page").empty().append(`
                    <div class="property-category input_step">
                    <div class="property-category-heading">Function</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Type</div><div class="property-value"> <input id="" type="text" value="Gain" class="form-control"/></div></div>
                    </div>
                    </div>
                    <div class="property-category input_step">
                        <div class="property-category-heading">Values</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Gain Value</div><div class="property-value"> <input id="gain_value" type="text" class="form-control"/></div></div>
                    
                    </div>
                    </div>
                    `);
                    $("#gain_value").val(targetBlock.details.gain);
                    $(".input_step input").on("change", function(){
                        targetBlock.details.gain = parseFloat($("#gain_value").val());
                        figure.setUserData(userData={block:targetBlock});
                       });
                    break;
                case "Buffer":
                    $("#simulation_page").empty().append(`
                    <div class="property-category input_step">
                    <div class="property-category-heading">Function</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Type</div><div class="property-value"> <input id="" type="text" value="Buffer" class="form-control"/></div></div>
                    </div>
                    </div>
                    `);  
                    
                    break;
                case "Scope":
                    $("#simulation_page").empty().append(`
                    <div class="property-category input_step">
                    <div class="property-category-heading">Output</div>
                    <div class="property-category-body">
                        <div class="property-section"><div class="property-label">Type</div><div class="property-value"> <input id="" type="text" value="Scope" class="form-control"/></div></div>
                    </div>
                    </div>
                    <div class="property-category input_step">
                        <div class="property-category-heading">Values</div>
                    <div class="property-category-body vcentre">
                    <div id="simulation-graph" style="width:400px;height:300px;margin:0;filter: brightness(1.25);border-radius:10px;"></div>
                    
                    </div>
                    </div>
                    <div style="height:400px"> </div>
                    
                    `);
                   // $("#gain_value").val(targetBlock.details.gain);
                   simulationG = document.getElementById('simulation-graph');
                   Plotly.newPlot( simulationG, [{
                   x: targetBlock.details.time,
                   y: targetBlock.details.series }], 
                   {
                           
                           title:{
                           text: 'Input Response',
                           font: {
                               size: 23,
                               color: 'lightgrey',
                           }
                           } ,
                           color: "lightgrey",
                       margin: { t: 50 },
                       plot_bgcolor: "#4f545b",
                       paper_bgcolor: "#4f545b",
                       xaxis: {
                           title: 'Time (s)',
                           color: 'lightgrey',
                           titlefont: {
                               family: 'Arial, sans-serif',
                               size: 18,
                               color: 'lightgrey'
                           },
                       },
                       yaxis: {
                           title: 'Output',
                           color: 'lightgrey',
                           titlefont: {
                               family: 'Arial, sans-serif',
                               size: 18,
                               color: 'lightgrey'
                           },
                       }
       
                   
                   } );
                    break;
    
            }
            
    
             
       	});
    	
    	// Databinding: UI --> Figure
        //
        
    	$("#position_panel input").on("change", function(){
    	    // with undo/redo support            
    	    var cmd = new draw2d.command.CommandMove(figure);
    	    cmd.setPosition(parseInt($("#property_position_x").val()),parseInt($("#property_position_y").val()));
    	    figure.getCanvas().getCommandStack().execute(cmd);
    	});
       
        $("#color_panel input").on("change", function(){
    	    // with undo/redo support  
            let colors = hexToRgb($("#property_bg_color").val());  
            var cmd = new draw2d.command.CommandAttr(figure, {bgColor:{red:colors.r,green:colors.g,blue:colors.b,alpha:1}}); 
    	    figure.getCanvas().getCommandStack().execute(cmd);
            colors = hexToRgb($("#property_border_color").val());  
            cmd = new draw2d.command.CommandAttr(figure, {color:{red:colors.r,green:colors.g,blue:colors.b,alpha:1}}); 
    	    figure.getCanvas().getCommandStack().execute(cmd);
    	});
       


	}
});

function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
  }
  function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
  }
  function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
      r: parseInt(result[1], 16),
      g: parseInt(result[2], 16),
      b: parseInt(result[3], 16)
    } : null;
  }

function textToArray(numId)
{
    var num = numId.trim();
    var i = 0;

    if (num.length == 0)
        num = "1";
    var numval= [];
    while (num.indexOf(" ") != -1)
    {
        numval[i] = parseInt(num);
        num = num.slice(num.indexOf(" "));    
        num = num.trimStart();   
        i++;
    }
    numval[i] = parseInt(num);
 
    numval = numval.reverse();
    
    nums = [... numval];
    return nums;
}

  function render(numId, outputId) {
    var num = document.getElementById(numId).value.trim();
    var i = 0;

    if (num.length == 0)
        num = "1";
    var numval= [];
    while (num.indexOf(" ") != -1)
    {
        numval[i] = parseInt(num);
        num = num.slice(num.indexOf(" "));    
        num = num.trimStart();   
        i++;
    }
    numval[i] = parseInt(num);
 
    numval = numval.reverse();
    ;
    nums = [... numval];
    
    var input = "";
    
    for (var j=numval.length-1;j>=0;j--)
    {
        var extra = "";
        var sign = "+";
        if (numval[j] == 0)
        input = input.slice(0, input.length - 1);
        else if (j > 1)
        {
            if (numval[j-1] < 0)
            {
                sign = "-";
                numval[j-1] = Math.abs(numval[j-1]);
            } else
            sign = "+";
            input += numval[j] + "x^" + j + sign;
        }
        else if (j>0)
        {
            if (numval[j-1] < 0)
            {
                sign = "-";
                numval[j-1] = Math.abs(numval[j-1]);
            } else
            sign = "+";
            input += numval[j] + "x" + sign;
        }
        else
        input += numval[j];
    }

    output = document.getElementById(outputId);
    output.innerHTML = '';
    console.log(output);

    MathJax.texReset();
    var options = MathJax.getMetricsFor(output);
    MathJax.tex2chtmlPromise(input, options).then(function (node) {
    output.appendChild(node);
    MathJax.startup.document.clear();
    MathJax.startup.document.updateDocument();
     });
     
 }   