
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
<body>             <x-layout>

</x-layout>





 <div class="container-fluid">
        <div class="row justify-content-evenly" id="catalog"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const catalog = document.getElementById('catalog');
    const products = window.products || [];
    const userRole = window.userRole || 'user'; // "admin" o "user"

    if (catalog && products.length > 0) {
        catalog.innerHTML = products.map(product => {
            // Link diverso per admin e user
            const link = userRole === 'admin' 
                ? `/products/${product.id}/edit` 
                : `/products/${product.id}`;

            const buttonLabel = userRole === 'admin' 
                ? 'Modifica prodotto' 
                : 'Visualizza dettagli';

            return `
                <div class="card m-2 glow" style="width: 18rem; display:inline-block;">
                    <img src="/storage/${product.img}" class="card-img-top" alt="${product.name}">
                    <div class="card-body">
                        <h5 class="card-title">${product.name}</h5>
                        <p class="card-text">${product.description || ''}</p>
                        <span class="badge bg-primary">${product.price ? product.price + ' €' : ''}</span>
                        <div class="mt-3 text-center">
                            <a href="${link}" class="btn btn-${userRole === 'admin' ? 'warning' : 'info'}">
                                ${buttonLabel}
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }
});
    </script>
 <script>
    window.products = @json($products);
    window.userRole = "{{ Auth::check() && Auth::user()->is_admin ? 'admin' : 'user' }}";
</script>
 
            </body>

</html>