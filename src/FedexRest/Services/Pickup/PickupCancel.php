<?php

namespace FedexRest\Services\Pickup;

use Exception;
use FedexRest\Exceptions\MissingAccessTokenException;
use FedexRest\Services\AbstractRequest;
use GuzzleHttp\Exception\GuzzleException;

class PickupCancel extends AbstractRequest {

    protected int $accountNumber;
    protected string $pickupConfirmationCode = '';
    protected string $scheduledDate = '';
    protected string $location = '';

    /**
     * @return string
     */
    public function setApiEndpoint(): string {
        return "/pickup/v1/pickups/cancel";
    }

    /**
     * @param int $accountNumber
     * @return $this
     */
    public function setAccountNumber(int $accountNumber): PickupCancel {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @param string $pickupConfirmationCode
     * @return $this
     */
    public function setPickupConfirmationCode(string $pickupConfirmationCode): PickupCancel {
        $this->pickupConfirmationCode = $pickupConfirmationCode;
        return $this;
    }

    /**
     * @param string $scheduledDate
     * @return $this
     */
    public function setScheduledDate(string $scheduledDate): PickupCancel {
        $this->scheduledDate = $scheduledDate;
        return $this;
    }

    /**
     * @param string $location
     * @return $this
     */
    public function setLocation(string $location): PickupCancel {
        $this->location = $location;
        return $this;
    }

    /**
     * @throws MissingAccessTokenException
     * @throws GuzzleException
     */
    public function request() {
        parent::request();

        try {
            $query = $this->http_client->put($this->getApiUri($this->api_endpoint), [
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
            'pickupConfirmationCode' => $this->pickupConfirmationCode,
            'scheduledDate' => $this->scheduledDate,
            'location' => $this->location
        ];
    }



}