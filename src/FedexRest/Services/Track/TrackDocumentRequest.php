<?php

namespace FedexRest\Services\Track;

use Exception;
use FedexRest\Exceptions\MissingAccessTokenException;
use FedexRest\Services\AbstractRequest;
use GuzzleHttp\Exception\GuzzleException;

class TrackDocumentRequest extends AbstractRequest
{

    private string $documentType;
    private string $trackingNumber;

    /**
     * @return string
     */
    public function setApiEndpoint()
    {
        return '/track/v1/trackingdocuments';
    }

    /**
     * @param $trackingNumber
     * @return $this
     */
    public function setTrackingNumber($trackingNumber): TrackDocumentRequest
    {
        $this->trackingNumber = $trackingNumber;
        return $this;
    }

    /**
     * @param $documentType
     * @return $this
     */
    public function setDocumentType($documentType): TrackDocumentRequest
    {
        $this->documentType = $documentType;
        return $this;
    }

    /**
     * @return array
     */
    public function prepare(): array {
        return [
            'trackDocumentDetail' => [
                'documentType' => $this->documentType
            ],
            'trackDocumentSpecification' => [
                [
                    "trackingNumberInfo" => [
                        "trackingNumber" => $this->trackingNumber
                    ]
                ]
            ]
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