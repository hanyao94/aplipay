<?php
/**
 * Created by PhpStorm.
 * User: Seven
 * Date: 2017/1/13
 * Time: 14:36
 * 支付宝回调地址
 */
    include_once "lotusphp_runtime/Logger/Logger.php";

    $log = new LtLogger(); //日志
    $log->conf["log_file"] = "log/aplipay_notify_log.txt";//日志保存的位置

    if(!empty($_POST)){
        foreach ($_POST as $key => $value){
            $param[$key] = $value;
            $log_param[$key] = $key.":".$value; //写入日志文件用的数组
        }
        $log_param['time'] = "date: ".date("Y-m-d h:i:sa"); //时间
        $log->log($log_param); //写入日志文件
        print_r($param);
    }else{
        $param = array("empty","date: ".date("Y-m-d h:i:sa"));
        $log->log($param);
        echo "empty";
    }
