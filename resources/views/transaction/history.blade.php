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

                    <table class="table">
                        <thead>
                            <tr>
                                <td class="col-6">Total Pemasukan Metode QRIS:</td>
                                <td>Rp.{{ number_format($qris) }}</td>
                            </tr>
                            <tr>
                                <td class="col-6">Total Pemasukan Metode CASH:</td>
                                <td>Rp.{{ number_format($cash) }}</td>
                            </tr>
                            <tr>
                                <th>NO</th>
                                <th class="col-3">Date</th>
                                <th class="col-3">Served By</th>                            
                                <th class="col-2">Total</th>                            
                                <th class="col-2">Pay Total</th>                            
                                <th class="col-2">Metode</th>                            
                                <th>Action</th>                            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                            
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ number_format($transaction->total) }}</td>
                                <td>{{ number_format($transaction->pay_total) }}</td>
                                <td>{{ $transaction->metode }}</td>
                                <td>
                                    <form action="/deleteTransaction/{{ $transaction->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="/transaction/{{ $transaction->id }}" class="btn btn-info btn-sm">Detail</a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Syur kh?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="">
                        <a href="/transaction" class="btn btn-danger btn-sm">Back</a>
                    </div>
                    
                </div>
            </div>
        </div>
@endsection