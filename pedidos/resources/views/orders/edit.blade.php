@extends('layouts.app')

@section('content')
<order-edit-component :order="{{ $order }}" />
@endsection