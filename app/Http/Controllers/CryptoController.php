<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CryptoController extends Controller
{
    // Método para obtener todos los precios de las criptomonedas
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
}

