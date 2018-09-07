@extends('layouts.app')

@section('content')

    <h1>タスク新規作成ページ</h1>
    
    {!! Form::model($task, ['route' => 'tasks.store']) !!}
    
        {!! Form::label('status', '状態:') !!}
        {!! Form::text('status') !!}
    
        {!! Form::label('content', '内容:') !!}
        {!! Form::text('content') !!}

        {!! Form::submit('投稿') !!}
    
    {!! Form::close() !!}

@endsection
