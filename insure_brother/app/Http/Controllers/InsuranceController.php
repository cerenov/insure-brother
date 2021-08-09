<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInsurenceRequest;
use App\Http\Requests\InsurenceRequest;
use App\Http\Requests\ReadInsurenceRequest;
use App\Http\Requests\UpdateInsurenceRequest;
use App\Jobs\SendMessage;
use App\Models\Insurance;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\Interfaces\InsuranceRepositoryInterface;

class InsuranceController extends Controller
{
    private $InsuranceRepository;

    public function __construct(InsuranceRepositoryInterface $InsuranceRepository)
    {
        $this->InsuranceRepository = $InsuranceRepository;
    }

    public function index()
    {
        $user = Auth::user();
        $insurances = $this->InsuranceRepository->getAll($user);

        return view('dashboard', [
            'insurances' => $insurances
        ]);

    }

    public function read(Request $request)
    {
        $insurance = $this->InsuranceRepository->getByID($request->id);

        return view('users.read_insurance', [
            'insurance' => $insurance
        ]);
    }

    public function create(CreateInsurenceRequest $request)
    {
        $data = $request->only(['title', 'text', 'price']);
        $user = Auth::user();
        $this->InsuranceRepository->create($data['title'], $data['text'], $data['price'], $user);

        return Redirect()->route('dashboard')->with('success', 'Услуга добавлена');
    }

    public function delete(Request $request)
    {
        $insurance = $this->InsuranceRepository->getByID($request->id);

        if (!$insurance) {
            return abort(404);
        }

        $this->InsuranceRepository->delete($request->id);

        return Redirect()->route('dashboard')->with('success', 'Услуга удалена');
    }

    public function update(UpdateInsurenceRequest $request)
    {
        $data = $request->only(['title', 'text', 'price', 'id']);

        $insurance = Insurance::find($data['id']);

        if (!$insurance) {
            return abort(404);
        }

        $this->InsuranceRepository->update($data['title'], $data['text'], $data['price'], $insurance);

        return Redirect()->route('dashboard')->with('success', 'Услуга отредактирована');
    }

    public function indexForClient()
    {
        $insurances = $this->InsuranceRepository->getAll();

        return view('home', [
            'insurances' => $insurances
        ]);
    }

    public function readForClient(Request $request)
    {
        $insurance = $this->InsuranceRepository->getByID($request->id);

        return view('clients.read_insurance_for_client', [
            'insurance' => $insurance
        ]);
    }
}
