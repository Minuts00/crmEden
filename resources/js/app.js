import './bootstrap';
import 'bootstrap';
import { Modal } from 'bootstrap';
window.bootstrap = { Modal };

document.addEventListener('DOMContentLoaded', () => {
    const catalog = document.getElementById('catalog');
    const products = window.products || [];
    const userRole = window.userRole || 'user';

    if (catalog && products.length > 0) {
        catalog.innerHTML = products.map(product => {
            // Solo per admin: link alla modifica
            if (userRole === 'admin') {
                return `
                    <div class="card m-2 glow" style="width: 18rem; display:inline-block;">
                        <img src="/storage/${product.img}" class="card-img-top" alt="${product.name}" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="card-text text-truncate" style="max-height: 60px;">${product.description || ''}</p>
                            <span class="badge bg-primary">${product.price ? product.price + ' €' : ''}</span>
                            <div class="mt-3 text-center">
                                <a href="/products/${product.id}/edit" class="btn btn-warning">
                                    Modifica prodotto
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            // Per utente: card con modal
            return `
                <div class="card m-2 glow" style="width: 18rem; display:inline-block;">
                    <img src="/storage/${product.img}" class="card-img-top" alt="${product.name}" style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">${product.name}</h5>
                        <p class="card-text text-truncate" style="max-height: 60px;">${product.description || ''}</p>
                        <span class="badge bg-primary">${product.price ? product.price + ' €' : ''}</span>
                        <div class="mt-3 text-center">
                            <button class="btn btn-info" 
                                    onclick="showProductModal(${JSON.stringify(product).replace(/"/g, '&quot;')})">
                                Visualizza dettagli
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }
});

// Aggiungi questa funzione globale
window.showProductModal = function(product) {
    // Crea modal se non esiste
    if (!document.getElementById('productModal')) {
        createModalStructure();
    }
    
    // Popola la modal con i dati del prodotto
    document.getElementById('modalProductName').textContent = product.name;
    document.getElementById('modalProductDescription').textContent = product.description || 'Nessuna descrizione disponibile';
    document.getElementById('modalProductPrice').textContent = product.price ? `€ ${product.price}` : 'Prezzo non disponibile';
    document.getElementById('modalProductImage').src = `/storage/${product.img}`;
    document.getElementById('modalProductImage').alt = product.name;
    
    // Mostra la modal
    const modal = new bootstrap.Modal(document.getElementById('productModal'));
    modal.show();
};

// Crea la struttura della modal dinamicamente
function createModalStructure() {
    const modalHTML = `
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Dettagli Prodotto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="modalProductImage" src="" class="img-fluid rounded" style="max-height: 400px; object-fit: contain;">
                        </div>
                        <div class="col-md-6">
                            <h3 id="modalProductName" class="mb-3"></h3>
                            <div class="mb-4">
                                <h5>Descrizione:</h5>
                                <p id="modalProductDescription" class="text-muted"></p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 id="modalProductPrice" class="text-primary mb-0"></h4>
                                <button class="btn btn-success">
                                    <i class="fas fa-cart-plus me-2"></i>Aggiungi al Carrello
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
    `;
    
    // Aggiungi la modal al body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
}