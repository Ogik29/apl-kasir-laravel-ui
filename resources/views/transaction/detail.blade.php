@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Transactions') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="ml-2">
                        Date: {{ $transaction->date }} <br>
                        Served By; {{ $transaction->user->name }}
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Item</th>                  
                                <th>Quantity</th>                            
                                <th>subtotal</th>                          
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail as $d)
                            
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item($d->item_id)->name }}</td>
                                <td>{{ number_format($d->quantity) }}</td>
                                <td>{{ number_format($d->quantity * $item($d->item_id)->price) }}</td>
                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Grand Total</td>
                                <td>{{ number_format($transaction->total) }}</td>
                            </tr>
                            <tr>
                                <td>Payment</td>
                                <td>{{ number_format($transaction->pay_total) }}</td>
                            </tr>
                            <tr>
                                <td>Return</td>
                                <td>{{ number_format($transaction->pay_total - $transaction->total)}}</td>
                            </tr>
                            <tr>
                                <td>Metode</td>
                                <td>{{ $transaction->metode }}</td>
                            </tr>
                            <tr>
                                <td><a href="/transaction-history" class="btn btn-danger btn-sm">Back</a></td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
@endsection