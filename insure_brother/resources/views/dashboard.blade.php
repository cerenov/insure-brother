@extends('layouts.app')

@section('content')
    @include('layouts.navigation')

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <a class="btn btn-primary" href="{{route('create_insurance')}}" role="button">Добавить услугу</a>
    </div>
    <div class="container">
        <div class="list-group">
            @foreach($insurances as $insurance)
                <div class="d-flex">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{$insurance->title}}</h5>
                    </div>
                    <a href="/insurance/{{$insurance->id}}/read" class="btn btn-success mt-3 mb-3 mr-20"
                       aria-current="true">детально</a>
                    <form action="/insurance/{{$insurance->id}}/delete" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger mt-3 mb-3" style="width: 100px;">удалить</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
