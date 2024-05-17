<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationAddress
{
    public function searchPoint(Request $request)
    {
        $to = $request->input('to');
        $from = $request->input('from');
        $apiKey = config('services.google_maps.api_key');

        $to_coordinate = $this->getCoordinates($to, $apiKey);
        $from_coordinate = $this->getCoordinates($from, $apiKey);

        if (!$to_coordinate || !$from_coordinate) {
            return response()->json(['error' => 'Invalid addresses provided.'], 400);
        }

        $t = $to_coordinate;
        $f = $from_coordinate;

        $distance_data = $this->getDistanceData($f, $t, $apiKey);

        if ($this->isValidDistanceData($distance_data)) {
            return response()->json([
                'origin_addresses' => $distance_data->destination_addresses[0],
                'to_coordinate' => $t,
                'destination_addresses' => $distance_data->origin_addresses[0],
                'from_coordinate' => $f,
                'distance' => $distance_data->rows[0]->elements[0]->distance->value,
                'duration' => $distance_data->rows[0]->elements[0]->duration->value,
            ]);
        } else {
            return response()->json(['error' => 'No valid route found between the specified points.'], 404);
        }
    }

    private function getCoordinates(string $address, string $apiKey): ?array
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $address,
            'key' => $apiKey
        ]);

        $data = $response->json();

        if (isset($data['results'][0])) {
            $location = $data['results'][0]['geometry']['location'];
            return ['lat' => $location['lat'], 'lng' => $location['lng']];
        }

        return null;
    }

    private function getDistanceData(array $from, array $to, string $apiKey): object
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins' => "{$from['lat']},{$from['lng']}",
            'destinations' => "{$to['lat']},{$to['lng']}",
            'key' => $apiKey
        ]);

        return $response->object();
    }

    private function isValidDistanceData(object $data): bool
    {
        return isset($data->rows[0]) &&
            isset($data->rows[0]->elements[0]) &&
            $data->rows[0]->elements[0]->status === 'OK' &&
            isset($data->rows[0]->elements[0]->distance) &&
            isset($data->rows[0]->elements[0]->duration);
    }
}
