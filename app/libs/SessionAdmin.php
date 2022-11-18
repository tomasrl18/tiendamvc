<?php

/*
 * Para diferenciar entre usuario normal y usuario administrador
 */

class SessionAdmin
{
    private $login = false;
    private $user;

    public function __construct()
    {
        session_start();

        if (isset($_SESSION['admin'])) {
            $this->user = $_SESSION['admin'];
            $this->login = true;
        } else {
            unset($this->user);
            $this->login = false;
        }
    }

    public function login($user)
    {
        if ($user) {
            $this->user = $user;
            $_SESSION['admin'] = $user;
            $this->login = true;
        }
    }

    public function logout()
    {
        unset($_SESSION['admin']);
        unset($this->user);

        // Comentada porque si tienes iniciadas la sesión de admin y de user, y
        // cierras sesión en unas de las dos, se cierran las dos
        // session_destroy();

        $this->login = false;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getUserId()
    {
        return $this->user->id;
    }
}