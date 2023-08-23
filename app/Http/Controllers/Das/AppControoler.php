<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppControoler extends Controller
{

    public function __invoke(){

        return view('admin.Layouts.app');
}
//
//    public function  index (){
//        return view('das');
//    }


}
