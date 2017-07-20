<?php

namespace Epignosis\Factory\Failure;

/**
 * Class Logger
 *
 * The logger factory exception.
 *
 * @author      Haris Batsis <xarhsdev@efrontlearning.com>
 * @category    Epignosis\Factory\Failure
 * @copyright   Epignosis LLC (c) Copyright 2017, All Rights Reserved
 * @package     Epignosis\Factory\Failure
 * @since       1.0.0-dev
 */
class Logger extends Factory
{
  /**
   * Used in case that is not possible to create an instance of the requested logger
   * adapter.
   *
   * @since   1.0.0-dev
   * @var     int
   */
  const FACTORY_LOGGER_FAILURE = 1;


  /**
   * Logger constructor.
   *
   * @param   int $code
   *            - The failure code. (Required)
   *
   * @param   \Exception|null $exception
   *            - The previous exception (if any), used for the exception chaining.
   *              (Optional, null)
   *
   * @param   array $additionalFailureInformation
   *            - The additional failure information. (Optional, [])
   *
   * @since   1.0.0-dev
   */
  public function __construct (
               $code,
    \Exception $exception = null,
         array $additionalFailureInformation = [])
  {
    $this->_timestamp = time();

    self::$_failureMessageList[self::FACTORY_LOGGER_FAILURE] = 'FACTORY_LOGGER_FAILURE';

    $this->_additionalFailureInformation = $additionalFailureInformation;

    parent::__construct($this->GetFailureMessage($code), $code, $exception);
  }
}