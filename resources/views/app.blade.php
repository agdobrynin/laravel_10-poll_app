<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('pageTitle', 'Poll App')</title>
        @vite('resources/css/app.css')

        @livewireStyles
    </head>
    <body class="container mx-auto mt-4 mb-10 max-w-xl">
        <nav class="p-4 mb-4 bg-slate-100 rounded-md shadow-md gap-2 flex justify-between">
            <div>
                <a href="{{ route('polls.list') }}" class="btn">Poll list</a>
                <a href="{{ route('polls.create') }}" class="btn">Create Poll</a>
            </div>
            @livewire('vote-stat')
        </nav>
        <div class="mx-4 mb-4">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
