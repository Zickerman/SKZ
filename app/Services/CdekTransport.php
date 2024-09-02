<?php


namespace App\Services;

use App\Contracts\TransportCompanyInterface;
use Illuminate\Support\Facades\Http;

class CdekTransport implements TransportCompanyInterface
{
	/**
     * @param array $params
     * @return array
     */
	public function getDeliveryPoints(array $params = []): array
	{
		$token = env('CDEK_BEARER_TOKEN', 'your_default_token_here');

		$response = Http::withHeaders([
			'Authorization' => 'Bearer ' . $token,
		])->get('https://api.edu.cdek.ru/v2/deliverypoints', [
			'postal_code' => $params['postal_code'] ?? null,
			'grant_type' => 'client_credentials',
			'client_id' => env('CDEK_CLIENT_ID', 'wqGwiQx0gg8mLtiEKsUinjVSICCjtTEP'),
			'client_secret' => env('CDEK_CLIENT_SECRET', 'RmAmgvSgSl1yirlz9QupbzOJVqhCxcP5'),
		]);

		if ($response->successful()) {
			return $response->json();
		}

		return [];
	}
}
