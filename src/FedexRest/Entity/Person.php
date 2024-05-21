<?php


namespace FedexRest\Entity;


class Person
{
    public ?Address $address = null;
    public string $personName = '';
    public string $phoneNumber;
    public string $companyName = '';
    public string $email = '';
    public ?string $taxId = null;

    /**
     * @param  mixed  $address
     * @return Person
     */
    public function withAddress(Address $address)
    {
        $this->address = $address;
        return $this;
    }


    /**
     * @param  mixed  $personName
     * @return Person
     */
    public function setPersonName(string $personName)
    {
        $this->personName = $personName;
        return $this;
    }

    /**
     * @param  string  $phoneNumber
     * @return $this
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @param  string  $email
     * @return $this
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param  string  $companyName
     * @return $this
     */
    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @param string|null $taxId
     * @return $this
     */
    public function setTaxId(?string $taxId) {
        $this->taxId = $taxId;
        return $this;
    }

    /**
     * @return array[]
     */
    public function prepare(): array
    {
        $data = [];
        if (!empty($this->personName)) {
            $data['contact']['personName'] = $this->personName;
        }
        if (!empty($this->phoneNumber)) {
            $data['contact']['phoneNumber'] = $this->phoneNumber;
        }
        if (!empty($this->companyName)) {
            $data['contact']['companyName'] = $this->companyName;
        }
        if (!empty($this->email)) {
            $data['contact']['emailAddress'] = $this->email;
        }

        if ($this->address != null) {
            $data['address'] = $this->address->prepare();
        }

        if(!empty($this->taxId)){
            $data['tins']['number'] = $this->taxId;
        }
        return $data;
    }
}
