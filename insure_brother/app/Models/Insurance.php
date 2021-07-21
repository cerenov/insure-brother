<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    /**
     * @var mixed
     */
    /**
     * @var mixed
     */
}
