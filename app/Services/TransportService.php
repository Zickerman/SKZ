<?php

namespace App\Services;

use App\Contracts\TransportCompanyInterface;


class TransportService implements TransportCompanyInterface
{
	protected $transportCompany;

	/**
     * @param TransportCompanyInterface $transportCompany
     */
	public function __construct(TransportCompanyInterface $transportCompany)
	{
		$this->transportCompany = $transportCompany;
	}

	/**
     * @param array $params
     * @return array
     */
	public function getDeliveryPoints(array $params = []): array
	{
		return $this->transportCompany->getDeliveryPoints($params);
	}
}
