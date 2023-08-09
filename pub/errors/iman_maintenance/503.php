<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

require_once 'processorFactory.php';
$processorFactory = new \Iman\Error\ProcessorFactory;
$processor = $processorFactory->createProcessor();
$response = $processor->process();
$response->sendResponse();
