<?php
$config = array (	
		//支付宝公钥
		'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB",

		//商户私钥
		'merchant_private_key' => "MIICXgIBAAKBgQCvFDqpI2nhPaW4S4r3ZR92wMT6UWdKPogyVDNqBIjk/VPYfk6f
1kGJVrOn+ahJhYbDUg3xqu9JfOyV1nGR9kJkjaL+Q+t8Db2OQhu0rHKwtrNkKWKl
EgHX75nRleOfEi3Y3Smp4wMC+fwfIK/QZGvA4bAveS4DT/1a6vKslPAAIwIDAQAB
AoGAJbv5bKzqTBaKWi9F805DOsgPbFgRKApUNmy5bBcwHhKPeLC4Z3C5TU13iTOg
1r/FrOFJihWqXy9immTOs4PdCQ254i5hMqXiqc7aTKRXWwF2HgEzqOiameNR2TIp
eQe40aBRihCBwPmHbSXWRl6dG4sAmF7zEfQPSYFAw8JZ+IECQQDdBwqhGD5n1ID/
fO8Mjx/SZRpr0/KKuHWHHoCoxvzP2fmki+SdZwM9FY3hSg1mR6pAMUKR0t74uy1x
GU0Q5tlBAkEAysf+k/4xpggV4Lspw/3kymeP+56k944QpxYe/qTG65I/gstdBb56
4nbW5Jt1g95YRgpF9GWxG1YodsgCnE78YwJBAM/9O1Riwv7j6swA3dacrF5JQ7aq
SPefIwGWg43PSsGxJglgly5DbLnDmbKiA7/2ulATysf8flPjl5xxKaM5CMECQQCS
gtNuLA/FLTxZZgE0KWI/13mRTDtW3Z8sifAU/gr3M3CN2M86EjkJHOIAxE2w3Fod
KNkITt0aqjKMN9CjDPKPAkEAir0avr2PZSSeAxRJe2uygT4eXwZFuUazQyOOOKlp
/oygip1/2WzRiPdU+/DYOMaovTF3rYsOucurCHSmdNTBkA==",

		//编码格式
		'charset' => "UTF-8",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//应用ID
		'app_id' => "2016111502846477",

		//异步通知地址,只有扫码支付预下单可用
		'notify_url' => "http://www.baidu.com",

		//最大查询重试次数
		'MaxQueryRetry' => "10",

		//查询间隔
		'QueryDuration' => "3"
);