<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg text-bg-success ">
        <div class="container-fluid text-bg-success">
            <a class="navbar-brand text" href="{{ route('home') }}">Navbar</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link text" href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text" href="{{ route('orders.create') }}">Ordina</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text" href="{{ route('products.create') }}">Carica Prodotto</a>
                </li>
                <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                @csrf
                    <button type="submit" class="btn btn-danger text">Logout</button>
                </form>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            </div>
        </div>
                </nav>
                <main>
        {{ $slot }}
    </main>
</body>
</html>