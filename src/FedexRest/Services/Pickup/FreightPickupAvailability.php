<?php

namespace FedexRest\Services\Pickup;

use Exception;
use FedexRest\Entity\Address;
use FedexRest\Exceptions\MissingAccessTokenException;
use FedexRest\Services\AbstractRequest;
use FedexRest\Services\Pickup\Entity\FreightShipmentAttributes;
use GuzzleHttp\Exception\GuzzleException;

class FreightPickupAvailability extends AbstractRequest {

    protected Address $pickupAddress;
    protected string $countryRelationship = '';
    protected string $dispatchDate = '';
    protected string $customerCloseTime = '';
    protected FreightShipmentAttributes $shipmentAttributes;

    /**
     * @return string
     */
    public function setApiEndpoint(): string {
        return '/pickup/v1/freight/pickups/availabilities';
    }

    /**
     * @param string $countryRelationship
     * @return $this
     */
    public function setCountryRelationship(string $countryRelationship): FreightPickupAvailability {
        $this->countryRelationship = $countryRelationship;
        return $this;
    }

    /**
     * @param string $dispatchDate
     * @return $this
     */
    public function setDispatchDatestamp(string $dispatchDate): FreightPickupAvailability {
        $this->dispatchDate = $dispatchDate;
        return $this;
    }

    /**
     * @param string $customerCloseTime
     * @return $this
     */
    public function setCustomerCloseTime(string $customerCloseTime): FreightPickupAvailability {
        $this->customerCloseTime = $customerCloseTime;
        return $this;
    }

    /**
     * @param Address $pickupAddress
     * @return $this
     */
    public function setPickupAddress(Address $pickupAddress): FreightPickupAvailability {
        $this->pickupAddress = $pickupAddress;
        return $this;
    }

    /**
     * @param FreightShipmentAttributes $shipmentAttributes
     * @return $this
     */
    public function setShipmentAttributes(FreightShipmentAttributes $shipmentAttributes): FreightPickupAvailability {
        $this->shipmentAttributes = $shipmentAttributes;
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
                'json' => [
                    'pickupAddress' => $this->pickupAddress->prepare(),
                    'countryRelationship' => $this->countryRelationship,
                    'dispatchDate' => $this->dispatchDate,
                    'customerCloseTime' => $this->customerCloseTime,
                    'shipmentAttributes' => $this->shipmentAttributes->prepare()
                ],
                'http_errors' => FALSE,
            ]);
            return ($this->raw === true) ? $query : json_decode($query->getBody()->getContents());
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
