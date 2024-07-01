<?php

namespace FedexRest\Services\TradeDocument;

use FedexRest\Exceptions\MissingAccessTokenException;
use FedexRest\Services\AbstractRequest;
use FedexRest\Services\TradeDocument\Entity\Document;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;

class UploadDocument extends AbstractRequest
{

    protected string $production_url = 'https://documentapi.prod.fedex.com';
    protected string $testing_url = 'https://documentapitest.prod.fedex.com/sandbox';
    public string $content_type = 'multipart/form-data';
    public string $attachment;
    public Document $document;

    public function setAttachment(string $attachment): UploadDocument
    {
        $this->attachment = $attachment;
        return $this;
    }

    public function setDocument(Document $document): UploadDocument
    {
        $this->document = $document;
        return $this;
    }

    public function prepare(): array {
        return [
            [
                'name' => 'attachment',
                'contents' => $this->attachment,
                'filename' => $this->document->name,
                'headers' => [
                    'Content-Type' => $this->document->contentType
                ]
            ],
            [
                'name' => 'document',
                'contents' =>  json_encode($this->document->prepare())
            ]
        ];
    }

    public function setApiEndpoint()
    {
        return '/documents/v1/etds/upload';
    }

    /**
     * @return mixed|string
     * @throws MissingAccessTokenException
     */
    public function request(): mixed
    {
        parent::request();
        $sender = Http::withOptions([
            'headers' => [
                'Authorization' => "Bearer {$this->access_token}",
                'X-locale' => 'fr_FR'
            ],
        ]);

        try {
            $query = $sender->attach('attachment', $this->attachment, $this->document->name, ['Content-Type' => $this->document->contentType])
                ->post($this->getApiUri($this->api_endpoint), ["document" => json_encode($this->document->prepare())]);

            return json_decode($query->body());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}