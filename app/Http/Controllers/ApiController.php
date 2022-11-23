<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Models\Products;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    public function list(Request $request)
    {
        // $data = Student::with(['major']);
        $limit = $request->input('limit');
        return Transaction::with(['details'])->paginate($limit);
    }

    public function detail(Request $request, $id)
    {
        return Transaction::with(['details'])->where('id', $id)->first();
    }
    public function store(Request $request)
    {
        $params = $request->all();
        $productIds = collect($params['products']);
        $productIds = $productIds->pluck('id');
        $productIds = [];
        foreach ($params['products'] as $value) {
            $productIds[] = $value['id'];
        }
        $products = Products::whereIn('id', $productIds)->get();
        $total_amount = 0;
        foreach ($params['products'] as $value) {
            $product = $products->firstWhere('id', $value['id']);
            $total_amount += ($product ? $product->price : 0) * $value['qty'];
        }
        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'id' => Uuid::uuid4()->toString(),
                'customer' => $params['customer_name'],
                'total_amount' => $total_amount

            ]);
            $transaction_details = [];
            foreach ($params['products'] as $key => $value) {
                $product = $products->firstwhere('id', $value['id']);
                $transaction_details[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'transaction_id' => $transaction->id,
                    'product_id' => $value['id'],
                    'quantity' => $value['qty'],
                    'amount' => $product ? $product->price : 0,
                    'created_at' => Carbon::now()
                ];
            }
            if ($transaction_details) {
                TransactionDetail::insert($transaction_details);
            }
            DB::commit();
            return $transaction;
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }
}
