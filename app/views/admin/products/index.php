<?php include_once (VIEWS . 'header.php')?>

    <div class="card p-4 bg-light mt-3">

        <div class="card-header">
            <h1 class="text-center">Administración de Productos</h1>
        </div>

        <div class="card-body">
            <table class="table table-striped text-center" width="100%">
                <thead>
                <th>Id</th>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Modificar</th>
                <th>Borras</th>
                </thead>

                <tbody>
                <?php foreach ($data['products'] as $products): ?>
                    <tr>
                        <td class="text-center"><?= $products->id ?></td>
                        <td class="text-center"><?= $data['type'][$products->type - 1]->description ?></td>
                        <td class="text-center"><?= $products->name ?></td>
                        <td class="text-center"><?= html_entity_decode($products->description) ?></td>

                        <td class="text-center">
                            <a href="<?= ROOT ?>adminProduct/update/<?= $products->id ?>" class="btn btn-info">
                                Editar
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="<?= ROOT ?>adminProduct/delete/<?= $products->id ?>" class="btn btn-danger">
                                Borrar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    <a href="<?= ROOT ?>AdminProduct/create" class="btn btn-success">
                        Crear Producto
                    </a>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

<?= include_once (VIEWS . 'footer.php')?>