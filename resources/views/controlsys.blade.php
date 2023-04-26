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
    <script src="{{URL('fabric.js')}}"></script>
    
    <title>Simulation</title>
    
    
    <style>
        html 
        {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            
        }
        body 
        {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box; 
            display: flex;
            align-items: center;
            flex-flow: column nowrap;
            justify-content: space-between;
            row-gap: 0vh;
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
        #simulation-values 
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
            height:120vh;
            margin: 0;
            padding: 0;
        }
        #diagram
        {
            width: 100vw;
            height:85vh;           
        }
         
        .division {
            width: 100px;
            border-top: 2px solid black;
        }

        .simple-division {
            display:flex;
            flex-flow: column nowrap;
            justify-content: space-between;
            row-gap: 2.5px;
            align-items: center;
        }
        .simple-division > input {
            text-align: center; 
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
    
    <div class="diagram-div">
    <canvas id="canvas" width="1500" height="500" style="border:1px solid #000000"></canvas>
    <script>
        var canvas = new fabric.Canvas('canvas');
        

        canvas.add(new fabric.Circle({ radius: 30, fill: '#ffffff', top: 100, left: 100 }));
        var rect = new fabric.Rect({left:100,width:20,height:20});
        canvas.add(rect);

        function makeSomething()
        {

        var aa = new fabric.Rect({
            width:100,
            height:100,
            fill: '#eef',
            scaleY: 0.5,
            originX: 'center',
            originY: 'center'
        });

        var text = new fabric.Text('controller', {
            fontSize: 20,
            originX: 'center',
            originY: 'center'
        });

        var group = new fabric.Group([ aa, text ], {
            left: 150,
            top: 100,
                
        });
        canvas.add(group);
        }

        function makeT()
        {
        var text = document.getElementById('group-text').value;
        var aa = new fabric.Rect({
            width:100,
            height:100,
            fill: '#eef',
            scaleY: 0.5,
            originX: 'center',
            originY: 'center'
            });

            var text = new fabric.Text(text, {
            fontSize: 20,
            originX: 'center',
            originY: 'center'
            });

                var group = new fabric.Group([ aa, text ], {
                left: 150,
                top: 100,
                
                });

canvas.add(group);
        }
    
    </script>
    <div style="padding-left:10px" id="simulation-values">
        <div class="simple-division">
            <p>Simulations per second</p>
            <input type="text" id="sps" placeholder="simulations per second">
        </div>
        <div class="simple-division">
            <p>Simulation duration (s)</p>
            <input type="text" id="duration" placeholder="simulation duration">
        </div>
        <div class="simple-division">
            <p>Step moment (s)</p>
            <input type="text" id="step" placeholder="step moment">
        </div>

        <div class="simple-division">
            <p>Controller</p>
            <input type="text" id="controller-num" placeholder="">
            <hr class="division" />
            <input type="text" id="controller-den" placeholder="">
            <button id="controller-button">render expression </button>
            <div id="controller-div"  style="border:1px solid #000000"></div>
        </div>
    <!--
        <div class="simple-division">
            <p>Plant</p>
            <input type="text" id="plant-num" placeholder="1 1">
            <hr class="division" />
            <input type="text" id="plant-den" placeholder="2 3 1">
            <button id="plant-button">render expression </button>
            <div id="plant-div"  style="border:1px solid #000000"></div>
        </div>
    -->
        <div>
            closed loop?<input type="checkbox" id="loop">
            <button onclick="simulation()">simulate </button> <br>
            <button onclick="bode()">Bode </button> <br>
            <button onclick="nyquistplot()">Nyquist </button> <br>
        </div>

        <div>
            Time<input name="domain" type="radio"> Laplace<input name="domain" type="radio">
        </div>

        <br>
        <input type="text" id="group-text" placeholder="text">
        <button onclick="makeT()">Add </button> <br>
    </div>

    <div id="tester" style="width:600px;height:300px;"></div>
    <br />
    <br />
    <div id="bodemag" style="width:600px;height:300px;"></div>
    <br />
    <div id="bodephase" style="width:600px;height:300px;"></div>
    <br />
    <br />
    <div id="nyquist" style="width:600px;height:500px;"></div>
</div>








    <script type="text/javascript">
        
        document.getElementById("controller-button").addEventListener("click", function() {render("controller-num","controller-den", "controller-button", "controller-div");});
       //document.getElementById("plant-button").addEventListener("click", function() {render("plant-num","plant-den", "plant-button", "plant-div");});
        var nums= [];
        var dens= [];
        var ttime = [];
        var magnitude = [];
        var phase = [];



     function render(numerator, denominator, button, destination) {
 
        var num = document.getElementById(numerator).value.trim();
        var den = document.getElementById(denominator).value.trim();
        var numlength = num.length/2;
        var i = 0;

        if (num.length == 0)
            num = "1";

        if (den.length == 0)
            den = "1";

        var numval= [];
        while (num.indexOf(" ") != -1)
        {
            numval[i] = parseInt(num);
            num = num.slice(num.indexOf(" "));    
            num = num.trimStart();   
            i++;
        }
        numval[i] = parseInt(num);
        
        var denlength = den.length/2;
        i = 0;
        var denval= [];
        while (den.indexOf(" ") != -1)
        {
            denval[i] = parseInt(den);
            den = den.slice(den.indexOf(" "));    
            den = den.trimStart();
            i++
        }
        denval[i] = parseInt(den);
        
        numval = numval.reverse();
        denval = denval.reverse();
        nums = [... numval];
        dens = [... denval];
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
                input += numval[j] + "s^" + j + sign;
            }
            else if (j>0)
            {
                if (numval[j-1] < 0)
                {
                    sign = "-";
                    numval[j-1] = Math.abs(numval[j-1]);
                } else
                sign = "+";
                input += numval[j] + "s" + sign;
            }
            else
            input += numval[j];
        }
        
        input += "\\over ";

        for (var j=denval.length-1;j>=0;j--)
        {
            var extra = "";
            var sign = "+";
            if (denval[j] == 0)
            input = input.slice(0, input.length - 1);
            else if (j > 1)
            {
                if (denval[j-1] < 0)
                {
                    sign = "-";
                    denval[j-1] = Math.abs(denval[j-1]);
                } else
                sign = "+";
                input += denval[j] + "s^" + j + sign;
            }
            else if (j>0)
            {
                if (denval[j-1] < 0)
                {
                    sign = "-";
                    denval[j-1] = Math.abs(denval[j-1]);
                } else
                sign = "+";
                input += denval[j] + "s" + sign;
            }
            else
            input += denval[j];
        }
        var button = document.getElementById(button);
       // button.disabled = true;

        output = document.getElementById(destination);
        output.innerHTML = '';

        MathJax.texReset();
        var options = MathJax.getMetricsFor(output);
        MathJax.tex2chtmlPromise(input, options).then(function (node) {
        output.appendChild(node);
        MathJax.startup.document.clear();
        MathJax.startup.document.updateDocument();
         }).catch(function (err) {
        output.appendChild(document.createElement('pre')).appendChild(document.createTextNode(err.message));
        }).then(function () {
        button.disabled = false;
        });
     }   

    function simulation()
    {

        console.log("numerator: "+nums);
        console.log("denominator: "+dens);
        if (nums.length >= dens.length)
        {
            console.log("ERROR");
        } else
        {
            var sps = parseFloat(document.getElementById("sps").value);
            timestep = 1/sps;
            var duration = parseFloat(document.getElementById("duration").value);
            var step = parseFloat(document.getElementById("step").value);
            var n = dens.length-1;
            console.log("ts: "+timestep);
            console.log("duration: "+duration);
            console.log("step: "+step);
            console.log("n: "+n);


            var a = new Array(n);
            var bmatrix = math.zeros(n,1);
            var cmatrix = math.matrix(nums);
            
            bmatrix.set([n-1,0], 1);



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


            var arrText = '';
            console.log("a: "+a);
            var amatrix = math.matrix(a);
            console.log(math.det(a));

            for (var i = 0; i < a.length; i++) {
                for (var j = 0; j < a[i].length; j++) {
                    arrText+=a[i][j]+' ';
                }
                    console.log(arrText);
                    arrText='';
            }
            console.log(cmatrix);
            console.table(bmatrix);

            //
            //simulation time
            //

            var time = 0;
            var xk = math.zeros(n,1);
            console.log("xk: "+math.size(xk));
            var u = 0;
            var yk = 0;
            var results = [];
            var domain = [];
            while (time <= duration)
            {
                if (time >= step)
                    u=1;
                var ax = math.multiply(amatrix,xk); // Axk

                var bu = math.multiply(bmatrix,u); //Buk

                var axbu = math.add(ax,bu); // Axk + Bu

                var h = math.multiply(timestep,axbu); // h (Axk + Bu)
                
                xk = math.add(xk,h); // xk+1

                yk = math.multiply(cmatrix,xk); // yk

                results.push(yk.get([0]));
                domain.push(time);
                time += timestep;
            }
            console.log(domain);
            console.log(results);
            TESTER = document.getElementById('tester');
            Plotly.newPlot( TESTER, [{
            x: domain,
            y: results }], {
            margin: { t: 0 } } );

        }
        



    }

    function bode()
    {
        console.log("numerator: "+nums);
        console.log("denominator: "+dens);
        
        var nval = nums.map((val, i) => {
            if([2, 3].includes(i % 4)) return val * -1;
            return val;
        }); //copy the numerator values array while multiplying by j^n
        //this makes the appropriate powers negative
        
        var dval = dens.map((val, i) => {
            if([2, 3].includes(i % 4)) return val * -1;
            return val;
        }); //copy the denominator values array while multiplying by j^n
        //this makes the appropriate powers negative
        

        
        var time = 0;
        ttime = [];
        magnitude2 = [];
        phase = [];
        magnitude = [];
        while (time <= 100)
        {
            var omega = time * 2 * Math.PI;

            const complexnum = nval.reduce((res, cur, i) => {
                if(i % 2 === 0) res[0] += cur * Math.pow(time,i);
                else res[1] += cur * Math.pow(time,i);
                return res;
            }, [0,0]); //array of real and imaginary evaluation of numerator (complexnum[0] is real while complexnum[1] is imaginary)
            
            const complexden = dval.reduce((res, cur, i) => {
                if(i % 2 === 0) res[0] += cur * Math.pow(time,i);
                else res[1] += cur * Math.pow(time,i);
                return res;
            }, [0,0]);  //array of real and imaginary evaluation of denominator (complexden[0] is real while complexden[1] is imaginary)
            
            //non dB magnitude
            const magni = Math.sqrt(Math.pow(complexnum[0],2)+Math.pow(complexnum[1],2))/Math.sqrt(Math.pow(complexden[0],2)+Math.pow(complexden[1],2)); //magnitude
            magnitude.push(magni);//non dB magnitude for nyquist
            magnitude2.push(20*Math.log10(magni)); //send magnitude in dB
            // phase.push(Math.atan2(complexnum[1],complexnum[0]) + Math.atan2(-complexden[1], complexden[0]));
            const up = (complexnum[1] * complexden[0]) - (complexnum[0] * complexden[1]); //cb - ad
            const down = (complexnum[1] * complexden[1]) + (complexnum[0] * complexden[0]); //ac + bd
            const pha = Math.atan2(up,down)* 180 / Math.PI;
            phase.push(pha);
            ttime.push(time);
            time += 0.01;
        }

        bodemag = document.getElementById('bodemag');
            Plotly.newPlot( bodemag, [{
            x: ttime,
            y: magnitude2 }],
             {
            margin: { t: 0 },
            xaxis: {
                type: 'log',
                autorange: true
            }}
             );

            bodephase = document.getElementById('bodephase');
            Plotly.newPlot( bodephase, [{
            x: ttime,
            y: phase }],
             {
            margin: { t: 0 },
            xaxis: {
                type: 'log',
                autorange: true
            }}
             );

    }

    function nyquistX(num, i) {
            return num * Math.cos(phase[i]* Math.PI/180);
    }
        function nyquistY(num, i) {
            return num * Math.sin(phase[i]* Math.PI/180);
    }

    function nyquistplot()
    {
          
        let nreal = magnitude.map(nyquistX);
        let nimaginary = magnitude.map(nyquistY);
        
        let nreal2 = [... nreal]; //add the negative frequencies
        let nimaginary2 = [... nimaginary]; //add the negative frequencies
      
        nreal = nreal.reverse().concat(nreal2); //add the negative frequencies
        nimaginary = nimaginary.map(x => x * -1).reverse().concat(nimaginary2); //add the negative frequencies

        //nreal = nreal2.concat(nreal);
        //nimaginary = nimaginary2.concat(nimaginary);
        nyquist = document.getElementById('nyquist');
        Plotly.newPlot( nyquist, [{
        x: nreal,
        y: nimaginary }], {
        margin: { t: 0 } } );
        
    }

    TESTER = document.getElementById('tester');
    Plotly.newPlot( TESTER, [{
    x: [1, 2, 3, 4, 5],
    y: [1, 2, 4, 8, 16] }], {
    margin: { t: 0 } } );


    bodemag = document.getElementById('bodemag');
    Plotly.newPlot( bodemag, [{
    x: [],
    y: [] }], {
    margin: { t: 0 } } );

    bodephase = document.getElementById('bodephase');
    Plotly.newPlot( bodephase, [{
    x: [],
    y: [] }], {
    margin: { t: 0 } } );

    nyquist = document.getElementById('nyquist');
    Plotly.newPlot( nyquist, [{
    x: [],
    y: [] }], {
    margin: { t: 0 } } );
    </script>
</body>
</html>