<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Todo App' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <!-- Cabeçalho do site -->
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/tasks">Tasks</a></li>
                <li><a href="/profile">Profile</a></li>
            </ul>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <!-- Rodapé do site -->
        <p>&copy; 2025 Todo App. All rights reserved.</p>
    </footer>
</body>
</html>