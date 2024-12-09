<!--
/********************************
Developer: Robert Oros  
University ID: 230237144

********************************/ 
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #010035;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #011B54;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #89CFF0;
        }

        form {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #022366;
            border-radius: 10px;
        }

        form h2 {
            margin-bottom: 15px;
            color: #89CFF0;
            font-size: 22px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #ffffff;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background-color: #033670;
            color: #ffffff;
        }

        button {
            padding: 10px 20px;
            background-color: #89CFF0;
            color: #010035;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #78BEEA;
        }

        .success-message {
            color: #28a745;
            margin-bottom: 20px;
        }

        .error-messages {
            color: #ff0000;
            margin-bottom: 20px;
        }

        .error-messages li {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Your Profile</h1>

        <!-- Success Messages -->
        @if(session('success_password'))
            <p class="success-message">{{ session('success_password') }}</p>
        @endif
        @if(session('success_personal'))
            <p class="success-message">{{ session('success_personal') }}</p>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <ul class="error-messages">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <!-- Change Personal Details Form -->
        <form action="{{ route('profile.update-personal-details') }}" method="POST">
            @csrf
            <h2>Change Personal Details</h2>
            <label for="customer_name">Name</label>
            <input type="text" id="customer_name" name="customer_name" value="{{ Auth::guard('customer')->user()->customer_name }}" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ Auth::guard('customer')->user()->email }}" required>
            <button type="submit">Update Personal Details</button>
        </form>

        <!-- Change Password Form -->
        <form action="{{ route('profile.update-password') }}" method="POST">
            @csrf
            <h2>Change Password</h2>
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>
