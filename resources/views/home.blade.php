<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Forge</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header,
        .footer {
            background-color: #101010;
            color: white;
            text-align: center;
            padding: 15px 0;
        }

        .footer a {
            text-decoration: none;
            color: #fff;
            margin: 0 10px;
        }

        .best-sellers,
        .categories {
            padding: 20px;
        }

        .best-sellers h2,
        .categories h2 {
            text-align: center;
        }

        .products,
        .categories-list {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .product,
        .category {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: 200px;
            text-align: center;
        }

        .search-bar {
            text-align: center;
            margin: 20px 0;
        }

        .footer-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 10px;
        }

        .footer-buttons button {
            background-color: #ff4500;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .footer-buttons button:hover {
            background-color: #e03e00;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h1>Tech Forge</h1>
        <nav>
            <a href="{{ route('wishlist') }}">Wishlist</a> |
            <a href="{{ route('cart') }}">Cart</a> |
            <a href="{{ route('about') }}">About Us</a> |
            <a href="{{ route('pc-builder') }}">PC Builder</a> |
            <a href="{{ route('login') }}">Login</a>
        </nav>

        <div class="categories-nav">
            <a href="{{ route('shop', ['category' => 'cases']) }}">Cases</a>
            <a href="{{ route('shop', ['category' => 'pc-components']) }}">PC Components</a>
            <a href="{{ route('shop', ['category' => 'peripherals']) }}">Peripherals</a>
            <a href="{{ route('shop', ['category' => 'monitors']) }}">Monitors</a>
            <a href="{{ route('shop', ['category' => 'cooling']) }}">Cooling</a>
        </div>  
    </div>
    
    <!-- Search Bar -->
    <div class="search-bar">
        <form action="{{ route('shop') }}" method="GET">
            <input type="text" name="query" placeholder="Search products..." required>
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Best Sellers Section -->
    <div class="best-sellers">
        <h2>Best Sellers</h2>
        <div class="products">
            @foreach ($bestSellers as $product)
            <div class="product">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="150">
                <h3>{{ $product->name }}</h3>
                <p>${{ number_format($product->price, 2) }}</p>
                <button onclick="location.href='{{ route('wishlist') }}'">Go to Wishlist</button>
                <button onclick="location.href='{{ route('cart') }}'">Add to Cart</button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Categories Section -->
    <div class="categories">
        <h2>Categories</h2>
        <div class="categories-list">
            @foreach ($categories as $category)
            <div class="category">
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="150">
                <h3>{{ $category->name }}</h3>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
    <p>Explore More:</p>
    <div class="footer-buttons">
        <button onclick="location.href='{{ route('feedback') }}'">Give us your feedback</button>
        <button onclick="location.href='{{ route('social-media') }}'">Follow us on social media</button>
        <button onclick="location.href='{{ route('payment-methods') }}'">Our payment methods</button>
    </div>
</div>


</body>

</html>