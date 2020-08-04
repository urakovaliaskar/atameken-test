<?php

namespace App\Http\Controllers;

use App\Currency;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function items(Request $request)
    {
        $currencies = Currency::filter($request->all())->get();
        if(count($currencies) > 0) {
            return response()->
                json(['message' => 'данные найдены', 'currencies' => $currencies])->
                setStatusCode(200);
        } else {
            $date = Carbon::now()->format('Y-m-d');
            if(isset($request['date'])) {
                $date = Carbon::parse($request['date'])->format('Y-m-d');
            }
            return response()->
            json(['message' => 'данные на '.$date.' не найдены'])->
            setStatusCode(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function item(Request $request)
    {
        if (!isset($request['name'])) {
            return response()->
            json(['message' => 'поле name обязательное.'])->
            setStatusCode(403);
        }

        $currency = Currency::filter($request->all())->first();

        if(isset($currency)) {
            return response()->
            json(['message' => 'данные найдены', 'currency' => $currency])->
            setStatusCode(200);
        } else {
            $date = Carbon::now()->format('Y-m-d');
            if(isset($request['date'])) {
                $date = Carbon::parse($request['date'])->format('Y-m-d');
            }
            return response()->
            json(['message' => 'данные на '.$date.' не найдены'])->
            setStatusCode(404);
        }
    }
}
