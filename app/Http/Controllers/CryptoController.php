<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CryptoController extends Controller
{
    // Método para obtener las información de las criptomonedas mas recientes
    public function getAllCryptoPrices()
    {
        $apiKey = env('COINMARKETCAP_API_KEY');
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';

        // Realizar la solicitud a la API de CoinMarketCap
        $response = Http::withHeaders([
            'X-CMC_PRO_API_KEY' => $apiKey,
        ])->get($url, [
            'start' => 1, // Iniciar desde la primera criptomoneda
            'limit' => 100, // Limitar a 100 criptomonedas
            'convert' => 'USD', // Queremos la cotización en USD
        ]);

        // Verificar si la respuesta fue exitosa
        if ($response->successful()) {
            $data = $response->json();
            $cryptos = $data['data'];

            // Solo extraemos la información relevante para mostrar
            $cryptoData = array_map(function($crypto) {
                return [
                    'name' => $crypto['name'],
                    'symbol' => $crypto['symbol'],
                    'price_usd' => $crypto['quote']['USD']['price'],
                    'percent_change_24h' => $crypto['quote']['USD']['percent_change_24h'],
                    'volume_24h' => $crypto['quote']['USD']['volume_24h'],
                ];
            }, $cryptos);

            // Devolver la respuesta en formato JSON
            return response()->json($cryptoData);
        } else {
            return response()->json(['error' => 'Error al obtener los datos.'], 500);
        }
    }

    //Función para obtener la información de una criptomoneda en especifico
    public function getCryptoInfo(Request $request)
    {
        //echo $request;

       $symbol = $request->query('symbol'); // Por ejemplo: BTC

        if (!$symbol) {
        return response()->json(['error' => 'Falta el parámetro "symbol".'], 400);
        }

        $apiKey = env('COINMARKETCAP_API_KEY');
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info';

    // Realizar la solicitud a la API de CoinMarketCap
        $response = Http::withHeaders([
            'X-CMC_PRO_API_KEY' => $apiKey,
        ])->get($url, [
            'symbol' => strtoupper($symbol),
        ]);

        // Verificar si la respuesta fue exitosa
        if ($response->successful()) {
        $data = $response->json();

        // CoinMarketCap devuelve los datos por símbolo, por ejemplo: data['BTC']
        $info = $data['data'][strtoupper($symbol)];

        // Extraer y devolver solo los campos relevantes
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

