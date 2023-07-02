<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Poll App</title>
        @vite('resources/css/app.css')

        @livewireStyles
    </head>
    <body class="container mx-auto mt-4 mb-10 max-w-screen-lg">
        <nav class="p-4 mb-4 bg-slate-100 rounded-md shadow-md gap-2 flex justify-between">
            <a href="{{ route('polls.list') }}" class="btn">Poll list</a>
            <a href="{{ route('polls.create') }}" class="btn">Create Poll</a>
        </nav>
        {{ $slot }}
        @livewireScripts
    </body>
</html>
