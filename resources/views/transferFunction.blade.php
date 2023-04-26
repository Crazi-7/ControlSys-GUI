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
    <script src="{{URL('simulation.js')}}"></script>
    <script> 

    function dropInput(n)
    {
        var input = document.getElementsByClassName("input-property");
        for (var i=0;i<input.length;i++)
        {
            input[i].style.display = "none";
        }
        input[n].style.display = "block";
    }

    </script>
    <title>Simulation</title>
    
    
    <style>
        html 
        {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 20px;
            
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
            color: #bbb;
            background-image: linear-gradient(146deg, rgba(147,104,204,1) 0%, rgba(205,103,177,1) 100%);
            font-family: Arial, sans-serif;

        }
        .vertical-parent-container 
        {
            background-color: #444;
            width: 90vw;
        }
        nav 
        {
            display: flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            column-gap: 40vw;
            align-items: center;
            width: 100%;
        }
        ul 
        {
            list-style-type: none;
            margin: 0;
            padding: 0;
            background-color: #333;
            width: 100%;
            
        }
        header
        {
            width:100%;
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

        .vertical-parent-container 
        {
            display:flex;
            flex-flow: column nowrap;
            justify-content: space-between;
            row-gap: 5vh;
            align-items: center;
        }

        .transfer-function
        {
            display:flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            column-gap: 5vw;
            align-items: center;
        }
        .bode-plot
        {
            display:flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            column-gap: 2vw;
            align-items: center; 
        }
        
        .bode-nyquist 
        {
            display:flex;
            flex-flow: column nowrap;
            justify-content: space-between;
            row-gap: 2vh;
            align-items: center;
        }

        .simulation-inputs
        {
            display:flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            column-gap: 5vw;
            align-items: center;
        }

        .output-simulation
        {
            display:flex;
            flex-flow: column nowrap;
            justify-content: space-between;
            row-gap: 5vh;
            align-items: center;
        }

        .input-property > .trig 
        {
            display:flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            column-gap: 2vw;
            align-items: center;
        }

        .transfer-output {
            background-color: #997dbd;
            width:400px;
            height:125px;
            display:flex;
            font-size: 30px;
            flex-flow: row nowrap;
            justify-content:center;
            align-items: center; 

        }
        .gap 
        {
            height:7vh;
        }

        #controller-button
        {
            width: 15vw;
            height: 7vh;
            background-color: #7aafe4;
            color:#ddd;
            font-size: 20px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
        }
        .plot 
        {
            background-color: #555;
        }
        input 
        {
            background-color: #555;
            color: #bbb;
        }
        input[type="text"],#input-type 
        {
            border-radius: 15px;
            border:none;
            height:40px;
            padding:5px;
            text-align: center;
            font-size: 25px;

        }
        #simulator-button 
        {
            width: 10vw;
            height: 7vh;
            background-color: #77c067;
            color:#ddd;
            font-size: 20px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
        }
        #transfer-output-id 
        {
            color:white;
            opacity: 0.9;
            border-radius: 20px;
        }
        .clickable:hover 
        {
            filter: brightness(0.6);
            cursor: pointer;
        }
        #input-type 
        {
            background-color: #555;
            color: #bbb;
            
        }
        #input-type>option 
        {
            background-color: #555;
            color: #bbb;
        }
        #simulation-properties
        {
            display: flex;
            align-items: center;
            flex-flow: column nowrap;
            justify-content: space-between;
            row-gap: 5vh;
            width:70vw;
            background-color: #555;
            border-radius: 15px;
            padding: 10vh 0;
        }
        #simulation-properties>div
        {
            display: flex;
            align-items: center;
            flex-flow: row nowrap;
            justify-content: space-between;
            background-color: #666;
            border-radius: 10px;
            width:50vw;
            
        }
        #simulation-properties>div>p
        {
            display:block;
            width:300px;
            text-align: center;
            font-weight: bold;
        }
        .tooltip {
  position: relative;
  display: inline-block;
 
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 400px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  top: -5px;
  left: 110%;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 50%;
  right: 100%;
  margin-top: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent black transparent transparent;
}
.tooltip:hover .tooltiptext {
  visibility: visible;
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
                    <div>@if (auth()->check())
                            {{Auth::user()->username}}
                        @else
                            Guest
                        @endif
                    </div>
                </a>
                </li>
                
            </ul> 
        </nav>
    </header>
    <div class="vertical-parent-container">
        <div class="gap"> </div>
        <div class="vertical-container transfer-function">
            <div class="transfer-input tooltip">
            <span class="tooltiptext">Input the coefficients of your transfer functions. Ex: 1s+2 -> 1 2</span>
                <input type="text" id="numerator" placeholder="1 0 2"/>
                <hr class="division-sign">
                <input type="text" id="denominator" placeholder = "1 2 3 4"/>
            </div>
            <div class="generate-button clickable"><button id="controller-button" onclick="generate()">Generate </button></div>
            <div class="transfer-output" id="transfer-output-id" ></div>
        </div>

        <div class="vertical-container bode-nyquist">
            <div class="bode-plot">
                <div id="bodemag" class="plot" style="width:600px;height:300px;"></div>
                <div id="bodephase"  class="plot" style="width:600px;height:300px;"></div>
            </div>
            <div id="nyquist"   class="plot" style="width:600px;height:500px;"></div>
        </div>

        <div class="vertical-container output-simulation">
            <div class="title">Output Simulation:</div>
            <div class="simulation-inputs">
                <div class="sim-input">
                    <p>Sampling rate (Hz)</p>
                    <input type="text" id="sps" placeholder="100">
                </div>
                <div class="sim-input">
                    <p>Simulation duration (s)</p>
                    <input type="text" id="duration" placeholder="10">
                </div>
                
                <div class="sim-input">
                    <p>Input type</p>

                    <select name="inputU" id="input-type" onchange="dropInput(this.value);">
                        <option value="0">Step Function</option>
                        <option value="1">Polynomial</option>
                        <option value="2">Trig</option>
                        <option value="3">Impulse</option>
                    </select>
                    
                    <div class="input-property" style="display:block;">
                        <p>Step moment (s) </p>
                        <input type="text" id="step" placeholder="1">
                    </div>

                    <div class="input-property" style="display:none;">
                        <p>Function </p>
                        <input type="text" id="polyfunc" placeholder="3x + 1">
                    </div>

                    <div class="input-property" style="display:none;">
                        <div class="trig">
                            <p>Magnitude </p>
                            <input type="text" id="trig-mag" placeholder="3">
                        </div>
                        <div class="trig">
                            <p>Phase Shift </p>
                            <input type="text" id="trig-phase" placeholder="3">
                        </div>
                        <div class="trig">
                            <p>Frequency (Hz) </p>
                            <input type="text" id="trig-freq" placeholder="1">
                        </div>
                        <div class="trig">
                            <p>DC </p>
                            <input type="text" id="trig-dc" placeholder="0">
                        </div>
                    </div>
                    <div class="input-property" style="display:none;">
                        <div class="impulse">
                            <p>Time of impulse</p>
                            <input type="text" id="imp-time" placeholder="1">
                        </div>
                        <div class="impulse">
                            <p>Value of impulse</p>
                            <input type="text" id="imp-val" placeholder="1">
                        </div>
                        
                    </div>

                </div>
            </div>
            <div> <input type="checkbox" id="closed-loop">Closed Loop</div>
            <div class="simulation-button clickable"><button id="simulator-button" onclick="simulationRun()">Simulate </button></div>
            <div id="simulation" style="width:600px;height:300px;"></div>
            <div class="simulation-values plot"></div>
            <div id="simulation-properties" style="display:none;">
                <div>
                    <p>Steady-state value is at: </p> <p id="steady-state-value"> </p>
                </div>
                <div>
                    <p>Time at Peak Overshoot is: </p> <p id="peak-over-time"> </p>
                </div>
                <div>
                    <p>%Peak Overshoot is: </p> <p id="peak-over-percent"> </p>
                </div>
                <div>
                    <p>1% settling time is: </p> <p id="settling"> </p>
                </div>
                <div>
                    <p>10%-90% time is: </p> <p id="tento"> </p>
                </div>
            </div>
        </div>

        


    </div>
    <script type="text/javascript">
        // document.getElementById("controller-button").addEventListener("click", function() {render("controller-num","controller-den", "controller-button", "controller-div");});
    
        const $input = document.querySelector("#numerator");
        const ALLOWED_CHARS_REGEXP = /[0-9\. \+\-]+/;
        $input.addEventListener("keypress", e => {
        if (!ALLOWED_CHARS_REGEXP.test(e.key)) {
            e.preventDefault();
        }
        });

        const $input2 = document.querySelector("#denominator");
        const ALLOWED_CHARS_REGEXP2 = /[0-9\. \+\-]+/;
        $input2.addEventListener("keypress", e => {
        if (!ALLOWED_CHARS_REGEXP.test(e.key)) {
            e.preventDefault();
        }
        });

        function generate() 
        {
            render();
            bode();
            nyquistplot();

        }

        bodemag = document.getElementById('bodemag');
        Plotly.newPlot( bodemag, 
        [{
        x: [],
        y: [] }], 
        {
            
                title:{
                text: 'Bode Magnitude',
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
                title: 'Frequency (rad/sec)',
                color: 'lightgrey',
                titlefont: {
                    family: 'Arial, sans-serif',
                    size: 18,
                    color: 'lightgrey'
                },
            },
            yaxis: {
                title: 'Magnitude (dB)',
                color: 'lightgrey',
                titlefont: {
                    family: 'Arial, sans-serif',
                    size: 18,
                    color: 'lightgrey'
                },
            }

     
        }
        );

       
        bodephase = document.getElementById('bodephase');
        Plotly.newPlot( bodephase, [{
        x: [],
        y: [] }], 
        {
            title:{
               text: 'Bode Phase',
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
                    title: 'Frequency (rad/sec)',
                    color: 'lightgrey',
                    titlefont: {
                        family: 'Arial, sans-serif',
                        size: 18,
                        color: 'lightgrey'
                    },
                },
                yaxis: {
                    title: 'Phase (degrees)',
                    color: 'lightgrey',
                    titlefont: {
                        family: 'Arial, sans-serif',
                        size: 18,
                        color: 'lightgrey'
                    },
                }

        } );

        nyquist = document.getElementById('nyquist');
        Plotly.newPlot( nyquist, [{
        x: [],
        y: [] }], 
        {
                title:{
                text: 'Nyquist Plot',
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
                    title: 'Real Axis',
                    color: 'lightgrey',
                    titlefont: {
                        family: 'Arial, sans-serif',
                        size: 18,
                        color: 'lightgrey'
                    },
                },
                yaxis: {
                    title: 'Imaginary Axis',
                    color: 'lightgrey',
                    titlefont: {
                        family: 'Arial, sans-serif',
                        size: 18,
                        color: 'lightgrey'
                    },
                }

        } );

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


        var nums= [];
        var dens= [];
        var ttime = [];
        var magnitude = [];
        var phase = [];

        function render() {
            
            var num = document.getElementById("numerator").value.trim();
            var den = document.getElementById("denominator").value.trim();
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
            var button = document.getElementById("controller-button");
            // button.disabled = true;

            output = document.getElementById("transfer-output-id");
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
            Plotly.newPlot( bodemag, 
            [{
            x: ttime,
            y: magnitude2 }], 
            {
                
                    title:{
                    text: 'Bode Magnitude',
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
                    title: 'Frequency (rad/sec)',
                    color: 'lightgrey',
                    titlefont: {
                        family: 'Arial, sans-serif',
                        size: 18,
                        color: 'lightgrey'
                    },
                    type: 'log',
                    autorange: true
                },
                yaxis: {
                    title: 'Magnitude (dB)',
                    color: 'lightgrey',
                    titlefont: {
                        family: 'Arial, sans-serif',
                        size: 18,
                        color: 'lightgrey'
                    },
                }

        
            }
            );

        
            bodephase = document.getElementById('bodephase');
            Plotly.newPlot( bodephase, [{
            x: ttime,
            y: phase }], 
            {
                title:{
                text: 'Bode Phase',
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
                    title: 'Frequency (rad/sec)',
                    color: 'lightgrey',
                    titlefont: {
                        family: 'Arial, sans-serif',
                        size: 18,
                        color: 'lightgrey'
                    },
                    type: 'log',
                autorange: true,
                },
                yaxis: {
                    title: 'Phase (degrees)',
                    color: 'lightgrey',
                    titlefont: {
                        family: 'Arial, sans-serif',
                        size: 18,
                        color: 'lightgrey'
                    },
                }

            } );


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
            y: nimaginary }], 
            {
                    title:{
                    text: 'Nyquist Plot',
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
                        title: 'Real Axis',
                        color: 'lightgrey',
                        titlefont: {
                            family: 'Arial, sans-serif',
                            size: 18,
                            color: 'lightgrey'
                        },
                    },
                    yaxis: {
                        title: 'Imaginary Axis',
                        color: 'lightgrey',
                        titlefont: {
                            family: 'Arial, sans-serif',
                            size: 18,
                            color: 'lightgrey'
                        },
                    }

            } );
                
        }


        function simulationRun()
        {

            if (nums.length >= dens.length)
            {
                console.log("ERROR");
            } else
            {
                var sps = parseFloat(document.getElementById("sps").value);
                timestep = 1/sps;
                var duration = parseFloat(document.getElementById("duration").value);
                var n = dens.length-1;


                var a = new Array(n);
                var bmatrix = math.zeros(n,1);
                var cmatrix = math.zeros(1,n);
                console.log(nums);
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
 
                //
                //simulation time
                //
                console.log("timestep:" + timestep);
                var time = 0;
                var xk = math.zeros(n,1);
               
                var u = 0;
                var yk = 0;
                var results = [];
                var domain = [];
                let inputU = parseInt(document.getElementById('input-type').value);
                

                if (inputU == 0 && !document.getElementById("closed-loop").checked) //if input is a step function
                {
                    document.getElementById("simulation-properties").style.display = "flex";
                    document.getElementById("steady-state-value").innerHTML = nums[0] / dens[0];
                    
                    
                } else
                {
                    document.getElementById("simulation-properties").style.display = "none";
                }


                while (time <= duration)
                {
                    if (document.getElementById("closed-loop").checked && time != 0) //check if its closed loop
                    {
                        u = inputValue(inputU, time) - results[results.length-1]; 
                    } else
                    {
                        u = inputValue(inputU, time); //input 
                    }
                               
                    var ax = math.multiply(amatrix,xk); // Axk                
                    var bu = math.multiply(bmatrix,u); //Buk
                    var axbu = math.add(ax,bu); // Axk + Bu            
                    var h = math.multiply(timestep,axbu); // h (Axk + Bu)
                    console.log(xk);
                    xk = math.add(xk,h); // xk+1
                    yk = math.multiply(cmatrix,xk); // yk

                    results.push(yk.get([0, 0]));
                    domain.push(time);
                    time += timestep;
                }
                //console.log(domain);
                //console.log(results);

                if (inputU == 0)
                {
                    const max = results.reduce((a, b) => Math.max(a, b), -Infinity);
                    const maxTime = results.indexOf(max);
                   
                    document.getElementById("peak-over-time").innerHTML = domain[maxTime];
                    document.getElementById("peak-over-percent").innerHTML = ((max - (nums[0] / dens[0])) * 100 / (nums[0] / dens[0])) + "%";
                     const steady = nums[0] / dens[0];
                     document.getElementById("steady-state-value").innerHTML = steady;
                    const settlingTime = domain[results.indexOf(results.find(element => Math.abs((element - steady)/steady) < 0.01))];
                    document.getElementById("settling").innerHTML = settlingTime;
                    const settlingTime10 = domain[results.indexOf(results.find(element => Math.abs((element - steady)/steady) < 0.1))];
                    const settlingTime90 = domain[results.indexOf(results.find(element => Math.abs((element - steady)/steady) < 0.9))];
                    document.getElementById("tento").innerHTML = settlingTime10 - settlingTime90;
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
        }

        function inputValue(i, time)
            {
                switch(i) {
                    case 0:
                        if (time > parseFloat(document.getElementById("step").value))
                            return 1;
                        else
                            return 0;
                    break;
                    case 1:
                        
                        let poly = document.getElementById("polyfunc").value.trim();
                        

                        if (poly.length == 0)
                            poly = 0;

                       
                        var coeff= [];
                        while (poly.indexOf(" ") != -1)
                        {
                            coeff[i] = parseInt(poly);
                            poly = poly.slice(poly.indexOf(" "));    
                            poly = poly.trimStart();   
                            i++;
                        }
                        coeff[i] = parseInt(poly);
                        coeff = coeff.reverse();
                        const total = coeff.reduce((res, cur, i) => {
                            res += cur * Math.pow(time,i);
                            return res;
                        }, 0);
                        
                        return total;

                        break;
                    case 2:
                        return (parseFloat(document.getElementById("trig-mag").value)* Math.sin(parseFloat(document.getElementById("trig-freq").value)* 2 * Math.PI * (time - parseFloat(document.getElementById("trig-phase").value))) + parseFloat(document.getElementById("trig-dc").value));
                        
                        break;

                    case 3:
                        
                        if (Math.abs(parseFloat(document.getElementById("imp-time").value) - time) <= 0.0000001)
                        {
                        
                        return parseFloat(document.getElementById("imp-val").value);
                        }
                        else 
                        return 0;

                        break;
                    default:
                        console.log("you got to be kidding me");
                    return 0;
                    
                }
            }
        



    




    </script>






</body>
</html>