<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
</head>
<style>

    body{
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background-image: linear-gradient(to bottom right,blue,red);       
    }


    .RegistrationBox{
        width: 500px;
        height: 500px;
        background: #010035;
        color: #fff;
        top: 50%;
        left: 50%;
        position: absolute;
        transform: translate(-50%, -50%);
        box-sizing: border-box;
        padding: 70px 30px;
        box-shadow: 0 15px 25px rgba(0, 0, 0, .5);
        text-align: center;
        
    }

    .RegistrationBox h1{
        margin: 0;
        padding: 0 0 20px;
        font-size: 30px;
    }

    .RegisterInputs input[type=text]{
        display: flex;
        flex-direction: column;
        width: 55%;
        height: 40px;
        margin-top: 19px;
        margin-left: auto;
        margin-right: auto;
        padding: 10px;
        gap: 35px; 
        border-radius: 45px;
        }

    .RegisterInputs input[type=submit]{
        width: 50%;
        height: 40px;
        margin-top: 19px;
        margin-left: auto;
        margin-right: auto;
        padding: 10px;
        gap: 35px; 
        border-radius: 45px;
        background: #010035;
        color: #fff;
        border: 1px solid #fff;
        cursor: pointer;
    }


</style>
<body>
    <div class="RegistrationBox">
        <h1>Register with us</h1>
        <div class="RegisterInputs">
            <input type="text" name="CustomerName" placeholder="Name">
            <input type="text" name="CustomerEmail" placeholder="Email">
            <input type="text" name="CustomerPassword" placeholder="Password">
            <input type="text" name="CustomerPhone" placeholder="Phone">
            <input type="button" name="Register" value="Register" placeholder="Register">
        </div>
        
    </div>
</body>
</html>