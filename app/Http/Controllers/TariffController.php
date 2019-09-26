<?php

namespace App\Http\Controllers;

use App\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    //
    public function getAllTarifs(){
        $tariffs = Tariff::all();
        $tariffs_array = [];

        foreach($tariffs as $tariff){
            $tariffs_array[] = [
                'value' => $tariff->id,
                'text'  => $tariff->name,
                'price' => $tariff->price,
                'days'  => $tariff->days
            ];
        }
        return ['success' => true, 'tariffs' => $tariffs_array];
    }
}
