@extends('layouts.app')

@section('content')
<h2 class="text-lg font-bold m-2">Choose your playlists:</h2>
<div class="flex flex-wrap -mx-1">
    @foreach ($playlists as $item)
        <a href="/playlists/{{ $item['id'] }}">
            <div class="max-w-sm rounded overflow-hidden shadow-lg my-3 mx-3">
                <img class="w-full" src="{{ $item['thumbnail'] }}">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ $item['title'] }}</div>
                </div>
            </div>
        </a>
    @endforeach
</div>


@endsection