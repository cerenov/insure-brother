@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <div class="container">
            <form action="/response/create" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$insurance->id}}">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="name">name</span>
                    <input type="text" class="form-control" placeholder="name" name="name" aria-label="name"
                           aria-describedby="name">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="phone">phone</span>
                    <input type="text" class="form-control" placeholder="phone" name="phone" aria-label="phone"
                           aria-describedby="phone">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="mail">mail</span>
                    <input type="text" class="form-control" placeholder="mail" name="mail" aria-label="mail"
                           aria-describedby="mail">
                </div>

                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <button type="submit" class="btn btn-success">Отправить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
