<?php


namespace App\Repositories;


use App\Models\Insurance;
use App\Models\User;
use App\Repositories\Interfaces\InsuranceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;


class InsuranceRepository implements InsuranceRepositoryInterface
{

    public function getAll()
    {
        return Insurance::all();
    }

    public function getAllByUser(User $user)
    {
        return Insurance::where('user_id', user()->id)->get();
    }

    public function getByID($id)

    {
        return Insurance::find($id);
    }

    public function create($title, $text, $price, User $user):Insurance
    {
        $insurance = new Insurance();
        $insurance->title = $title;
        $insurance->text = $text;
        $insurance->price = $price;
        $insurance->user()->associate($user);
        $insurance->save();

        return $insurance;
    }

    public function update($title, $text, $price, Insurance $insurance): Insurance
    {
        $insurance->title = $title;
        $insurance->text = $text;
        $insurance->price = $price;
        $insurance->save();

        return $insurance;
    }

    public function delete($id)
    {
        return Insurance::destroy($id);
    }
}
