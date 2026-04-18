
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
<body>             <x-layout>


   
  <script>
        window.products = @json($frontendProducts ?? $products ?? []);
        window.userRole = "{{ Auth::check() && Auth::user()->is_admin ? 'admin' : 'user' }}";
    </script>
 </x-layout>
            </body>

</html>