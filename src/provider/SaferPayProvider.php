<?php

namespace payment\provider;

use Curl\Curl;
use payment\base\Provider;
use payment\PaymentException;
use payment\base\ProviderInterface;

class SaferPayProvider extends Provider implements ProviderInterface
{
    public function getId()
    {
        return 'saferpay';
    }
    
    public function callCreate($accountId, $amount, $currency, $description, $orderId, $successLink, $failLink, $backLink, $notifyUrl)
    {
        $curl = new Curl();
        $curl->post('https://www.saferpay.com/hosting/CreatePayInit.asp', [
            'ACCOUNTID' => $accountId,
            'AMOUNT' => $amount,
            'CURRENCY' => $currency,
            'DESCRIPTION' => $description,
            'ORDERID' => $orderId,
            'SUCCESSLINK' => $successLink,
            'FAILLINK' => $failLink,
            'BACKLINK' => $backLink,
            'NOTIFYURL' => $notifyUrl,
            'AUTOCLOSE' => '0',
        ]);
        
        if (!$curl->error) {
            return $curl->response;
        }
        
        throw new PaymentException($curl->error_message);
    }
    
    public function callConfirm($data, $signature)
    {
        $curl = new Curl();
        $curl->post('https://www.saferpay.com/hosting/VerifyPayConfirm.asp', [
            'DATA' => $data,
            'SIGNATURE' => $signature,
        ]);
        
        if (!$curl->error) {
            return $curl->response;
        }
        
        throw new PaymentException("payconfirm error");
    }
    
    public function callComplete($id, $token, $amount, $action, $accountId, $spPassword = null)
    {
        $data = [
            'ID' => $id,
            'TOKEN' => $token,
            'AMOUNT' => $amount,
            'ACTION' => $action,
            'ACCOUNTID' => $accountId,
        ];
        
        if (!empty($spPassword)) {
            $data['spPassword'] = $spPassword;
        }
        
        $curl = new Curl();
        $curl->post('https://www.saferpay.com/hosting/PayCompleteV2.asp', $data);
        
        if (!$curl->error) {
            return $curl->response;
        }
        
        throw new PaymentException("payconfirm error");
    }
}