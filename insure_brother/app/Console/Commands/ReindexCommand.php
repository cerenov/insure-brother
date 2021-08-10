<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\InsuranceRepositoryInterface;
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


    private $insurance_repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InsuranceRepositoryInterface $insurance_repository)
    {
        parent::__construct();

        $this->insurance_repository = $insurance_repository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
