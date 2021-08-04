<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
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

        return view('users.index_responses', [
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

        $insurance = Insurance::find($data['id']);

        $user = $insurance->user()->get();
        if ($user->isNotEmpty()) {
            SendMessage::dispatch($user[0]->email, $response);
        }

        return Redirect()->route('home')->with('success', 'Отклик отправлен');
    }

    public function read(Request $request)
    {
        $response = Response::find($request->id);

        return view('users.read_response', [
            'response' => $response
        ]);
    }
}
