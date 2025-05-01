<?php

namespace App\Jobs;

use App\Repositories\DealRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchAndStoreDealsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected DealRepository $dealRepository;

    public function __construct(DealRepository $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    public function handle(): void
    {
        try {
            // Get Amadeus access token
            $tokenResponse = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->asForm()->post('https://test.api.amadeus.com/v1/security/oauth2/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('services.amadeus.client_id'),
                'client_secret' => config('services.amadeus.client_secret'),
            ]);

            if (!$tokenResponse->successful()) {
                Log::error('Amadeus token error: ' . $tokenResponse->body());
                return;
            }

            $accessToken = $tokenResponse->json()['access_token'];
            Log::info('Amadeus access token obtained: ' . $accessToken);

            // Fetch flight deals
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get('https://test.api.amadeus.com/v2/shopping/flight-offers', [
                'originLocationCode' => 'LON',
                'destinationLocationCode' => 'NYC',
                'departureDate' => now()->addDays(7)->format('Y-m-d'),
                'adults' => 1,
                'nonStop' => 'false',
                'currencyCode' => 'USD',
                'max' => 10,
            ]);

            if ($response->successful()) {
                $deals = $response->json()['data'] ?? [];
                Log::info('Amadeus deals fetched: ' . count($deals));

                foreach ($deals as $dealData) {
                    $itinerary = $dealData['itineraries'][0];
                    $segment = $itinerary['segments'][0];

                    $this->dealRepository->create([
                        'type' => 'flight',
                        'origin' => $segment['departure']['iataCode'],
                        'destination' => $segment['arrival']['iataCode'],
                        'price' => $dealData['price']['total'],
                        'departure_date' => $segment['departure']['at'],
                        'return_date' => isset($dealData['itineraries'][1]) ? $dealData['itineraries'][1]['segments'][0]['departure']['at'] : null,
                        'details' => json_encode([
                            'carrier' => $segment['carrierCode'],
                            'flight_number' => $segment['number'],
                            'duration' => $itinerary['duration'],
                        ]),
                    ]);
                }
            } else {
                Log::error('Amadeus API error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error fetching deals from Amadeus: ' . $e->getMessage());
        }
    }
}