@extends('layouts.app')

@section('content')

    {{-- @include('answers._index', [
    'answers'=>$question->answers,
    'answersCount'=> $question->answers_count,
    ]) --}}
    {{-- @include('answers._create' ) --}}
    <question-page :question="{{ $question }}"></question-page>
@endsection
