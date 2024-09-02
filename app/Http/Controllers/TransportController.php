<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Services\TransportService;


class TransportController extends Controller
{
	protected $transportService;

	/**
     * @param TransportService $transportService
     */
	public function __construct(TransportService $transportService)
	{
		$this->transportService = $transportService;
	}

	/**
     * @return \Illuminate\Contracts\View\View
     */
	public function getDeliveryPoints()
	{
		$deliveryPoints = $this->transportService->getDeliveryPoints([
			'postal_code' => '460026' // захардкодил для примера
		]);

		return view('frontend.delivery', ['deliveryPoints' => $deliveryPoints]);
	}
}
