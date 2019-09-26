<?php

namespace App\Http\Controllers;

use App\Orders;
use App\Tariff;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    //
    public function newOrder(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', "min:3"],
            'phone' => ['required', "min:10", "starts_with:+7(,+79,8(,89", 'regex:/^[0-9\(\)\-\+]+[0-9]*$/'],
            'address' => ['required', 'min:5'],
            'tariff'  => ['required', 'gt:0'],
            'first_day' => ['required', 'min:5']            
        ]);

        if($validator->fails()){
            return ['success' => false, 'errors' => $validator->errors()->all()];
        }

        $tariff = Tariff::find($request->tariff);
        if(!$tariff){
            return ['success' => false, 'errors' => ['Указан не существующий тариф']];
        }
        if(!in_array($request->first_day, $tariff->days)){
            return ['success' => false, 'errors' => ['Тариф не позволяет начать с этого дня']];
        }

        $user = User::where('phone', $request->phone)->first();

        if(!$user){
            try{
                $user = User::create([
                    'name'  => $request->name,
                    'phone' => $request->phone
                ]);
            } catch(Exception $e){
                return ['success' => false, 'errors' => [env('APP_DEBUG', false) ? $e->getMessage() : "Что-то пошло не так"]];
            }
        }

        try {
            $new_order = Orders::create([
                'user_id'   => $user->id,
                'tariff_id' => $tariff->id,
                'first_day' => $request->first_day,
                'address'   => $request->address
            ]);
        } catch(Exception $e){
            return ['success' => false, 'errors' => [env('APP_DEBUG', false) ? $e->getMessage() : "Что-то пошло не так"]];
        }
        
        return ['success' => true, 'new_order_id' => $new_order->id];
    }
}
