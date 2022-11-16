<?php

class CartController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Cart');
    }

    public function index($errors = [])
    {
        $session = new Session();

        if($session->getLogin()) {

            $user_id = $session->getUserId();
            $cart = $this->model->getCart($user_id);

            if(count($cart) == 0) {
                header('location:' . ROOT . 'shop');
            }

            $data = [
              'titulo' => 'Carrito',
              'menu' => true,
              'user_id' => $user_id,
              'data' => $cart,
              'errors' => $errors,
            ];

            $this->view('carts/index', $data);

        } else {
            header('location:' . ROOT);
        }
    }

    public function addProduct($product_id , $user_id)
    {
        $errors = [];

        if(! $this->model->verifyProduct($product_id, $user_id)){
            if(! $this->model->addProduct($product_id , $user_id)){
                array_push($errors , 'Error al insertar el producto en el carrito');
            }
        }

        $this->index($errors);
    }

    public function update()
    {
        if(isset($_POST['rows']) && isset($_POST['user_id'])){
            $errors = [];
            $rows = $_POST['rows'];
            $user_id = $_POST['user_id'];

            for ($i = 0; $i < $rows; $i++){
                $product_id = $_POST['i' . $i];
                $quantity = $_POST['c'. $i];

                if(! $this->model->update($user_id , $product_id , $quantity)) {
                    array_push($errors, 'Error al actualizar el producto');
                }
            }
        }

        $this->index($errors);
    }

    public function delete($product, $user)
    {
        $errors = [];

        if( ! $this->model->delete($product, $user)) {
            array_push($errors, 'Error al borrar el producto');
        }

        $this->index($errors);
    }

    public function checkout()
    {
        $session = new Session();

        if($session->getLogin()) {

            $user = $session->getUser();

            $data = [
                'titulo' => 'Carrito | Checkout',
                'subtitle' => 'Checkout | Iniciar Sesión',
                'menu' => true,
                'data' => $user,
            ];

            $this->view('carts/address', $data);
        } else {
            $data = [
              'titulo' => 'Carrito | Checkout',
              'subtitle' => 'Checkout | Iniciar Sesión',
              'menu' => true,
            ];

            $this->view('carts/checkout', $data);
        }
    }

    public function paymentmode()
    {
        // Comprobar si está logueado
        $session = new Session();

        if( ! $session->getLogin()) {
            header('location:' . ROOT);
        }

        $errors = [];
        $user = $session->getUser();

        // Desarrollar el POST y comprobar datos
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $first_name = $_POST['first_name'] ?? '';
            $last_name_1 = $_POST['last_name_1'] ?? '';
            $last_name_2 = $_POST['last_name_2'] ?? '';
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';
            $city = $_POST['city'] ?? '';
            $state = $_POST['state'] ?? '';
            $postcode = $_POST['postcode'] ?? 0;
            $country = $_POST['country'] ?? '';

            if($user->first_name != $first_name) {
                if(empty($first_name)) {
                    array_push($errors, 'El nombre es requerido');
                } else {
                    $user->first_name = $first_name;
                }
            }

            if($user->last_name_1 != $last_name_1) {
                if(empty($last_name_1)) {
                    array_push($errors, 'El primer apellido es requerido');
                } else {
                    $user->last_name_1 = $last_name_1;
                }
            }

            if($user->last_name_2 != $last_name_2) {
                if(empty($last_name_2)) {
                    array_push($errors, 'El segundo apellido es requerido');
                } else {
                    $user->last_name_2 = $last_name_2;
                }
            }

            if($user->email != $email) {
                if(empty($email)) {
                    array_push($errors, 'El email es requerido');
                } else {
                    $user->email = $email;
                }
            }

            if($user->address != $address) {
                if(empty($address)) {
                    array_push($errors, 'El dirección es requerida');
                } else {
                    $user->address = $address;
                }
            }

            if($user->city != $city) {
                if(empty($city)) {
                    array_push($errors, 'La ciudad es requerida');
                } else {
                    $user->city = $city;
                }
            }

            if($user->state != $state) {
                if(empty($state)) {
                    array_push($errors, 'La provincia es requerida');
                } else {
                    $user->state = $state;
                }
            }

            if($user->zipcode != $postcode) {
                if($postcode == 0) {
                    array_push($errors, 'El código postal es requerido');
                } else {
                    $user->zipcode = $postcode;
                }
            }

            if($user->country != $country) {
                if(empty($country)) {
                    array_push($errors, 'El país es requerido');
                } else {
                    $user->country = $country;
                }
            }
        }

        if (count($errors) > 0) {
            $data = [
                'titulo' => 'Carrito | Checkout',
                'subtitle' => 'Checkout | Iniciar Sesión',
                'menu' => true,
                'data' => $user,
                'errors' => $errors,
            ];

            $this->view('carts/address', $data);
        } else {
            $session->login($user);
            $payments = $this->model->getPayments();

            $data = [
                'titulo' => 'Carrito | Forma de Pago',
                'subtitle' => 'Checkout | Forma de Pago',
                'menu' => true,
                'payments' => $payments,
            ];

            $this->view('carts/paymentmode', $data);
        }
    }

    public function verify()
    {
        // Comprobar si el payment está vacío
        $errors = [];

        $session = new Session();

        $user = $session->getUser();
        $cart = $this->model->getCart($user->id);
        $payments = $this->model->getPayments();

        $payment = $_POST['payment'] ?? '';

        if(empty($payment)) {
            array_push($errors, 'Seleccione un método de pago');
        }

        if($errors) {
            $data = [
                'titulo' => 'Carrito | Forma de pago',
                'menu' => true,
                'errors' => $errors,
                'payments' => $payments,
            ];

            $this->view('carts/paymentmode', $data);
        } else {
            $data = [
                'titulo' => 'Carrito | Verificar los datos',
                'menu' => true,
                'errors' => $errors,
                'payment' => $payment,
                'user' => $user,
                'data' => $cart,
            ];

            $this->view('carts/verify', $data);
        }
    }

    public function thanks()
    {
        // Comprobar si la sesión existe
        // Comprobar si estamos logueados

        $session = new Session();
        $user = $session->getUser();

        if($this->model->closeCart($user->id, 1)) {
            $data = [
                'titulo' => 'Carrito | Gracias por su compra',
                'data' => $user,
                'menu' => true,
            ];

            $this->view('carts/thanks', $data);
        } else {
            $data = [
                'titulo' => 'Carrito | Gracias por su compra',
                'menu' => true,
                'subtitle' => 'Error en la actualización de los productos del carrito',
                'text' => 'Existió un problema al actualizar el estado del carrito. 
                            Por favor pruebe más tarde o comuniquese con nuestro servcio de soporte',
                'color' => 'alert-danger',
                'url' => 'login',
                'coloButton' => 'btn-danger',
                'textButton' => 'Regresar',
            ];

            $this->view('mensaje', $data);
        }
    }
}