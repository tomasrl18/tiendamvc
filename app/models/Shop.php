<?php

class Shop
{
    private $db;

    public function __construct()
    {
        $this->db = Mysqldb::getInstance()->getDatabase();
    }

    public function getMostSold()
    {
        $sql = 'SELECT * FROM products WHERE mostSold=1 AND deleted=0 LIMIT 8';

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProductById($id)
    {
        $sql = 'SELECT * FROM products WHERE id=:id';

        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);

        // No ponemos fetchAll porque el id es una clave primaria y solo habrá 1
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function getNews()
    {
        $sql = 'SELECT * FROM products WHERE mostSold!=1 AND new=1 AND deleted=0 LIMIT 8';

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function sendEmail($name, $email, $message)
    {
        $msg = $name . ', Ha enviado un mensaje nuevo. <br>';
        $msg .= 'Su correo es: ' . $email . '<br>';
        $msg .= 'Mensaje:<br>' . $message;

        $headers = 'MIME-Version:1.0\r\n';
        $headers .= 'Content-type:text/html; charset=UTF-8c';
        $headers .= 'From: ' . $name . '\r\n';
        $headers .= 'Reply-to: ' . $email . '\r\n';

        $subject = 'Mensaje de usuario ' . $name;

        return mail('info@tiendamvc.local', $subject, $msg, $headers);
    }
}