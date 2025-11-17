<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
         @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <x-layout></x-layout>



<div class="container">
    <h1>Dashboard</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Prezzo</th>
                <th>Creato</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    @if(auth()->user()->is_admin)
                        <td>{{ $order->user->nickname }}</td>
                    @endif
                    <td>{{ $order->description }}</td>
                    <td>{{ number_format($order->price) }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                   
                </tr>
            @empty
                <tr><td colspan="7">Nessun ordine trovato</td></tr>
            @endforelse
        </tbody>
    </table>
{{ $orders->links() }} 
    
</div>

        
    </body>
</html>