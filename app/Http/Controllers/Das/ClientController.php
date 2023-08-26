<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return Client::latest()->get();
    }
}
