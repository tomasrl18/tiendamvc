<?php include_once(VIEWS . 'header.php') ?>
    <div class="card p-4 bg-light mt-3">
        <div class="card-header">
            <h1 class="text-center">Eliminación de un producto</h1>
        </div>
        <div class="card-body">
            <form action="<?= ROOT ?>adminProduct/delete/<?= $data['product']->id ?>" method="POST">

                <div class="form-group text-left">
                    <label for="type">Tipo de Producto:</label>
                    <select class="form-control" name="type" id="type" disabled>
                        <?php foreach ($data['type'] as $type) : ?>
                            <option value="<?= $type->value ?>"
                                <?= (isset($data['product']->type) && $data['product']->type == $type->value) ? ' selected ' : '' ?>
                            >
                                <?= $type->description ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <br>

                <div class="form-group text-left">
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" class="form-control" disabled
                           value="<?= (isset($data['product']->name)) ? $data['product']->name : '' ?>">
                </div>

                <br>

                <div class="form-group text-center">
                    <hr>
                    <p class="text-center" style="font-size: 20px"><b>Una vez borrado el producto, no será recuperable.</b></p>
                    <hr>

                    <input type="submit" value="Si" class="btn btn-danger" style="width: 10%">

                    <a href="<?= ROOT ?>adminProduct" class="btn btn-info" style="width: 10%">No</a>
                </div>

            </form>
        </div>
    </div>

<?php include_once(VIEWS . 'footer.php') ?>