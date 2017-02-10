<?php

namespace Shopsys\ShopBundle\Model\Payment;

use Shopsys\ShopBundle\Model\Payment\PaymentEditData;
use Shopsys\ShopBundle\Model\Payment\PaymentFacade;
use Shopsys\ShopBundle\Model\Pricing\Vat\VatFacade;

class PaymentEditDataFactory
{

    /**
     * @var \Shopsys\ShopBundle\Model\Payment\PaymentFacade
     */
    private $paymentFacade;

    /**
     * @var \Shopsys\ShopBundle\Model\Pricing\Vat\VatFacade
     */
    private $vatFacade;

    public function __construct(
        PaymentFacade $paymentFacade,
        VatFacade $vatFacade
    ) {
        $this->paymentFacade = $paymentFacade;
        $this->vatFacade = $vatFacade;
    }

    /**
     * @return \Shopsys\ShopBundle\Model\Payment\PaymentEditData
     */
    public function createDefault() {
        $paymentEditData = new PaymentEditData();
        $paymentEditData->paymentData->vat = $this->vatFacade->getDefaultVat();

        return $paymentEditData;
    }

    /**
     * @param \Shopsys\ShopBundle\Model\Payment\Payment $payment
     * @return \Shopsys\ShopBundle\Model\Payment\PaymentEditData
     */
    public function createFromPayment(Payment $payment) {
        $paymentEditData = new PaymentEditData();
        $paymentData = new PaymentData();
        $paymentData->setFromEntity($payment, $this->paymentFacade->getPaymentDomainsByPayment($payment));
        $paymentEditData->paymentData = $paymentData;

        foreach ($payment->getPrices() as $paymentPrice) {
            $paymentEditData->prices[$paymentPrice->getCurrency()->getId()] = $paymentPrice->getPrice();
        }

        return $paymentEditData;
    }
}
