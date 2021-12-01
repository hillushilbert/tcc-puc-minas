@extends('layouts.app')

@section('content')
<order-list-component :orders="{{ $orders }}" />
@endsection