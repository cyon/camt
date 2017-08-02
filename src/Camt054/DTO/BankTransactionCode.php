<?php
namespace Genkgo\Camt\Camt054\DTO;


class BankTransactionCode extends \Genkgo\Camt\DTO\BankTransactionCode
{
    /** @var string */
    private $domainCode;

    /** @var string */
    private $familyCode;

    /** @var string */
    private $subFamilyCode;

    /**
    * @return string
    */
    public function getDomainCode()
    {
        return $this->domainCode;
    }

    /**
    * @param string $domainCode
    */
    public function setDomainCode($domainCode)
    {
        $this->domainCode = $domainCode;
    }

    public function getFamilyCode()
    {
        return $this->familyCode;
    }

    public function setFamilyCode($familyCode)
    {
        $this->familyCode = $familyCode;
    }

    public function getSubFamilyCode()
    {
        return $this->subFamilyCode;
    }

    public function setSubFamilyCode($subFamilyCode)
    {
        $this->subFamilyCode = $subFamilyCode;
    }
}
