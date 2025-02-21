<?php

namespace FedexRest\Services\Pickup;

use Exception;
use FedexRest\Entity\Person;
use FedexRest\Entity\Weight;
use FedexRest\Exceptions\MissingAccessTokenException;
use FedexRest\Services\AbstractRequest;
use FedexRest\Services\Pickup\Entity\ExpressFreightDetail;
use GuzzleHttp\Exception\GuzzleException;

class Pickup extends AbstractRequest {

    protected Person $sender;
    protected string $readyDatestamp = '';
    protected string $pickupType = '';
    protected string $carrierCode = '';
    protected string $customerCloseTime = '';
    protected string $countryRelationship = '';
    protected int $accountNumber;
    protected ?string $trackingNumber;
    protected Weight $totalWeight;
    protected ?ExpressFreightDetail $expressFreightDetail;

    /**
     * @return string
     */
    public function setApiEndpoint(): string {
        return '/pickup/v1/pickups';
    }

    /**
     * @param string $pickupType
     * @return $this
     */
    public function setPickupType(string $pickupType): Pickup {
        $this->pickupType = $pickupType;
        return $this;
    }

    /**
     * @param Weight $totalWeight
     * @return $this
     */
    public function setTotalWeight(Weight $totalWeight): Pickup {
        $this->totalWeight = $totalWeight;
        return $this;
    }

    /**
     * @param ExpressFreightDetail $expressFreightDetail
     * @return $this
     */
    public function setExpressFreightDetail(ExpressFreightDetail $expressFreightDetail): Pickup {
        $this->expressFreightDetail = $expressFreightDetail;
        return $this;
    }

    /**
     * @param int $accountNumber
     * @return $this
     */
    public function setAccountNumber(int $accountNumber): Pickup {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @param string $carrierCode
     * @return $this
     */
    public function setCarrierCode(string $carrierCode): Pickup {
        $this->carrierCode = $carrierCode;
        return $this;
    }

    /**
     * @param string $readyDatestamp
     * @return $this
     */
    public function setReadyDatestamp(string $readyDatestamp): Pickup {
        $this->readyDatestamp = $readyDatestamp;
        return $this;
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
     * @param string $customerCloseTime
     * @return $this
     */
    public function setCustomerCloseTime(string $customerCloseTime): Pickup {
        $this->customerCloseTime = $customerCloseTime;
        return $this;
    }

    /**
     * @param string $trackingNumber
     * @return $this
     */
    public function setTrackingNumber(string $trackingNumber): Pickup {
        $this->trackingNumber = $trackingNumber;
        return $this;
    }

    /**
     * @param Person $sender
     * @return $this
     */
    public function setSender(Person $sender): Pickup {
        $this->sender = $sender;
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
        $res = [
            'associatedAccountNumber' => [
                "value" => $this->accountNumber
            ],
            'originDetail' => [
                'pickupLocation' => $this->sender->prepare(),
                'readyDateTimestamp' => $this->readyDatestamp,
                'customerCloseTime' => $this->customerCloseTime,
            ],
            'carrierCode' => $this->carrierCode
        ];

        if(!empty($this->pickupType)){
            $res['pickupType'] = $this->pickupType;
        }
        if(!empty($this->totalWeight)){
            $res['totalWeight'] = $this->totalWeight;
        }
        if(!empty($this->expressFreightDetail)){
            $res["expressFreightDetail"] = $this->expressFreightDetail;
        }
        if(!empty($this->countryRelationship)){
            $res["countryRelationships"] = $this->countryRelationship;
        }
        if(!empty($this->trackingNumber)){
            $res["trackingNumber"] = $this->trackingNumber;
        }

        return $res;
    }
}
