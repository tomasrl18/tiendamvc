        <?php include_once ('header.php') ?>
            <div class="card p-4 bg-light mt-3">

                <div class="card-header">
                    <h1 class="text-center">Login</h1>
                </div>

                <div class="card-body">
                    <!-- Recibirá los datos que le lleguen del método verifyUser
                    del loginController -->
                    <form action="<?= ROOT ?>login/verifyUser/" method="POST">

                        <div class="form-floating mb-3">
                            <input type="text" name="user" class="form-control" id="floatingInput"
                                   placeholder="Escriba el correo electrónico"
                                   value="<?= isset($data['data']) ? $data['data']['user'] : '' ?>">
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

                        <div class="form-group text-left">
                            <input type="checkbox" name="remember"
                              <?= (isset($data['data']) && $data['data']['remember'] == 'on') ? 'checked' : '' ?>>
                            <label>Recordar</label>
                        </div>

                    </form>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="<?= ROOT ?>login/registro" class="btn btn-info">Nuevo usuario</a>
                        </div>

                        <div class="col-sm-6">
                            <a href="<?= ROOT ?>login/olvido" class="btn btn-info">He olvidado mi contraseña</a>
                        </div>

                    </div>
                </div>

            </div>
        <?php include_once ('footer.php') ?>