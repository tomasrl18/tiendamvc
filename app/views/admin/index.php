<?php include_once dirname(__DIR__) . ROOT . 'header.php' ?>

<div class="card p-4 bg-light mt-3">

    <div class="card-header">
        <h1 class="text-center">Modulo de administración</h1>
    </div>

    <div class="card-body">
        <form action="<?= ROOT ?>admin/verifyUser" method="post">

            <div class="form-floating mb-3">
                <input type="email" name="user" class="form-control" id="floatingInput"
                       placeholder="Escriba el correo electrónico"
                       value="<?= $data['data']['user'] ?? '' ?>">
                <label for="floatingInput">Usuario</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingInput"
                       placeholder="Escriba la clave de acceso"
                       value="<?= $data['data']['password'] ?? '' ?>">
                <label for="floatingInput">Clave de acceso</label>
            </div>

            <div class="form-group text-left">
                <input type="submit" value="Enviar" class="btn btn-success">
            </div>

        </form>
    </div>
</div>

<?php include_once dirname(__DIR__) . ROOT . 'footer.php' ?>