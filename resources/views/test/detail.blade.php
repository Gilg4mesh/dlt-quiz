@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <a href={{"/test/$test_id/alldetails"}} class="text-warning">點擊查看全部題目</a>
                <h2 class="text-danger">錯題/未做題</h2>
                @for($i = 0 ; $i < $total ; $i++)
                    @if($judges[$i] != 1)
                       @include('test.detail_form')
                    @endif
                @endfor
            </div>
        </div>
    </div>

@endsection

