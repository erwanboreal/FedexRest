<?php

namespace FedexRest\Services\TradeDocuments;

use Exception;
use FedexRest\Exceptions\MissingAccessTokenException;
use FedexRest\Services\AbstractRequest;
use GuzzleHttp\Exception\GuzzleException;

class UploadImage extends AbstractRequest {

    protected string $attachment;
    protected string $workflowName;
    protected string $referenceId;
    protected string $name;
    protected string $contentType;
    protected array $meta;

    public function setApiEndpoint(): string {
        return '/documents/v1/lhsimages/upload';
    }

    /**
     * @param string $attachment
     * @return $this
     */
    public function setAttachment(string $attachment): UploadImage {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * @param string $workflowName ETDPreshipment or ETDPostshipment
     * @return $this
     */
    public function setWorkflowName(string $workflowName): UploadImage {
        $this->workflowName = $workflowName;
        return $this;
    }

    /**
     * @param string $referenceId
     * @return $this
     */
    public function setReferenceId(string $referenceId): UploadImage {
        $this->referenceId = $referenceId;
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): UploadImage {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $contentType
     * @return $this
     */
    public function setContentType(string $contentType): UploadImage {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @param array $meta
     * @return $this
     */
    public function setMeta(array $meta): UploadImage {
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
                        "rules" => ["workflowName" => $this->workflowName],
                        "name" => $this->name,
                        "referenceId" => $this->referenceId,
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