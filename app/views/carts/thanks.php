<?php include_once(VIEWS . 'header.php')?>

    <div class="card p-4 bg-light mt-3">

        <div class="card-header">
            <h1 class="text-center">Muchas gracias por su compra</h1>
        </div>

        <div class="text-center card-body">
            <h2>Estimado/a <?= $data['data']->first_name ?>:</h2>
            <h4>
                ¡Gracias por visitarnos y hacer su compra!
                Estamos contentos de que haya encontrado lo que buscaba.
                Nuestro objetivo es que siempre esté satisfecho, avísenos de su nivel de satisfacción.
                Esperamos volver a verle pronto.
            </h4>
            <h3>¡Que tenga un gran día!</h3>
        </div>

        <div class="text-center card-footer">
            <a href="<?= ROOT ?>shop" class="btn btn-success mt-2">Regresar a la tienda</a>
        </div>
    </div>

<?php include_once(VIEWS . 'footer.php')?>