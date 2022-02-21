<?php


namespace Spirit\FacebookPixel\Block;

class Search extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getSearchQuery()
    {
        return $this->_escaper->escapeHtml($this->getRequest()->getParam('q'));
    }
}
