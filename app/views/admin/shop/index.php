<?php include_once(VIEWS . 'header.php')?>

    <div class="card p-4 bg-light mt-3">
        <div class="card-header">
            <h1 class="text-center">Vista de Administración - Tienda</h1>
        </div>

        <div class="card-body row text-center" style="justify-content: center">

            <div class="text-bg-light mb-3" style="max-width: 1rem;"></div>

            <a href="../../adminUser" class="card text-bg-info mb-3" style="max-width: 17rem; text-decoration: none">
                <div class="card-header">USUARIOS</div>
                <div class="card-body">
                    <h5 class="card-title">Gestión de usuarios</h5>
                    <p class="card-text">
                        Listado y gestión de usuarios normales y administradores. Creación de nuevos usuarios.
                    </p>
                </div>
            </a>

            <div class="text-bg-light mb-3" style="max-width: 1rem;"></div>

            <a href="../../adminProduct" class="card text-bg-info mb-3" style="max-width: 17rem; text-decoration: none">
                <div class="card-header">PRODUCTOS</div>
                <div class="card-body">
                    <h5 class="card-title">Gestión de productos</h5>
                    <p class="card-text">Gestión de los productos activos. Creación de nuevos productos.</p>
                </div>
            </a>

            <div class="text-bg-light mb-3" style="max-width: 1rem;"></div>

            <a href="../../adminSales" class="card text-bg-info mb-3" style="max-width: 17rem; text-decoration: none">
                <div class="card-header">VENTAS</div>
                <div class="card-body">
                    <h5 class="card-title">Listado de ventas</h5>
                    <p class="card-text">Listado de todas las compras realizadas en la tienda. Posibilidad de su búsqueda por rango de fecha.</p>
                </div>
            </a>

        </div>

        <div class="card-footer">

        </div>
    </div>

<?php include_once(VIEWS . 'footer.php')?>