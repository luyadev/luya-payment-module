<?php

namespace luya\payment\base;

use luya\helpers\url;
use yii\base\Model;

class PayModel extends Model
{
    public $id;
    public $totalAmount;
    public $orderId;
    public $currency;
    public $successLink;
    public $abortLink;
    public $errorLink;
    public $authToken;
    public $randomKey;
    public $items = [];
    public $isClosed = 0;

    public function rules()
    {
        return [
            [['orderId', 'currency', 'successLink', 'abortLink', 'errorLink', 'totalAmount'], 'required'],
            [['totalAmount', 'isClosed', 'id'], 'integer'],
            [['authToken', 'randomKey'], 'string'],
        ];
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setAuthToken($token)
    {
        $this->authToken = $token;
    }

    public function setRandomKey($key)
    {
        $this->randomKey = $key;
    }

    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getApplicationSuccessLink()
    {
        return $this->successLink;
    }

    public function getApplicationAbortLink()
    {
        return $this->abortLink;
    }

    public function getApplicationErrorLink()
    {
        return $this->errorLink;
    }

    /**
     * Get the Payment Gateway Create link.
     *
     * This method is used to retrieve the link for dispatching to the requested url.
     *
     * @return string
     */
    public function getTransactionGatewayCreateLink()
    {
        return Url::toInternal(['/payment/default/create', 'lpToken' => $this->authToken, 'lpKey' => $this->randomKey], true);
    }
    
    /**
     * Get the Payment Gateway Back link.
     *
     * This method is used to retrieve the link for dispatching to the requested url.
     *
     * @return string
     */
    public function getTransactionGatewayBackLink()
    {
        return Url::toInternal(['/payment/default/back', 'lpToken' => $this->authToken, 'lpKey' => $this->randomKey], true);
    }
    
    /**
     * Get the Payment Gateway Fail link.
     *
     * This method is used to retrieve the link for dispatching to the requested url.
     *
     * @return string
     */
    public function getTransactionGatewayFailLink()
    {
        return Url::toInternal(['/payment/default/fail', 'lpToken' => $this->authToken, 'lpKey' => $this->randomKey], true);
    }
    
    /**
     * Get the Payment Gateway Abort link.
     *
     * This method is used to retrieve the link for dispatching to the requested url.
     *
     * @return string
     */
    public function getTransactionGatewayAbortLink()
    {
        return Url::toInternal(['/payment/default/abort', 'lpToken' => $this->authToken, 'lpKey' => $this->randomKey], true);
    }
    
    /**
     * Get the Payment Gateway Notify link.
     *
     * This method is used to retrieve the link for dispatching to the requested url.
     *
     * @return string
     */
    public function getTransactionGatewayNotifyLink()
    {
        return Url::toInternal(['/payment/default/notify', 'lpToken' => $this->authToken, 'lpKey' => $this->randomKey], true);
    }
}