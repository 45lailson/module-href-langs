<?php

namespace Href\Langs\Plugin\Frontend\Magento\Cms\Helper;

use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Framework\App\RequestInterface;
use Href\Langs\Helper\Data;

class PageCustom
{
    /**
     * @var PageConfig
     */
    protected $pageConfig;

    /**
     * @var RequestInterface
     */
    protected $_request;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * PageCustom constructor.
     * @param PageConfig $pageConfig
     * @param RequestInterface $request
     * @param Data $helper
     */
    public function __construct(
        PageConfig $pageConfig,
        RequestInterface $request,
        Data $helper
    ) {
        $this->pageConfig = $pageConfig;
        $this->_request = $request;
        $this->helper = $helper;
    }

    /**
     * @param \Magento\Cms\Helper\Page $subject
     * @param $result
     * @return mixed
     */
    public function afterPrepareResultPage(\Magento\Cms\Helper\Page $subject, $result)
    {
        // If the page is active in multiple store views
        if ($this->helper->isCmsPageMultiStore()) {
            $pageId = $this->helper->getCmsPageId(); // Get the ID of the current CMS page
            $pageUrlKey = $this->helper->getCmsPageUrlKey(); // Get the URL Key of the current CMS page

            foreach ($this->helper->getCmsPageStores() as $store) {
                $storeLanguage = $this->helper->getStoreLanguage($store);

                // Build the URL with the store view code
                $storeBaseUrl = rtrim($this->helper->getCurrentUrl(), '/'); // Remove the trailing slash from the base URL
                $storeUrl = $storeBaseUrl . '/' . $storeLanguage . '/' . $pageUrlKey;

                // Add the hreflang Meta Tag to the header
                $hreflangTag = sprintf(
                    '<link rel="alternate" hreflang="%s" href="%s">',
                    $storeLanguage,
                    $storeUrl
                );

                $this->pageConfig->addRemotePageAsset(
                    $hreflangTag,
                    'link_rel',
                    ['attributes' => 'hreflang']
                );
            }
        }

        return $result;
    }
}
