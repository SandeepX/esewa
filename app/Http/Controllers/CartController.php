<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class CartController extends Controller
{

    public function index()
    {
        try{
            $auth = Auth::user()->id;
            $Cartdetail = Cart::where('order_by',$auth)->get();
            $pid = session()->getId();
            $txAmt = 10;
            $psc = 8;
            $pdc =5;
            $siteUrl = 'http://127.0.0.1:8001';
            $successUrl = $siteUrl . "/verification-payment?q=su";
            $failureUrl = $siteUrl . "/verification-payment?q=fu";
            $total = 0;
            foreach($Cartdetail as $item){
                $total+= $item->price;
            }
            $amt = $txAmt + $pdc + $psc + $total;
            return view('cart.checkout',
                compact('Cartdetail','pid',
                'txAmt','psc','pdc','amt','total','successUrl','failureUrl')
            );
        }catch (Exception $exception){
            return redirect()->back()->with('message',$exception->getMessage());
        }


    }

    public function store(CartRequest $request)
    {
        try{
            $validatedRequest = $request->validated();
            //dd($validatedRequest);
            $data = $request->all();
            $data['order_by'] =  Auth::user()->id;

            DB::beginTransaction();
            $status = Cart::create($data);
            if($status){
                redirect()->back()->with('message', 'PRODUCT ADDED TO CART.');
            }else{
                redirect()->back()->with('message', 'PRODUCT NOT ADDED TO CART.');
            }
        }catch(\Exception $e){
            DB::rollback();
            redirect()->back()->with('message','product not added');
        }
        DB::commit();
        return redirect()->route('home');
    }

    public function verify(Request $request)
    {
        try{
            $status = $request->q;

            if($status === 'fu'){
                $request->session()->regenerate();
                return redirect()->route('carts.index')->with('failure','Transaction Failed, Please try again');
            }

            if($status === 'su')
            {
                //dd($status); if it is success then their is su else fu
                $oid = $request->oid;
                $amt = $request ->amt;
                $refId = $request->refId;
                //dump($oid,$amt,$refId);

                //dd($refId);

                $url = "https://uat.esewa.com.np/epay/transrec";

                $auth = Auth::user()->id;
                $Cartdetail = Cart::whereIn('id', ['1','3','5','6','9'])
                    ->where('order_by',$auth)
                    ->get();

                $txAmt = 10;
                $psc = 8;
                $pdc = 5;

                $total = 0;
                foreach($Cartdetail as $item){
                    $total+= $item->price;
                }
                $amt = $txAmt + $pdc + $psc + $total;
//            $data = [
//                'amt'=> $amt,
//                'rid'=> $refId,
//                'pid'=> session()->getId(),
//                'scd'=> 'EPAYTEST'
//            ];
//                $curl = curl_init($url);
//                curl_setopt($curl, CURLOPT_POST, true);
//                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//                $response = curl_exec($curl);
//                curl_close($curl);

                //dd($response);
//
//                if(strpos($response,"Success")){
//                    $request->session()->regenerate();
//                    return redirect()->route('carts.index')->with('success','Your Order has been placed Successfully');
//                }
//                if(strpos($response,"failure")){
//                    $request->session()->regenerate();
//                    return redirect()->route('carts.index')->with('failure','something went wrong, Please Try Again');
//                }

                $response = Http::post($url, [
                    'amt'=> $amt,
                    'rid'=> $refId,
                    'pid'=> session()->getId(),
                    'scd'=> 'EPAYTEST'
                ]);

                if($response->successful()){
                    $request->session()->regenerate();
                    return redirect()->route('carts.index')->with('success','Your Order has been placed Successfully');
                }
                if($response->failed()){
                    $request->session()->regenerate();
                    return redirect()->route('carts.index')->with('failure','something went wrong, Please Try Again');
                }

            }
        }catch(\Exception $exception){
            return redirect()->route('cart.index')->with('failure',$exception->getMessage());
        }

    }





}
