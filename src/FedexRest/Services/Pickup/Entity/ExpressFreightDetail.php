<?php

namespace FedexRest\Services\Pickup\Entity;

use FedexRest\Entity\Dimensions;

class ExpressFreightDetail {

    public string $service;
    public ?string $truckType;
    public ?string $trailerLength;
    public ?string $bookingNumber;
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
     * @param string $truckType
     * "DROP_TRAILER_AGREEMENT" "LIFTGATE" "TRACTOR_TRAILER_ACCESS"
     * @return $this
     */
    public function setTruckType(string $truckType): ExpressFreightDetail {
        $this->truckType = $truckType;
        return $this;
    }

    /**
     * @param string $trailerLength
     * "TRAILER_28_FT" "TRAILER_48_FT" "TRAILER_53_FT"
     * @return $this
     */
    public function setTrailerLength(string $trailerLength): ExpressFreightDetail {
        $this->trailerLength = $trailerLength;
        return $this;
    }

    /**
     * @param string $bookingNumber
     * @return $this
     */
    public function setBookingNumber(string $bookingNumber): ExpressFreightDetail {
        $this->bookingNumber = $bookingNumber;
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
        $res = [
            "dimensions" => $this->dimensions->prepare(),
            "service" => $this->service,
        ];

        if(!empty($this->truckType)){
            $res["trucType"] = $this->truckType;
        }
        if(!empty($this->trailerLength)){
            $res["trailerLength"] = $this->trailerLength;
        }
        if(!empty($this->bookingNumber)){
            $res["bookingNumber"] = $this->bookingNumber;
        }

        return $res;
    }

}