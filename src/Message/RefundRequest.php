<?php

namespace Omnipay\LianLianPay\Message;

class RefundRequest extends AbstractRequest
{
    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return 'https://traderapi.lianlianpay.com/refund.htm';
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

    /**
     * 退款金额，该金额必须小于或等于原订单金额，单位为：元
     * 大于0的数字，精确到小数点后两位。如：49.65。
     *
     * @return float
     */
    public function getMoneyRefund()
    {
        return $this->getParameter('money_refund');
    }

    public function setMoneyRefund($moneyRefund)
    {
        return $this->setParameter('money_refund', $moneyRefund);
    }

    public function getNoOrder()
    {
        return $this->getParameter('no_order');
    }

    public function setNoOrder($noOrder)
    {
        return $this->setParameter('no_order', $noOrder);
    }

    public function getDtOrder()
    {
        return $this->getParameter('dt_order');
    }

    public function setDtOrder($dtOrder)
    {
        return $this->setParameter('dt_order', $dtOrder);
    }

    public function getOidPayBill()
    {
        return $this->getParameter('oid_pay_bill');
    }

    public function setOidPayBill($oidPayBill)
    {
        return $this->setParameter('oid_pay_bill', $oidPayBill);
    }

}