<?php

namespace Omnipay\LianLianPay;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    /***
     * @return string
     */
    public function getName()
    {
        return 'LianLianPay';
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
        return $this->setKey($key);
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
}