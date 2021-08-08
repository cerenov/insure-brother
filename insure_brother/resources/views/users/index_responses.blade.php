@extends('layouts.app')

@section('content')
    @include('layouts.navigation')
    Список:
    <ul class="list-group">
        @foreach($insurances as $insurances)
            @foreach($insurances->responses as $response)
                <li class="list-group-item">
                    <div class="container">
                        <div class="input-group mb-3">
                            <h2>ID: {{$response->id}}</h2>
                        </div>
                        <div class="input-group mb-3">
                            <h2>Имя: {{$response->name}}</h2>
                        </div>
                        <div class="input-group mb-3">
                            <h2>Телефон: {{$response->phone}}</h2>
                        </div>
                        <div class="input-group mb-3">
                            <h2>mail: {{$response->mail}}</h2>
                        </div>
                    </div>
                </li>
            @endforeach
        @endforeach
    </ul>
@endsection
