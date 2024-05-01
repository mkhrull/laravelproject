<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    function show(){
        $data=User::all();
        return view('admindashboard', ['data'=>$data]);
    }

    // DisplayController.php
public function showMomento360()
{
    return view('momento360');
}
}
