<?php

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function new(Request $req){
        $newDriver = new Driver();
        $newDriver->fullName = $req->get("fullName");
        $newDriver->phone = $req->get("phone");
        $newDriver->carNo = $req->get("carNo");
        if ($newDriver->save()){
            return $newDriver;
        } else {
            return response("لطفا تمام پارامترها را ارسال کنید", 400);
        }
    }

    public function show(Request $req)
    {
        return Driver::find($req->get("id"));
    }

    public function showPhone(Request $req)
    {
        $driver = Driver::where("phone", $req->get("phone"))->first();
        return $driver;
    }

    public function showAll()
    {
        return Driver::all();
    }
}
