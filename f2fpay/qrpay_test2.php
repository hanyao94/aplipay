<?php
/**
 * Created by PhpStorm.
 * User: Seven
 * Date: 2016/12/24
 * Time: 14:04
 */
header("Content-type: text/html; charset=utf-8");
require_once 'model/builder/AlipayTradePrecreateContentBuilder.php';
require_once  'service/AlipayTradeService.php';

if (!empty($_POST['out_trade_no'])&& trim($_POST['out_trade_no'])!=""){
    // (必填) 商户网站订单系统中唯一订单号，64个字符以内，只能包含字母、数字、下划线，
    // 需保证商户系统端不能重复，建议通过数据库sequence生成，
    $outTradeNo = $_POST['out_trade_no'];

    // (必填) 订单标题，粗略描述用户的支付目的。如“xxx品牌xxx门店当面付扫码消费”
    $subject = $_POST['subject'];

    // (必填) 订单总金额，单位为元，不能超过1亿元
    // 如果同时传入了【打折金额】,【不可打折金额】,【订单总金额】三者,则必须满足如下条件:【订单总金额】=【打折金额】+【不可打折金额】
    $totalAmount = $_POST['total_amount'];

    //支付超时，线下扫码交易定义为5分钟
    $timeExpress = "5m";

    //创建请求builder，设置请求参数
    $qrPayRequestBuilder = new AlipayTradePrecreateContentBuilder();
    $qrPayRequestBuilder->setOutTradeNo($outTradeNo);
    $qrPayRequestBuilder->setTotalAmount($totalAmount);
    $qrPayRequestBuilder->setExtendParams($timeExpress);
    $qrPayRequestBuilder->setSubject($subject);

    // 调用qrPay方法获取当面付应答
    $qrPay = new AlipayTradeService($config);

    $qrPayResult = $qrPay->qrPay($qrPayRequestBuilder);

switch ($qrPayResult->getTradeStatus()) {
    case "SUCCESS":
        echo "支付宝创建订单二维码成功:" . "<br>---------------------------------------<br>";
        $response = $qrPayResult->getResponse();
        $qrcode = $qrPay->create_erweima($response->qr_code);
        echo $qrcode;
        print_r($response);

        break;
    case "FAILED":
        echo "支付宝创建订单二维码失败!!!" . "<br>--------------------------<br>";
//        if(!empty($qrPayResult->getResponse())){
//            print_r($qrPayResult->getResponse());
//        }
        break;
    case "UNKNOWN":
        echo "系统异常，状态未知!!!" . "<br>--------------------------<br>";
//        if(!empty($qrPayResult->getResponse())){
//            print_r($qrPayResult->getResponse());
//        }
        break;
    default:
        echo "不支持的返回状态，创建订单二维码返回异常!!!";
        break;
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>支付宝当面付 二维码支付</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        *{
            margin:0;
            padding:0;
        }
        ul,ol{
            list-style:none;
        }
        .title{
            color: #ADADAD;
            font-size: 14px;
            font-weight: bold;
            padding: 8px 16px 5px 10px;
        }
        .hidden{
            display:none;
        }

        .new-btn-login-sp{
            border:1px solid #D74C00;
            padding:1px;
            display:inline-block;
        }

        .new-btn-login{
            background-color: transparent;
            background-image: url("../img/new-btn-fixed.png");
            border: medium none;
        }
        .new-btn-login{
            background-position: 0 -198px;
            width: 82px;
            color: #FFFFFF;
            font-weight: bold;
            height: 28px;
            line-height: 28px;
            padding: 0 10px 3px;
        }
        .new-btn-login:hover{
            background-position: 0 -167px;
            width: 82px;
            color: #FFFFFF;
            font-weight: bold;
            height: 28px;
            line-height: 28px;
            padding: 0 10px 3px;
        }
        .bank-list{
            overflow:hidden;
            margin-top:5px;
        }
        .bank-list li{
            float:left;
            width:153px;
            margin-bottom:5px;
        }

        #main{
            width:750px;
            margin:0 auto;
            font-size:14px;
            font-family:'宋体';
        }
        #logo{
            background-color: transparent;
            background-image: url("../img/new-btn-fixed.png");
            border: medium none;
            background-position:0 0;
            width:166px;
            height:35px;
            float:left;
        }
        .red-star{
            color:#f00;
            width:10px;
            display:inline-block;
        }
        .null-star{
            color:#fff;
        }
        .content{
            margin-top:5px;
        }

        .content dt{
            width:160px;
            display:inline-block;
            text-align:right;
            float:left;

        }
        .content dd{
            margin-left:100px;
            margin-bottom:5px;
        }
        #foot{
            margin-top:10px;
        }
        .foot-ul li {
            text-align:center;
        }
        .note-help {
            color: #999999;
            font-size: 12px;
            line-height: 130%;
            padding-left: 3px;
        }

        .cashier-nav {
            font-size: 14px;
            margin: 15px 0 10px;
            text-align: left;
            height:30px;
            border-bottom:solid 2px #CFD2D7;
        }
        .cashier-nav ol li {
            float: left;
        }
        .cashier-nav li.current {
            color: #AB4400;
            font-weight: bold;
        }
        .cashier-nav li.last {
            clear:right;
        }
        .alipay_link {
            text-align:right;
        }
        .alipay_link a:link{
            text-decoration:none;
            color:#8D8D8D;
        }
        .alipay_link a:visited{
            text-decoration:none;
            color:#8D8D8D;
        }
    </style>
</head>
<body text=#000000 bgColor="#ffffff" leftMargin=0 topMargin=4>
<div id="main">
    <div id="head">
        <dl class="alipay_link">
            <a target="_blank" href="http://www.alipay.com/"><span>支付宝首页</span></a>|
            <a target="_blank" href="https://b.alipay.com/home.htm"><span>商家服务</span></a>|
            <a target="_blank" href="http://help.alipay.com/support/index_sh.htm"><span>帮助中心</span></a>
        </dl>
        <span class="title">支付宝统一预下单接口快速通道</span>
    </div>
    <div class="cashier-nav">
        <ol>
            <li class="current">1、确认信息 →</li>
            <li>2、点击确认 →</li>
            <li class="last">3、确认完成</li>
        </ol>
    </div>
    <form name=alipayment action="" method=post target="_blank">
        <div id="body" style="clear:left">
            <dl class="content">
                <dt>商户订单号：</dt>
                <dd>
                    <span class="null-star">*</span>
                    <input size="30" name="out_trade_no" />
						<span>商户网站订单系统中唯一订单号，必填
</span>
                </dd>
                <dt>订单名称：</dt>
                <dd>
                    <span class="null-star">*</span>
                    <input size="30" name="subject" />
						<span>必填
</span>
                </dd>

                <dt>付款金额：</dt>
                <dd>
                    <span class="null-star">*</span>
                    <input size="30" name="total_amount" />
						<span>必填
</span>
                </dd>


                <dt></dt>
                <dd>
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type="submit" style="text-align:center;">确 认</button>
                        </span>
                </dd>
            </dl>
        </div>
    </form>
    <div id="foot">
        <ul class="foot-ul">
            <li><font class="note-help">如果您点击“确认”按钮，即表示您同意该次的执行操作。 </font></li>
            <li>
                支付宝版权所有 2011-2015 ALIPAY.COM
            </li>
        </ul>
    </div>
</div>
</body>
</html>
