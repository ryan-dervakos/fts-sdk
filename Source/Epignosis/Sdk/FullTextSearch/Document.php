<?php

namespace Epignosis\Sdk\FullTextSearch;

use Epignosis\Sdk\Abstraction\AbstractSdk;
use Epignosis\Sdk\FullTextSearch\Failure\Document as FullTextSearchDocumentException;

/**
 * Class Document
 *
 * The full-text search document SDK.
 *
 * @author      Haris Batsis <xarhsdev@efrontlearning.com>
 * @category    Epignosis\Sdk\FullTextSearch
 * @copyright   Epignosis LLC (c) Copyright 2017, All Rights Reserved
 * @package     Epignosis\Sdk\FullTextSearch
 * @since       1.0.0-dev
 */
class Document extends AbstractSdk
{
  /**
   * Returns the configuration of the full-text search document SDK.
   *
   * @return  array
   *
   * @since   1.0.0-dev
   */
  protected function _GetConfigurationSdk()
  {
    return [
      'Request' => [
        'Scoped' => [
          'Create' => [],
          'Delete' => [],
          'Retrieve' => [],
          'RetrieveMany' => [],
          'Update' => []
        ],
        'Shared' => []
      ],
      'Response' => [
        'Scoped' => [
          'Create' => [],
          'Delete' => [],
          'Retrieve' => [],
          'RetrieveMany' => [],
          'Update' => []
        ],
        'Shared' => []
      ]
    ];
  }

  /**
   * Creates the requested document.
   *
   * @param   array $data
   *            - The data of the document to be created. (Required)
   *
   * @return  array
   *
   * @since   1.0.0-dev
   *
   * @throws  FullTextSearchDocumentException
   *            - In case that is not possible to create the requested document.
   */
  public function Create(array $data)
  {
    try {
      return $this->_GetParsedResponse (
        $this->_GetClientInterface()->Post (
          $this->_GetConfigurationPrivate('Request', 'Create'), $data
        ),
        $this->_GetConfigurationPrivate('Response', 'Create')
      );
    } catch (\Exception $exception) {
      throw new FullTextSearchDocumentException (
        FullTextSearchDocumentException::SDK_FTS_DOCUMENT_CREATE_FAILURE, $exception
      );
    }
  }

  /**
   * Deletes the requested document.
   *
   * @param   array $data
   *            - The data of the document to be deleted. (Required)
   *
   * @return  array
   *
   * @since   1.0.0-dev
   *
   * @throws  FullTextSearchDocumentException
   *            - In case that is not possible to delete the requested document.
   */
  public function Delete(array $data)
  {
    try {
      return $this->_GetParsedResponse (
        $this->_GetClientInterface()->Delete (
          $this->_GetConfigurationPrivate('Request', 'Delete'), $data
        ),
        $this->_GetConfigurationPrivate('Response', 'Delete')
      );
    } catch (\Exception $exception) {
      throw new FullTextSearchDocumentException (
        FullTextSearchDocumentException::SDK_FTS_DOCUMENT_DELETE_FAILURE, $exception
      );
    }
  }

  /**
   * Retrieves the requested document.
   *
   * @param   array $data
   *            - The data of the document to be retrieved. (Required)
   *
   * @return  array
   *
   * @since   1.0.0-dev
   *
   * @throws  FullTextSearchDocumentException
   *            - In case that is not possible to retrieve the requested document.
   */
  public function Retrieve(array $data)
  {
    try {
      return $this->_GetParsedResponse (
        $this->_GetClientInterface()->Get (
          $this->_GetConfigurationPrivate('Request', 'Retrieve'), $data
        ),
        $this->_GetConfigurationPrivate('Response', 'Retrieve')
      );
    } catch (\Exception $exception) {
      throw new FullTextSearchDocumentException (
        FullTextSearchDocumentException::SDK_FTS_DOCUMENT_RETRIEVE_FAILURE, $exception
      );
    }
  }

  /**
   * Retrieves many documents.
   *
   * @param   array $data
   *            - The data of the documents to be retrieved. (Required)
   *
   * @return  array
   *
   * @since   1.0.0-dev
   *
   * @throws  FullTextSearchDocumentException
   *            - In case that is not possible to retrieve the requested documents.
   */
  public function RetrieveMany(array $data)
  {
    try {
      return $this->_GetParsedResponse (
        $this->_GetClientInterface()->Get (
          $this->_GetConfigurationPrivate('Request', 'RetrieveMany'), $data
        ),
        $this->_GetConfigurationPrivate('Response', 'RetrieveMany')
      );
    } catch (\Exception $exception) {
      throw new FullTextSearchDocumentException (
        FullTextSearchDocumentException::SDK_FTS_DOCUMENT_RETRIEVE_MANY_FAILURE,
        $exception
      );
    }
  }

  /**
   * Updates the requested document.
   *
   * @param   array $data
   *            - The data of the document to be updated. (Required)
   *
   * @return  array
   *
   * @since   1.0.0-dev
   *
   * @throws  FullTextSearchDocumentException
   *            - In case that is not possible to update the requested document.
   */
  public function Update(array $data)
  {
    try {
      return $this->_GetParsedResponse (
        $this->_GetClientInterface()->Put (
          $this->_GetConfigurationPrivate('Request', 'Update'), $data
        ),
        $this->_GetConfigurationPrivate('Response', 'Update')
      );
    } catch (\Exception $exception) {
      throw new FullTextSearchDocumentException (
        FullTextSearchDocumentException::SDK_FTS_DOCUMENT_UPDATE_FAILURE, $exception
      );
    }
  }
}