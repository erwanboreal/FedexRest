<?php

namespace FedexRest\Services\TradeDocuments;

use Exception;
use FedexRest\Exceptions\MissingAccessTokenException;
use FedexRest\Services\AbstractRequest;
use GuzzleHttp\Exception\GuzzleException;

class UploadDocument extends AbstractRequest {

    protected string $attachment;
    protected string $workflowName;
    protected string $carrierCode;
    protected string $name;
    protected string $contentType;
    protected array $meta;

    public function setApiEndpoint(): string {
        return '/documents/v1/etds/upload';
    }

    /**
     * @param string $attachment
     * @return $this
     */
    public function setAttachment(string $attachment): UploadDocument {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * @param string $workflowName ETDPreshipment or ETDPostshipment
     * @return $this
     */
    public function setWorkflowName(string $workflowName): UploadDocument {
        $this->workflowName = $workflowName;
        return $this;
    }

    /**
     * @param string $carrierCode FDXE or FDXG
     * @return $this
     */
    public function setCarrierCode(string $carrierCode): UploadDocument {
        $this->carrierCode = $carrierCode;
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): UploadDocument {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $contentType
     * @return $this
     */
    public function setContentType(string $contentType): UploadDocument {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @param array $meta
     * @return $this
     */
    public function setMeta(array $meta): UploadDocument {
        $this->meta = $meta;
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
                    'attachment' => $this->attachment,
                    'document' => [
                        "workflowName" => $this->workflowName,
                        "carrierCode" => $this->carrierCode,
                        "name" => $this->name,
                        "contentType" => $this->contentType,
                        "meta" => $this->meta
                    ]
                ],
                'http_errors' => FALSE,
            ]);
            return ($this->raw === true) ? $query : json_decode($query->getBody()->getContents());
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}