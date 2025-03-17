<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculatrice Devis</title>
    @livewireStyles
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/hello-chris.css') }}">
</head>
<body>
    {{ $slot }}

    @livewireScripts
</body>
</html>
