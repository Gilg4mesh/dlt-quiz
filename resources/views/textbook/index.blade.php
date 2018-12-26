@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1>學習資源</h1>
        

    @if(config('app.textbook_resource') == 'DB')

        @foreach ($textbook_types as $textbook_type)
        <p>{{ $textbook_type }}</p>
            @foreach ($textbooks as $textbook)
                @if ($textbook['type'] == $textbook_type)
                <ul>
                    <li><a href="{{ config('app.url').'/textbooklink/'.$textbook['hashlink']->hashlink }}" target='_blank'>{{ $textbook['title'] }}</a></li>
                </ul>
                @endif
            @endforeach
            
        @endforeach
    @else
        <iframe src="{{ config('app.textbook_resource') }}" style="height:60vh;width:100%;"></iframe>
    @endif
    </div>
</div>



@endsection
