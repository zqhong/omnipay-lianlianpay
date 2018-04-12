<?php

namespace Omnipay\LianLianPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\LianLianPay\Message\QueryRefundRequest;
use Omnipay\LianLianPay\Message\RefundRequest;

class Gateway extends AbstractGateway
{
    /***
     * @return string
     */
    public function getName()
    {
        return 'LianLianPay';
    }

    /**
     * 退款
     *
     * @param array $params
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function refund($params)
    {
        return $this->createRequest(RefundRequest::class, $params);
    }

    /**
     * 退款结果查询
     *
     * @param $params
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function queryRefund($params)
    {
        return $this->createRequest(QueryRefundRequest::class, $params);
    }

    public function getOidPartner()
    {
        return $this->getParameter('oid_partner');
    }

    public function setOidPartner($oidPartner)
    {
        return $this->setParameter('oid_partner', $oidPartner);
    }

    public function getRsaPrivateKey()
    {
        return $this->getParameter('rsa_private_key');
    }

    public function setRsaPrivateKey($rsaPrivateKey)
    {
        return $this->setParameter('rsa_private_key', $rsaPrivateKey);
    }

    public function getKey()
    {
        return $this->getParameter('key');
    }

    public function setKey($key)
    {
        return $this->setParameter('key', $key);
    }

    public function getSignType()
    {
        return $this->getParameter('sign_type');
    }

    public function setSignType($signType)
    {
        return $this->setParameter('sign_type', $signType);
    }

    public function getValidOrder()
    {
        return $this->getParameter('valid_order');
    }

    public function setValidOrder($validOrder)
    {
        return $this->setParameter('valid_order', $validOrder);
    }

    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }

    public function setNotifyUrl($notifyUrl)
    {
        return $this->setParameter('notify_url', $notifyUrl);
    }
}