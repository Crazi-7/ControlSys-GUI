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

           // console.log(simJson);
    }


    function simulate()
    {
        //simJson
        simJson.nets = [];
        console.log(app.view.figures);
        console.log(app.view.lines);
        let linus = app.view.lines.data;
        linus.forEach((value) => addWirings(value));
         //adds wirings to simJson
        console.log(simJson);
    }
    function addWirings(value)
    {

        let net = simJson.nets.find(net => net.input=== value.sourcePort.parent.id);
        if (net == undefined) //new net
        {
            net = 
            {
                net_id: value.id,
                input: value.sourcePort.parent.id,
                outputs: [value.targetPort.parent.id]
            };
            simJson.nets.push(net);
            simJson.blocks.find(block => block.id == value.sourcePort.parent.id).output_net = value.id; //set current net as output net in corresponding block

        } else //output branch
        {
            net.outputs.push(value.targetPort.parent.id); //add another output port
        }

        //myArray.find(x => x.id === '45').foo;
        //let neto = input.nets.find(net => net.net_id === current.output_net); //find the output net
    }










    //=============================================
    //
    // OLD SIMULATION
    //
    //==============================================




    let history = []; //sequence of block ids indexed by order of checking
    let netValues =[]; //values of net labels indexed by id
    let input;
    let step;
    function generate()
    {
        history = [];
        netValues =[];
        input = JSON.parse(document.getElementById('json-input').value);
        step = input.blocks.find(block => block.type === "input");
        scanNet();
        simulate();
        console.log(history);
        //makeBlock("input","function","f(x)");
    }   

    function scanNet() 
    {
        let current = step;
        history.push(current.id);        
        let neto = input.nets.find(net => net.net_id === current.output_net); //find the output net
        let pnet = neto.net_id; //previous net
        neto.outputs.forEach((value) => netBranchBlock(value, pnet)); //check next branch
    }

    function netBranchBlock(item, pnet)
    {
        let current;
        let proceed = true;
        current = input.blocks.find(block => block.id === item);
        if (history.includes(current.id))
            proceed = false;
        else 
        {
            if (current.type == "logic") //logic means there can be multiple inputs
            {                
                let branches = current.details.input_nets.slice();               
                if (branches.indexOf(pnet) > -1)
                    branches.splice(branches.indexOf(pnet), 1); //remove the branch u came from to prevent messing up the output                    
                const result = branches.every((value) => checkFeedback(value, current.id, [])); //check if all branches are feedback or are satisfied
                if (result)
                    history.push(current.id);
                else
                    proceed = false;           
            } else if (current.type == "scope")
            {
                history.push(current.id);
                proceed = false;
            } else
            {
                history.push(current.id);
            }
        }
            if (proceed)
            {
                neto = input.nets.find(net => net.net_id === current.output_net); //find the output net
                neto.outputs.forEach((value) => netBranchBlock(value, neto.net_id)); //scan all branches of the output net
            }
    }
    
    function checkFeedback(item, bid, arrayHistory)
    {
        let searchBreakpoint = arrayHistory; //add search history here
        
        while (true)
            {
                let netSearch = input.nets.find(net => net.net_id === item); 
                let blockSearch = input.blocks.find(block => block.id === netSearch.input) 
                if (history.includes(blockSearch.id)) 
                {
                    const checkSubset = searchBreakpoint.every(elem => history.includes(elem));  
                    return checkSubset;
                } //feed forward finish search (checks if the current block is evaluated somewhere before) also checks if the branch has been evaluated
                searchBreakpoint.push(blockSearch.id)
                if (blockSearch.type == "logic")
                {
                    if (searchBreakpoint.includes(bid)) {return true;} //the program looped back (this path)
                    if (bid == blockSearch.id) {return true;} //feedback finish search
                    const result = blockSearch.details.input_nets.every((value) => checkFeedback(value, bid, searchBreakpoint)); //check if all branches are feedback or are satisfied
                    return result;
                } else 
                {
                    item = blockSearch.details.input_net;
                }                
            }
            //keep searching through history to find the input if its recursive
    }




    var results = [];
    var domain = [];

    function simulateOLD() 
    {
    results = [];
    domain = [];
        let time = 0;
        let stop = 10;
        let timeStep = 1/100.0;
        while (time < stop)
        {
        history.forEach((value, index) => simulationRun(value, index, time, timeStep));
        console.log("nets" + netValues)
        time += timeStep;
        }
        simulation = document.getElementById('simulation');
            Plotly.newPlot( simulation, [{
            x: domain,
            y: results }], 
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
                plot_bgcolor: "#555",
                paper_bgcolor: "#555555",
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

    }
    
    

    function getNet(i)
    {
        if (netValues[i] == undefined)
            netValues[i] = 0;
        return netValues[i];
    }


    





    function simulationRun(val, index, time, timestep)
    {
        let item = input.blocks.find(block => block.id === val);
        console.log("------ ");  
        console.log("item:"+ item.type);
        console.log("time: ", time); 
        console.log("index: "+ index + " value: " + val); 
        switch(item.type)
        {
            case "transfer":

                let nums = item.details.transfer_function[0];
                let dens = item.details.transfer_function[1];
                console.log("denom", dens);
                var n = dens.length-1;

                var a = new Array(n);
                var bmatrix = math.zeros(n,1);
                var cmatrix = math.zeros(1,n);

                bmatrix.set([n-1,0], 1);
                for (var i=0;i<nums.length;i++)
                {
                    cmatrix.set([0,i], nums[i]); 
                }

                for (var i=0;i<n-1;i++)
                {
                    a[i] =  new Array(n);
                    for (var j=0;j<n;j++)
                    {
                        if (j == (i+1))
                        a[i][j] = 1;
                        else
                        a[i][j] = 0;
                    }
                }
                a[n-1] =  new Array(n);
                for (var j=0;j<n;j++)
                    {
                        a[n-1][j] = -dens[j]; 
                    }
                let u = getNet(item.details.input_net);
                //console.log("u: ", u);  
                var amatrix = math.matrix(a);
                if (item.details.xk.length === 0)
                {
                    item.details.xk = math.zeros(n,1);
                    console.log("xk"+ item.details.xk);
                }
                var ax = math.multiply(amatrix,item.details.xk); // Axk    
                
                          
                var bu = math.multiply(bmatrix,u); //Buk
                var axbu = math.add(ax,bu); // Axk + Bu            
                var h = math.multiply(timestep,axbu); // h (Axk + Bu)

                item.details.xk = math.add(item.details.xk,h); // xk+1
                yk = math.multiply(cmatrix,item.details.xk); // yk
                //console.log("output dest:", item.output_net);
                //console.log("yk", yk.get([0, 0]));
                netValues[item.output_net] = yk.get([0, 0]);

                break;
            case "logic":

                let sum = 0;
                console.log("length"+ item.details.input_nets.length);
                for (let i=0;i<item.details.input_nets.length;i++)
                {
                    

                    sum += getNet(item.details.input_nets[i]) * item.details.input_signs[i];
                }
               // console.log("output dest:", item.output_net);
               // console.log("sum:", sum);
                netValues[item.output_net] = sum;

                break;
            case "input":
                if (time >= 1)
                    netValues[item.output_net] = 1;
                else
                    netValues[item.output_net] = 0;
                break;
            case "scope":
                //console.log("scopiee" + getNet(item.details.input_net))
                results.push(getNet(item.details.input_net));
                domain.push(time);
                break;
                
        }
    }
