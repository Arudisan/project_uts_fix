<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Models\Product;
use App\Models\Transaction;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::paginate(100);
        return view('admin.pages.checkout.product', compact('data'), [
            'title' => 'List Product',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $productID = $request->input('product_id');
        $qty = (int) $request->input('qty', 1);
        $checkout = [
            'products' => [],
            'user' => [
                "name" => "",
                "address" => ""
            ],
        ];
        $data = Cache::get('checkout', $checkout);
        $temp = null;
        if (isset($data['products'][$productID])) {
            $temp =  [
                "id" => $productID,
                "qty" => $qty + $data['products'][$productID]['qty']
            ];
        } else {
            $temp =  [
                "id" => $productID,
                "qty" => $qty
            ];
        }
        $data['products'][$productID] = $temp;

        Cache::put('checkout', $data);
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $proudctIds = $request->input('product_id');
        $prices = $request->input('price');
        $qty = $request->input('qty');
        //untuk memanggil product berdasarkan ID product
        $product = Product::whereIn('id', $proudctIds)->get();
        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'id' => Uuid::uuid4()->toString(),
                'customer' => $data['customer'],
                'address'  => $data['address'],
                'email' => $data['email'],
                'total_amount' => $data['total']
            ]);
            $transactionDetails = [];
            foreach ($proudctIds as $key => $value) {
                $product = $product->firstWhere('id', $value);
                $transactionDetails[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['id'],
                    'quantity' => $qty[$key],
                    'amount' => $prices[$key],
                    'created_at' => Carbon::now()
                ];
            }
            if ($transactionDetails) {
                TransactionDetail::insert($transactionDetails);
            }
            $paymentUrl = $this->createInvoice($transaction);
            Cache::forget('checkout');
            DB::commit();
            return redirect()->route('checkout.index')->with([
                Alert::html(
                    'apakah yakin anda ingin melanjutkan pembayaran ?',
                    "<a target='_blank' href='$paymentUrl'>Silahkan klik link ini untuk melanjutkan pembayaran</a>",
                    'info'
                )
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }
    public function createInvoice($transaction)
    {
        // set konnfigrasi midtrans ngambil dari config/midrtrans.php
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // buat params untuk dikirim ke midtrans
        $midtrans_params = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => (int) $transaction->total_amount //ditetapkan harus int yang dikirim
            ],
            'customer_details' => [
                'first_name' => $transaction->customer,
                'email' => $transaction->email,
            ],
        ];
        $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;
        return $paymentUrl;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function chart()
    {
        $data = Cache::get('checkout');
        $prices = [];
        $qty = [];
        $id = [];
        dd($data);
        if (!$data) {
            return redirect()->route('admin.pages.l');
        }
        foreach ($data['products'] as $product) {
            $id[] = $product['id'];
            $qty[] = $product['qty'];
        }

        $products = Product::whereIn('id', $id)->get();

        foreach ($products as $product) {
            $prices[] = $product->price;
        }

        $totalHarga = 0;

        foreach ($prices as $key => $price) {
            $totalHarga += $price + $qty[$key];
        }
        return view('admin.pages.checkout.chart', compact('data'), [
            'title' => 'My Chart',
            'products' => $products,
            'totalHarga' => $totalHarga
        ]);
    }
}
