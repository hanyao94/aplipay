<?php
/**
 * Created by PhpStorm.
 * User: Seven
 * Date: 2017/1/13
 * Time: 14:36
 * 支付宝回调地址
 */
    header("Content-type: text/html; charset=utf-8");
    include_once dirname(__FILE__).DIRECTORY_SEPARATOR."lotusphp_runtime/Logger/Logger.php";
    include_once dirname(__FILE__).DIRECTORY_SEPARATOR."aop/AopClient.php";
    include_once dirname(__FILE__).DIRECTORY_SEPARATOR."f2fpay/config/config.php";

    $log = new LtLogger(); //日志
    $log->conf["log_file"] = "log/aplipay_notify_log.txt";//日志保存的位置

    if(!empty($_POST)){
        foreach ($_POST as $key => $value){
            $param[$key] = $value;
            $log_param[$key] = $key.":".$value; //写入日志文件用的数组
        }
        $log_param['time'] = "date: ".date("Y-m-d h:i:sa"); //时间
        $log->log($log_param); //写入日志文件
        //print_r($param);
    }else{
        $param = array("支付宝post请求参数为空","date: ".date("Y-m-d h:i:sa"));
        $log->log($param);
        exit("failure");
    }

    //验签
    $aopClient = new AopClient();
    $aopClient->alipayrsaPublicKey = $config['alipay_public_key']; //公钥
    $signVerified = $aopClient->rsaCheckV1($param,'');
    if ($signVerified){
        //验签通过
        $log->log(array("验签通过","date: ".date("Y-m-d h:i:sa")));

        //验证这笔订单和商户系统创建的订单是否一致，金额是否存在
        $log->log(array("订单号、金额验证通过","date: ".date("Y-m-d h:i:sa")));


        //WAIT_BUYER_PAY 	交易创建，等待买家付款
        if ($param['trade_status'] == 'WAIT_BUYER_PAY'){
            $log->log(array("交易创建成功，等待买家付款","date: ".date("Y-m-d h:i:sa")));
            exit("failure");
        }

        //根据支付状态trade_status，TRADE_SUCCESS或TRADE_FINISHED时，支付宝才会认定为买家付款成功。
        if (($param['trade_status'] == 'TRADE_SUCCESS')||($param['trade_status'] =='TRADE_FINISHED')){
            //交易成功，更改状态
            $log->log(array("交易成功，更改订单状态","trade_status: ".$param['trade_status'],"date: ".date("Y-m-d h:i:sa")));
            exit("SUCCESS");
        }

        //TRADE_CLOSED     未付款交易超时关闭，或付完款全额退款
        if ($param['trade_status'] == 'TRADE_CLOSED'){
            //未付款超时，更改订单号，待重新发起支付
            $log->log(array("未付款超时，更改订单号，待重新发起支付","date: ".date("Y-m-d h:i:sa")));
            exit("failure");
        }

    }else{
        //验签失败
        $log->log(array("验签失败","date: ".date("Y-m-d h:i:sa")));
        exit("failure");
    }



