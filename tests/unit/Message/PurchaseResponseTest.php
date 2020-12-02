<?php
declare(strict_types=1);

namespace Omnipay\TwoCheckout\Tests\unit\Message;

use Omnipay\Tests\TestCase;
use Omnipay\TwoCheckout\Message\PurchaseRequest;
use Omnipay\TwoCheckout\Message\PurchaseResponse;

class PurchaseResponseTest extends TestCase
{
    public function testSuccess()
    {
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize([
            'account' => $account = '10314',
            'secretKey' => $secretKey = 'somethingRandom',
            'transactionId' => $transactionId = md5(random_bytes(5)),
            'amount' => $amount = '42.00',
            'returnUrl' => $returnUrl = 'https://example.com/return',
            'description' => $description = 'A test payment',
        ]);
        $response = $request->send();
        $this->assertInstanceOf(PurchaseResponse::class, $response);

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('GET', $response->getRedirectMethod());
        $this->assertStringStartsWith('https://www.2checkout.com/checkout/purchase?', $response->getRedirectUrl());

        $queryString = parse_url($response->getRedirectUrl(), PHP_URL_QUERY);
        parse_str($queryString, $query);

        $this->assertSame([
            'x_receipt_link_url' => $returnUrl,
            'sid' => $account,
            'total' => $amount,
            'merchant_order_id' => $description,
            'cart_order_id' => $transactionId,
            'id_type' => '1',
        ], $query);
    }
}
