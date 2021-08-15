<?php


namespace App\Repositories\Interfaces;


use App\Models\Insurance;
use App\Models\User;

interface InsuranceRepositoryInterface
{
    public function getAll();
    public function getAllByUser(User $user);
    public function getByID($id);
    public function create($title, $text, $price, User $user):Insurance;
    public function delete($id);
    public function update($title, $text, $price, Insurance $insurance):Insurance;
}
