<?php
declare(strict_types=1);

namespace Omnipay\TwoCheckout\Tests\unit\Message;

use Omnipay\Tests\TestCase;
use Omnipay\TwoCheckout\Message\CompletePurchaseRequest;
use Omnipay\TwoCheckout\Message\CompletePurchaseResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CompletePurchaseRequestTest extends TestCase
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

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertArrayHasKey('sale_id', $data);
        $this->assertArrayHasKey('list_currency', $data);
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);

        $this->assertInstanceOf(CompletePurchaseResponse::class, $response);
    }
}
