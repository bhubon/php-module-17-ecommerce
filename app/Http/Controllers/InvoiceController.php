<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Helper\SSLCommerz;
use App\Models\CustomerProfile;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->header('id');
        return Invoice::where('user_id', $user_id)->latest()->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $user_id = $request->header('id');
            $user_email = $request->header('email');

            $tran_id = uniqid();
            $delivery_status = 'Pending';
            $payment_status = 'Pending';

            $profile = CustomerProfile::where('user_id', $user_id)->first();
            $cus_details = "Name:$profile->cus_name, Address:$profile->cus_add,City:$profile->cus_city,Phone:$profile->cus_phone";
            $ship_details = "Name:$profile->ship_name, Address:$profile->ship_add,City:$profile->ship_city,Phone:$profile->ship_phone";

            //Payable calculation

            $total = 0;
            $cartList = ProductCart::where('user_id', $user_id)->get();
            foreach ($cartList as $cartItem) {
                $total += $cartItem->price;
            }

            $vat = ($total * 3) / 100;
            $payable = $total + $vat;

            $invoice = Invoice::create([
                'total' => $total,
                'vat' => $vat,
                'payable' => $payable,
                'cus_details' => $cus_details,
                'ship_details' => $ship_details,
                'tran_id' => $tran_id,
                'delivery_status' => $delivery_status,
                'payment_status' => $payment_status,
                'user_id' => $user_id,
            ]);

            foreach ($cartList as $cartItem) {
                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $cartItem['product_id'],
                    'user_id' => $user_id,
                    'qty' => $cartItem['qty'],
                    'sale_price' => $cartItem['price'],
                ]);
            }

            $paymendMethod = SSLCommerz::InitiatePayment($profile, $payable, $tran_id, $user_email);
            DB::commit();



            return ResponseHelper::Out('success', [
                'payment_method' => $paymendMethod,
                'payable' => $payable,
                'vat' => $vat,
                'total' => $total,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::Out('failed', $e->getMessage(), 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $user_id = $request->header('id');
        return Invoice::where(['user_id' => $user_id, 'id' => $id])->with('invoice_products')->get();
        ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
