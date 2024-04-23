<?php
namespace App\Http\Controllers\outsideService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UtilXMLController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /* Получение координат отправляя точку A, B для получения расстояния и время поездки она считает среднее значение {
    "origin_addresses": "Astana, Kazakhstan",
    "to_coordinate": {
        "lat": 43.2379761,
        "lng": 76.8828618
    },
    "destination_addresses": "Almaty, Kazakhstan",
    "from_coordinate": {
        "lat": 51.1655126,
        "lng": 71.4272222
    },
    "distance": 1233453,
    "duration": 57992
} */
        public function coordinate_to_from(Request $request){
            $to = urlencode($request->to);
            $from = urlencode($request->from);

            $to_coord = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$to.'&key='.env('GOOGLE_TOKEN'));
            $to_coordinate = json_decode($to_coord, true);
            $t=$to_coordinate['results'][0]['geometry']['location'];

            $from_coord = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$from.'&key='.env('GOOGLE_TOKEN'));
            $from_coordinate = json_decode($from_coord, true);
            $f=$from_coordinate['results'][0]['geometry']['location'];

            $distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.$to.'&destinations='.$from.'&key='.env('GOOGLE_TOKEN'));
            $distance_arr = json_decode($distance_data);
            //return $distance_arr;
            return response()->json([
                "origin_addresses" => $distance_arr->destination_addresses[0],
                "to_coordinate" => $t,
                "destination_addresses" => $distance_arr->origin_addresses[0],
                "from_coordinate" => $f,
                "distance" => $distance_arr->rows[0]->elements[0]->distance->value,
                "duration" => $distance_arr->rows[0]->elements[0]->duration->value,
            ]);

        }    
    }
