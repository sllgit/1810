<?php
namespace App\Http\Controllers;

class IndexController extends Controller{

    public function index(){
        return 111;
    }
    public function dos(){
        return 222;
    }
    public function text($id)
    {
        echo $id;
    }
}