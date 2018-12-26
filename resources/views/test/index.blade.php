@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1>測驗</h1>
            <p>準備好了嗎~開始答題吧！</p>
            {!! Form::open(['url' => '/test']) !!}
            <div class="row form-horizontal">
                {!! Form::label('tag_list','請選擇範圍：',['class'=>'col-lg-2 control-label ']) !!}
                <div class="col-lg-2" >
                    @if (!$tags)
                    <label class='control-label'>沒有選項</label>
                    @else
                    {!! Form::select('tag_list', $tags, 0, ['id'=>'totalnumber','class' => 'form-control']) !!}
                    @endif
                </div>

                {!! Form::label('totalnumber','請選擇題量：',['class'=>'col-lg-2 control-label ']) !!}
                <div class="col-lg-2" >
                    {!! Form::select('totalnumber', [5=>5,10=>10,15=>15,20=>20], 0, ['id'=>'totalnumber','class' => 'form-control']) !!}
                </div>

                {!! Form::label('testtype','開始測驗：',['class'=>'col-lg-2 control-label ']) !!}
                <div class="col-lg-2" >
                        {!! Form::submit('START', ['class' => 'btn btn-primary form-control']) !!}
                </div>
            </div>
            <br/>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

