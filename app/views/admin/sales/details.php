<?php include_once(VIEWS . 'header.php') ?>

<?php $verify = false; $subtotal = 0; $send = 0; $discount = 0; $user_id = $data['user_id'] ?>

    <h2 class="text-center">Detalles del carrito</h2>
    <form action="<?= ROOT ?>adminSales/details/" method="POST">
        <table class="table table-stripped" width="100%">

            <tr>
                <th width="12%">Producto</th>
                <th width="58%">Descripción</th>
                <th width="1.8%">Cant.</th>
                <th width="10.12%">Precio</th>
                <th width="10.12%">Subtotal</th>
                <th width="1%">&nbsp;</th>
            </tr>

            <?php foreach ($data['data'] as $key => $value): ?>
                <tr>
                    <td>
                        <img src="<?= ROOT ?>img/products/<?= $value->image ?>" width="105" alt="<?= $value->name ?>">
                    </td>

                    <td>
                        <b><?= $value->name ?></b>
                        : <?= substr(html_entity_decode($value->description),0, 200) ?>
                    </td>

                    <td class="text-end">
                        <input type="number" name="c<?= $key ?>" class="text-right"
                               value="<?= number_format($value->quantity, 0) ?>"
                               min="1" max="99">
                        <input type="hidden" name="i<?= $key ?>" value="<?= $value->product ?>">
                    </td>

                    <td class="text-end">
                        <?= number_format($value->price, 2) ?> &euro;
                    </td>

                    <td class="text-end">
                        <?= number_format($value->price * $value->quantity, 2) ?> &euro;
                    </td>

                    <td>&nbsp;</td>

                </tr>

                <?php $subtotal += $value->price * $value->quantity ?>
                <?php $discount += $value->discount ?>
                <?php $send += $value->send ?>

            <?php endforeach; ?>

            <?php $total = $subtotal - $discount + $send ?>

            <input type="hidden" name="rows" value="<?= count($data['data']) ?>">
            <input type="hidden" name="user_id" value="<?= $data['user_id'] ?>">

        </table>
        <hr>
        <table width="100%" class="text-end">

            <tr>
                <td width="79.25%"></td>
                <td width="11.55%">Subtotal:</td>
                <td width="9.20%"><?= number_format($subtotal, 2) ?></td>
            </tr>

            <tr>
                <td width="79.25%"></td>
                <td width="11.55%">Descuento:</td>
                <td width="9.20%"><?= number_format($discount, 2) ?></td>
            </tr>

            <tr>
                <td width="79.25%"></td>
                <td width="11.55%">Envío:</td>
                <td width="9.20%"><?= number_format($send, 2) ?></td>
            </tr>

            <tr>
                <td width="79.25%"></td>
                <td width="11.55%">Total:</td>
                <td width="9.20%"><?= number_format($total, 2) ?></td>
            </tr>

        </table>
    </form>

<?php include_once(VIEWS . 'footer.php') ?>