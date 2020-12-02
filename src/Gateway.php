<?php
declare(strict_types=1);

namespace Omnipay\TwoCheckout;

use Omnipay\Common\AbstractGateway;
use Omnipay\TwoCheckout\Message\CompletePurchaseRequest;
use Omnipay\TwoCheckout\Message\PurchaseRequest;

/**
 * Gateway for 2Checkout.
 */
class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '2Checkout';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [
            'account' => '',
            'secretKey'  => '',
        ];
    }

    /**
     * Get the unified account number.
     *
     * @return string merchant account
     */
    public function getAccount()
    {
        return $this->getParameter('account');
    }

    /**
     * Set the unified account.
     *
     * @param string $purse merchant account
     *
     * @return self
     */
    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    /**
     * Get the unified secret key.
     *
     * @return string secret key
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set the unified secret key.
     *
     * @param string $value secret key
     *
     * @return self
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * @param array $parameters
     *
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = []): PurchaseRequest
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = []): CompletePurchaseRequest
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }
}
