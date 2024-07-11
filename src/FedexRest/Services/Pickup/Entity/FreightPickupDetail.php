<?php

namespace FedexRest\Services\Pickup\Entity;

use FedexRest\Entity\Person;

class FreightPickupDetail {

    protected int $accountNumber;
    protected string $role;
    protected string $payment;
    protected string $comapnyName;
    protected string $personName;
    protected string $phoneNumber;
    protected string $emailAddress;
    protected Person $alternateBilling;
    protected array $lineItems;

    /**
     * @param int $accountNumber
     * @return $this
     */
    public function setAccountNumber(int $accountNumber): FreightPickupDetail {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function setRole(string $role): FreightPickupDetail {
        $this->role = $role;
        return $this;
    }

    /**
     * @param string $payment
     * @return $this
     */
    public function setPayment(string $payment): FreightPickupDetail {
        $this->payment = $payment;
        return $this;
    }

    /**
     * Sender company
     * @param string $comapnyName
     * @return $this
     */
    public function setCompanyName(string $comapnyName): FreightPickupDetail {
        $this->comapnyName = $comapnyName;
        return $this;
    }

    /**
     * Sender name
     * @param string $personName
     * @return $this
     */
    public function setPersonName(string $personName): FreightPickupDetail {
        $this->personName = $personName;
        return $this;
    }

    /**
     * Sender phone
     * @param string $phoneNumber
     * @return $this
     */
    public function setPhoneNumber(string $phoneNumber): FreightPickupDetail {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Sender email
     * @param string $emailAddress
     * @return $this
     */
    public function setEmailAddress(string $emailAddress): FreightPickupDetail {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @param Person $alternateBilling
     * @return $this
     */
    public function setAlternateBilling(Person $alternateBilling): FreightPickupDetail {
        $this->alternateBilling = $alternateBilling;
        return $this;
    }

    /**
     * @param FreightItem[] $lineItems
     * @return $this
     */
    public function setLineItems(array $lineItems): FreightPickupDetail {
        $this->lineItems = $lineItems;
        return $this;
    }

    public function prepare(): array
    {
        $data = [];

        if (!empty($this->accountNumber)) {
            $data['accountNumber']['value'] = $this->accountNumber;
        }

        if (!empty($this->role)) {
            $data['role'] = $this->role;
        }

        if (!empty($this->payment)) {
            $data['payment'] = $this->payment;
        }

        if (!empty($this->lineItems)) {
            $line_items = [];
            foreach ($this->lineItems as $line_item) {
                $line_items[] = $line_item->prepare();
            }
            $data['lineItems'] = $line_items;
        }

        if (!empty($this->alternateBilling)) {
            $data['alternateBilling'] = $this->alternateBilling->prepare();
        }

        $data['submittedBy'] = [
            'companyName' => $this->comapnyName,
            'personName' => $this->personName,
            'phoneNumber' => $this->phoneNumber,
            'emailAddress' => $this->emailAddress,
        ];

        return $data;
    }
}