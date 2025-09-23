
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
<body>             <x-layout>

</x-layout>

<script>
    
</script>
<script>
    const products = window.products;
    console.log(products);
    const catalog = document.getElementById('catalog');
    products.forEach(product => {
        const col = document.createElement('div');
        col.className = 'col-3';
        col.innerHTML = `
            <div class="card glow">
                <img src="${product.image_url}" class="card-img-top" alt="${product.name}">
                <div class="card-body">
                    <h5 class="card-title">${product.name}</h5>
                    <p class="card-text">${product.description}</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        `;
        catalog.querySelector('.row').appendChild(col);
    });
</script>
/* <!-- <div class="container-fluid" id="catalog">
    <div class="row justify-content-evenly">
        <div class="col-3">
            <div class="card glow">
  <img src="..." class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        </div>
        <div class="col-3">             
            <div class="card glow">
  <img src="..." class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        </div>
        <div class="col-3">
            <div class="card glow">
  <img src="..." class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        </div>
    </div>
</div> -->
            </body>

</html>