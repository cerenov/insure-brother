<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ElasticsearchInterface
{
    public function search(string $query = ''): Collection;
}
