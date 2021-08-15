<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInsurenceRequest;
use App\Http\Requests\UpdateInsurenceRequest;
use App\Models\Insurance;
use App\Repositories\Interfaces\ElasticsearchInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\InsuranceRepositoryInterface;
use Illuminate\Support\Collection;


class InsuranceController extends Controller
{
    private $insurance_repository;
    private $elasticsearch;

    public function __construct(InsuranceRepositoryInterface $insurance_repository, ElasticsearchInterface $elasticsearch)
    {
        $this->insurance_repository = $insurance_repository;
        $this->elasticsearch = $elasticsearch;
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
        $this->insurance_repository->create($data['title'], $data['text'], $data['price'], $user);

        return Redirect()->route('dashboard')->with('success', 'Услуга добавлена');
    }

    public function delete(Request $request)
    {
        $insurance = $this->insurance_repository->getByID($request->id);

        if (!$insurance) {
            return abort(404);
        }

        $this->insurance_repository->delete($request->id);

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

        return Redirect()->route('dashboard')->with('success', 'Услуга отредактирована');
    }

    public function indexForClient(Request $request)
    {
        $search = '';
        if ($request->has('q')) {
            $search = $request->q;
        }

        $results = $this->elasticsearch->search($search);

        $insurances = $this->paginate($results);

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

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
