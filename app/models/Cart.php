<?php

class Cart
{
    private $db;

    public function __construct()
    {
        $this->db = Mysqldb::getInstance()->getDatabase();
    }

    public function verifyProduct($product_id , $user_id)
    {
        // El state = 0 es necesario para que se vean los productos
        $sql = 'SELECT * FROM carts WHERE product_id=:product_id AND user_id=:user_id AND state=0';

        $query = $this->db->prepare($sql);

        $params = [
            ':product_id' => $product_id,
            ':user_id' => $user_id,
        ];

        $query->execute($params);

        return $query->rowCount();
    }

    public function addProduct($product_id, $user_id)
    {
        $sql = 'SELECT * FROM products WHERE id=:id';

        $query = $this->db->prepare($sql);
        $query->execute([':id' => $product_id]);

        $product = $query->fetch(PDO::FETCH_OBJ);

        $sql2 = 'INSERT INTO carts(state, user_id, product_id, quantity, discount, send, date)
                    VALUES (:state, :user_id, :product_id, :quantity, :discount, :send, :date)';

        /*$sql2 = 'INSERT INTO carts(state, user_id, product_id, quantity, discount, send, price, date)
                    VALUES (:state, :user_id, :product_id, :quantity, :discount, :send, :price, :date)';*/

        $query2 = $this->db->prepare($sql2);

        $new_time = date("Y-m-d H:i:s", strtotime('+2 hours'));

        $params2 = [
            ':state' => 0,
            ':user_id' => $user_id,
            ':product_id' => $product_id,
            ':quantity' => 1,
            ':discount' => $product->discount,
            ':send' => $product->send,
            //':price' => $product->price,
            ':date' => $new_time,
        ];

        $query2->execute($params2);

        return $query2->rowCount();
    }

    public function getCart($user_id)
    {
        $sql = 'SELECT c.user_id as user, c.product_id as product, c.quantity as quantity, 
                    c.send as send, c.discount as discount, p.price as price, p.image as image, p.description as description,
                    p.name as name FROM carts as c, products as p 
                       WHERE c.user_id=:user_id AND state=0 AND c.product_id=p.id';

        $query = $this->db->prepare($sql);
        $query->execute([':user_id' => $user_id]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function update($user, $product, $quantity)
    {
        $sql = 'UPDATE carts SET quantity=:quantity WHERE user_id=:user_id AND product_id=:product_id AND state=0';
        $query = $this->db->prepare($sql);

        $params = [
            ':user_id' => $user,
            ':product_id' => $product,
            ':quantity' => $quantity,
        ];

        return $query->execute($params);
    }

    public function delete($product, $user)
    {
        $sql = 'DELETE FROM carts WHERE user_id=:user_id AND product_id=:product_id AND state=0';

        $query = $this->db->prepare($sql);

        $params = [
          ':user_id' => $user,
          ':product_id' => $product,
        ];

        return $query->execute($params);
    }

    /*public function getProductPrice()
    {
        $sql = 'SELECT price FROM ';

        $query = $this->db->prepare($sql);
    }*/

    public function closeCart($id, $state)
    {
        $sql2 = 'SELECT carts.product_id, products.price 
                FROM carts 
                JOIN products 
                ON carts.product_id=products.id 
                WHERE carts.state=0 
                AND carts.user_id=:id';

        $query2 = $this->db->prepare($sql2);

        $query2->execute([':id' => $id]);

        $products = $query2->fetchAll(PDO::FETCH_OBJ);

        $verify = true;

        foreach ($products as $product) {
            $sql = 'UPDATE carts SET state=:state, price=:price, date=:date WHERE user_id=:user_id AND state=0 AND product_id=:product_id';

            $query = $this->db->prepare($sql);

            $new_time = date("Y-m-d H:i:s", strtotime('+2 hours'));

            $params = [
                ':user_id' => $id,
                ':state' => $state,
                ':date' => $new_time,
                ':price' => $product->price,
                ':product_id' => $product->product_id,
            ];

            $verify = $query->execute($params);
        }

        //$sql = 'UPDATE carts SET state=:state, date=:date WHERE user_id=:user_id AND state=0';

        //$query = $this->db->prepare($sql);

        //$new_time = date("Y-m-d H:i:s", strtotime('+2 hours'));

        /*$params = [
          ':user_id' => $id,
          ':state' => $state,
          ':date' => $new_time,
        ];*/

        //return $query->execute($params);
        return $verify;
    }

    public function getPayments()
    {
        $sql = 'SELECT * FROM payments';

        $query = $this->db->prepare($sql);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}