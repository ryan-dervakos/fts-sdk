<?php

namespace Epignosis\Logger\Abstraction;

use Epignosis\Logger\Failure\Logger as LoggerException;

/**
 * Interface LoggerInterface
 *
 * The logger interface.
 *
 * @author      Haris Batsis <xarhsdev@efrontlearning.com>
 * @category    Epignosis\Logger\Abstraction
 * @copyright   Epignosis LLC (c) Copyright 2017, All Rights Reserved
 * @package     Epignosis\Logger\Abstraction
 * @since       1.0.0-dev
 */
interface LoggerInterface
{
  /**
   * Clears the log.
   *
   * @return  LoggerInterface
   *
   * @since   1.0.0-dev
   *
   * @throws  LoggerException
   *            - In case that is not possible to clear the log.
   */
  public function ClearLog();

  /**
   * Returns the log.
   *
   * @return  array
   *
   * @since   1.0.0-dev
   *
   * @throws  LoggerException
   *            - In case that is not possible to return the log.
   */
  public function GetLog();

  /**
   * Logs the requested data.
   *
   * @param   array $data
   *            - The data to be logged. (Required)
   *
   * @param   bool $success
   *            - Whether it is a successful log message, or not. (Optional, true)
   *
   * @param   bool $sensitive
   *            - Whether the requested data are sensitive, or not. (Optional, false)
   *
   * @return  LoggerInterface
   *
   * @since   1.0.0-dev
   *
   * @throws  LoggerException
   *            - In case that is not possible to log the requested information.
   */
  public function Log(array $data, $success = true, $sensitive = false);
}