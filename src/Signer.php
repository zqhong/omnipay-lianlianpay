<?php

namespace Omnipay\LianLianPay;

class Signer
{
    /**
     * @var array
     */
    protected $params;

    /**
     * @var array
     */
    protected $llPayConfig;

    public function __construct($params, $llPayConfig)
    {
        $this->params = $params;
        $this->llPayConfig = $llPayConfig;
    }

    /**
     * 获取签名
     *
     * @return string
     */
    public function sign()
    {
        $para_filter = paraFilter($this->params);
        //对待签名参数数组排序
        $para_sort = argSort($para_filter);
        //生成签名结果
        $mysign = $this->buildRequestMysign($para_sort);

        return $mysign;
    }

    /**
     * 除去数组中的空值和签名参数
     *
     * @param array $params 签名参数组
     * return 去掉空值与签名参数后的新签名参数组
     * @return array
     */
    protected function paraFilter($params)
    {
        $para_filter = array();
        foreach ($params as $key => $val) {
            if ($key == "sign" || $val == "") {
                continue;
            } else {
                $para_filter[$key] = $params[$key];
            }
        }
        return $para_filter;
    }

    /**
     * 对数组排序
     * @param array $params 排序前的数组
     * @return array 排序前的数组
     */
    protected function argSort($params)
    {
        ksort($params);
        reset($params);
        return $params;
    }

    /**
     * 生成签名结果
     * @param array $para_sort 已排序要签名的数组
     * @return string 签名结果字符串
     */
    protected function buildRequestMysign($para_sort)
    {
        // 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkString($para_sort);
        switch (strtoupper(trim($this->llPayConfig['sign_type']))) {
            case "MD5" :
                $mySign = md5Sign($prestr, $this->llPayConfig['key']);
                break;
            case "RSA" :
                $mySign = RsaSign($prestr, $this->llPayConfig['RSA_PRIVATE_KEY']);
                break;
            default :
                $mySign = "";
        }
        return $mySign;
    }

}