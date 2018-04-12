<?php

/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 *
 * @param array $params 需要拼接的数组
 * return 拼接完成以后的字符串
 * @return bool|string
 */
function createLinkString($params)
{
    $arg = "";
    foreach ($params as $key => $val) {
        $arg .= $key . "=" . $val . "&";
    }

    //去掉最后一个&字符
    $arg = substr($arg, 0, -1);
    //如果存在转义字符，那么去掉转义
    if (get_magic_quotes_gpc()) {
        $arg = stripslashes($arg);
    }
    return $arg;
}

/**
 * 除去数组中的空值和签名参数
 *
 * @param array $params 签名参数组
 * return 去掉空值与签名参数后的新签名参数组
 * @return array
 */
function paraFilter($params)
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
function argSort($params)
{
    ksort($params);
    reset($params);
    return $params;
}


/**
 * 远程获取数据，POST模式
 *
 * @param string $url 指定URL完整路径地址
 * @param array $para 请求的数据
 * @return mixed 远程输出的数据
 */
function getHttpResponseJSON($url, $para)
{
    $json = json_encode($para);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //信任任何证书
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json))
    );
    $responseText = curl_exec($curl);
    curl_close($curl);
    return $responseText;
}

/**
 * 签名字符串
 * @param string $prestr 需要签名的字符串
 * @param string $key 私钥
 * @return string 签名结果
 */
function md5Sign($prestr, $key)
{
    $prestr = $prestr . "&key=" . $key;
    return md5($prestr);
}

/**
 * 验证签名
 *
 * @param string $prestr 需要签名的字符串
 * @param string $sign 签名结果
 * @param string $key 私钥
 * @return bool 签名结果
 */
function md5Verify($prestr, $sign, $key)
{
    $prestr = $prestr . "&key=" . $key;
    $mysgin = md5($prestr);
    if ($mysgin == $sign) {
        return true;
    } else {
        return false;
    }
}

/**RSA签名
 * $data签名数据(需要先排序，然后拼接)
 * 签名用商户私钥，必须是没有经过pkcs8转换的私钥
 * 最后的签名，需要用base64编码
 * @return string Sign签名
 */
function Rsasign($data, $priKey)
{
    //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
    $res = openssl_get_privatekey($priKey);

    //调用openssl内置签名方法，生成签名$sign
    openssl_sign($data, $sign, $res, OPENSSL_ALGO_MD5);

    //释放资源
    openssl_free_key($res);

    //base64编码
    $sign = base64_encode($sign);
    return $sign;
}

/**RSA验签
 * $data待签名数据(需要先排序，然后拼接)
 * $sign需要验签的签名,需要base64_decode解码
 * 验签用连连支付公钥
 * return 验签是否通过 bool值
 */
function Rsaverify($data, $sign)
{
    //读取连连支付公钥文件
    $pubKey = file_get_contents(dirname(__FILE__) . '/../../key/llpay_public_key.pem');

    //转换为openssl格式密钥
    $res = openssl_get_publickey($pubKey);

    //调用openssl内置方法验签，返回bool值
    $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_MD5);

    //释放资源
    openssl_free_key($res);

    //返回资源是否成功
    return $result;
}
