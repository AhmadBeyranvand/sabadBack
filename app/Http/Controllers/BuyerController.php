<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends Controller
{

    public function new(Request $req){
        $newBuyer = new Buyer();
        $newBuyer->fullName = $req->get("fullName");
        $newBuyer->phone = $req->get("phone");
        $newBuyer->address = $req->get("address");
        if($newBuyer->save()){
            return $newBuyer;
        } else {
            return response("لطفا تمام پارامترها را ارسال کنید", 400);
        }
    }

    public function show(Request $req)
    {
        return Buyer::find($req->get("id"));
    }

    public function showPhone(Request $req)
    {
        $buyer = Buyer::where("phone", $req->get("phone"))->first();
        return $buyer;
    }

    public function showAll()
    {
        return Buyer::all();
    }
}
