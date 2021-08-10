<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInsurenceRequest;
use App\Http\Requests\InsurenceRequest;
use App\Http\Requests\ReadInsurenceRequest;
use App\Http\Requests\UpdateInsurenceRequest;
use App\Jobs\SendMessage;
use App\Models\Insurance;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Elasticsearch\Helper\Iterators\SearchResponseIterator;
use http\Client\Curl\User;
use http\Env\Url;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\Interfaces\InsuranceRepositoryInterface;

class InsuranceController extends Controller
{
    private $insurance_repository;
    private $client;

    public function __construct(InsuranceRepositoryInterface $insurance_repository)
    {
        $this->insurance_repository = $insurance_repository;
        $this->client = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->build();
    }

    public function index()
    {
        $user = Auth::user();
        $insurances = $this->insurance_repository->getAll($user);

        return view('dashboard', [
            'insurances' => $insurances
        ]);

    }

    public function read(Request $request)
    {
        $insurance = $this->insurance_repository->getByID($request->id);

        return view('users.read_insurance', [
            'insurance' => $insurance
        ]);
    }

    public function create(CreateInsurenceRequest $request)
    {
        $data = $request->only(['title', 'text', 'price']);
        $user = Auth::user();
        $insurance = $this->insurance_repository->create($data['title'], $data['text'], $data['price'], $user);

        $params = [
            'index' => 'insurances',
            'id' => $insurance->id,
            'body' => [
                'title' => $insurance->title,
                'text' => $insurance->text,
            ]
        ];
        try {
            $this->client->index($params);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }


        return Redirect()->route('dashboard')->with('success', 'Услуга добавлена');
    }

    public function delete(Request $request)
    {
        $insurance = $this->InsuranceRepository->getByID($request->id);

        if (!$insurance) {
            return abort(404);
        }

        $this->InsuranceRepository->delete($request->id);

        $params = [
            'index' => 'insurances',
            'id' => $request->id
        ];

        try {
            $this->client->delete($params);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return Redirect()->route('dashboard')->with('success', 'Услуга удалена');
    }

    public function update(UpdateInsurenceRequest $request)
    {
        $data = $request->only(['title', 'text', 'price', 'id']);

        $insurance = Insurance::find($data['id']);

        if (!$insurance) {
            return abort(404);
        }

        $insurance = $this->insurance_repository->update($data['title'], $data['text'], $data['price'], $insurance);

        $params = [
            'index' => 'insurances',
            'id' => $insurance->id,
            'body' => [
                'doc' => [
                    'title' => $insurance->title,
                    'text' => $insurance->text
                ]
            ]
        ];

        try {
            $this->client->update($params);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return Redirect()->route('dashboard')->with('success', 'Услуга отредактирована');
    }

    public function indexForClient(Request $request)
    {
        $search = '';
        if ($request->has('q')) {
            $search = $request->q;
        }

        if ($search == '') {
            $params = [
                'index' => 'insurances',
                'body' => [
                    'query' => [
                        'match_all' => new \stdClass()

                    ],
                    'fields' => ['title', 'text']
                ]
            ];
        } else {
            $params = [
                'index' => 'insurances',
                'body' => [
                    'query' => [
                        'multi_match' => [
                            'query' => $search,
                            'fields' => ['title', 'text']
                        ]
                    ]
                ]
            ];
        }

        try {
            $insurances = $this->client->search($params);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return view('home', [
            'insurances' => $insurances,
            'search' => $search
        ]);
    }

    public function readForClient(Request $request)
    {
        $insurance = $this->insurance_repository->getByID($request->id);

        return view('clients.read_insurance_for_client', [
            'insurance' => $insurance
        ]);
    }
}
