<!--/
    developer : Amen Alhousieni
    university id : 230237878
    function : my aim to do the fisrt half of code for home page till signiup blocks
/-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechForge Home</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/home/page.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:100,300,400,600,700&display=swap" rel="stylesheet" />

    <style>
        body {
            margin: 0;
            padding: 0;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
        }

        /* Navigation placeholder */
        .NavBar {
            background: #010035;
            height: 50px;
        }



        /* Sign-up & Hero Section */
        .signup-section {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            padding: 60px 20px;
            gap: 40px;
            background: #111111;
        }

        .signup-text {
            flex: 1 1 400px;
        }

        .signup-text h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .signup-text p {
            font-size: 20px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .signupForm {
            background: #FFFFFF;
            color: #000;
            border-radius: 20px;
            padding: 40px;
            max-width: 400px;
            flex: 1 1 300px;
        }

        .signupForm h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #000000;
        }

        .signupForm small {
            font-weight: 300;
            font-size: 14px;
            color: #000000;
            display: block;
            margin-bottom: 20px;
        }

        .signupForm input {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 30px;
            background: #D9D9D9;
            font-size: 16px;
            font-weight: 600;
            opacity: 0.8;
        }

        .signupForm button {
            background: #010035;
            color: #FFF;
            border: none;
            border-radius: 30px;
            padding: 15px 30px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
        }

        /* Logo Section */
        .whiteTechForgeImg {
            text-align: center;
            padding: 40px 0;
        }

        .whiteTechForgeImg img {
            max-width: 300px;
            width: 100%;
        }

        /* Best Sellers */
        .BestSellers {
            padding: 60px 20px;
        }

        .BestSellers h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: left;
            color: black;
        }

        .ProductsGrid {
            display: flex;
            gap: 20px;
	  width: 100vw;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .ProductCard {
            background: #F7F7F7;
            color: #000000;
            border-radius: 20px;
            width: 300px;
            padding: 20px;
            text-align: center;
	  gap: 20px;
	  font-size: 20px;
            display: flex;
            flex-direction: column;
            /* Arrange items vertically */
            justify-content: space-between;
            /* Ensure the "See More" button is at the bottom */
            height: 100%;
            /* Ensure consistent card height */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .ProductCard img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
            object-fit: cover;
            height: 200px;
            /* Ensure consistent image height */
        }

        .ProductCard h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .rating {
            margin: 10px 0;
        }

        .ProductCard p {
            font-size: 16px;
            margin-bottom: 10px;
            flex-grow: 1;
            /* Fills available space between the content and button */
        }

        .SeeMore {
            display: inline-block;
            background: #010035;
            color: #FFFFFF;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            margin-top: auto;
            /* Pushes the button to the bottom */
        }

        /* Categories Section */
        .Categories {
            background: #263238;
            padding: 60px 20px;
        }

        .Categories h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 40px;
            color: white;
        }

        .CategoriesGrid {
            display: flex;
	  flex-wrap: wrap;
            gap: 40px;
	  width: 100vw;
	  justify-content: center;
	  align-items: center;
            margin: 0 auto;
        }

        .CategoryCard {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
        }

        .CategoryCard img {
            width: 300px;
            flex: 1 0 40%;
            height: 300px;
            object-fit: cover;
            display: block;
        }

        .CategoryCard .overlay {
            position: absolute;
	  height: 100%;
	  width: 100%;
	  display: flex;
	  justify-content: center;
	  align-items: center;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            padding: 20px;
            text-align: center;
        }

        .CategoryCard .overlay span {
            font-size: 24px;
            font-weight: 700;
            color: #FFFFFF;
        }

        /* Footer */
        footer {
            background: #111111;
            color: #FFFFFF;
            padding: 40px 20px;
            text-align: center;
        }

        footer h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        footer a {
            color: #FFFFFF;
            text-decoration: underline;
        }

        .footer-sections {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            justify-content: center;
            margin-top: 20px;
        }

        .footer-section {
            text-align: center;
            min-width: 200px;
        }

        .footer-social-icons,
        .footer-payment-methods {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }

        .footer-social-icons a i {
            font-size: 24px;
        }

        .footer-payment-methods img {
            height: 20px;
        }
    </style>
</head>

<body>
    <div id="nav" class="NavBar"></div>
    <!-- Carousel -->
    <div id="home"></div>

    <!-- Best Sellers Section -->
    <section class="BestSellers">
        <h1>Best Sellers</h1>
        <div class="ProductsGrid">
            @foreach($bestSellers as $stock)
            @php
            $product = $stock->product;
            $image = $product->images->first(); // Get the first image for the product
            $imagePath = $image ? $image->url : 'img/placeholder.jpg'; // Use a placeholder if no image exists
            @endphp
            {{ \Log::info($imagePath) }} <!-- For debugging purposes -->
            <div class="ProductCard">
	      <img src="{{ Str::lower($imagePath) }}" alt="{{ $image ? $image->alt : $product->name }}">
              <h2>{{ $product->name }}</h2>
                <div class="rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>{{ \Illuminate\Support\Str::limit($product->description, 50) }}</p>
                <p>{{ number_format($product->price, 2) }}$</p>
                <a href="{{ route('product.getProduct', ['id' => $product->id]) }}" class="SeeMore">See More</a>
            </div>
            @endforeach
        </div>

    </section>

    <!-- Categories Section (first 6 categories, 3 per row) -->
    <section class="Categories">
        <h1>Categories</h1>
        <div class="CategoriesGrid">
            @foreach($categories->take(6) as $category)
            @php
            $categoryImage = 'storage/categories/' . $category->name . '.jpg';
            $categoryHref = '/shop?categories=' . urlencode($category->name); // Build the href dynamically
            @endphp
            <a href="{{ $categoryHref }}" class="CategoryCard"> <!-- Make the entire card clickable -->
	      <img src="{{ asset(Str::lower($categoryImage)) }}" alt="{{ $category->name }}">
              <div class="overlay">
                    <span>{{ $category->name }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </section>


    <!-- Footer -->
    <footer>
        <div class="footer-sections">

            <div class="footer-section">
                <h3>Follow us on social media</h3>
                <div class="footer-social-icons">
                    <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Our Payment Methods</h3>
                <div class="footer-payment-methods">
                    <img src="{{ asset('img/mastercard.png') }}" alt="MasterCard">
                    <img src="{{ asset('img/visa.png') }}" alt="Visa">
                    <img src="{{ asset('img/paypal.png') }}" alt="PayPal">
                </div>
            </div>
        </div>
    </footer>
