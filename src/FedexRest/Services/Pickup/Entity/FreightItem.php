<?php

namespace FedexRest\Services\Pickup\Entity;

use FedexRest\Entity\Address;
use FedexRest\Entity\Dimensions;
use FedexRest\Entity\Weight;

class FreightItem
{
    public ?string $itemDescription = '';
    public ?Weight $weight;
    public ?Dimensions $dimensions;
    public ?string $service;
    public ?int $sequenceNumber;
    public ?string $packagingType;
    public ?Address $destination;

    /**
     * @param string $itemDescription
     * @return FreightItem
     */
    public function setItemDescription(string $itemDescription): FreightItem
    {
        $this->itemDescription = $itemDescription;
        return $this;
    }

    /**
     * @param string $service
     * @return FreightItem
     */
    public function setService(string $service): FreightItem
    {
        $this->$service = $service;
        return $this;
    }

    /**
     * @param Address $destination
     * @return FreightItem
     */
    public function setDestination(Address $destination): FreightItem
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @param  Weight|null  $weight
     * @return $this
     */
    public function setWeight(?Weight $weight): FreightItem
    {
        $this->weight = $weight;
        return $this;
    }

    /**
    * @param  Dimensions|null $dimensions
    * @return $this
    */
    public function setDimensions(?Dimensions $dimensions): FreightItem
    {
        $this->dimensions = $dimensions;
        return $this;
    }

    /**
    * @param int|null $sequenceNumber
    * @return $this
    */
    public function setSequenceNumber(?int $sequenceNumber): FreightItem
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
    * Specify the packaging being used.
    * @param string $packagingType
    * "BAG" "BARREL" "BASKET" "BOX" "BUCKET" "BUNDLE" "CAGE" "CARTON" "CASE" "CHEST" "CONTAINER" "CRATE" "CYLINDER" "DRUM" "ENVELOPE" "HAMPER" "OTHER" "PACKAGE" "PAIL" "PALLET" "PARCEL" "PIECE" "REEL" "ROLL" "SACK" "SHRINK_WRAPPED" "SKID" "TANK" "TOTE_BIN" "TUBE" "UNIT"
    * @return $this
    */
    public function setPackagingType(string $packagingType): FreightItem
    {
        $this->packagingType = $packagingType;
        return $this;
    }

    public function prepare(): array
    {
        $data = [];

        if (!empty($this->itemDescription)) {
            $data['description'] = $this->itemDescription;
        }

        if (!empty($this->service)) {
            $data['service'] = $this->service;
        }

        if (!empty($this->weight)) {
            $data['weight'] = $this->weight->prepare();
        }

        if (!empty($this->dimensions)) {
            $data['dimensions'] = $this->dimensions->prepare();
        }

        if (!empty($this->destination)) {
            $data['destination'] = $this->destination->prepare();
        }

        if (!empty($this->sequenceNumber)) {
            $data['sequenceNumber'] = $this->sequenceNumber;
        }

        if (!empty($this->packagingType)) {
            $data['packaging'] = $this->packagingType;
        }

        return $data;
    }
}
