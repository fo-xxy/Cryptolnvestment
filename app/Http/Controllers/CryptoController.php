<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

//Se usa para poder encontrar el archivo json con los datos para el historial
use Illuminate\Support\Facades\Storage;

class CryptoController extends Controller
{
    //Método para obtener las información de las criptomonedas mas recientes
    public function getAllCryptoPrices()
    {
        $apiKey = env('COINMARKETCAP_API_KEY');
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';

        $response = Http::withHeaders([
            'X-CMC_PRO_API_KEY' => $apiKey,
        ])->get($url, [
            'start' => 1,
            'limit' => 100,
            'convert' => 'USD',
        ]);

        //Valida si la respuesta tuvo exito o no
        if ($response->successful()) {
            $data = $response->json();
            $cryptos = $data['data'];

            //Extraemos la información a mostrar
            $cryptoData = array_map(function ($crypto) {
                return [
                    'name' => $crypto['name'],
                    'symbol' => $crypto['symbol'],
                    'price_usd' => $crypto['quote']['USD']['price'],
                    'percent_change_24h' => $crypto['quote']['USD']['percent_change_24h'],
                    'volume_24h' => $crypto['quote']['USD']['volume_24h'],
                ];
            }, $cryptos);

            $entry = [
                'timestamp' => now()->toDateTimeString(),
                'data' => $cryptoData
            ];

            //Ruta del archivo en storage/app/crypto_history.json
            $filePath = 'crypto_history.json';

            //Lee el archivo json 
            $existingData = [];
            if (Storage::exists($filePath)) {
                $existingData = json_decode(Storage::get($filePath), true);
            }

            // Agregar el nuevo registro
            $existingData[] = $entry;

            //Actualiza o guarda el archivo con los nuevops datos
            Storage::put($filePath, json_encode($existingData, JSON_PRETTY_PRINT));

            return response()->json($cryptoData);
        } else {
            return response()->json(['error' => 'Error al obtener los datos.'], 500);
        }
    }

    //Método para obtener la información de una criptomoneda en especifico
    public function getCryptoInfo(Request $request)
    {
        //echo $request;

        $symbol = $request->query('symbol');

        if (!$symbol) {
            return response()->json(['error' => 'Falta el parámetro "symbol".'], 400);
        }

        $apiKey = env('COINMARKETCAP_API_KEY');
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info';

        $response = Http::withHeaders([
            'X-CMC_PRO_API_KEY' => $apiKey,
        ])->get($url, [
            'symbol' => strtoupper($symbol),
        ]);

        //Valida si la respuesta tuvo exito o no
        if ($response->successful()) {
            $data = $response->json();

            $info = $data['data'][strtoupper($symbol)];

            //Extraemos la información a mostrar
            $cryptoInfo = [
                'name' => $info['name'],
                'symbol' => $info['symbol'],
                'logo' => $info['logo'],
                'category' => $info['category'],
                'description' => $info['description'],
                'date_added' => $info['date_added'],
                'website' => $info['urls']['website'][0] ?? null,
                'whitepaper' => $info['urls']['technical_doc'][0] ?? null,
            ];

            return response()->json($cryptoInfo);
        } else {
            return response()->json(['error' => 'Error al obtener la información de la criptomoneda.'], 500);
        }
    }
}
