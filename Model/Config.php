<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Iman\BetterMaintenance\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    /** @var ScopeConfigInterface */
    protected $scopeConfig;

    /**
     * @var null
     */
    protected $storeId = null;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return mixed
     */
    public function getLogoUrl()
    {
        return $this->config('maintenance/logo');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (string)$this->config('maintenance/title');
    }

    /**
     * @return string
     */
    public function getCopyright()
    {
        return (string)$this->config('maintenance/copyright');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->config('maintenance/description');
    }

    /**
     * @return bool
     */
    public function isUseCustomBlock()
    {
        return (bool)$this->config('maintenance/use_block');
    }

    /**
     * @return string
     */
    public function getCustomBlockIdentifier()
    {
        return (string)$this->config('maintenance/custom_cms_block');
    }

    public function enabled(){
        return (bool)$this->config('general/enabled');
    }

    protected function config($code)
    {
        return $this->scopeConfig->getValue("iman_maintenance/{$code}", ScopeInterface::SCOPE_STORE, $this->storeId);
    }
}
