<?php

namespace FedexRest\Services\Pickup;

use Exception;
use FedexRest\Entity\Person;
use FedexRest\Entity\Weight;
use FedexRest\Exceptions\MissingAccessTokenException;
use FedexRest\Services\AbstractRequest;
use FedexRest\Services\Pickup\Entity\FreightPickupDetail;
use GuzzleHttp\Exception\GuzzleException;

class FreightPickup extends AbstractRequest {
    protected string $production_url = 'https://developer.fedex.com/api/en-fr/catalog/ltl-freight';
    protected string $testing_url = 'https://developer.fedex.com/api/en-fr/catalog/ltl-freight';

    protected Person $sender;
    protected string $readyDatestamp = '';
    protected string $customerCloseTime = '';
    protected Weight $totalWeight;
    protected string $countryRelationships;
    protected FreightPickupDetail $freightPickupDetail;
    protected int $accountNumber;


    /**
     * @return string
     */
    public function setApiEndpoint(): string {
        return '/pickup/v1/freight/pickups';
    }

    /**
     * @param int $accountNumber
     * @return $this
     */
    public function setAccountNumber(int $accountNumber): FreightPickup {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @param string $readyDatestamp
     * @return $this
     */
    public function setReadyDatestamp(string $readyDatestamp): FreightPickup {
        $this->readyDatestamp = $readyDatestamp;
        return $this;
    }

    /**
     * @param string $customerCloseTime
     * @return $this
     */
    public function setCustomerCloseTime(string $customerCloseTime): FreightPickup {
        $this->customerCloseTime = $customerCloseTime;
        return $this;
    }

    /**
     * @param FreightPickupDetail $freightPickupDetail
     * @return $this
     */
    public function setFreightPickupDetail(FreightPickupDetail $freightPickupDetail): FreightPickup {
        $this->freightPickupDetail = $freightPickupDetail;
        return $this;
    }


    /**
     * @param Person $sender
     * @return $this
     */
    public function setSender(Person $sender): FreightPickup {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @param Weight $totalWeight
     * @return $this
     */
    public function setTotalWeight(Weight $totalWeight): FreightPickup {
        $this->totalWeight = $totalWeight;
        return $this;
    }

    /**
     * @param string $countryRelationships
     * @return $this
     */
    public function setCountryRelationships(string $countryRelationships): FreightPickup {
        $this->countryRelationships = $countryRelationships;
        return $this;
    }

    /**
     * @throws MissingAccessTokenException
     * @throws GuzzleException
     */
    public function request() {
        parent::request();

        try {
            $query = $this->http_client->post($this->getApiUri($this->api_endpoint), [
                'json' => $this->prepare(),
                'http_errors' => FALSE,
            ]);
            return ($this->raw === true) ? $query : json_decode($query->getBody()->getContents());
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function prepare(): array {
        return [
            'associatedAccountNumber' => [
                "value" => $this->accountNumber
            ],
            'originDetail' => [
                'pickupLocation' => $this->sender->prepare(),
                'readyDateTimestamp' => $this->readyDatestamp,
                'customerCloseTime' => $this->customerCloseTime
            ],
            'freightPickupDetail' => $this->freightPickupDetail->prepare(),
            'countryRelationships' => $this->countryRelationships,
            'totalWeight' => $this->totalWeight->prepare(),
        ];
    }
}
