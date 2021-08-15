<?php

namespace App\Observers;

use App\Models\Insurance;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class InsuranceObserver
{
    //public $afterCommit = true;
    private $elasticsearch;

    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->build();
    }

    /**
     * Handle the Insurance "created" event.
     *
     * @param  \App\Models\Insurance  $insurance
     * @return void
     */
    public function created(Insurance $insurance)
    {
        $this->elasticsearch->index([
            'index' => 'insurances',
            'id' => $insurance->id,
            'body' => [
                'title' => $insurance->title,
                'text' => $insurance->text,
            ]
        ]);
    }

    /**
     * Handle the Insurance "updated" event.
     *
     * @param  \App\Models\Insurance  $insurance
     * @return void
     */
    public function updated(Insurance $insurance)
    {
        $this->elasticsearch->update([
            'index' => 'insurances',
            'id' => $insurance->id,
            'body' => [
                'doc' => [
                    'title' => $insurance->title,
                    'text' => $insurance->text
                ]
            ]
        ]);
    }

    /**
     * Handle the Insurance "deleted" event.
     *
     * @param  \App\Models\Insurance  $insurance
     * @return void
     */
    public function deleted(Insurance $insurance)
    {
        $this->elasticsearch->delete([
            'index' => 'insurances',
            'id' => $insurance->id
        ]);
    }

    /**
     * Handle the Insurance "restored" event.
     *
     * @param  \App\Models\Insurance  $insurance
     * @return void
     */
    public function restored(Insurance $insurance)
    {
        //
    }

    /**
     * Handle the Insurance "force deleted" event.
     *
     * @param  \App\Models\Insurance  $insurance
     * @return void
     */
    public function forceDeleted(Insurance $insurance)
    {
        //
    }
}
