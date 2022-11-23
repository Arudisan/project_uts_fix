<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\transactionDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTransactionRequest;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        $products = [1, 2, 3, 4, 5, 6];
        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'id' => Uuid::uuid4()->toString(),
                'customer' => 'ardi',
                'total_amount' => 100000
            ]);
            $transactionDetail = [];
            foreach ($products as $index => $product) {
                $transactionDetails[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'transaction_id' => $transaction->id,
                    'product_id' => $index,
                    'quantity' => 10000,
                    'amount' => 10000,
                    'created_at' => Carbon::now()
                ];
            }
            if ($transactionDetails) {
                TransactionDetail::insert($transactionDetails);
            }
            //menyimpan permanen,jika semua querynya success
            DB::commit();
            return "ok";
        } catch (\Throwable $th) {
            //membatalkan semua query,jika salah satu query ada yang error;
            DB::rollback();
            return $th;
        }
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
}
