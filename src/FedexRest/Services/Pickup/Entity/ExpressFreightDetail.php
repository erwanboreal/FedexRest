<?php

namespace FedexRest\Services\Pickup\Entity;

use FedexRest\Entity\Dimensions;

class ExpressFreightDetail {

    public string $service;
    public Dimensions $dimensions;

    /**
     * @param string $service
     * @return $this
     */
    public function setService(string $service): ExpressFreightDetail {
        $this->service = $service;
        return $this;
    }

    /**
     * @param Dimensions $dimensions
     * @return $this
     */
    public function setDimensions(Dimensions $dimensions): ExpressFreightDetail {
        $this->dimensions = $dimensions;
        return $this;
    }

    public function prepare(): array {
        return [
            "dimensions" => $this->dimensions->prepare(),
            "service" => $this->service
        ];
    }

}