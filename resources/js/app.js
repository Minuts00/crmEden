import './bootstrap';
import * as bootstrap from 'bootstrap';
const FALLBACK_IMAGE = 'https://placehold.co/600x400?text=No+Image';

document.addEventListener('DOMContentLoaded', () => {
    const catalog = document.getElementById('catalog');
    const emptyState = document.getElementById('catalogEmptyState');
    const products = window.products || [];
    const userRole = window.userRole || 'user';
     if (!catalog) {
        return;
    }

    if (!products.length) {
        emptyState?.classList.remove('d-none');
        return;
    }

    catalog.innerHTML = products.map((product) => buildProductCard(product, userRole)).join('');

    if (userRole !== 'admin') {
        ensureModalStructure();

        catalog.addEventListener('click', (event) => {
            const trigger = event.target.closest('[data-product-modal-trigger]');
            if (!trigger) {
                return;
            }
         const payload = trigger.getAttribute('data-product-payload');
            if (!payload) {
                return;
            }

            const product = JSON.parse(decodeURIComponent(payload));
            openProductModal(product);
        });
    }
});
function buildProductCard(product, userRole) {
    const safeProduct = {
        id: product.id,
        name: product.name || 'Prodotto senza nome',
        description: product.description || 'Nessuna descrizione disponibile.',
        category_name: product.category_name || 'Senza categoria',
        price_list: product.price_list,
        price_min: product.price_min,
        stock: !!product.stock,
        main_image: product.main_image || FALLBACK_IMAGE,
        images: Array.isArray(product.images) ? product.images.filter(Boolean) : [],
    };

    const stockClass = safeProduct.stock ? 'stock-pill--available' : 'stock-pill--unavailable';
    const stockLabel = safeProduct.stock ? 'Disponibile' : 'Non disponibile';
    const priceList = formatPrice(safeProduct.price_list);
    const priceMin = formatPrice(safeProduct.price_min);
    const serializedProduct = encodeURIComponent(JSON.stringify(safeProduct));

    const actionButton = userRole === 'admin'
        ? `<a href="/products/${safeProduct.id}/edit" class="btn btn-warning w-100">Modifica prodotto</a>`
        : `<button class="btn btn-info w-100"
                    data-product-modal-trigger
                   data-product-payload="${serializedProduct}">Visualizza dettagli</button>`;


    return `
        <article class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card product-card glow h-100">
                <img src="${safeProduct.main_image}" class="card-img-top product-card__image" alt="${escapeHtml(safeProduct.name)}">
                <div class="card-body d-flex flex-column gap-2">
                    <span class="product-card__category">${escapeHtml(safeProduct.category_name)}</span>
                    <h5 class="card-title mb-0">${escapeHtml(safeProduct.name)}</h5>
                    <div class="product-card__prices">
                        <p class="mb-1"><strong>Listino:</strong> ${priceList}</p>
                        <p class="mb-0"><strong>Prezzo minimo:</strong> ${priceMin}</p>
                    </div>
                    <span class="stock-pill ${stockClass}">${stockLabel}</span>
                    <div class="mt-auto pt-2">${actionButton}</div>
                </div>
                  </div>
        </article>
    `;
}

function ensureModalStructure() {
    if (document.getElementById('productModal')) {
        return;
    }

    document.body.insertAdjacentHTML('beforeend', `
        <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalProductName"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modalProductCarousel" class="carousel slide mb-3" data-bs-ride="false">
                            <div class="carousel-inner" id="modalCarouselInner"></div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#modalProductCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#modalProductCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                           <div class="row g-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Categoria:</strong> <span id="modalProductCategory"></span></p>
                                <p class="mb-1"><strong>Prezzo di listino:</strong> <span id="modalProductPriceList"></span></p>
                                <p class="mb-1"><strong>Prezzo minimo:</strong> <span id="modalProductPriceMin"></span></p>
                                <p class="mb-0"><strong>Disponibilità:</strong> <span id="modalProductStock"></span></p>
                            </div>
   <div class="col-md-6">
                                <p class="mb-0" id="modalProductDescription"></p>
                            </div>
                        </div>
                    </div>
                          <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>
           `);
}

function openProductModal(product) {
    const modalElement = document.getElementById('productModal');
    const carouselInner = document.getElementById('modalCarouselInner');

    document.getElementById('modalProductName').textContent = product.name || 'Dettaglio prodotto';
    document.getElementById('modalProductCategory').textContent = product.category_name || 'Senza categoria';
    document.getElementById('modalProductPriceList').textContent = formatPrice(product.price_list);
    document.getElementById('modalProductPriceMin').textContent = formatPrice(product.price_min);
    document.getElementById('modalProductStock').textContent = product.stock ? 'Disponibile' : 'Non disponibile';
    document.getElementById('modalProductDescription').textContent = product.description || 'Nessuna descrizione disponibile.';

    const images = Array.isArray(product.images) && product.images.length ? product.images : [product.main_image || FALLBACK_IMAGE];

    carouselInner.innerHTML = images
        .map((imageUrl, index) => `
            <div class="carousel-item ${index === 0 ? 'active' : ''}">
                <img src="${imageUrl}" class="d-block w-100 modal-carousel-image" alt="${escapeHtml(product.name || 'Prodotto')}">
            </div>
        `)
        .join('');

    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
    modal.show();
}

function formatPrice(value) {
    const amount = Number(value);
    if (Number.isNaN(amount)) {
        return 'N/D';
    }

    return new Intl.NumberFormat('it-IT', {
        style: 'currency',
        currency: 'EUR',
    }).format(amount);
}

function escapeHtml(value) {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}