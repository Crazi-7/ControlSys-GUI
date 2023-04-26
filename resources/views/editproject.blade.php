<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{URL('favicon.ico')}}">
    <title>Home</title>
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
            row-gap: 10vh;
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


        
        .project-container
        {
            background-color: #2f2f2f;
            width: 95vw;
            font-size: 64px;
            font-weight: bold;
            display: flex;
            align-items: center;
            flex-flow: column nowrap;
            justify-content: space-around;
            row-gap: 8vh;
            padding: 5vh 0;
            border-radius: 20px;
            

        }
      
        form 
        {
            display: flex;
            align-items: center;
            flex-flow: column nowrap;
            justify-content: space-around;
            row-gap: 2vh;
        }
        .input-error 
        {
            border-color: #cf7070;
            border-style: solid !important;
            border-width: 4px;
        }

       input[type="text"]
       {
        background-color: #444444;
        font-size: 48px;
        border-radius: 3vw;
        height: 10vh;
        border-style: none;
        text-align: center;
        width: 40vw;
        color: #eeeeee;
        

       }
      
        .clickable:hover 
        {
            filter: brightness(0.6);
            cursor: pointer;
        }

        .button-wrapper
        {
            display: flex;
            align-items: center;
            flex-flow: row nowrap;
            justify-content: space-around;
            column-gap: 5vw;
        }
        .button
        {
            text-align: center;
            font-size: 35px;
            font-weight: bold;
            width: 15vw;
            height:10vh;
            background-color: #4b96e0;
            border-radius: 30px;
            border-style: none;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
            
        }
        .cancel 
        {
            display: flex;
            align-items: center;
            flex-flow: column nowrap;
            justify-content: space-around;
            background-color: #96c1ed;;
        }
        .fail 
        {
            font-size: 32px;
            margin-bottom: 2vh;
            text-align: center;
            color: #dc4e4e;
        }
        
        a
        {
            color: inherit; /* blue colors for links too */
            text-decoration: inherit; /* no underline */
   
        }
        .start 
        {
            background-color: #5ecc33;
            width: 30vw;
            height:15vh;
            font-size: 42px;
            display: inline-block;
            display: flex;
            align-items: center;
            flex-flow: column nowrap;
            justify-content: space-around;
        }
        .project-pfp
        {
            width: 15vw;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul id="header-list">
                <li class="header-list-elements"><a href="{{route('index')}}">Control Systems GUI</a></li>
                <li class="header-list-elements "><a href="{{route('home')}}" class="active">Home</a></li>
                <li class="header-list-elements" style="float:right"><a href="{{route('logout')}}">Logout</a></li>
                <li class="header-list-elements"  style="float:right; margin-left:10px;">
                <a href="{{route('profile')}}" id="profile-anchor">
                    <img class="pfp" src="{{URL('profiles/user_null.png')}}" alt="pfp" /> 
                    <div>{{Auth::user()->username}}</div>
                </a>
                </li>
                
            </ul> 
        </nav>
    </header>
    <div class="project-container">
       
        <form action="" method="post"> @csrf
            <img src="{{URL($project->profile)}}" class="project-pfp" />
            <label for="name">Project name</label> <br>
            <div>
                <input class="@if ($errors->has('name')) input-error @endif" type="text" name="name" placeholder="Blank Title" min="5" value="{{$project->name}}">
                @if ($errors->has('name'))
                    <div class="fail">{{$errors->first('name')}} </div>
                @endif
            </div>
             <br>

            <div class="button-wrapper">
                <a class="clickable button cancel" href="{{route('home')}}">Cancel</a>
                <input class="clickable button create-project" type="submit" value="Change" />
            </div>
           
        </form>
     
    </div>

    <div class="project-container">
        <div>
        <a class="clickable button start" href="{{ route('gui', ['id' => $project->id]) }}">Start Developing</a>
        </div>
    </div>
</body>
</html>