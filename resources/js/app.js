import './bootstrap';
import 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const catalog = document.getElementById('catalog');
    const products = window.products || [];
    if (catalog) {
        products.forEach(product => {
            catalog.innerHTML += `
                <div class="col-3">
                    <div class="card glow">
                        <img src="${product.image_url || 'https://via.placeholder.com/150'}" class="card-img-top" alt="${product.name}">
                        <div class="card-body">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="card-text">${product.description}</p>
                            <a href="#" class="btn btn-primary">Dettagli</a>
                        </div>
                    </div>
                </div>
            `;
        });
    }
})();