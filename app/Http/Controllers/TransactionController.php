<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Cart;
use App\Models\Item;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaction.index', [
            // 'items' => Item::latest()->get(),
            'items' => Item::doesntHave('cart')->where('stock', '>', 0)->get(),
            'carts' => Item::has('cart')->get()->sortByDesc('cart.created_at')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Cart::create($request->all());
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('transaction.detail', [
            'transaction' => Transaction::find($id),
            'detail' => TransactionDetail::where('transaction_id', $id)->get(),
            'item' => function ($item_id) {
                return Item::find($item_id);
            }
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionRequest  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->quantity > $request->stock) {
            return back()->with('failed', 'Quantity tidak boleh melebihi stock');
        } elseif ($request->quantity <= 0) {
            return back()->with('failed', 'Quantity tidak boleh sama kurang dari 0');
        }

        Cart::find($id)->update($request->all());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::destroy($id);
        return back();
    }

    public function history_transaction()
    {
        return view('transaction.history', [
            'transactions' => Transaction::latest()->get()
        ]);
    }

    public function checkout(Request $request)
    {
        $validateData = $request->validate([
            'total' => 'required',
            'pay_total' => 'required'
        ]);

        $validateData['user_id'] = auth()->user()->id;
        $validateData['date'] = now();

        $transaction = Transaction::create($validateData);

        foreach (Cart::all() as $cart) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'item_id' => $cart->item_id,
                'quantity' => $cart->quantity
            ]);
        }
        Cart::truncate();

        return redirect('/transaction/' . $transaction->id);
    }
}
