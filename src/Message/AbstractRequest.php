<?php

namespace Omnipay\LianLianPay\Message;

use Omnipay\Common\Message\AbstractRequest as AbstractCommomRequest;
use Omnipay\LianLianPay\LLpaySubmit;

abstract class AbstractRequest extends AbstractCommomRequest
{
    /**
     * @return string
     */
    abstract protected function getEndpoint();

    public function getData()
    {
        return $this->getParameters();
    }

    /**
     * Get send data.
     *
     * @param  mixed $data
     * @return Response
     * @throws \Exception
     */
    public function sendData($data)
    {
        $api = new LLpaySubmit([
            'oid_partner' => $this->getOidPartner(),
            'RSA_PRIVATE_KEY' => $this->getRsaPrivateKey(),
            'key' => $this->getKey(),
            'sign_type' => strtoupper($this->getSignType()),
            'valid_order' => $this->getValidOrder(),
        ]);

        unset($data['key']);

        $result = $api->buildRequestJSON($data, $this->getEndpoint());
        $result = json_decode($result, true);
        return new Response($this, $result);
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