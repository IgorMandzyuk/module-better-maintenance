<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

require_once 'processorFactory.php';
$processorFactory = new \Im\Error\ProcessorFactory;
$processor = $processorFactory->createProcessor();
$response = $processor->process();
$response->sendResponse();
