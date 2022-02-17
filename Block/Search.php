<?php


namespace Spirit\FacebookPixel\Block;


class Search extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getSearchQuery()
    {
        return htmlspecialchars(
            $this->getRequest()->getParam('q'),
            ENT_QUOTES,
            'UTF-8'
        );
    }
}

