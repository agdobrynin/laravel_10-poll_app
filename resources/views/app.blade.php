<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pool App</title>
        @vite('resources/css/app.css')

        @livewireStyles
    </head>
    <body class="container mx-auto mt-10 mb-10 max-w-lg">
        @livewireScripts
        @livewire('create-pool')
    </body>
</html>
