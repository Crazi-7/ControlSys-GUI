<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{URL('favicon.ico')}}">
    <title>CSG</title>
    <script>
        function reveal() {
  var reveals = document.querySelectorAll(".reveal");

  for (var i = 0; i < reveals.length; i++) {
    var windowHeight = window.innerHeight;
    var elementTop = reveals[i].getBoundingClientRect().top;
    var elementVisible = 150;

    if (elementTop < windowHeight - elementVisible) {
      reveals[i].classList.add("active");
    } else {
      reveals[i].classList.remove("active");
    }
  }
}

window.addEventListener("scroll", reveal);
    </script>


    <style>
        html 
        {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: "Asap", sans-serif;
            width:100%;
        }
        body 
        {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box; 
        }
        .partition 
        {
            height: 500px;
            width: 100%;
            
        }
        p
        {
            font-size: 20px;
        }
        #first-part 
        {
            height: 100vh;
            
            background-image: url("{{URL('images/index/machine3.jpg')}}");
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            filter: brightness(0.5);
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            justify-content: space-around;
            align-items: center;
        }
        #first-logo 
        {
            height: 50vh;
            width: 50vh;
            border-radius: 5vh;
            filter: brightness(1.3);
        }
        #first-button 
        {
            background-color: #B475CC;
            color:#3D2F33;
            border: none;
            border-radius: 3vh;
            height: 15vh;
            width: 55vh;
            font-size: 60px;
            font-weight: 1000;
            filter: brightness(1.3);
            

        }
        #first-button:hover 
        {
            filter: brightness(0.6);
            cursor: pointer;
        }


        #second-part 
        {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            text-align: center;
        }

        #second-div
        {
            width: 40vw;
            background-color: #3D2F33;
            padding: 20px;
            color: #d9d9d9;
        }
        #second-div>h1
        {
            margin:15px;
            
            font-size: 40px;
        }
        #second-div>p
        {
            font-size: 20px;
            text-align: left;
            padding: 5px 10px;
        }
        #second-image 
        {
            width: 60vw;
            background-image: url("{{URL('images/index/circuit1.jpg')}}");
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            filter: brightness(0.6);
        }
        #third-part 
        {
            height: 80vh;
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
        }
        .third-divs 
        {
            width: 33vw;
        }

        #third-one 
        {
            background-color: #5caad8;
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            justify-content: space-around;
            align-items: center;
        }
        #third-two 
        {
            background-color: #6175d3;
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            justify-content: space-around;
            align-items: center;
        }
        #third-three 
        {
            background-color: #9368cc;
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            justify-content: space-around;
            align-items: center;
        }
        .third-icons 
        {
            width: 40vh;
            height: 40vh;
            filter: invert(1);
        }
        .third-titles 
        {
            color:white;
            font-size: 35px;
            font-weight: bold;
        }

        #fourth-part 
        {
            height: 50vh;
            background-image: url("{{URL('images/index/machine1.jpg')}}");
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }


        section{
        min-height: 70vh;
        display: flex;
        justify-content: center;
        align-items: center;
}
section:nth-child(1){
  color: #e0ffff;
  }
section:nth-child(2){
  color: #42455a;
  background: #e0ffff;
} 
section:nth-child(3){
  color: #e0ffff;
}
section:nth-child(4){
  color: #42455a;
  background: #e0ffff;
}
section .container{
  margin: 20px;
}
section h1{
  font-size: 3rem;
  margin: 20px;
}
section h2{
  font-size: 40px;
  text-align: center;
  text-transform: uppercase;
  margin-bottom:40px;
}
section .text-container{
   display: flex;
}
section .text-container .text-box{
  margin: 30px;
  padding: 20px;
  background: #00c2cb;
  border-radius: 15px;
}
section .text-container .text-box h3{
  font-size: 30px;
  text-align: center;
  text-transform: uppercase;
  height:80px;
  margin:0;
  display: flex;
            flex-flow: column nowrap;
            justify-content: center;
            align-items: center;
  
}
.vcentre 
        {
            display: flex;
            flex-flow: column nowrap;
            justify-content: center;
            align-items: center;
        }
@media (max-width: 900px){
  section h1{
    font-size: 2rem;
    text-align: center;
  }
  section .text-container{
    flex-direction: column;
  }
}

.reveal{
  position: relative;
  transform: translateY(150px);
  opacity: 0;
  transition: 1s all ease;
}

.reveal.active{
  transform: translateY(0);
  opacity: 1;
}
.scroll-magic *{
 
  box-sizing: border-box;
  font-family: "Asap", sans-serif;
}
.scroll-magic{
  background: #42455a;
}
.aims {
    
    min-height: 60vh;
  
}
.aims>div>.text-container
{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
.aims>div>.text-container>div
{
    height:80px;
}
.feature-cont>div 
{
    width:400px;
}

    </style>
</head>


<body>
    <div class="partition" id="first-part">
        <img class="first-flex" id="first-logo" src="{{URL('images/Control Systems GUI-1.png')}}"/>
        <button class="first-flex" id="first-button" onClick="javascript:window.location.href='{{route('home')}}'">Start Now!</button>
    </div>


    <div class="partition" id="second-part">
        <div id="second-div">
            <h1>Information</h1>
            <p>Control Theory is essential in any field of engineering and is crucial to numerous applications. And as such, it is desirable that most engineers have familiarity with both theoretical and practical aspects of control. However, control theory is regarded as mathematically complex and challenging to new students getting exposed to such ideas.</p>
            <p>This is a third year project called Control Systems GUI. The goal of the project is to simplify learning control systems by providing a free and easy to use platform to run simulations. This will be achieved by replicating the visual GUI used by Simulink combined with the simulation features of the Siso toolbox. In terms of novelty, the project will recreate existing features in a more accessible way that has not been done before.</p>
        </div>
        <div id ="second-image"> </div>
    </div>
    <div class="scroll-magic">
    <!-- <section>
  <h1>Scroll Down to Reveal Elements &#8595;</h1>
</section> -->
<section class="aims">
  <div class="container reveal">
    <h2>Aims</h2>
    <div class="text-container">
   

      <div class="text-box vcentre">
        <h3>Simple and Intuitive</h3>
       
      </div>
      <div class="text-box vcentre">
        <h3>Easilly Accessible</h3>
      
      </div>
      <div class="text-box vcentre">
        <h3>No Tutorials</h3>
      
      </div>
      <div class="text-box vcentre">
        <h3>Open-source</h3>
      
      </div>
      <div class="text-box vcentre">
        <h3>Free</h3>
      
      </div>

    </div>
  </div>
</section>

<section>
  <div class="container reveal">
    <h2>Features</h2>
    <div class="text-container feature-cont">
      <div class="text-box">
        <h3>Bode and Nyquist plots</h3>
        <p>
          Find the Bode magnitude, Bode phase and Nyquist of any given transfer function. Simulate the same transfer function and find values like peak overshoot. 
        </p>
      </div>
      
      <div class="text-box">
        <h3>Responsive GUI</h3>
        <p>
          Use the GUI to simulate the output of any complex system you build. Simple drag and drop to create.
        </p>
      </div>
      <div class="text-box">
        <h3>Multiple Projcts</h3>
        <p>
          Have as many systems saved as you want. Share your creations by copying the URL.
        </p>
      </div>
    
    </div>
  </div>
</section>



</div>

    <!-- <div class="partition" id="third-part">
        <div class="third-divs" id="third-one">
            <img class="third-icons" src="{{URL('images/icons/control-panel.png')}}" alt="">
            <p class="third-titles">Lorem Ipsum</p>
        </div>
        <div class="third-divs" id="third-two">
            <img class="third-icons" src="{{URL('images/icons/control-system.png')}}" alt="">
            <p class="third-titles">Lorem Ipsum</p>
        </div>
        <div class="third-divs" id="third-three">
            <img class="third-icons" src="{{URL('images/icons/settings.png')}}" alt="">
            <p class="third-titles">Lorem Ipsum</p>
        </div>
    </div> -->

    <div class="partition" id="fourth-part">

    </div>
</body>
</html>