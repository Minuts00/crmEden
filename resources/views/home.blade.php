<x-layout>
    <section class="container py-4">
        <header class="mb-4">
            <h1 class="h3 mb-1">Catalogo prodotti</h1>
            <p class="text-muted mb-0">Esplora i prodotti disponibili.</p>
        </header>
<div id="catalog" class="row g-4"></div>
  <div id="catalogEmptyState" class="alert alert-info d-none" role="status">
            Nessun prodotto disponibile al momento.
        </div>
    </section>
      <script>
        window.products = @json($frontendProducts ?? $products ?? []);
        window.userRole = "{{ Auth::check() && Auth::user()->is_admin ? 'admin' : 'user' }}";
    </script>
    </x-layout>