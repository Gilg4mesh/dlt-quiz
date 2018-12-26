@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h3>測試結果</h3>
            @if($point==100)
                <h4>Excellent!您得了100分!</h4>
            @elseif($point>=85)
                <h4>Great!您得了{{$point}}分！</h4>
            @elseif($point>=60)
                <h4>Good!您得了{{$point}}分！</h4>
            @else
                <h4>繼續努力!您得了{{$point}}分！</h4>
            @endif
            <h4>一共{{$total}}道題，您答對了{{array_sum($answer)}}道</h4>

            @if($point==100)
                <a class="text-warning" href={{"/test/$test_id/alldetails"}}>點擊查看答題詳情</a>
            @else
                <a class="text-danger" href={{"/test/$test_id/details"}}>點擊查看錯題詳情</a>
            @endif
        </div>
    </div>
@endsection

