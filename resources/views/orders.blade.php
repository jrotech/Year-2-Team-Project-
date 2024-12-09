<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/orders/page.js'])
    </head>
    <body class="h-[200vh] bg-main-bg">
      <div id="nav"></div>
      <div id="orders"
      data-invoices = "{{json_encode($invoices)}}"></div>
      
    </body>
</html>
