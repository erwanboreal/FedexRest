<?php

namespace FedexRest\Services\Pickup\Entity;

use FedexRest\Entity\Dimensions;
use FedexRest\Entity\Weight;
use FedexRest\Services\Ship\Type\PackagingType;

class FreightShipmentAttributes {

    public ?Weight $weight;
    public ?Dimensions $dimensions;
    public ?string $service;
    public ?string $packagingType;

    /**
     * @param  Weight|null  $weight
     * @return $this
     */
    public function setWeight(?Weight $weight): FreightShipmentAttributes
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @param  Dimensions|null $dimensions
     * @return $this
     */
    public function setDimensions(?Dimensions $dimensions): FreightShipmentAttributes
    {
        $this->dimensions = $dimensions;
        return $this;
    }

    /**
     * @param string $service
     * @return $this
     */
    public function setService(string $service): FreightShipmentAttributes
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @param string $packagingType
     * Refer PackagingType
     * @return $this
     */
    public function setPackagingType(string $packagingType): FreightShipmentAttributes
    {
        $this->packagingType = $packagingType;
        return $this;
    }

    public function prepare(): array
    {
        $data = [];

        if (!empty($this->service)) {
            $data['service'] = $this->service;
        }

        if (!empty($this->weight)) {
            $data['weight'] = $this->weight->prepare();
        }

        if (!empty($this->dimensions)) {
            $data['dimensions'] = $this->dimensions->prepare();
        }

        if (!empty($this->packagingType)) {
            $data['packaging'] = $this->packagingType;
        }

        return $data;
    }


}