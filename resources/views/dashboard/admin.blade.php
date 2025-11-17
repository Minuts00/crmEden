<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <x-layout></x-layout>

    <!-- <div class="container"> 
    <h2>Dashboard Amministratore</h2>
    <p>Visualizza tutti gli ordini del sistema</p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Ordine</th>
                <th>Utente</th>
                <th>Prodotto</th>
                <th>Data Creazione</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->nickname ?? 'Sconosciuto' }}</td>
                    <td>{{ $order->product_id ?? '-' }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>-->
<div class="container">
    <h1>Dashboard</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                @if(auth()->user()->is_admin)
                    <th>Utente</th>
                @endif
                <th>Nome</th>
                <th>Prezzo</th>
                <th>Creato</th>
                <th>Azioni</th>
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
                    <td>{{ number_format($order->price, 8,2) }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">Vedi</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Nessun ordine trovato</td></tr>
            @endforelse
        </tbody>

    </table>
    </div> 

</body>
</html>