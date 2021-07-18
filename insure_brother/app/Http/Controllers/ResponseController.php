<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insurance;

class ResponseController extends Controller
{
    public function index()
    {
        $insurances = Insurance::all();

        return view('home', [
            'insurances' => $insurances
        ]);

    }
}
