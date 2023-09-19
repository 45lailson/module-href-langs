<?php

namespace Href\Langs\Helper;

use Magento\Cms\Model\Page;
use Magento\Framework\Locale\Resolver;
use Magento\Framework\View\Element\Template;

class Data
{
    /**
     * @var Resolver
     */
    protected $_locale;

    /**
     * @var Page
     */
    protected $_cmsPage;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Data constructor.
     * @param Resolver $locale
     * @param Page $cmsPage
     * @param Template\Context $context
     */
    public function __construct(
        Resolver $locale,
        Page $cmsPage,
        Template\Context $context

    ) {
        $this->_locale = $locale;
        $this->_cmsPage = $cmsPage;
        $this->_storeManager = $context->getStoreManager();

    }

    /**
     * Obter a localidade e converter o formato country-lang
     * @return string
     */
    public function getLanguageStore()
    {
        return strtolower(str_replace("_", "-", $this->_locale->getLocale()));
    }

    /**
     * Verificar se a página CMS está ativa em várias store views
     * @return bool
     */
    public function isCmsPageMultiStore()
    {
        $storesCms = $this->_cmsPage->getStores();
        return count($storesCms) > 1;
    }

    /**
     * Obter o ID da página CMS atual
     *
     * @return int|null
     */
    public function getCmsPageId()
    {
        return $this->_cmsPage->getId();
    }

    /**
     * Obter a URL Key da página CMS atual
     *
     * @return string|null
     */
    public function getCmsPageUrlKey()
    {
        return $this->_cmsPage->getIdentifier();
    }

    /**
     * Obter as store-views associadas à página CMS atual
     *
     * @return array
     */
    public function getCmsPageStores()
    {
        return $this->_cmsPage->getStores();
    }

    /**
     * @param $store
     * @return string
     */
    public function getStoreLanguage($store)
    {
        return strtolower(str_replace("_", "-", $this->_locale->getLocale()));
    }

    /**
     * Obter a URL completa da página CMS atual
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrentUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl() . $this->_cmsPage->getIdentifier();
    }
}
