<?php

namespace Omnipay\LianLianPay;

class LLpaySubmit
{
    /**
     * @var array
     */
    protected $llpay_config;

    public function __construct($llpayConfig)
    {
        $this->llpay_config = $llpayConfig;
    }

    /**
     * 生成签名结果
     * @param array $para_sort 已排序要签名的数组
     * @return string 签名结果字符串
     */
    public function buildRequestMysign($para_sort)
    {
        // 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkString($para_sort);
        switch (strtoupper(trim($this->llpay_config['sign_type']))) {
            case "MD5" :
                $mySign = md5Sign($prestr, $this->llpay_config['key']);
                break;
            case "RSA" :
                $mySign = RsaSign($prestr, $this->llpay_config['RSA_PRIVATE_KEY']);
                break;
            default :
                $mySign = "";
        }
        return $mySign;
    }

    /**
     * 生成要请求给连连支付的参数数组
     * @param array $params 请求前的参数数组
     * @return array 要请求的参数数组
     */
    public function buildRequestParams($params)
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($params);
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
     *
     * @param array $params 请求参数数组
     * @param string $endpoint
     * @return string 连连支付处理结果
     */
    public function buildRequestJSON($params, $endpoint)
    {
        //待请求参数数组字符串
        $request_data = $this->buildRequestParams($params);

        //远程获取数据
        $sResult = getHttpResponseJSON($endpoint, $request_data);

        return $sResult;
    }
}
