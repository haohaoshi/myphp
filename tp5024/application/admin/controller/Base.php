<?php
/**
 * Created by PhpStorm.
 * User: Lujz
 * Date: 2019\6\20 0020
 * Time: 16:56
 */

namespace app\admin\controller;


use think\Controller;

class Base extends Controller
{
    public function __construct()
    {

    }

    public function ajax(){
        echo 'ajax';
    }
}