<?php

namespace App\Http\Controllers;

use App\Buyer;
use App\Driver;
use App\Factor;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FactorController extends Controller
{
    public function new(Request $req)
    {
        $newFactor = new Factor();
        $newFactor->buyer_id = $req->get("buyer_id");
        $newFactor->driver_id = $req->get("driver_id");
        $newFactor->s1count = $req->get("s1count");
        $newFactor->s2count = $req->get("s2count");
        $newFactor->s3count = $req->get("s3count");
        $newFactor->s4count = $req->get("s4count");
        $newFactor->s1price = $req->get("s1price");
        $newFactor->s2price = $req->get("s2price");
        $newFactor->s3price = $req->get("s3price");
        $newFactor->s4price = $req->get("s4price");
        $newFactor->totalPrice = $req->get("totalPrice");
        $newFactor->prePay = $req->get("prePay");
        $newFactor->transport = $req->get("transport");
        if ($newFactor->save()) {
            return $newFactor->id;
        } else {
            return response("لطفا تمام پارامترها را ارسال کنید", 400);
        }
    }

    public function show(Request $req)
    {
        $id = $req->get("id");
        if ($id > 0) {
            $factor = Factor::find($id);
            $buyer = Buyer::find($factor->buyer_id);
            $driver = Driver::find($factor->driver_id);
            return ["factor" => $factor, "buyer" => $buyer, "driver" => $driver];
        }
    }

    public function showAll(Request $req)
    {
        $data = [];
        $all = [];
        if ($req->get("fullName")) {
            $buyerID = Buyer::where("fullName", "LIKE", '%' . $req->get("fullName") . '%');
            if ($buyerID) {
                $all = Factor::where("buyer_id", $buyerID->pluck('id')[0])->orderBy('id', 'desc')->limit(200)->get();
            }
        } elseif ($req->get("phone")) {
            $buyerID = Buyer::where("phone", "LIKE", '%' . $req->get("phone") . '%')->first();
            if ($buyerID) {
                $all = Factor::where("buyer_id", $buyerID->pluck('id')[0])->orderBy('id', 'desc')->limit(200)->get();
            }
        } else {
            $all = Factor::orderBy('id', 'desc')->limit(200)->get();
        }
        foreach ($all as $f) {
            // return $f->id;
            $item = [];
            $buyer = Buyer::find($f->buyer_id);
            $item = ["data" => $f, "buyer" => $buyer->fullName];
            array_push($data, $item);
        }
        return $data;
    }

    public function showDebters()
    {
        $debterIDs = DB::select(
            "SELECT f.buyer_id, b.fullName, b.phone, sum(f.totalPrice-f.prePay-f.afterPay) as remain 
                FROM factors as f 
                INNER JOIN buyers as b 
                ON b.id=f.buyer_id 
                WHERE f.totalPrice-f.prePay-f.afterPay>0
                GROUP BY buyer_id
                ; "
        );

        return  $debterIDs;
    }

    public function showDebtOf($userID)
    {
        $debterDetails = DB::select(
            "SELECT * 
            FROM factors 
            WHERE buyer_id=" . $userID . " AND totalPrice-prePay-afterPay<>0
        "
        );

        return  $debterDetails;
    }

    public function clearFactor($factorID)
    {
        $f = Factor::find($factorID);
        $f->afterPay = $f->totalPrice - $f->prePay;
        return $f->save();
    }

    public function clearUser($userID)
    {
        $factors = Factor::where("buyer_id", $userID)->pluck('id');
        foreach ($factors as $f) {
            $this->clearFactor($f);
        }
        return $factors;
    }

    public function stats()
    {
        $todayTotal = Factor::whereDate('created_at', Carbon::today())->sum("totalPrice");
        $todayPrePay = Factor::whereDate('created_at', Carbon::today())->sum("prePay");

        $sumTotal = Factor::all()->sum("totalPrice");
        $sumPrePay = Factor::all()->sum("prePay");
        $data = [
            "today" => [
                "total" => $todayTotal,
                "prePay" => $todayPrePay,
                "remain" => $todayTotal - $todayPrePay
            ],
            "total" => [
                "total" => $sumTotal,
                "prePay" => $sumPrePay,
                "remain" => $sumTotal - $sumPrePay
            ],
        ];

        return $data;
    }
}
