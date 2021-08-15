<?php

namespace App\Repositories;

use App\Models\Insurance;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

class ElasticsearchRepository implements Interfaces\ElasticsearchInterface
{
    /** @var \Elasticsearch\Client */
    private $client;
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOST','elasticsearch').':'.env('ELASTICSEARCH_PORT','9200')])
            ->build();
    }
    public function search(string $query = ''): Collection
    {
        $items = $this->searchOnElasticsearch($query);
        return $this->buildCollection($items);
    }
    private function searchOnElasticsearch(string $search = ''): array
    {
        if ($search == '') {
            $body = [
                'query' => [
                    'match_all' => new \stdClass()

                ],
                'fields' => ['title', 'text']
            ];
        } else {
            $body = [
                'query' => [
                    'multi_match' => [
                        'query' => $search,
                        'fields' => ['title', 'text']
                    ]
                ]
            ];
        }

        $params = [
            'scroll' => '30s',
            'size'   => 10,
            'index' => 'insurances',
            'body' => $body
        ];

        $insurances = $this->client->search($params);

        return $insurances;
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Insurance::findMany($ids)
            ->sortBy(function ($insurance) use ($ids) {
                return array_search($insurance->getKey(), $ids);
            });
    }
}
