<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Im\Installer\Setup;

use Im\Installer\Model\Maintenance;
use Magento\Framework\App\State;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Filesystem\Io\File;

class InstallData implements InstallDataInterface
{
    /**
     * @var Maintenance
     */
    protected $maintenance;

    /**
     * @var State
     */
    protected $appState;

    /**
     * @var File
     */
    private $file;

    /**
     * @param Maintenance $maintenance
     * @param State $appState
     * @param File $file
     */
    public function __construct(
        Maintenance $maintenance,
        State $appState,
        File $file
    ) {
        $this->maintenance = $maintenance;
        $this->appState = $appState;
        $this->file = $file;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Exception
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface   $context
    ) {
        $this->appState->emulateAreaCode('frontend', function () {
            $this->maintenance->rebuild();
        });
    }
}
