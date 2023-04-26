<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{URL('favicon.ico')}}">
    <title>CSG login</title>
    <style>
        html 
        {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        body 
        {
            margin: 0px;
            padding: 5vh 0px;
            box-sizing: border-box; 
            display: flex;
            align-items: center;
            flex-flow: column nowrap;
            justify-content: space-between;
            row-gap: 10vh;
            color: white;
            background-color: #414141;
            /* background: rgb(204,104,104);
            background-image: linear-gradient(146deg, rgba(147,104,204,1) 0%, rgba(205,103,177,1) 100%); */
        }
        .container 
        {
    
            font-size: 48px;
            
        }
        h1
        {
            font-size: 72px;
            margin: 2vh 0;
            background-color: #8b6196;
            color: #d9d9d9;
            border-radius: 20px;
            padding: 20px;
            width: 400px;
        }
        hr 
        {
            width: 15vw;
            border-top: 1vh solid white;
            margin-bottom: 5vh;
            
        }
        fieldset,.set2, .alert-fail
        {
            width: 80vw;
            background-color: #5b5b5b;
           
            border-radius: 15px;
            border:none;
            color: #d9d9d9;
            display: flex;
            flex-flow: column nowrap;
            align-items: center;
            justify-content:flex-start;
            row-gap: 0;

            
        }
        input 
        {
            height: 10vh;
            width: 20vw;
            font-size: 35px;
            margin: 2vh 0;
            color: #d9d9d9;
            border-style: none;
            text-align: center;
            
        }
        .input-section>input
        {
            height: 10vh;
            width: 20vw;
            font-size: 35px;
            margin: 2vh 0;
            filter:brightness(1.1);
            border-style: none;
            text-align: center;
            background-color: #5b5b5b !important;
            -webkit-text-fill-color: gray !important;
            margin-bottom: 3vh;
            border-radius: 20px;
        }
        input[type="text"]
        {
            background-color: #5b5b5b !important;
        }
        input:autofill, input:-webkit-autofill {
            background-color: #5b5b5b !important;
        }
        input[type="password"]
        {
            
        }
        input[type="submit"]
        {
            border-radius: 30px;
            width: 15vw;
            background-color: #619661;
            filter:brightness(1.2);
            color: #d9d9d9;
        }
        .clickable:hover 
        {
             filter: brightness(0.6);
             cursor: pointer;
             background-image: linear-gradient(rgb(0 0 0/40%) 0 0);
             
        }
    
        .input-section {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content:flex-start;
            margin: 20px 0;
           
        }
        .input-section>label {
            width:300px;
            text-align: left;
            display:block;
        }
        .input-section>input {
            width:600px;
            display:block;
        }
        .input-container
        {
            margin: 30px 10px;
        
        }
        .set2 {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content:flex-start;
            row-gap: 30px;
            padding:20px;
        }
        .set-elem 
        {
            font-size: 48px;
           border-radius: 15px;
            background-color: #4e819c;
            width:500px;
            height:90px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content:center;
            margin: 10px 0;

        }
        a {
            text-decoration: none;
            color: #d9d9d9;
        }
        #last 
        {
            margin-bottom: 30px;
        }
        .alert-fail 
        {
            height: 100px;
        }
    </style>
</head>
<body>
@if(session('error'))
                <div class="alert alert-fail alert-dismissible fade show container" role="alert">
                    {{session('error')}}
                    
                </div>
@endif

   <div class="container">
       <form action="/login" method="post" name="formone"> @csrf
           
           <fieldset>  

                <h1>Login </h1>  
                <div class="input-container">
                    <div class="input-section">
                        <label for="Username">Username</label> 
                        <input type="text" name="username" placeholder="User" min="4"> 
                    </div>
                    
                    <div class="input-section">
                        <label for="Password">Password</label> 
                        <input type="password" name="password" placeholder="**********" min="6"> 
                    </div>
                </div>

                <input type="submit" value="Login" class="clickable">
           </fieldset>
       </form>
       </div>
       <div class="set2" >
       <h1 class="set-heading" style="width:700px;">Don't have an account?</h1>
       <div class="set-elem clickable" ><a href="{{route('register')}}">Register</a></div>
       <div class="set-elem clickable" ><a href="{{route('simple')}}">Continue as guest</a></div> 
       <div class="set-elem clickable" id="last" > <a href="{{route('index')}}">Go back</a></div>
        
   </div> 
</body>
</html>