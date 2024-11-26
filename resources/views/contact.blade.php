<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>
<body>
    <h1>Contact Us</h1>

    
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    
    @if($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('contact.submit') }}" method="POST">
        @csrf
        <label for="name">Your Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Your Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="message">Your Message:</label><br>
        <textarea id="message" name="message" rows="5" required></textarea><br><br>

        <button type="submit">Send Message</button>
    </form>
</body>
</html>
