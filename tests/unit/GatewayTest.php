<?php
declare(strict_types=1);

namespace Omnipay\TwoCheckout\Tests\unit;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\Tests\TestCase;
use Omnipay\TwoCheckout\Gateway;

class GatewayTest extends TestCase
{
    /** @var Gateway */
    public $gateway;

    private $account        = '54401';
    private $secretKey      = 'someRandomSecret';

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway();
        $this->gateway->setAccount($this->account);
        $this->gateway->setSecretKey($this->secretKey);
    }

    public function testGateway()
    {
        $this->assertSame($this->account,     $this->gateway->getAccount());
        $this->assertSame($this->secretKey,   $this->gateway->getSecretKey());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase([
            'transactionId' => $transactionId = md5(random_bytes(5)),
            'amount' => $amount = '42.00',
            'returnUrl' => 'https://example.com/return'
        ]);

        $this->assertSame($this->account, $request->getAccount());
        $this->assertSame($this->secretKey, $request->getSecretKey());
        $this->assertSame($transactionId, $request->getTransactionId());
        $this->assertSame($amount, $request->getAmount());
    }
}
