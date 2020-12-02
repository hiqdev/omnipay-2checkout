<?php
declare(strict_types=1);

namespace Omnipay\TwoCheckout\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate(
            'account', 'amount', 'transactionId'
        );

        return [
            'x_receipt_link_url' => $this->getReturnUrl(),
            'sid' => $this->getAccount(),
            'total' => $this->getAmount(),
            'merchant_order_id' => $this->getDescription(),
            'cart_order_id' => $this->getTransactionId(),
            'id_type' => 1,
        ];
    }


    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
