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
    <title>Contact Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #010035; /* Dark blue background */
            color: #FFFFFF;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #011B54; /* Slightly lighter dark blue */
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 36px;
            color: #89CFF0; /* Light blue */
        }

        p {
            text-align: center;
            font-size: 16px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: 600;
            color: #FFFFFF;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #022366; /* Darker blue for inputs */
            color: #FFFFFF;
            font-size: 16px;
        }

        input:focus, textarea:focus {
            outline: none;
            border: 2px solid #89CFF0; /* Light blue focus border */
        }

        textarea {
            resize: none;
        }

        button {
            padding: 12px 20px;
            background-color: #89CFF0; /* Light blue button */
            color: #010035; /* Dark blue text for contrast */
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #78BEEA; /* Slightly darker light blue on hover */
        }

        .success-message {
            text-align: center;
            color: #4CAF50; /* Green for success */
            font-weight: 600;
            margin-bottom: 15px;
        }

        .error-messages {
            color: #FF0000; /* Red for errors */
            margin-bottom: 15px;
        }

        .error-messages li {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>

        <!-- Success Message -->
        @if(session('success'))
            <p class="success-message">{{ session('success') }}</p>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <ul class="error-messages">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <!-- Contact Form -->
        <form action="{{ route('contact.submit') }}" method="POST">
            @csrf
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>

            <label for="message">Your Message:</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>
</body> 
</html>
