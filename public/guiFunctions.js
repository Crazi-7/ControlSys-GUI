function pageFirst()
{   
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
                        dc: 0
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
                    inputs: 2,
                    input_nets: [-1,-1],
                    input_signs: [1,1] 
                };
                break;
            case "Integrator":
                details =
                {
                    initial_value: 0,
                    stored:0,
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
                    input_net: -1,
                };
                break;

        }
        let block = {
            category: item.currentTarget.childNodes[3].className.substr(25),
            type: item.currentTarget.childNodes[3].innerHTML,
            name: item.currentTarget.childNodes[3].innerHTML,
            id: rect.id,
            output_net: -1,
            details:details
        };
        simJson.blocks.push(block);
        rect.setUserData(userData={block:block});
    }


    
    //=============================================
    //
    // Simulation Prep
    //
    //==============================================

    function simulate()
    {
        simJson.nets = [];
        let linus = app.view.lines.data;
        linus.forEach((value) => addWirings(value));//create the nets in simJson
        adderBind(); //bind the blocks to those nets
        
        console.log("sim:");
        console.log(simJson);
        generate(); //simulation

    }
    function addWirings(value)
    {
        let net = simJson.nets.find(net => net.input=== value.sourcePort.parent.id);
        if (net == undefined) //new net
        {
            net = 
            {
                net_id: [value.id],
                input: value.sourcePort.parent.id,
                outputs: [value.targetPort.parent.id]
            };
            simJson.nets.push(net);
            simJson.blocks.find(block => block.id == value.sourcePort.parent.id).output_net = value.id; //set current net as output net in corresponding block
        } else //output branch
        {
            net.outputs.push(value.targetPort.parent.id); //add another output port
            net.net_id.push(value.id);
        }
    }


    function adderBind() 
    {
        //the goal of this function is to bind the adder ports in connected order
        let adders = simJson.blocks.filter(block => block.category != "sources");
        let linus = app.view.lines.data;
        
        adders.forEach(function (adder) {
                if (adder.type == "Scope") //clear the outputs on every simulaiton run
                {
                    adder.details.time = [];
                    adder.details.series = [];
                }
                if (adder.type == "Integrator") //add initial value to prep for simulation
                {
                    adder.details.stored = adder.details.initial_value;
                }
                let filtered = linus.filter(linez => linez.targetPort.parent.id === adder.id); //all connected ports to said adder
                let ports = app.view.figures.data.find(block => block.id == adder.id).inputPorts; // find the original blocks input ports
                ports.data.forEach(function (port, index){       //check if the input ports are wired          
                    let matched = filtered.filter(filter => filter.targetPort.id === port.id); //connection that belongs to the port
                    if (matched.length > 0) //if there is a connection
                    {
                
                        let netStuff = simJson.nets.find(net => net.net_id.includes(matched[0].id));
                        //it contains here

                       // console.log("ding"+ index);
                        if (simJson.blocks.find(block => block.id == adder.id).type == "Adder")
                            simJson.blocks.find(block => block.id == adder.id).details.input_nets[index] = netStuff.net_id[0];//add the source net to the adder
                        else 
                            simJson.blocks.find(block => block.id == adder.id).details.input_net = netStuff.net_id[0];//add the source net to non adders
                    } else
                    {
                       // console.log("fail"+ index);
                        if (simJson.blocks.find(block => block.id == adder.id).type == "Adder")
                            simJson.blocks.find(block => block.id == adder.id).details.input_nets[index] = -1; //add a -1
                    }
                    
                  //  console.log("adder:"+ adder.id);
                  //  console.log("----------");
                });       
            
        });
        // net.outputs.forEach((value) => function(value) {
        //     let targetBlock = simjson.blocks.find(block => block.id === value);
        //     if (targetBlock.type == "Adder")
        //     {
        //         targetBlock.details.input_nets.push();
        //     }

        // });
      
    }
    function testFunctiono(num) {
        return num.id;
      }


    //=============================================
    //
    // Engine
    //
    //==============================================




    let history = []; //sequence of block ids indexed by order of checking
    let netValues ={}; //values of net labels indexed by id
    let input= simJson;
    let step;
    function generate()
    {
        history = [];
        netValues = {};  
        step = simJson.blocks.filter(block => block.category === "sources");  //find the block where the type is input
        integrators = simJson.blocks.filter(block => block.type === "Integrator");  //integration output

        console.log(integrators);
        integrators.forEach((value) => inputBranch(value));
        console.log("source", step);
        step.forEach((value) => inputBranch(value)); //calculate
        //scanNet();
        simulationStart();
        console.log(history);
        
    }   

    function inputBranch(value) 
    {
        let current = value; //scan input
        history.push(current.id);   //put input as first element     
        let neto = input.nets.find(net => net.net_id.includes(current.output_net)); //find the output net 
        if (neto != undefined)
        {
            let pnet = neto.net_id[0]; //id of net
            neto.outputs.forEach((value) => netBranchBlock(value, pnet)); //check next branch
        }
    }
    function scanNet() 
    {
        let current = step; //scan input
        history.push(current.id);   //put input as first element     
        let neto = input.nets.find(net => net.net_id.includes(current.output_net)); //find the output net 
        let pnet = neto.net_id[0]; //previous net
        neto.outputs.forEach((value) => netBranchBlock(value, pnet)); //check next branch
    }

    function netBranchBlock(item, pnet)
    {
        let current;
        let proceed = true;
        current = input.blocks.find(block => block.id === item); //find current block
        if (history.includes(current.id))
            proceed = false; //if current block has already be evaluated stop
        else 
        {
            if (current.type == "Adder") //logic means there can be multiple inputs
            {                
                let branches = current.details.input_nets.slice();       //check all inputs for feedback        
                if (branches.indexOf(pnet) > -1) 
                    branches.splice(branches.indexOf(pnet), 1); //remove the branch u came from to prevent messing up the output  
                    console.log("branches", branches);               
                const result = branches.every((value) => checkFeedback(value, current.id, [])); //check if all branches are feedback or are satisfied
                if (result)
                    history.push(current.id); //add current block to history after confirming that all inputs have been evaluated
                else
                    proceed = false;   //kill the branch      
            } else if (current.output_net == -1)
            {
                history.push(current.id); 
                proceed = false; //stop at the scope
            } else if (current.type == "Integrator")
            {
                proceed = false;                
            }
             else
            {
                if (current.type == "Transfer Function")
                    current.details.xk = [];
                history.push(current.id); //add blocks
            }
           
        }
            if (proceed)
            {
                neto = input.nets.find(net => net.net_id.includes(current.output_net)); //find the output net
                if (neto != undefined)
                {
                    neto.outputs.forEach((value) => netBranchBlock(value, neto.net_id[0])); //scan all branches of the output net
                }
                console.log("neto");
                console.log(neto);
                console.log("current");
                console.log(current);
                
            }
    }
    
    function checkFeedback(item, bid, arrayHistory)
    {
        let searchBreakpoint = arrayHistory; //add search history here
        
        while (true)
            {
                let netSearch = input.nets.find(net => net.net_id.includes(item)); 
                console.log("item: ", item);                
                console.log("netsearch: ", netSearch);
                if (netSearch == undefined)
                {
                    return true;
                }
                let blockSearch = input.blocks.find(block => block.id === netSearch.input) 
                if (history.includes(blockSearch.id)) 
                {
                    const checkSubset = searchBreakpoint.every(elem => history.includes(elem));  
                    return checkSubset;
                } //feed forward finish search (checks if the current block is evaluated somewhere before) also checks if the branch has been evaluated
                searchBreakpoint.push(blockSearch.id)
                if (blockSearch.type == "Adder")
                {
                    if (searchBreakpoint.includes(bid)) {return true;} //the program looped back (this path)
                    if (bid == blockSearch.id) {return true;} //feedback finish search
                    const result = blockSearch.details.input_nets.every((value) => checkFeedback(value, bid, searchBreakpoint)); //check if all branches are feedback or are satisfied
                    return result;
                } else if (blockSearch.category == "sources" || blockSearch.type == "Integrator")
                {
                    return false; //stop the branch and kill it
                }
                else 
                {
                    item = blockSearch.details.input_net;
                }                
            }
            //keep searching through history to find the input if its recursive
    }

    var results = [];
    var domain = [];

    function simulationStart() 
    {
    results = [];
    domain = [];
        let time = 0;
        let stop = parseFloat(document.getElementById("simulation_time").value);
        let freq = parseFloat(document.getElementById("simulation_frequency").value);
        let timeStep = 1/freq;
        
        while (time < stop)
        {
        history.forEach((value, index) => simulationRun(value, index, time, timeStep));
        console.log("nets");
        console.log(netValues);
        time += timeStep;
        }

    }
       

    function getNet(i)
    {
        if (netValues[i] == undefined)
            netValues[i] = 0;
        console.log("netRequested:"+ netValues[i]);
        console.log("at:"+ i);
        return netValues[i];
    }


    function simulationRun(val, index, time, timestep)
    {
        let item = input.blocks.find(block => block.id === val);
        console.log("------ ");  
        console.log("item:"+ item.type);
        console.log("time: ", time); 
        console.log("index: "+ index + " id: " + val); 
        switch(item.type)
        {
            case "Transfer Function":

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
                console.log("u: ", u, "inputnet:", item.details.input_net);  
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
                console.log("tf val:"+ netValues[item.output_net]);
                console.log("to:"+ item.output_net)
                break;
            case "Adder":

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
            case "Step":
                if (time >= item.details.input_details.step_time)
                    netValues[item.output_net] = item.details.input_details.step_value;
                else
                    netValues[item.output_net] = 0;
                console.log("stepped:"+ netValues[item.output_net]);
                console.log("to:",item.output_net);
                break;
            
            case "Impulse":
                if (Math.abs(parseFloat(item.details.input_details.impulse_time) - time) <= 0.000001)
                    netValues[item.output_net] = item.details.input_details.impulse_value;
                else
                    netValues[item.output_net] = 0;
                console.log("stepped:"+ netValues[item.output_net]);
                console.log("to:",item.output_net);
                break;

            case "Trig":
                netValues[item.output_net] = (item.details.input_details.amplitude* Math.sin(item.details.input_details.frequency* 2 * Math.PI * (time - item.details.input_details.phase)) + item.details.input_details.dc);
                break;

            case "Polynomial":
                let coeff = [... item.details.input_details.function];
                coeff = coeff.reverse();
                const total = coeff.reduce((res, cur, i) => {
                    res += cur * Math.pow(time,i);
                    return res;
                }, 0);
                console.log("total", total);
                netValues[item.output_net] = total;
                break;            
            case "Constant":                
                netValues[item.output_net] = item.details.input_details.value;           
                break;
            case "Integrator":                        
                item.details.stored = (getNet(item.details.input_net)* timestep)+item.details.stored;
                netValues[item.output_net] = item.details.stored;
                break;
            case "Gain":
                netValues[item.output_net] = getNet(item.details.input_net)* item.details.gain;
                break;
            case "Buffer":
                netValues[item.output_net] = getNet(item.details.input_net);
                break;
            case "Scope":
                
                item.details.series.push(getNet(item.details.input_net))
                item.details.time.push(time);
                break;
                
        }
    }
