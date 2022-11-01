<?php include_once(VIEWS . 'header.php')?>
<?php $dateComp = false; $user_idComp = false; $product_idComp = false; ?>
    <div class="card p-4 bg-light mt-3">

        <div class="card-header">
            <h1 class="text-center"><?= $data['subtitle'] ?></h1>

            <div class="input-group mb-3">
                <input type="date" class="form-control" placeholder="Busqueda por fecha">
                <button class="btn btn-outline-secondary" type="button">Enviar</button>
            </div>



        </div>

        <div class="card-body">
            <table class="table table-striped text-center" width="100%">
                <thead>
                    <th>Id Usuario</th>
                    <th>Nombre Usuario</th>
                    <th>Fecha de compra</th>
                    <th>Valor total de la compra</th>
                    <th></th>
                </thead>

                <tbody>

                <!-- Aquí había un for -->

                    <tr>
                        <td class="text-center">  </td>
                        <td class="text-center">  </td>
                        <td class="text-center">  </td>
                        <td class="text-center">  &euro;</td>

                        <td class="text-center">
                            <a href="<?= ROOT ?>adminSales/details/" class="btn btn-primary">
                                Detalles
                            </a>
                        </td>

                    </tr>

                <!-- Aquí terminaba el for -->

                </tbody>
            </table>
        </div>

        <div class="card-footer">

        </div>

    </div>

<?php include_once(VIEWS . 'footer.php')?>