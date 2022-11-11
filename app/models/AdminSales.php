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
        $sql = "SELECT carts.user_id, users.first_name, GROUP_CONCAT(products.name SEPARATOR ', ') as productos, 
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

    public function findSalesByData($data)
    {
        $sql = "SELECT carts.user_id, users.first_name, GROUP_CONCAT(products.name SEPARATOR ', ') as productos, 
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

    public function details()
    {
        
    }
}