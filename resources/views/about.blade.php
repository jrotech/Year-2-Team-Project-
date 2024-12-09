<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About Us</title>
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fb; /* Light background for contrast */
            color: #333;
        }

        /* Navigation container */
        .nav-container {
            background-color: #010035;
            padding: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .nav-container a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nav-container a:hover {
            background-color: #003f91;
        }

        /* About Us container */
        .about-us-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 36px;
            color: #010035;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 28px;
            color: #003f91;
            margin-top: 30px;
        }

        h3 {
            font-size: 24px;
            color: #010035;
            margin-top: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
            line-height: 1.8;
            margin-top: 10px;
        }

        /* Back button styling */
        .back-button {
            display: block;
            margin: 30px auto 0;
            padding: 10px 20px;
            background-color: #010035;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .back-button:hover {
            background-color: #003f91;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <!-- About Us Content -->
    <div class="about-us-container">
        <h1>About Us</h1>
        <p>Welcome to Team 32's PC Builder platform!</p>
        <p>
            We are passionate about technology and aim to provide you with the best tools to build your personalized PC.
            Whether you're a seasoned gamer, a professional designer, or just someone looking to get started, we have the
            right components and support to help you make the perfect choice.
        </p>

        <h2>Our Mission</h2>
        <p>
            Our mission is simple: to make custom PC building accessible, easy, and enjoyable for everyone. We combine
            expert advice, high-quality components, and an intuitive PC builder to make the process seamless. Whether
            you're building your first PC or upgrading an existing setup, we’re here to help.
        </p>

        <h2>AI-Powered Recommendations</h2>
        <p>
            Our AI chatbot offers personalized recommendations based on your preferences, making the process of choosing
            components easier and more fun. The chatbot can suggest the best products, configurations, and even help you
            troubleshoot.
        </p>

        <h2>Best Selling Products</h2>
        <p>
            Explore our top-rated and best-selling products, carefully curated to ensure you get the best performance for
            your budget.
        </p>

        <h3>Team 32</h3>
        <p>
            We are a team of tech enthusiasts and developers working together to make PC building fun, efficient, and
            affordable for all.
        </p>

        <!-- Back button -->
        <a href="/" class="back-button">Back</a>
    </div>
</body>
</html>
