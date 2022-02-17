<?php

namespace Spirit\FacebookPixel\Block;

use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;

class Success extends Template
{
    /**
     * @var Session
     */
    protected $_checkoutSession;

    /**
     * @var OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var Product
     */
    protected $_product;

    /**
     * @var Order
     */
    protected $_order;

    /**
     * Success constructor.
     *
     * @param Session $checkoutSession
     * @param OrderFactory $orderFactory
     * @param Product $product
     * @param Context $context
     */
    public function __construct(
        Session $checkoutSession,
        OrderFactory $orderFactory,
        Product $product,
        Context $context
    ) {
        $this->_checkoutSession = $checkoutSession;
        $this->_orderFactory    = $orderFactory;
        $this->_product         = $product;

        $increment_id = $this->_checkoutSession->getLastRealOrderId();
        if ($increment_id) {
            $this->_order = $this->_orderFactory->create()->loadByIncrementId($increment_id);
        }
        //        $this->_order = $this->_orderFactory->create()->loadByIncrementId( '2000000063' );

        parent::__construct($context);
    }

    /**
     * @return false|float|string|null
     */
    public function geCurrencyCode()
    {
        return $this->_order ? $this->_order->getOrderCurrencyCode() : false;
    }

    /**
     * @return integer|boolean
     */
    public function getOrderId()
    {
        return $this->_order ? $this->_order->getId() : false;
    }

    /**
     * @return integer|boolean
     */
    public function getOrderIncrementId()
    {
        return $this->_order ? $this->_order->getIncrementId() : false;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        if (! $this->_order) {
            return 0;
        }

        return number_format($this->_order->getSubtotalInclTax() + $this->_order->getShippingInclTax(), 2);
    }

    /**
     * @return float
     */
    public function getShippingCost(): float
    {
        if (! $this->_order) {
            return 0;
        }

        return number_format($this->_order->getShippingInclTax(), 2);
    }

    /**
     * @return float
     */
    public function getTaxAmount(): float
    {
        if (! $this->_order) {
            return 0;
        }

        return number_format($this->_order->getTaxAmount(), 2);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->_order ? $this->_order->getAllVisibleItems() : [];
    }

    /**
     * @return float|int
     */
    public function getSuccessItemsCount()
    {
        $numItems = 0;
        $items = $this->_order ? $this->_order->getAllVisibleItems()  : false;
        foreach ($items as $item) {
            $numItems += $item->getQtyOrdered();
        }
        return $numItems;
    }
}
