@extends('layouts.app')

@section('css')
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">

    @stack('css_quiz')

@endsection

@section('content')
    <?php $parentName = config('quiz.models.parent_name_singular');?>
    @yield('content_pandoapps')
@endsection

@section('scripts')
    @stack('scripts_quiz')
@endsection
