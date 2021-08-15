<?php

namespace App\Console\Commands;

use App\Models\Insurance;
use App\Repositories\Interfaces\InsuranceRepositoryInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ClientBuilder $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = ClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOST','elasticsearch').':'.env('ELASTICSEARCH_PORT','9200')])
            ->build();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Indexing all Insurances');

        Insurance::chunk(200, function ($insurances) {
            foreach ($insurances as $insurance) {
                $this->elasticsearch->index([
                    'index' => 'insurances',
                    'id' => $insurance->id,
                    'body' => [
                        'title' => $insurance->title,
                        'text' => $insurance->text,
                    ]
                ]);
                $this->output->write('.');
            }
        });
        $this->info('\nDone!');

        return 0;
    }
}
