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
        // Select de Marmol
        /*$sql = 'SELECT carts.id cart_id , users.id user_id , users.first_name , carts.product_id product_id ,
        products.name , carts.date, carts.send , carts.discount, carts.quantity , products.price
        FROM carts JOIN users ON carts.user_id = users.id JOIN products ON products.id = carts.product_id
        WHERE carts.state=1 ORDER BY carts.date';*/


        // Mi select
        $sql = 'SELECT carts.*, products.price, products.name, users.first_name, users.id
                FROM carts 
                JOIN products 
                ON carts.product_id=products.id 
                JOIN users 
                ON carts.user_id=users.id 
                WHERE carts.state=1
                ORDER BY carts.date';

        $query = $this->db->prepare($sql);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function findSalesByData($data)
    {
        $sql = 'SELECT carts.*, products.price, users.first_name, users.id
                FROM carts 
                JOIN products 
                ON carts.product_id=products.id 
                JOIN users 
                ON carts.user_id=users.id 
                WHERE carts.state=1';

        if($data['date1'] != '') {
            $sql .= ' AND carts.date>=:date1';
        }

        if($data['date2'] != '') {
            $sql .= ' AND carts.date<:date2';
        }

        $sql .= ' ORDER BY carts.date';

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

    /*public function ahoraPiensoUnNombre()
    {
        $sql = 'SELECT products.name, carts.date
        FROM carts
        JOIN products
        ON carts.product_id=products.id
        WHERE carts.state=1
        ORDER BY carts.date';

        $query = $this->db->prepare($sql);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }*/

    public function details()
    {
        
    }

    /*public function groupCarts($carts)
    {
        $cartList = array();

        array_push($carts, array(
            'user_id' => $carts[0]->user_id,
            'first_name' => $carts[0]->first_name,
            'product_id' => $carts[0]->product_id,
            'name' => $carts[0]->name,
            'date' => $carts[0]->date,
            'send' => $carts[0]->send,
            'discount' => $carts[0]->discount,
            'quantity' => $carts[0]->quantity,
            'price' => $carts[0]->price,
        ));

        for($i = 1; $i < count($carts); $i++) {

            $aux = false;

            for($j = 0; $j < count($cartList); $j++) {
                if($cartList[$j]['user_id'] == $carts[$i]->user_id && $carts[$i]->date == $cartList[$j]['date']) {
                    if($carts[$i]->product_id != $cartList[$j]['product_id']) {
                        $aux = true;
                        break;
                    }
                } else {
                    $aux = false;
                }
            }

            if($aux) {
                $cartList[$j]['name'] = $cartList[$j]['name'] . ', ' . $carts[$i]->name;
                $cartList[$j]['price'] = number_format(floatval($cartList[$j]['price'] + $carts[$i]->price), 2);
            } else {
                array_push($cartList, array(
                    'user_id' => $carts[$i]->user_id,
                    'first_name' => $carts[$i]->first_name,
                    'product_id' => $carts[$i]->product_id,
                    'name' => $carts[$i]->name,
                    'date' => $carts[$i]->date,
                    'send' => $carts[$i]->send,
                    'discount' => $carts[$i]->discount,
                    'quantity' => $carts[$i]->quantity,
                    'price' => $carts[$i]->price,
                ));
            }
        }

        return $cartList;
    }*/
}