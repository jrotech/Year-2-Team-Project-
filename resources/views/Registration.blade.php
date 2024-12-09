<!--
/********************************
Developer: Redwan
University ID: 230367027
********************************/
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        background-image: url('{{ asset("img/loginbackground.jpg") }}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .RegistrationBox {
        width: 30%;
        /* Fixed width for large screens */
        max-width: 600px;
        /* Cap maximum size */
        background: #010035;
        color: #fff;
        border-radius: 10px;
        box-sizing: border-box;
        padding: 50px 30px;
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.5);
        text-align: center;
    }

    .RegistrationBox h1 {
        margin: 0;
        padding: 0 0 20px;
        font-size: 28px;
        /* Larger font size for better readability */
    }

    .RegisterInputs input[type="text"],
    input[type="password"] {
        display: block;
        width: 70%;
        /* Fixed width for input fields */
        height: 50px;
        /* Larger height for better appearance */
        margin: 15px auto;
        /* Center inputs */
        padding: 10px;
        border-radius: 45px;
        border: 1px solid #ddd;
        font-size: 18px;
        /* Larger font size */
        box-sizing: border-box;
    }

    .RegisterInputs input[type="submit"] {
        width: 70%;
        /* Match text input width */
        height: 50px;
        margin: 20px auto;
        border-radius: 45px;
        background: #0056b3;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 18px;
        /* Larger font for consistency */
        transition: background-color 0.3s ease;
    }

    .RegisterInputs input[type="submit"]:hover {
        background-color: #003f91;
    }
</style>

<body>
    <div class="RegistrationBox">
        @if ($errors->any())
        <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <h1>Register with us</h1>
        <div class="RegisterInputs">
            <form method="post" action="/register">
                @csrf
                <input type="text" name="CustomerName" placeholder="Name">
                <input type="text" name="CustomerEmail" placeholder="Email">
                <input type="password" name="CustomerPassword" placeholder="Password">
                <input type="password" name="CustomerPassword_confirmation" placeholder="Confirm Password" required>
                <input type="text" name="CustomerPhone" placeholder="Phone" required>
                <input type="submit" name="Register" value="Register">
            </form>
        </div>
    </div>
</body>


</html>