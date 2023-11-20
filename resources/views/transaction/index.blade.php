@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="mb-3">
            <a href="/transaction-history" class="btn btn-info">History Transactions</a>
        </div>

        <div class="col-md-7">
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
                                <th>NO</th>
                                <th class="col-3">Category</th>
                                <th class="col-3">Item</th>                            
                                <th>Stock</th>                            
                                <th class="col-2">Price</th>                            
                                <th>Action</th>                            
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($items as $item)
                            
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ number_format($item->stock) }}</td>
                                <td>{{ number_format($item->price) }}</td>

                                <form action="/transaction" method="POST">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <td>
                                        <button type="submit" class="btn btn-success btn-sm">Add Cart</button>
                                    </td>
                                </form>

                            </tr>
                            
                        @endforeach
                        
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Cart') }}</div>

                <div class="card-body">
                    @if (session('failed'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('failed') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                   
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="col-4">Item</th>
                                <th class="col-3">Quantity</th>
                                <th class="col-3">Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                                
                            <tr>
                                <td>{{ $cart->name }}</td>
                                <form action="/transaction/{{ $cart->cart->id }}" method="POST">
                                <td>
                                    <input class="form-control" id="qty-{{ $loop->iteration }}" type="number" name="quantity" value="{{ $cart->cart->quantity }}" onchange="update_subtotal({{ $loop->iteration }})" min="1" max="{{ $cart->stock + $cart->cart->quantity }}">
                                    <input type="hidden" name="price" value="{{ $cart->price }}" class="price-{{ $loop->iteration }}">
                                    <input type="hidden" name="stock" value="{{ $cart->stock }}">
                                </td>
                                <td><p class="subtotalItem-{{ $loop->iteration }}">{{ $cart->price * $cart->cart->quantity }}</p></td>
                                <td>
                                    <div class="d-flex">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm d-none btn-update-{{ $loop->iteration }}">Update</button>
                                </form>
                                        <form action="/transaction/{{ $cart->cart->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-delete-{{ $loop->iteration }}">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>

                    <table class="table">
                        <thead>
                            <th class="col-4"></th>
                            <th></th>
                            <th class="col-6"></th>
                        </thead>
                        <tbody>
                            <form action="/transaction_detail" method="POST">
                                @csrf
                                <tr class="table-warning">
                                    <td> <b> Grand Total </b> </td>
                                    <td> <b> : </b> </td>
                                    <td>
                                        <input type="number" name="total" class="form-control" id="total" readonly value="{{ $carts->sum(function($item_in_cart){return $item_in_cart->cart->quantity * $item_in_cart->price;}) }}">
                                    </td>
                                </tr>
                                <tr class="table">
                                    <td> <b> Pay Total  </b> </td>
                                    <td> <b> : </b> </td>
                                    <td>
                                        <input type="number" name="pay_total" class="form-control @error('pay_total') is-invalid @enderror" id="pay" onchange="hitung_kembalian()">
                                        @error('pay_total')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>

                                <tr class="table">
                                    <td> <b> Return  </b> </td>
                                    <td> <b> : </b> </td>
                                    <td>
                                        <input type="text" name="" class="form-control" readonly id="return">
                                    </td>
                                </tr>

                                <tr class="table">
                                    <td>
                                        <a href="" class="btn btn-danger btn-sm">Reset</a>
                                        <button type="submit" class="btn btn-primary btn-sm">Checkout</button>
                                    </td>
                                </tr>
                            </form>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection

<script>

    function update_subtotal(item_id){
        var qty = document.querySelector('#qty-' + item_id).value
        var price = document.querySelector('.price-' + item_id).value

        document.querySelector('.btn-delete-' + item_id).classList.add('d-none')
        document.querySelector('.btn-update-' + item_id).classList.remove('d-none')
    
        var subtotal = price * qty;
        document.querySelector('.subtotalItem-' + item_id).innerHTML = subtotal;
    }

    function hitung_kembalian() {
        var pay = document.querySelector('#pay').value
        var total = document.querySelector('#total').value

        var return_total = pay - total;
        if(return_total < 0) {
            document.querySelector('#return').value = "Uang Anda Tidak Cukup";
        } else {
            document.querySelector('#return').value = return_total;
        }
    }

</script>