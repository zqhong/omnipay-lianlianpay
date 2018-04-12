<?php

namespace Omnipay\LianLianPay\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse
{
    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        $data = $this->getData();

        // ret_code：0000，交易成功
        if (
            is_array($data) &&
            isset($data['ret_code']) &&
            $data['ret_code'] == '0000'
        ) {
            return true;
        }

        return false;
    }
}