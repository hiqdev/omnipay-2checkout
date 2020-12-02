<?php /** @noinspection StaticInvocationViaThisInspection */
declare(strict_types=1);

namespace Omnipay\TwoCheckout\Tests\unit\Message;

use Omnipay\Tests\TestCase;
use Omnipay\TwoCheckout\Message\PurchaseRequest;
use Omnipay\TwoCheckout\Message\PurchaseResponse;

class PurchaseRequestTest extends TestCase
{
    private function createRequest()
    {
        return new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetData()
    {
        $request = $this->createRequest()->initialize([
            'account' => $account = '10314',
            'secretKey' => $secretKey = 'somethingRandom',
            'transactionId' => $transactionId = md5(random_bytes(5)),
            'amount' => $amount = '42.00',
            'returnUrl' => $returnUrl = 'https://example.com/return',
            'description' => $description = 'A test payment',
        ]);

        $data = $request->getData();

        $this->assertSame($account, $data['sid']);
        $this->assertSame($transactionId, $data['cart_order_id']);
        $this->assertSame($returnUrl, $data['x_receipt_link_url']);
        $this->assertSame($amount, $data['total']);
        $this->assertSame($description, $data['merchant_order_id']);
        $this->assertSame(1, $data['id_type']);
    }

    public function testSendData()
    {
        $request = $this->createRequest()->initialize([
            'account' => $account = '10314',
            'secretKey' => $secretKey = 'somethingRandom',
            'transactionId' => $transactionId = md5(random_bytes(5)),
            'amount' => $amount = '42.00',
        ]);
        $data = $request->getData();
        $response = $request->sendData($data);

        $this->assertInstanceOf(PurchaseResponse::class, $response);
    }
}
