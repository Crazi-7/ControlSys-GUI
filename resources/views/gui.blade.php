<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{URL('favicon.ico')}}">
    <title>Profile</title>
    <!--<script src="{{URL('fabric.js')}}"></script>-->
    <script src="https://cdn.plot.ly/plotly-2.16.1.min.js"></script>
    <script src="{{URL('math.js')}}" type="text/javascript"></script>
    <script src="{{URL('jquery.js')}}" type="text/javascript"></script>
    <script src="{{URL('jquery-ui.js')}}"></script>
    <script src="{{URL('draw2d.js')}}" type="text/javascript"></script>
    

  
    <style>
        html 
        {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            
        }
        body 
        {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box; 
           
            color: white;
            background-image: linear-gradient(146deg, rgba(147,104,204,1) 0%, rgba(205,103,177,1) 100%);
        }
        nav 
        {
            display: flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            column-gap: 40vw;
            align-items: center;
            width: 100vw;
        }
        ul 
        {
            list-style-type: none;
            margin: 0;
            padding: 0;
            background-color: #333;
            width: 100vw;
            
        }
        .header-list-elements
        {
         display: inline-block;
         color: #ffffff;
         
        }
        .header-list-elements a {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 3vh 1.5vw;
            text-decoration: none;
            font-size: 30px;
            font-weight: bold;
        }
        .active 
        {
            background-color: #9368cc;
        }
        .header-list-elements a:hover:not(.active) 
        {
            background-color: #111;
        }
        .pfp 
        {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin:0;
            
        }
        #profile-anchor
        {
            display:flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            column-gap: 10px;
            align-items: center;
            
        }
        .diagram-div 
        {
            width: 100vw;
            height:90vh;
        }
        #diagram
        {
            width: 100vw;
            height:85vh;           
        }
        #engine 
        {
            background-color: #ffffff;
            width:1450px; 
            height:700px;
        }
         
       
    </style>

</head>
<body>
<header>
        <nav>
            <ul id="header-list">
                <li class="header-list-elements"><a href="{{route('index')}}">Control Systems GUI</a></li>
                <li class="header-list-elements "><a href="{{route('home')}}" >Home</a></li>
                <li class="header-list-elements" style="float:right"><a href="{{route('logout')}}">Logout</a></li>
                <li class="header-list-elements"  style="float:right; margin-left:10px;">
                <a href="{{route('profile')}}" id="profile-anchor" class="">
                    <img class="pfp" src="{{URL('profiles/user_null.png')}}" alt="pfp" /> 
                    <div>{{Auth::user()->username}}</div>
                </a>
                </li>
                
            </ul> 
        </nav>
    </header>
    <iframe id="engine" src="{{route('guiEngine')}}" style="position:aboslute;background-repeat: no-repeat;">
    </iframe>
    <div class = "input-json">
        <textarea name="" id="json-input" cols="50" rows="40">
                   {
            "blocks": 
            [
                {
                "type": "transfer",
                "name": "controller",
                "id": 1,
                "output_net": 3,
                "details": {
                    "transfer_function": [[1],[1,1]],
                    "input_net": 2,
                    "xk": []
                }
                },

                {
                "type": "logic",
                "name": "adder",
                "id": 2,
                "output_net": 2,
                "details": {
                    "input_nets": [1, 3],
                    "input_signs": [1, -1]
                }
                },

                {
                "type": "input",
                "name": "stepInp",
                "id": 3,
                "output_net": 1,
                "details": {
                    "input_type": "step",
                    "input_details":{
                    "step_value": 1,
                    "step_time": 1
                    }
                    
                }
                },

                {
                "type": "scope",
                "name": "scope_1",
                "id": 4,
                "details": {
                    "input_net": 3
                },
                "output_net": -1
                }
                
            ],

            "nets": [
                {
                "name":"net_1",
                "net_id":1,
                "input": 3,
                "outputs": [2]
                },
                {
                "name":"net_2",
                "net_id":2,
                "input": 2,
                "outputs": [1]
                },
                {
                "name":"net_3",
                "net_id":3,
                "input": 1,
                "outputs": [2, 4]
                }
            ]
            
            } 
        </textarea>
        <button onclick="generate()">Generate</button>
    </div>
    <div id="simulation" style="width:600px;height:600px;"></div>
    <div class="diagram-div">
    

   <!-- <canvas id="canvas" width="1500" height="500" style="border:1px solid #000000"></canvas> -->
    <script>

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
                    
                    let blockSearch = input.blocks.find(block => block.id === netSearch.input);
                
                   
                    if (history.includes(blockSearch.id)) {

                        const checkSubset = searchBreakpoint.every(elem => history.includes(elem));
                       
                        return checkSubset;
                    } //feed forward finish search (checks if the current block is evaluated somewhere before) also checks if the branch has been evaluated

                    searchBreakpoint.push(blockSearch.id);

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

        function simulate() 
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





        function makeBlock(type, label, value)
        {
        
            switch (type) 
            {
                case "input":
                    var block = new fabric.Rect({
                        width:100,
                        height:100,
                        fill: '#eef',
                        scaleY: 0.5,
                        originX: 'center',
                        originY: 'center',
                        rx: 30,
                        ry: 50
                        });

                    var text = new fabric.Text(value, {
                        fontSize: 20,
                        originX: 'center',
                        originY: 'center'
                    });
                break;
                
                case "transfer":
                    var block = new fabric.Rect({
                        width:100,
                        height:100,
                        fill: '#eef',
                        scaleY: 0.5,
                        originX: 'center',
                        originY: 'center'
                        });

                    var text = new fabric.Text(value, {
                        fontSize: 20,
                        originX: 'center',
                        originY: 'center'
                    });
                break;
            
            }

        

      

        var group = new fabric.Group([block, text], {
                left: 150,
                top: 100,
                
        });

        group.add(new fabric.Text(label, {
            top: 50,
            originX: 'center',
            originY: 'center',
            fontSize: 15,
        }));

        canvas.add(group);
        }



        //var canvas = new fabric.Canvas('canvas');
        

        
        simulation = document.getElementById('simulation');
        Plotly.newPlot( simulation, [{
        x: [1, 2, 3, 4, 5],
        y: [1, 2, 4, 8, 16] }], 
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



        

    </script>

    </div>
   


</body>
</html>