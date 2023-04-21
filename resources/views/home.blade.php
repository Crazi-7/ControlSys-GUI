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
            display: flex;
            align-items: center;
            flex-flow: column nowrap;
            justify-content: space-around;
            row-gap: 8vh;
            padding: 5vh 0;
            border-radius: 20px;
            

        }
        .project 
        {
            width: 90vw;
            background-color: #444444;
            display: flex;
            align-items: center;
            flex-flow: row nowrap;
            justify-content: space-around;
            
            
        }
        .project > div 
        {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
        }

        .project-profile
        {
            width: 4vw;
            margin-left: 3vw;
            border-radius: 50%;
            
        }
        .project-name 
        {
            width: 43vw;
        }
        .project-date 
        {
            width: 20vw;
        }
        .edit-button 
        {
            width: 10vw;
            background-color: #7769c5;
        }
        .quick-button 
        {
            width: 90vw;
            background-color: #3d7a43;
            font-size: 40px;
            font-weight: bold;
        }
        .delete-button 
        {
            width: 10vw;
            background-color:#be6385;
        }
        .clickable:hover 
        {
            filter: brightness(0.6);
            cursor: pointer;
        }


        .create-project
        {
            text-align: center;
            font-size: 35px;
            font-weight: bold;
            width: 30vw;
            background-color: #4b96e0;
            border-radius: 30px;
        }

        a
        {
            color: inherit; /* blue colors for links too */
            text-decoration: inherit; /* no underline */
            height: inherit;
            
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
        <!-- for each loop-->
        <div class="project">
            
            <div class="quick-button clickable"><a href="projects/simple"><p>Quick-Start</p></a></div>

        </div>

        @foreach ($projects as $project)
        <div class="project">
            <img class="project-profile" src="{{$project->profile}}" />
            <div class="project-name"><p>{{$project->name}}</p></div>
            <div class="project-date"><p>{{$project->timestamp}}</p></div>
            <div class="edit-button clickable"><a href="project/{{$project->id}}/edit"><p>Edit</p></a></div>
            <div class="delete-button clickable"><a href="project/{{$project->id}}/delete"><p>Delete</p></a></div>
        </div>
        @endforeach
        <div class="project clickable create-project">
            <a href="{{route('newproject')}}"> <p>Create A New Project</p> </a>
        </div>
    </div>
</body>
</html>