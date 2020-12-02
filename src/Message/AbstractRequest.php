<?php
declare(strict_types=1);

namespace Omnipay\TwoCheckout\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Get the account.
     *
     * @return string account
     */
    public function getAccount()
    {
        return $this->getParameter('account');
    }

    /**
     * Set the account.
     *
     * @param string $purse account
     *
     * @return self
     */
    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    /**
     * Get the secret key.
     *
     * @return string secret key
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set the secret key.
     *
     * @param string $key secret key
     *
     * @return self
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * Get the request return URL.
     *
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    /**
     * Sets the request return URL.
     *
     * @param string $value
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }
}
