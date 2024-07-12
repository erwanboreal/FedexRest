<?php

namespace FedexRest\Services\Pickup;

use Exception;
use FedexRest\Entity\Address;
use FedexRest\Exceptions\MissingAccessTokenException;
use FedexRest\Services\AbstractRequest;
use FedexRest\Services\Pickup\Entity\ShipmentAttributes;
use GuzzleHttp\Exception\GuzzleException;

class PickupAvailability extends AbstractRequest {

    protected Address $pickupAddress;
    protected array $pickupRequestType = [];
    protected array $carriers = [];
    protected string $countryRelationship = '';
    protected string $dispatchDate = '';
    protected string $customerCloseTime = '';
    protected ShipmentAttributes $shipmentAttributes;


    /**
     * @return string
     */
    public function setApiEndpoint(): string {
        return '/pickup/v1/pickups/availabilities';
    }

    /**
     * @param string $countryRelationship
     * @return $this
     */
    public function setCountryRelationship(string $countryRelationship): PickupAvailability {
        $this->countryRelationship = $countryRelationship;
        return $this;
    }

    /**
     * @param array $carriers
     * @return $this
     */
    public function setCarriers(array $carriers): PickupAvailability {
        $this->carriers = $carriers;
        return $this;
    }

    /**
     * @param array $pickupRequestType
     * @return $this
     */
    public function setPickupRequestType(array $pickupRequestType): PickupAvailability {
        $this->pickupRequestType = $pickupRequestType;
        return $this;
    }

    /**
     * @param string $dispatchDate
     * @return $this
     */
    public function setDispatchDatestamp(string $dispatchDate): PickupAvailability {
        $this->dispatchDate = $dispatchDate;
        return $this;
    }

    /**
     * @param string $customerCloseTime
     * @return $this
     */
    public function setCustomerCloseTime(string $customerCloseTime): PickupAvailability {
        $this->customerCloseTime = $customerCloseTime;
        return $this;
    }

    /**
     * @param Address $pickupAddress
     * @return $this
     */
    public function setPickupAddress(Address $pickupAddress): PickupAvailability {
        $this->pickupAddress = $pickupAddress;
        return $this;
    }

    /**
     * @param ShipmentAttributes $shipmentAttributes
     * @return $this
     */
    public function setShipmentAttributes(ShipmentAttributes $shipmentAttributes): PickupAvailability {
        $this->shipmentAttributes = $shipmentAttributes;
        return $this;
    }

    /**
     * @return array
     */
    public function prepare(): array {
        return [
            'pickupAddress' => $this->pickupAddress->prepare(),
            'pickupRequestType' => $this->pickupRequestType,
            'carriers' => $this->carriers,
            'countryRelationship' => $this->countryRelationship,
            'dispatchDate' => $this->dispatchDate,
            'customerCloseTime' => $this->customerCloseTime,
            'shipmentAttributes' => $this->shipmentAttributes->prepare()
        ];
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
}
