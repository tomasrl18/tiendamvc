<?php

class ErrorController extends Controller
{
    public function index() {

        $urlError = trim($_SERVER['REQUEST_URI'], '/');
        $urlError = filter_var($urlError, FILTER_SANITIZE_URL);
        $urlError = explode('/', $urlError);

        $data = [
            'back' => $urlError[0],
        ];

        $this->view('error/index' , $data);
    }
}