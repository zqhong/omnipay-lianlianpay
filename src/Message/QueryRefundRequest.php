<?php

namespace Omnipay\LianLianPay\Message;

class QueryRefundRequest extends AbstractRequest
{
    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return 'https://queryapi.lianlianpay.com/refundquery.htm';
    }


    public function getNoRefund()
    {
        return $this->getParameter('no_refund');
    }

    public function setNoRefund($noRefund)
    {
        return $this->setParameter('no_refund', $noRefund);
    }

    public function getDtRefund()
    {
        return $this->getParameter('dt_refund');
    }

    public function setDtRefund($dtRefund)
    {
        return $this->setParameter('dt_refund', $dtRefund);
    }

    public function getOidRefundNo()
    {
        return $this->getParameter('oid_refundno');
    }

    public function setOidRefundNo($oidRefundNo)
    {
        return $this->setParameter('oid_refundno', $oidRefundNo);
    }
}