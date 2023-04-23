function pageFirst()
{
    console.log("1");
    const pages = document.getElementsByClassName("property-page-container");
    const headers = document.getElementsByClassName("property-page-header");
            pages[0].classList.remove("vertical-moved");
            pages[1].classList.remove("vertical-moved");
            pages[2].classList.remove("vertical-moved");
            headers[0].classList.remove("vertical-moved");
            headers[1].classList.remove("vertical-moved");
            headers[2].classList.remove("vertical-moved");
}
function pageSecond()
{
    console.log("2");
    const pages = document.getElementsByClassName("property-page-container");
    const headers = document.getElementsByClassName("property-page-header");
    pages[0].classList.add("vertical-moved");
    pages[1].classList.remove("vertical-moved");
    pages[2].classList.remove("vertical-moved");
    headers[0].classList.add("vertical-moved");
    headers[1].classList.remove("vertical-moved");
    headers[2].classList.remove("vertical-moved");
}
function pageThird()
{
    console.log("3");
    const pages = document.getElementsByClassName("property-page-container");
    const headers = document.getElementsByClassName("property-page-header");
    pages[0].classList.add("vertical-moved");
    pages[1].classList.add("vertical-moved");
    pages[2].classList.remove("vertical-moved");
    headers[0].classList.add("vertical-moved");
    headers[1].classList.add("vertical-moved");
    headers[2].classList.remove("vertical-moved");
}



function addComponent(item)
    {
        
        
       var color;
        switch(item.currentTarget.childNodes[3].className.substr(25)) 
        {
            case "sources":
                // sources
                color = "#41a7eb";
                break;
            case "functionsy":
                //functions
                color = "#4ae159";
                break;
            default:
                //sinks
                color = "#ded74e";
        }
        
        var LabelRectangle= draw2d.shape.basic.Rectangle.extend({
            init:function(attr)
            {
                this._super(attr);
                var show=function(){this.setVisible(true);};
                var hide=function(){this.setVisible(false);};

                switch(item.currentTarget.childNodes[3].className.substr(25)) {
                    case "sources":
                        // sources
                        var output= this.createPort("output");
                        break;
                    case "functionsy":
                        //functions
                        var input = this.createPort("input");
                        input.on("connect",hide,input);
                        input.on("disconnect",show,input);

                        var output= this.createPort("output");
                        break;
                    default:
                        //sinks
                        var input = this.createPort("input");
                        input.on("connect",hide,input);
                        input.on("disconnect",show,input);
                }
                if (item.currentTarget.childNodes[3].innerHTML == "Adder")
                {
                    var input = this.createPort("input");
                    input.on("connect",hide,input);
                    input.on("disconnect",show,input);
                }
                // Create any Draw2D figure as decoration for the connection
                this.label = new draw2d.shape.basic.Label({text:item.currentTarget.childNodes[3].innerHTML, color:color, fontColor:"#0d0d0d"});
                // add the new decoration to the connection with a position locator.
                this.add(this.label, new draw2d.layout.locator.CenterLocator(this));
                this.label.installEditor(new draw2d.ui.LabelInplaceEditor());
            }
        })
        var rect = new LabelRectangle({width:100, height:80,bgColor: color, radius: 10});
        app.view.add(rect, 150+Math.random()*150,150+Math.random()*100);



        let details;

        switch(item.currentTarget.childNodes[3].innerHTML)
        {
            case "Step":
                details =
                {
                    input_type: "step",
                    input_details: 
                    {
                        step_value: 1,
                        step_time: 1
                    }
                };
                break;
            case "Impulse":
                details =
                {
                    input_type: "impulse",
                    input_details: 
                    {
                        impulse_value: 1,
                        impulse_time: 1
                    }
                };
                break;
            case "Polynomial":
                details =
                {
                    input_type: "polynomial",
                    input_details: 
                    {
                        function: [1,1]
                    }
                };
                break;
            case "Trig":
                details =
                {
                    input_type: "trig",
                    input_details: 
                    {
                        amplitude: 1,
                        frequency: 1,
                        phase: 0,
                    }
                };
                break;
            case "Constant":
                details =
                {
                    input_type: "constant",
                    input_details: 
                    {
                        value: 1
                    }
                };
                break;
            case "Adder":
                details =
                {
                    input_nets: [1,1],
                    input_signs: [1,1] 
                };
                break;
            case "Integrator":
                details =
                {
                    initial_value: 0,
                    input_net: -1
                };
                break;
            case "Transfer Function":
                details =
                {  
                    transfer_function: [[1],[1,1]],
                    input_net: -1,
		            xk: []    
                };
                break;
            case "Gain":
                details =
                {  
                    gain: 5,
                    input_net: -1,
                };
                break;
            case "Buffer":
                details =
                {  
                    input_net: -1
                };
                break;
            case "Scope":
                details =
                {  
                    time: [],
                    series: [],
                    inputs: 1,  
                };
                break;

        }
        simJson.blocks.push(
            {
                category: item.currentTarget.childNodes[3].className.substr(25),
                type: item.currentTarget.childNodes[3].innerHTML,
                name: item.currentTarget.childNodes[3].innerHTML,
                id: rect.id,
                output_net: "nothing",
                details:details
            });

            console.log(simJson);
    }