<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Iman\Error;

use Magento\Framework\App\Bootstrap;

require_once BP . '/app/bootstrap.php';
require_once BP . '/pub/errors/processor.php';
require_once BP . '/pub/errors/iman_maintenance/processor.php';

class ProcessorFactory
{
    /**
     * @return Processor
     */
    public function createProcessor()
    {
        $objectManagerFactory = Bootstrap::createObjectManagerFactory(BP, $_SERVER);
        $objectManager = $objectManagerFactory->create($_SERVER);
        $request = $objectManager->create(\Magento\Framework\App\Request\Http::class);
        $response = $objectManager->create(\Magento\Framework\App\Response\Http::class);
        $logger = $objectManager->create(\Psr\Log\LoggerInterface::class);

        return new Processor($request, $response, $logger);
    }
}
