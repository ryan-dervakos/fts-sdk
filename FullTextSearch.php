<?php

class FullTextSearch
{
  private $_configuration = [];
  private $_error = [];
  private $_sdkInformation = [
    'Version' => [
      'Extra' => 'dev',
      'Major' => 2,
      'Minor' => 0,
      'Patch' => 0,
      'Release' => '2017-08-31'
    ]
  ];


  public function __construct(array $configuration = [])
  {
    $this->Configure($configuration);
  }

  public function AccountCreate(array $data)
  {

  }

  public function Configure(array $configuration)
  {
    $this->_configuration = $configuration;

    return $this;
  }

  public function DocumentDeIndex(array $data)
  {

  }

  public function DocumentIndex(array $data)
  {

  }

  public function DocumentSearch(array $data)
  {

  }

  public function PermissionPolicyDelete(array $data)
  {

  }

  public function PermissionPolicyPush(array $data)
  {

  }

  public function GetError()
  {
    return $this->_error;
  }

  public function GetSdkInformation()
  {
    return $this->_sdkInformation;
  }

  public function GetSdkVersion()
  {
    return $this->_sdkInformation['Version'];
  }

  public function GetSdkVersionFull()
  {
    return sprintf (
      '%d.%d.%d-%s (%s)',
      $this->_sdkInformation['Version']['Major'],
      $this->_sdkInformation['Version']['Minor'],
      $this->_sdkInformation['Version']['Patch'],
      $this->_sdkInformation['Version']['Extra'],
      $this->_sdkInformation['Version']['Release']
    );
  }
}