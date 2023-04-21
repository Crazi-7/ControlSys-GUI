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
        }
        body 
        {
            margin: 0px;
            padding: 10vh 0px;
            box-sizing: border-box; 
            display: flex;
            align-items: center;
            flex-flow: column nowrap;
            justify-content: space-between;
            row-gap: 10vh;
            color: white;
            background: rgb(204,104,104);
            background-image: linear-gradient(146deg, rgba(147,104,204,1) 0%, rgba(205,103,177,1) 100%);
        }
        .container 
        {
    
            font-size: 48px;
            
        }
        h1
        {
            font-size: 72px;
            margin: 2vh 0;
        }
        hr 
        {
            width: 15vw;
            border-top: 1vh solid white;
            margin-bottom: 5vh;
            
        }
        fieldset
        {
            width: 80vw;
            background: linear-gradient(69deg, rgba(204,104,104,1) 0%, rgba(205,152,103,1) 70%);
            border-width: 1vh;
            border-style: solid;
            overflow: hidden;
            
        }
        input 
        {
            height: 10vh;
            width: 20vw;
            font-size: 35px;
            
            background-color: #f8d5c9;
            border-style: none;
            text-align: center;
            filter: opacity(50%);
            border-radius: 20px;
        }
        .below-input 
        {
            font-size: 20px;
            margin-bottom: 0vh;
            color: #feabab;
        }
        
        input[type="submit"]
        {
            border-radius: 30px;
            width: 15vw;
        }
        input[type="submit"]:hover 
        {
             filter: brightness(0.6);
             cursor: pointer;
        }
        .alert-fail
        {
            width: 80vw;
            height: 10vh;
            background: linear-gradient(69deg, rgba(204,104,104,1) 0%, rgba(205,152,103,1) 70%);
            border-width: 0.5vh;
            border-style: solid;
            margin 0;
        }

        br 
        {
            display: block;
            margin: 6px 0;
        }

        .is-invalid 
        {
            border-width: 8px;
            border-color: #fd6f6f;
            border-style: solid;
        }

    </style>
</head>
<body>

@if(session('error'))
                <div class="alert alert-fail alert-dismissible fade show container" role="alert">
                    {{session('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
@endif

   <div class="container">
       <form action="/register" method="post" name="formone"> @csrf
           
           <fieldset>  

                <h1>Register </h1>  
                <hr>

                <label for="Username">Username</label> <br>
                <input type="text" name="username" class ="@if ($errors->has('username')) is-invalid @endif" placeholder="User" min="4"> 
                <div class="below-input"> 
                    @if ($errors->has('username'))       
                        {{$errors->first('username')}}      
                    @endif
                </div> <br> <br>
                
                <label for="email">Email</label> <br>
                <input type="email" name="email" class ="@if ($errors->has('email')) is-invalid @endif" placeholder="someone@mail.com" min="4"> 
                <div class="below-input"> 
                    @if ($errors->has('email'))       
                        {{$errors->first('email')}}      
                    @endif
                </div> <br> <br>

                <label for="password">Password</label> <br>
                <input type="password" name="password" class ="@if ($errors->has('password')) is-invalid @endif" placeholder="**********" min="6"> 
                <div class="below-input"> 
                    @if ($errors->has('password'))       
                        {{$errors->first('password')}}      
                    @endif
                </div> <br> <br>
                
                <label for="cpassword">Confirm Password</label> <br>
                <input type="password" name="cpassword" class ="@if ($errors->has('password_confirmation') || $errors->has('password')) is-invalid @endif" placeholder="**********" min="6">
                <div class="below-input"> 
                    @if ($errors->has('password_confirmation'))       
                        {{$errors->first('password_confirmation')}}      
                    @endif
                </div> <br> <br>

                <input type="submit" value="Register">
                <div class="below-input"></div>
           </fieldset>
       </form>
       <p>Already have an account? <a href="{{route('login')}}">Login</a></p>
       <p> <a href="{{route('index')}}">Go back</a></p>
   </div> 
</body>
</html>