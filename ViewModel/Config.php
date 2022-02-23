<?php

namespace Spirit\FacebookPixel\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ArgumentInterface
{
    const CONFIG_NAMESPACE = 'spirit_facebook_pixel';

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @return boolean
     */
    public function getIsActive(): bool
    {
        return $this->getConfig('general/status') && !empty($this->getConfig('general/pixel_id')) ?? false;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getConfig(string $key)
    {
        return $this->_scopeConfig->getValue(
            self::CONFIG_NAMESPACE . "/$key",
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getPixelID(): string
    {
        return $this->getConfig('general/pixel_id') ?? '';
    }

    /**
     * @return boolean
     */
    public function getIsAddToCartActive(): bool
    {
        return $this->getConfig('settings/add_to_cart') ?? false;
    }

    /**
     * @return boolean
     */
    public function getIsAddToCartListActive(): bool
    {
        return $this->getConfig('settings/add_to_cart_list') ?? false;
    }

    /**
     * @return string
     */
    public function getAddToCartListProductSelector(): string
    {
        return $this->getConfig('general/add_to_cart_list_product_selector') ?? '.product-item-info';
    }

    /**
     * @return string
     */
    public function getAddToCartListButtonSelector(): string
    {
        return $this->getConfig('general/add_to_cart_list_button_selector') ?? '.action.tocart';
    }

    /**
     * @return string
     */
    public function getAddToCartListPriceSelector(): string
    {
        return $this->getConfig('general/add_to_cart_list_price_selector') ?? '[data-price-type="finalPrice"]';
    }

    /**
     * @return boolean
     */
    public function getIsViewCategoryActive(): bool
    {
        return $this->getConfig('settings/view_category') ?? false;
    }

    /**
     * @return boolean
     */
    public function getIsViewContentActive(): bool
    {
        return $this->getConfig('settings/view_content') ?? false;
    }

    /**
     * @return boolean
     */
    public function getIsSearchActive(): bool
    {
        return $this->getConfig('settings/search') ?? false;
    }

    /**
     * @return boolean
     */
    public function getIsInitiateCheckoutActive(): bool
    {
        return $this->getConfig('settings/initiate_checkout') ?? false;
    }

    /**
     * @return boolean
     */
    public function getIsPurchaseActive(): bool
    {
        return $this->getConfig('settings/purchase') ?? false;
    }
}
