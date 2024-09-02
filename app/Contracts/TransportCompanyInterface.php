<?php


namespace App\Contracts;


interface TransportCompanyInterface
{
	/**
     * @param array $params
     * @return array
     */
	public function getDeliveryPoints(array $params = []): array;
}
