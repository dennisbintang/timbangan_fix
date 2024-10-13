@extends('layouts.app')

@section('content')
    @include('administrasi.form', ['administrasi' => $administrasi])
@endsection
