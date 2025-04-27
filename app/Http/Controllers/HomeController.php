<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //Ruta para la pagina principal, pero desde el controlador
    /*public function __invoke(){
        return "Bienvenido a la pagina principal.";
    }*/


    public function index(){
        return "Bienvenido a la.";
    }


    public function view(){
        return 'Aquí podrás observar las graficas';
    }
}
