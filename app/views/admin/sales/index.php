<?php include_once(VIEWS . 'header.php')?>

    <div class="card p-4 bg-light mt-3">

        <div class="card-header">
            <h1 class="text-center"><?= $data['subtitle'] ?></h1>

            <div class="row">
                <div class="input-group mb-3" style="width: 20%">
                    <label for="date1" type="hidden" class="input-group-text">De</label>
                    <input type="date" name="date1" id="date1" class="form-control" placeholder="Búsqueda por fecha...">
                </div>

                <div class="input-group mb-3" style="width: 20%">
                    <label for="date2" type="hidden" class="input-group-text">A</label>
                    <input type="date" name="date2" id="date2" class="form-control" placeholder="Busqueda por fecha...">

                </div>

                <a href="<?= ROOT ?>adminSales/paramsSelect/" class="btn btn-secondary" type="button" style="width: 10%; height: 10%">Buscar</a>
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
                <?php foreach ($data['data'] as $value): ?>

                    <tr>
                        <td class="text-center"> <?= $value->id ?> </td>
                        <td class="text-center"> <?= $value->first_name ?> </td>
                        <td class="text-center"> <?= $value->date ?> </td>
                        <td class="text-center"> <?= $value->price ?> &euro;</td>

                        <td class="text-center">
                            <a href="<?= ROOT ?>adminSales/details/" class="btn btn-primary">
                                Detalles
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>

            </table>
        </div>

        <div class="card-footer">

        </div>

    </div>

<?php include_once(VIEWS . 'footer.php')?>