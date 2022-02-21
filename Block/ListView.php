<?php


namespace Spirit\FacebookPixel\Block;

class ListView extends \Magento\Framework\View\Element\Template
{
    /**
     * @return \Magento\Eav\Model\Entity\Collection\AbstractCollection|null
     */
    public function getProductCollection()
    {
        /** @var \Magento\Catalog\Block\Product\ListProduct $categoryProductListBlock */
        $categoryProductListBlock = $this->_layout->getBlock('category.products.list');

        if (empty($categoryProductListBlock)) {
            return [];
        }

        $categoryProductListBlock->toHtml();
        // Fetch the current collection from the block and set pagination
        $collection = $categoryProductListBlock->getLoadedProductCollection();
        $collection->setCurPage($this->getCurrentPage())->setPageSize($this->getLimit());

        return $collection;
    }

    /**
     * @return int
     */
    protected function getLimit()
    {
        /** @var \Magento\Catalog\Block\Product\ProductList\Toolbar $productListBlockToolbar */
        $productListBlockToolbar = $this->_layout->getBlock('product_list_toolbar');
        if (empty($productListBlockToolbar)) {
            return 9;
        }

        return (int)$productListBlockToolbar->getLimit();
    }

    /**
     * @return int
     */
    protected function getCurrentPage()
    {
        $page = (int)$this->_request->getParam('p');
        if (!$page) {
            return 1;
        }

        return $page;
    }

    public function getJsonProductCollection()
    {
        /** @var \Magento\Catalog\Block\Product\ListProduct $categoryProductListBlock */
        $categoryProductListBlock = $this->_layout->getBlock('category.products.list');

        if (empty($categoryProductListBlock)) {
            return [];
        }

        $categoryProductListBlock->toHtml();
        // Fetch the current collection from the block and set pagination
        $collection = $categoryProductListBlock->getLoadedProductCollection();
        $collection->setCurPage($this->getCurrentPage())->setPageSize($this->getLimit());
        $category = $categoryProductListBlock->getLayer()->getCurrentCategory();
        $productsJsonArray = [];
        foreach ($collection as $product) {

            $data = [];
            $data['content_ids'] = $product->getSku();
            $data['content_name'] = $product->getName();
            $data['content_category'] = $category->getName();
            $data['currency'] = 'EUR';
            $data['value'] = number_format($product->getPriceInfo()->getPrice('final_price')->getValue(), 2, '.', '');

            $productsJsonArray[] = $data;

        }

        return json_encode($productsJsonArray, JSON_UNESCAPED_UNICODE);
    }
}
