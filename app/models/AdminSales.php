<?php

class AdminSales
{
    private $db;

    public function __construct()
    {
        $this->db = Mysqldb::getInstance()->getDatabase();
    }

    public function show()
    {
        $sql = "SELECT carts.id, carts.user_id, users.first_name, GROUP_CONCAT(products.name SEPARATOR ', ') as productos, 
                        ROUND(SUM(products.price*carts.quantity), 2) as total, carts.date 
                FROM carts 
                JOIN users 
                ON carts.user_id=users.id 
                JOIN products 
                ON carts.product_id=products.id 
                WHERE carts.state=1 
                GROUP BY carts.date";

        $query = $this->db->prepare($sql);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUserId()
    {

    }

    public function getSaleDate($user_id, $cart_id)
    {
        $sql = 'SELECT date FROM carts WHERE state=1 AND user_id=:user_id AND id=:cart_id';

        $query = $this->db->prepare($sql);

        $params = [
          'user_id' => $user_id,
          'cart_id' => $cart_id,
        ];

        $query->execute($params);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function details($user_id, $date)
    {
        $sql = 'SELECT c.user_id as user, c.product_id as product, c.quantity as quantity, 
                    c.send as send, c.discount as discount, p.price as price, p.image as image, p.description as description,
                    p.name as name FROM carts as c, products as p 
                       WHERE c.user_id=:user_id AND state=1 AND c.product_id=p.id AND c.date=:date';

        $query = $this->db->prepare($sql);

        $params = [
            ':user_id' => $user_id,
            ':date' => $date->date,
        ];

        $query->execute($params);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findSalesByData($data)
    {
        $sql = "SELECT carts.id, carts.user_id, users.first_name, GROUP_CONCAT(products.name SEPARATOR ', ') as productos, 
                        ROUND(SUM(products.price*carts.quantity), 2) as total, carts.date 
                FROM carts 
                JOIN users 
                ON carts.user_id=users.id 
                JOIN products 
                ON carts.product_id=products.id 
                WHERE carts.state=1 ";

        if($data['date1'] != '') {
            $sql .= ' AND carts.date>=:date1';
        }

        if($data['date2'] != '') {
            $sql .= ' AND carts.date<:date2';
        }

        $sql .= ' GROUP BY carts.date ORDER BY carts.date';

        $query = $this->db->prepare($sql);

        $params = [
            ':date1' => $data['date1'],
            ':date2' => $data['date2'],
        ];

        if(count($params) == 0) {
            $query->execute();
        } else {
            $query->execute($params);
        }

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /*public function validateID($id)
    {
        $sql = 'SELECT * FROM users WHERE id=:id';

        $query = $this->db->prepare($sql);

        return $query->execute([':id' => $id]);
    }*/

    /*public function findByID($data)
    {
        $sql = "SELECT carts.user_id, users.first_name, GROUP_CONCAT(products.name SEPARATOR ', ') as productos, 
                        ROUND(SUM(products.price*carts.quantity), 2) as total, carts.date 
                FROM carts 
                JOIN users 
                ON carts.user_id=users.id 
                JOIN products 
                ON carts.product_id=products.id 
                WHERE carts.state=1";

        if($data['id'] != '') {
            $sql .= ' AND users.id=:id';
        }

        $sql .= ' GROUP BY carts.date ORDER BY carts.date';

        $query = $this->db->prepare($sql);

        $params = [ 'id' => $data['id'], ];

        if(count($params) == 0) {
            $query->execute();
        } else {
            $query->execute($params);
        }

        return $query->fetchAll(PDO::FETCH_OBJ);
    }*/
}