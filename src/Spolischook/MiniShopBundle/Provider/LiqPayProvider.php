<?php

namespace Spolischook\MiniShopBundle\Provider;

use Spolischook\MiniShopBundle\Entity\Order;
use Spolischook\MiniShopBundle\Model\LiqPayRequest;

class LiqPayProvider
{
    const ACTION = 'https://www.liqpay.com/api/pay';

    protected $publicKey;

    protected $payWay;

    protected $serverUrl;

    protected $language;

    public function __construct($publicKey, $payWay, $serverUrl, $language)
    {
        $this->publicKey = $publicKey;
        $this->payWay    = $payWay;
        $this->serverUrl = $serverUrl;
        $this->language  = $language == 'ru' ? 'ru' : 'en';
    }

    public function getResponse(Order $order)
    {
        $liqPayRequest = new LiqPayRequest();

        $liqPayRequest->publicKey = $this->publicKey;
        $liqPayRequest->amount    = $order->getAmount();
        $liqPayRequest->currency  = $order->getCurrency();
//        $liqPayRequest->description = '';
        $liqPayRequest->payWay    = $this->payWay;
        $liqPayRequest->serverUrl = $this->serverUrl;
        $liqPayRequest->orderId   = $order->getId();
        $liqPayRequest->language  =$this->language;
    }
}
