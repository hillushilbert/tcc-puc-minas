@component('mail::message')
# Introduction

Olá {{$order->customer->name}},

Seu pedido foi processado e já está sendo despachado para entrega. Clique no botão abaixo para acompanhar a entrega.

Seu código de rastreamento é : {{ $codigo_rastreamento }}

@component('mail::button', ['url' => ''])
Acompanhar
@endcomponent

Equipe,<br>
{{ config('app.name') }}
@endcomponent
