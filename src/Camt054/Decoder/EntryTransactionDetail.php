<?php

namespace Genkgo\Camt\Camt054\Decoder;

use Genkgo\Camt\DTO;
use Genkgo\Camt\Camt054\DTO\BankTransactionCode;
use Genkgo\Camt\Decoder\EntryTransactionDetail as BaseDecoder;
use \SimpleXMLElement;
use Genkgo\Camt\Iban;

class EntryTransactionDetail extends BaseDecoder
{
    public function addBankTransactionCode(DTO\EntryTransactionDetail $detail, SimpleXMLElement $xmlDetail)
    {
        $bankTransactionCode = new BankTransactionCode();

        if (isset($xmlDetail->BkTxCd->Domn->Cd)) {
            $bankTransactionCode->setDomainCode($xmlDetail->BkTxCd->Domn->Cd);
        }

        if (isset($xmlDetail->BkTxCd->Domn->Fmly)) {
            $bankTransactionCode->setFamilyCode($xmlDetail->BkTxCd->Domn->Fmly->Cd);
            $bankTransactionCode->setSubfamilyCode($xmlDetail->BkTxCd->Domn->Fmly->SubFmlyCd);
        }

        $detail->setBankTransactionCode($bankTransactionCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getRelatedPartyAccount(SimpleXMLElement $xmlRelatedPartyTypeAccount = null)
    {

        if ($xmlRelatedPartyTypeAccount !== null) {

            if (false === isset($xmlRelatedPartyTypeAccount->Id)) {
                return;
            }

            if (isset($xmlRelatedPartyTypeAccount->Id->IBAN)) {
                return new DTO\IbanAccount(new Iban((string)$xmlRelatedPartyTypeAccount->Id->IBAN));
            }

            if (isset($xmlRelatedPartyTypeAccount->Id->BBAN)) {
                return new DTO\BBANAccount((string)$xmlRelatedPartyTypeAccount->Id->BBAN);
            }

            if (isset($xmlRelatedPartyTypeAccount->Id->UPIC)) {
                return new DTO\UPICAccount((string)$xmlRelatedPartyTypeAccount->Id->UPIC);
            }

            if (isset($xmlRelatedPartyTypeAccount->Id->PrtryAcct)) {
                return new DTO\ProprietaryAccount((string)$xmlRelatedPartyTypeAccount->Id->PrtryAcct->Id);
            }

            if (isset($xmlRelatedPartyTypeAccount->Id->Othr)) {
                $xmlOtherIdentification = $xmlRelatedPartyTypeAccount->Id->Othr;
                $otherAccount           = new DTO\OtherAccount((string)$xmlOtherIdentification->Id);

                if (isset($xmlOtherIdentification->SchmeNm)) {
                    if (isset($xmlOtherIdentification->SchmeNm->Cd)) {
                        $otherAccount->setSchemeName((string)$xmlOtherIdentification->SchmeNm->Cd);
                    }

                    if (isset($xmlOtherIdentification->SchmeNm->Prtry)) {
                        $otherAccount->setSchemeName((string)$xmlOtherIdentification->SchmeNm->Prtry);
                    }
                }

                if (isset($xmlOtherIdentification->Issr)) {
                    $otherAccount->setIssuer($xmlOtherIdentification->Issr);
                }

                return $otherAccount;
            }
        }
    }
}
