<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HealthCard;

class HealthCardController extends Controller
{
    public function index(){
        return HealthCard::with('employee')->get();
    }

    public function store(Request $request){
        return HealthCard::create($request->all());
    }

    public function show($id){
        return HealthCard::findOrFail($id);
    }

    public function update($id, Request $request){
        $health_card = HealthCard::findOrFail($id);
        $health_card->fill($request->all());
        $health_card->save();
        return $health_card;
    }

    public function destroy($id){
        $health_card = HealthCard::findOrFail($id);
        $health_card->delete();
        return $health_card;
    }
}
