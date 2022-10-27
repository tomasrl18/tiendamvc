<?php include_once ('header.php')?>

    <div class="card p-4 bg-light mt-3">
        <div class="card-header">
            <!-- Pondrá como subtitulo lo que reciba por $data['subtitle']
            en este caso será "¿Olvidaste la contraseña?" -->
            <h1 class="text-center"><?= $data['subtitle'] ?></h1>
        </div>
        <div class="card-body">
            <!-- Este formulario recibirá los datos que le lleguen del
             método olvido del loginController-->
            <form action="<?= ROOT ?>login/olvido" method="post">

                <div class="form-group text-left">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="form-group text-left mt-2">
                    <input type="submit" value="Enviar" class="btn btn-success">
                    <!-- Al darle a botón Regresar redirige al login -->
                    <a href="<?= ROOT ?>login" class="btn btn-info">Regresar</a>
                </div>

            </form>
        </div>

        <div class="card-footer">
            <div class="row">
                <p>Recibirás un correo electrónico, comprueba la carpeta de spam</p>
            </div>
        </div>

    </div>

<?php include_once ('footer.php')?>
