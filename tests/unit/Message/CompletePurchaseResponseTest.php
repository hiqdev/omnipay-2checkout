<?php

declare(strict_types=1);

namespace Omnipay\TwoCheckout\Tests\unit\Message;

use DateTimeImmutable;
use Omnipay\Tests\TestCase;
use Omnipay\TwoCheckout\Message\CompletePurchaseRequest;
use Omnipay\TwoCheckout\Message\CompletePurchaseResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CompletePurchaseResponseTest extends TestCase
{
    private CompletePurchaseRequest $request;

    public function setUp()
    {
        parent::setUp();

        $stub = file_get_contents(__DIR__ . '/../Stub/CompletePurchaseRequestStub.txt');
        parse_str($stub, $requestArray);
        $httpRequest = new HttpRequest([], $requestArray);

        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);

        $this->request->initialize([
            'account' => $account = '10070',
            'secretKey' => $secretKey = 'somethingRandom',
        ]);
    }

    public function testSuccess()
    {
        $data = $this->request->getData();

        $response = new CompletePurchaseResponse($this->request, $data);

        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getCode());

        $this->assertSame($data['vendor_order_id'], $response->getTransactionId());
        $this->assertSame($data['sale_id'], $response->getTransactionReference());
        $this->assertSame($data['invoice_list_amount'], $response->getAmount());
        $this->assertSame($data['list_currency'], $response->getCurrency());
        $this->assertEquals(
            new DateTimeImmutable('@' . strtotime($data['sale_date_placed'])),
            $response->getPayTime()
        );
        $this->assertNotEmpty($response->getPayer());
    }
}
