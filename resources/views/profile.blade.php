<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{URL('favicon.ico')}}">
    <title>Profile</title>
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

         
        .user-container
        {
            background-color: #111;
            width: 85vw;
            
            border-radius: 20px;
            
            display: grid;
            grid: 
            'profile user user'
            'profile email email'
            'password password projects';
            grid-template-columns: 1fr 1fr 1fr;
            gap: 5vh;
            padding: 10vh;

            font-size: 35px;
            font-weight: bold;
            text-align: center;


        }
        .user-element:hover
        {
            filter:brightness(60%);
        }
        .user-element 
        {
            background-color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 20px;
            height: 20vh;
        }

        #user-pfp 
        {
            width:25vw;
            height:25vw;
            grid-area: profile;
        }

        #user-name 
        {
            grid-area: user;
            
        }
        #user-email 
        {
            grid-area: email;
            
        }
        #user-password 
        {
            grid-area: password;
            overflow: hidden;
            font-size: 20px;
            
        }
        #user-project 
        {
            grid-area: projects;
            
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
                <a href="{{route('profile')}}" id="profile-anchor" class="active">
                    <img class="pfp" src="{{URL('profiles/user_null.png')}}" alt="pfp" /> 
                    <div>{{Auth::user()->username}}</div>
                </a>
                </li>
                
            </ul> 
        </nav>
    </header>

    <div class="user-container">
       <img class="user-element" id="user-pfp" src="{{URL(Auth::user()->profile)}}" />
       <div class="user-element" id="user-name"><p>{{Auth::user()->username}}</p></div>
       <div class="user-element" id="user-email"><p>{{Auth::user()->email}}</p></div>
       <div class="user-element" id="user-password"><p>{{Auth::user()->password}}</p></div>
       <div class="user-element" id="user-project"><p>{{$projectnum}}</p></div>
    </div>

</body>
</html>