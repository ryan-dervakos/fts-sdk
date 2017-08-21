<?php

namespace Epignosis\Abstraction;

use Epignosis\Auth\Abstraction\AuthInterface;
use Epignosis\Client\Abstraction\ClientInterface;
use Epignosis\Server\Abstraction\ServerInterface;
use Epignosis\Factory\Auth as AuthFactory;
use Epignosis\Factory\Client as ClientFactory;
use Epignosis\Factory\Server as ServerFactory;
use Epignosis\Failure\Sdk as SdkException;

/**
 * Abstract Class AbstractSdk
 *
 * The abstract SDK class.
 *
 * @author      Haris Batsis <xarhsdev@efrontlearning.com>
 * @category    Epignosis\Abstraction
 * @copyright   Epignosis LLC (c) Copyright 2017, All Rights Reserved
 * @package     Epignosis\Abstraction
 * @since       1.0.0-dev
 */
abstract class AbstractSdk
{
  /**
   * The auth factory.
   *
   * @default null
   * @since   1.0.0-dev
   * @var     AuthFactory
   */
  private $_authFactory = null;

  /**
   * The client factory.
   *
   * @default null
   * @since   1.0.0-dev
   * @var     ClientFactory
   */
  private $_clientFactory = null;

  /**
   * The configuration.
   *
   * @default []
   * @since   1.0.0-dev
   * @var     array
   */
  private $_configuration = [];

  /**
   * The server factory.
   *
   * @default null
   * @since   1.0.0-dev
   * @var     ServerFactory
   */
  private $_serverFactory = null;


  /**
   * Returns the configuration of the full-text search document SDK and its service.
   *
   * @return  array
   *
   * @since   1.0.0-dev
   */
  abstract protected function _GetConfigurationSdkService();

  /**
   * Returns the "Accept" header.
   *
   * @return  string
   *
   * @since   1.0.0-dev
   */
  private function _GetAcceptHeader()
  {
    return sprintf (
      $this->_configuration['Private']['Service']['HeaderList']['Accept'],
      (int) $this->_configuration['Public']['Service']['Version'],
      strtolower($this->_configuration['Public']['Service']['Format'])
    );
  }

  /**
   * Returns the "Accept-Language" header.
   *
   * @return  string
   *
   * @since   1.0.0-dev
   */
  private function _GetAcceptLanguageHeader()
  {
    $language = explode('-', $this->_configuration['Public']['Service']['Language']);

    return sprintf (
      '%s-%s', strtolower($language[0]), strtoupper($language[1])
    );
  }

  /**
   * Returns the auth interface.
   *
   * @return  AuthInterface
   *
   * @since   1.0.0-dev
   *
   * @throws  SdkException
   *            - In case that is not possible to return the auth interface.
   */
  private function _GetAuthInterface()
  {
    try {
      return $this->_authFactory->GetCached (
        'Signature', $this->_configuration['Private']['Service']['Auth']
      );
    } catch (\Exception $exception) {
      throw new SdkException (
        SdkException::SDK_GET_AUTH_INTERFACE_FAILURE, $exception
      );
    }
  }

  /**
   * Returns the client interface configuration.
   *
   * @return  array
   *
   * @since   1.0.0-dev
   */
  private function _GetClientInterfaceConfiguration()
  {
    return
      (array) $this->_configuration['Public']['Client'] +
      (array) $this->_configuration['Private']['Sdk']['Client'];
  }

  /**
   * Returns the server interface.
   *
   * @return  ServerInterface
   *
   * @since   1.0.0-dev
   *
   * @throws  SdkException
   *            - In case that is not possible to return the server interface.
   */
  private function _GetServerInterface()
  {
    try {
      return $this->_serverFactory->GetCached('Http');
    } catch (\Exception $exception) {
      throw new SdkException (
        SdkException::SDK_GET_SERVER_INTERFACE_FAILURE, $exception
      );
    }
  }

  /**
   * Returns the end-point of the requested service action.
   *
   * @param   string $action
   *            - The action to return its end-point. (Required)
   *
   * @param   array $data
   *            - The data of the requested action. (Required)
   *
   * @param   bool $multiplicity
   *            - Whether the action concerns multiple operations, or not.
   *              (Optional, false)
   *
   * @return  string
   *
   * @since   1.0.0-dev
   */
  private function _GetServiceActionEndPoint($action, array $data, $multiplicity = false)
  {
    $serviceConfiguration = $this->_configuration['Private']['Service'];

    if ($multiplicity) {
      return rtrim($serviceConfiguration['BaseEndPoint']['Multiple'], '/');
    }

    $baseEndPoint = rtrim($serviceConfiguration['BaseEndPoint']['Single'], '/');

    $actionEndPointParameterList =
      $this->_configuration['Private']['Service']['ActionList'][$action]['EndPoint'];

    $actionEndPoint = null;

    foreach ($actionEndPointParameterList as $key => $value) {
      if ('Id' === $key) {
        $actionEndPoint .= '/';

        foreach ($value as $_value) {
          if (!empty($data[$key][$_value])) {
            $actionEndPoint .= $data[$key][$_value] . '-';
          }
        }

        $actionEndPoint = rtrim($actionEndPoint, '-');
      } else {
        $actionEndPoint .= '/' . $data[$value];
      }
    }

    return null == $actionEndPoint ? $baseEndPoint : $baseEndPoint . $actionEndPoint;
  }

  /**
   * Returns whether the requested service action requires authentication, or not.
   *
   * @param   string $action
   *            - The action to return its auth requirement. (Required)
   *
   * @return  bool
   *
   * @since   1.0.0-dev
   */
  private function _ServiceActionRequiresAuth($action)
  {
    $serviceConfiguration = $this->_configuration['Private']['Service'];

    if (isset($serviceConfiguration['ActionList'][$action]['Auth']['Status'])) {
      return (bool) $serviceConfiguration['ActionList'][$action]['Auth']['Status'];
    }

    return $serviceConfiguration['Auth']['Status'];
  }

  /**
   * Returns the client interface.
   *
   * @return  ClientInterface
   *
   * @since   1.0.0-dev
   *
   * @throws  SdkException
   *            - In case that is not possible to return the client interface.
   */
  protected function _GetClientInterface()
  {
    try {
      return $this->_clientFactory->GetCached (
        'Http', $this->_GetClientInterfaceConfiguration()
      );
    } catch (\Exception $exception) {
      throw new SdkException (
        SdkException::SDK_GET_CLIENT_INTERFACE_FAILURE, $exception
      );
    }
  }

  /**
   * Returns the configuration of the requested service action.
   *
   * @param   string $action
   *            - The action to return its configuration. (Required)
   *
   * @param   array $data
   *            - The data of the requested action. (Required)
   *
   * @param   bool $multiple
   *            - Whether it is a multiple action, or not. (Optional, false)
   *
   * @return  array
   *
   * @since   1.0.0-dev
   */
  protected function _GetConfigurationServiceAction (
          $action,
    array $data,
          $multiple = false)
  {
    $configuration = [
      'HeaderList' => [
        'Accept' => $this->_GetAcceptHeader(),
        'Accept-Language' => $this->_GetAcceptLanguageHeader(),

        'FTS-AGENT' => sprintf (
          'FTS_PHP_SDK/v%s', $this->_configuration['Private']['Sdk']['Version']
        ),

        'FTS-ENDPOINT' => $this->_GetServiceActionEndPoint (
          $action, $data, $multiple
        ),

        'FTS-TIMESTAMP' => time()
      ]
    ];

    $actionConfiguration =
      $this->_configuration['Private']['Service']['ActionList'][$action];

    if (!$multiple) {
      foreach ($actionConfiguration['EndPoint'] as $key => $value) {
        if ('Id' === $key) {
          unset($data[$key]);
        } else {
          unset($data[$value]);
        }
      }
    }

    if ($this->_ServiceActionRequiresAuth($action)) {
      list($headerName, $headerValue) = $this->_GetAuthInterface()->GetSignedRequest (
        (array) $this->_configuration['Public']['Auth'],
        $actionConfiguration,
        ['Data' => $data, 'HeaderList' => $configuration['HeaderList']]
      );

      $configuration['HeaderList'][$headerName] = $headerValue;
    }

    return $configuration;
  }

  /**
   * AbstractSdk constructor.
   *
   * @param   array $configuration
   *            - The configuration to be used. (Optional, [])
   *
   * @since   1.0.0-dev
   *
   * @throws  SdkException
   *            - In case that the PHP version is not supported (< 5.4.0).
   */
  public function __construct(array $configuration = [])
  {
    if (version_compare(PHP_VERSION, '5.4.0', '<')) {
      throw new SdkException(SdkException::SDK_REQUIREMENT_PHP_VERSION);
    }

    $this->_authFactory = new AuthFactory;
    $this->_clientFactory = new ClientFactory;
    $this->_serverFactory = new ServerFactory;

    $this->Configure($configuration);
  }

  /**
   * Configures the referenced SDK.
   *
   * @param   array $configuration
   *            - The configuration to be used. (Required)
   *
   * @return  AbstractSdk
   *
   * @since   1.0.0-dev
   */
  public function Configure(array $configuration)
  {
    $this->_configuration = [
      'Private' => $this->_GetConfigurationSdkService(),
      'Public' => (array) $configuration
    ];

    return $this;
  }

  /**
   * Returns information regarding the requested notification event.
   *
   * @return  array
   *
   * @since   1.0.0-dev
   *
   * @throws  SdkException
   *            - In case that is not possible to return the information of the requested
   *              notification event.
   */
  public function GetNotificationEvent()
  {
    try {
      $this->_GetAuthInterface()->AuthenticateServerRequest (
        $this->_GetServerInterface()->GetRequestInterface()
      );

      return $this->_GetServerInterface()->GetRequestInterface()->GetPostData();
    } catch (\Exception $exception) {
      throw new SdkException (
        SdkException::SDK_GET_NOTIFICATION_EVENT_FAILURE, $exception
      );
    }
  }
}
