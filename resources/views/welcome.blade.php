@extends('layouts.app')

@section('content')
    <div class="text-center">
        <form action="/redirect" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 rounded-lg shadow py-2 px-2 text-white m-2">Login</button>
        </form>
        </a>
    </div>

@endsection