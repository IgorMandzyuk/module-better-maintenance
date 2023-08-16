<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Iman\BetterMaintenance\Plugin\App;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\Http as HttpApp;
use Magento\Framework\Filesystem;
use Psr\Log\LoggerInterface;
use Iman\BetterMaintenance\Model\Config;
class Http
{
    const MAINTENANCE_PAGE_PATH = 'errors/iman_maintenance/503.php';

    /** @var Filesystem */
    protected $filesystem;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @var Config
     */
    private  $config;

    /**
     * @param Filesystem $filesystem
     * @param LoggerInterface $logger
     */
    public function __construct(
        Filesystem      $filesystem,
        LoggerInterface $logger,
        Config $config
    ) {
        $this->filesystem = $filesystem;
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * @param HttpApp $httpApp
     * @param \Closure $proceed
     * @param Bootstrap $bootstrap
     * @param \Exception $exception
     * @return mixed|true
     */
    public function aroundCatchException(HttpApp $httpApp, \Closure $proceed, Bootstrap $bootstrap, \Exception $exception)
    {
        if (Bootstrap::ERR_MAINTENANCE == $bootstrap->getErrorCode() && $this->config->enabled()) {
            $pubDirectory = $this->filesystem->getDirectoryRead(DirectoryList::PUB);
            $maintenanceEntry = $pubDirectory->getAbsolutePath(self::MAINTENANCE_PAGE_PATH);

            if ($pubDirectory->isExist(self::MAINTENANCE_PAGE_PATH)) {
                require $maintenanceEntry;
                return true;
            } else {
                $this->logger->error('Cannot find file ' . $maintenanceEntry);
            }
        }

        return $proceed($bootstrap, $exception);
    }
}
