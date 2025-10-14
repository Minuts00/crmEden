import './bootstrap';
import 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const catalog = document.getElementById('catalog');
    const products = window.products || [];
    if (catalog && products.length > 0) {
        catalog.innerHTML = products.map(product => `
            <div class="card m-2 glow" style="width: 18rem; display:inline-block;">
                <img src="${product.image_url || 'https://via.placeholder.com/150'}" class="card-img-top" alt="${product.name}">
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">${product.description || ''}</p>
                    <span class="badge bg-primary">${product.price ? product.price + ' €' : ''}</span>
                </div>
            </div>
        `).join('');
    }
});