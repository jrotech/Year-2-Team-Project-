<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product View - Nvidia GTX 3070</title>
    <!-- Laravel Asset Helper for CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: Arial Black, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .product-view {
            display: flex;
            gap: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .product-image img {
            width: 400px;
            height: auto;
            border-radius: 8px;
        }
        .product-details {
            flex: 1;
        }
        .product-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .product-price {
            color: #e63946;
            font-size: 24px;
            margin: 10px 0;
        }
        .product-stock {
            color: green;
            font-weight: bold;
            margin: 10px 0;
        }
        .product-rating {
            margin: 10px 0;
            font-size: 16px;
            color: #ffa500;
        }
        .description {
            margin: 20px 0;
        }
        .description h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .add-to-cart {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .add-to-cart:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="product-view">
            <!-- Product Image -->
            <div class="product-image">
                <img src="{{ asset('images/nvidia-gtx-3070.jpg') }}" alt="Nvidia GTX 3070">
            </div>

            <!-- TEST TEST Product Details -->
            <div class="product-details">
                <h1 class="product-title">Nvidia GTX 3070</h1>
                <p class="product-price">£3000.00</p>
                <p class="product-stock">In Stock</p>
                <p class="product-rating">Rating: ⭐⭐⭐⭐☆ (4.5/5)</p>
                <p class="description">
                    <strong>Description:</strong> 
                    High-performance graphics card for gaming and professional work. Built with advanced cooling systems and optimized performance.
                </p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
    </div>
</body>
</html>
