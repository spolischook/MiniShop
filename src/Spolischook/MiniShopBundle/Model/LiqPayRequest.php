<?php

namespace Spolischook\MiniShopBundle\Model;

class LiqPayRequest
{
    public $publicKey;
    public $amount;
    public $currency;
//    public $description;
    public $type = 'buy';
    public $payWay = 'card,delayed';
    public $serverUrl;
    public $orderId;
    public $language;
}
