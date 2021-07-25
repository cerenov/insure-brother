@extends('layouts.app')

@section('content')
    @include('layouts.navigation')
    <form action="/insurance/{{$insurance->id}}/update" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{$insurance->id}}">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <input class="ring-purple-200" type="text" value="{{$insurance->title}}" name="title">
        </div>
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <input class="ring-purple-200" type="text" value="{{$insurance->text}}" name="text">
        </div>
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <input type="number" placeholder="0.00" required name="price" min="0" max="99999999999999" value="{{$insurance->price}}"
                   step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
            this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'"
                   id="price" name="price">
        </div>
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <button type="submit" class="btn btn-success">Записать</button>
        </div>
    </form>
@endsection
