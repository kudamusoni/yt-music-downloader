@extends('layouts.app')

@section('content')
<table class="table-auto">
    <thead>
        <tr>
            <th class="px-4 py-2">Titleg</th>
            <th class="px-4 py-2">Link</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($file as $item)    
            <tr>
                <td class="border px-4 py-2">{{ $item['title'] }}</td>
                <td class="border px-4 py-2">
                    <iframe src="//recordmp3.co/#/watch?v={{ $item['id'] }}&layout=button" style="width: 300px; height: 40px; border: 0px;">
                    </iframe>
                    <noscript>
                        <a href="https://recordmp3.co/#/watch?v={{ $item['id'] }}">Download</a>
                    </noscript>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection