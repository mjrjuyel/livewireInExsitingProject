<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            justify-content: space-between;
        }

        header {
            background-color: #333;
            padding: 15px 30px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
        }

        header nav ul li {
            display: inline;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        header nav ul li a:hover {
            color: #f0a500;
        }

        .banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 50px;
            background: linear-gradient(to right, #004d99, #0066cc);
            color: #fff;
            height: calc(100vh - 60px);
        }

        .banner-content {
            max-width: 50%;
        }

        .banner-content h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .banner-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .banner-content .btn-login {
            padding: 12px 24px;
            font-size: 1rem;
            background-color: #f0a500;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .banner-content .btn-login:hover {
            background-color: #d08900;
        }

        .banner-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
        @endif
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
      <div class="container">
        <header>
            <div class="logo">Eteamify</div>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </header>

        <div class="banner">
            <div class="banner-content">
                <h1>Eteamify</h1>
                <p>Streamline your employee and admin management with our powerful, user-friendly system. Improve efficiency and manage your team effectively with Eteamify.</p>
                <a href="dashboard.html" class="btn-login">Login to Dashboard</a>
            </div>
            <div class="banner-image">
                <img src="https://via.placeholder.com/500" alt="Employee and Admin Management Illustration">
            </div>
        </div>
    </div>
    </body>
</html>
