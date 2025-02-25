<!--
/********************************
Developer: Robert Oros 
University ID: 230237144
********************************
CSS style and design

Developer: Amen Alhouseini
University ID: 230237878

Developer: Hasnain Imran
University ID: 230209037

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
            background-image: url('{{ asset("img/BG BLUR.png") }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            margin: 0;
            padding: 0;
            background-size: 200%;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #4A90E2;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #357ABD;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #4A90E2;
        }

        form {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #F9FAFB;
            border-radius: 10px;
        }

        form h2 {
            margin-bottom: 15px;
            color: #4A90E2;
            font-size: 22px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #ffffff;
            color: #333333;
        }

        button {
            padding: 10px 20px;
            background-color: #4A90E2;
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #357ABD;
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
        <button class="back-button" onclick="history.back()">&larr; Back</button>
        <h1>Manage Your Profile</h1>

        @if(session('success_password'))
            <p class="success-message">{{ session('success_password') }}</p>
        @endif
        @if(session('success_personal'))
            <p class="success-message">{{ session('success_personal') }}</p>
        @endif

        @if($errors->any())
            <ul class="error-messages">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('profile.update-personal-details') }}" method="POST">
            @csrf
            <h2>Change Personal Details</h2>
            <label for="customer_name">Name</label>
            <input type="text" id="customer_name" name="customer_name" value="{{ Auth::guard('customer')->user()->customer_name }}" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ Auth::guard('customer')->user()->email }}" required>
            <button type="submit">Update Personal Details</button>
        </form>

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
