<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class InsuranceController extends Controller
{
    public function index()
    {
        $insurances = Insurance::where('user_id', Auth::user()->id)->get();

        return view('dashboard', [
            'insurances' => $insurances
        ]);

    }

    public function read(Request $request)
    {
        $insurance = Insurance::find($request->id);

        return view('read_insurance', [
            'insurance' => $insurance
        ]);
    }

    public function create(Request $request)
    {
        $data = $request->only(['title', 'text', 'price']);

        $insurance = new Insurance();
        $insurance->title = $data['title'];
        $insurance->text = $data['text'];
        $insurance->price = $data['price'];
        $insurance->user_id = Auth::user()->id;

        $insurance->save();

        return Redirect()->route('dashboard')->with('success', 'Услуга добавлена');
    }

    public function delete(Request $request)
    {
        $Insurance = Insurance::find($request->id);

        if (!$Insurance) {
            return abort(404);
        }

        $Insurance->delete();

        return Redirect()->route('dashboard')->with('success', 'Услуга удалена');
    }

    public function update(Request $request)
    {
        $data = $request->only(['title', 'text', 'price', 'id']);

        $insurance = Insurance::find($data['id']);

        if (!$insurance) {
            return abort(404);
        }

        $insurance->title = $data['title'];
        $insurance->text = $data['text'];
        $insurance->price = $data['price'];
        $insurance->save();

        return Redirect()->route('dashboard')->with('success', 'Услуга отредактирована');
    }

    public function indexForClient()
    {
        $insurances = Insurance::all();

        return view('home', [
            'insurances' => $insurances
        ]);

    }

    public function readForClient(Request $request)
    {
        $insurance = Insurance::find($request->id);

        return view('read_insurance_for_client', [
            'insurance' => $insurance
        ]);
    }
}
