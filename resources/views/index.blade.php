<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{URL('favicon.ico')}}">
    <title>CSG</title>


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
        }
        .partition 
        {
            height: 500px;
            width: 100%;
            
        }
        #first-part 
        {
            height: 100vh;
            
            background-image: url("{{URL('images/index/machine3.jpg')}}");
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

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
        }
        #first-button 
        {
            background-color: #f5f411;
            border: none;
            border-radius: 3vh;
            height: 15vh;
            width: 50vh;
            font-size: 55px;
            font-weight: bold;

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
            
        }

        #second-div
        {
            width: 40vw;
            background-color: #cd67b1;
        }
        #second-image 
        {
            width: 60vw;
            background-image: url("{{URL('images/index/circuit1.jpg')}}");
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
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
    </style>
</head>


<body>
    <div class="partition" id="first-part">
        <img class="first-flex" id="first-logo" src="{{URL('images/Control Systems GUI-1.png')}}"/>
        <button class="first-flex" id="first-button" onClick="javascript:window.location.href='{{route('home')}}'">Start Now!</button>
    </div>


    <div class="partition" id="second-part">
        <div id="second-div"></div>
        <div id ="second-image"> </div>
    </div>


    <div class="partition" id="third-part">
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
    </div>

    <div class="partition" id="fourth-part">

    </div>
</body>
</html>