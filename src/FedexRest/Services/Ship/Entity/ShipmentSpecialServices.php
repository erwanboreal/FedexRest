<?php

namespace FedexRest\Services\Ship\Entity;

class ShipmentSpecialServices
{
    public ?array $specialServiceTypes;
    public ?array $returnShipmentDetails;
    public ?array $etdDetail;

    /**
     * @param array  $specialServiceTypes
     * @return $this
     */
    public function setSpecialServiceTypes(array $specialServiceTypes): ShipmentSpecialServices
    {
        $this->specialServiceTypes = $specialServiceTypes;
        return $this;
    }

    /**
     * @param array  $returnShipmentDetails
     * @return $this
     */
    public function setReturnShipmentDetails(array $returnShipmentDetails): ShipmentSpecialServices
    {
        $this->returnShipmentDetails = $returnShipmentDetails;
        return $this;
    }
    /**
     * @param array  $etdDetail
     * @return $this
     */
    public function setEtdDetail(array $etdDetail): ShipmentSpecialServices
    {
        $this->etdDetail = $etdDetail;
        return $this;
    }


    public function prepare(): array
    {
        $data = [];
        if (!empty($this->returnShipmentDetails)) {
            $data['returnShipmentDetail'] = $this->returnShipmentDetails;
        }
        if (!empty($this->specialServiceTypes)) {
            $data['specialServiceTypes'] = $this->specialServiceTypes;
        }
        if(!empty($this->etdDetail)) {
            $data['etdDetail'] = $this->etdDetail;
        }
        return $data;
    }
}
