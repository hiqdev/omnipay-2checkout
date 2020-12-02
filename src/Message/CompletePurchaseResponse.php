<?php
declare(strict_types=1);

namespace Omnipay\TwoCheckout\Message;

use DateTimeImmutable;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class CompletePurchaseResponse extends AbstractResponse
{
    /** @var RequestInterface|CompletePurchaseRequest */
    protected $request;

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        if (strtolower($this->getSignatureValue()) !== $this->generateSignature()) {
            throw new InvalidResponseException('Invalid hash ' . strtoupper($this->generateSignature()));
        }
    }

    public function generateSignature()
    {
        $params = [
            $this->getTransactionReference(),
            $this->request->getAccount(),
            $this->request->getTransactionId(),
            $this->request->getSecretKey()
        ];

        return md5(implode('', $params));
    }

    public function getSignatureValue()
    {
        return $this->data['md5_hash'];
    }

    public function getCurrency()
    {
        return $this->data['list_currency'];
    }

    public function getAmount()
    {
        return $this->data['invoice_list_amount'];
    }

    public function getPayer()
    {
        return $this->data['customer_name'] . '/' . $this->data['customer_email'];
    }

    public function getTransactionId()
    {
        return $this->data['vendor_order_id'];
    }

    public function getTransactionReference()
    {
        return $this->data['sale_id'];
    }

    public function getPayTime()
    {
        return new DateTimeImmutable('@' . strtotime($this->data['sale_date_placed']));
    }

    public function isSuccessful()
    {
        return true;
    }
}
