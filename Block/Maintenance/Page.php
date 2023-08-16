<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Iman\BetterMaintenance\Block\Maintenance;

use Iman\BetterMaintenance\Model\Config;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cms\Block\Block;
class Page extends Template
{
    /** @var Config */
    protected $config;

    public function __construct(
        Config  $config,
        Context $context,
        array   $data = []
    ) {
        $this->setTemplate('Iman_BetterMaintenance::maintenance_page.phtml');
        $this->config = $config;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->config->getLogoUrl();
    }

    public function getCopyright()
    {
        return $this->config->getCopyright();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->config->getTitle();
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->config->getDescription();
    }

    /**
     * @return mixed
     */
    public function _toHtml()
    {
        if (!$this->config->enabled()){
            return '';
        }

        $html = parent::_toHtml();
        if ($this->config->isUseCustomBlock() && $this->config->getCustomBlockIdentifier()){
            $cmsBlock = $this->getLayout()->createBlock(Block::class);
            $html = $cmsBlock->setBlockId($this->config->getCustomBlockIdentifier())->toHtml();
        }

        return $html;
    }
}
