<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Iman\Error;

use Magento\Framework\App\Request\Http as Request;
use Magento\Framework\App\Response\Http as Response;
use Magento\Framework\App\Response\HttpInterface;
use Magento\Framework\Error\Processor as BaseProcessor;
use Psr\Log\LoggerInterface;

require_once BP . '/pub/errors/processor.php';

class Processor extends BaseProcessor
{

    /**
     * @var string
     */
    protected $template = 'Iman_BetterMaintenance::maintenance_page.phtml';

    /**
     * @var string
     */
    protected $countdownConfigFile = BP . '/var/.maintenance.flag';

    /**
     * @var
     */
    protected $templatePath;

    /**
     * @var
     */
    protected $requestType;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Request $request
     * @param Response $response
     * @param LoggerInterface $logger
     */
    public function __construct(
        Request         $request,
        Response        $response,
        LoggerInterface $logger
    ) {
        parent::__construct($response);
        $this->_response = $response;
        $this->logger = $logger;
    }

    /**
     * @return void
     */
    public function process()
    {
        return $this->processMaintenancePage();
    }

    /**
     * @return mixed
     */
    protected function processMaintenancePage()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $state = $objectManager->get(\Magento\Framework\App\State::class);
        $state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
        $content = $objectManager->create(\Iman\BetterMaintenance\Block\Maintenance\Page::class)->toHtml();

        return $this->response(503, $content ? $content : 'Service Temporary Unavailable');
    }

    /**
     * @param $code
     * @param $body
     * @param $type
     * @return Response|HttpInterface|void
     */
    protected function response($code, $body, $type = 'text/html')
    {
        return $this->_response
            ->setHttpResponseCode($code)
            ->setBody($body)
            ->setHeader('Content-Type', $type);
    }


    /**
     * @param $error
     * @return void
     */
    protected function logError($error)
    {
        // $this->logger->critical(' Custom Maintenance Error: ' . $error);
    }
}
