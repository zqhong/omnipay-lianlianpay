<?php

namespace Omnipay\LianLianPay;

class LLpaySubmit
{
    var $llpay_config;

    /**
     *连连退款网关地址
     */

    function __construct($llpay_config)
    {
        $this->llpay_config = $llpay_config;
    }

    function LLpaySubmit($llpay_config)
    {
        $this->__construct($llpay_config);
    }

    /**
     * 生成签名结果
     * @param $para_sort 已排序要签名的数组
     * return 签名结果字符串
     */
    function buildRequestMysign($para_sort)
    {
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkString($para_sort);
        $mysign = "";
        switch (strtoupper(trim($this->llpay_config['sign_type']))) {
            case "MD5" :
                $mysign = md5Sign($prestr, $this->llpay_config['key']);
                break;
            case "RSA" :
                $mysign = RsaSign($prestr, $this->llpay_config['RSA_PRIVATE_KEY']);
                break;
            default :
                $mysign = "";
        }
        return $mysign;
    }

    /**
     * 生成要请求给连连支付的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
    function buildRequestPara($para_temp)
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($para_temp);
        //对待签名参数数组排序
        $para_sort = argSort($para_filter);
        //生成签名结果
        $mysign = $this->buildRequestMysign($para_sort);
        //签名结果与签名方式加入请求提交参数组中
        $para_sort['sign'] = $mysign;
        $para_sort['sign_type'] = strtoupper(trim($this->llpay_config['sign_type']));
        foreach ($para_sort as $key => $value) {
            $para_sort[$key] = $value;
        }
        return $para_sort;
    }


    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取连连支付的处理结果
     * @param $para_temp 请求参数数组
     * @return 连连支付处理结果
     */
    function buildRequestJSON($para_temp, $llpay_gateway_new)
    {
        //待请求参数数组字符串
        $request_data = $this->buildRequestPara($para_temp);

        //远程获取数据
        $sResult = getHttpResponseJSON($llpay_gateway_new, $request_data);

        return $sResult;
    }
}
