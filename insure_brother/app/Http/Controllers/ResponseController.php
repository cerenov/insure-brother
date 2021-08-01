<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use App\Models\Response;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Insurance;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{
    public function index()
    {
        $insurances = Insurance::with('responses')->where('user_id', Auth::user()->id)->get();

        return view('read_response', [
            'insurances' => $insurances
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->only(['name', 'phone', 'mail', 'id']);

        $response = new Response();
        $response->name = $data['name'];
        $response->phone = $data['phone'];
        $response->mail = $data['mail'];
        $response->insurance_id = $data['id'];
        $response->number_months = 0;
        $response->cost = 0;

        $response->save();

//        $users = User::all();
//        TestJob::dispatch('$users->toArray()');

        return Redirect()->route('home')->with('success', 'Отклик отправлен');
    }
}
