<?php

namespace Demo\Account;

use Demo\Helper\Printer;
use Epignosis\Sdk\FullTextSearch\Account;

/** @noinspection PhpIncludeInspection */
/** @noinspection PhpUndefinedVariableInspection */
require
  rtrim(dirname(__DIR__), \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR .
  'Helper' . \DIRECTORY_SEPARATOR .
  'Bootstrap.php';

/** @noinspection PhpIncludeInspection */
require
  rtrim(dirname(__DIR__), \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR .
  'Data' . \DIRECTORY_SEPARATOR .
  'Account' . \DIRECTORY_SEPARATOR .
  'Create.php';

try {

  $responseList = [];

  /** @noinspection PhpUndefinedVariableInspection */
  $fullTextSearchAccountingSdk = new Account($configuration);

  /** @noinspection PhpUndefinedVariableInspection */
  $responseList['Multiple'] = $fullTextSearchAccountingSdk->Create (
    $data['Multiple'], true
  );

  foreach ($data['Single'] as $account) {
    $responseList['Single'][] = $fullTextSearchAccountingSdk->Create($account, false);
  }

} catch (\Exception $exception) {

  Printer::PrintError($exception);

} finally {

  Printer::PrintResponse (function() use ($responseList, $data) {
    foreach ($responseList as $keyType => $response) {
      if ('Multiple' == $keyType) {
        echo
          sprintf (
            '<b>Create Multiple Accounts (Requested Data)</b><pre>%s</pre>',
            print_r($data['Multiple'], true)
          ),

          sprintf (
            '<b>Multiple Accounts Creation (Response)</b><pre>%s</pre>',
            print_r($response, true)
          );
      } else {
        foreach ($response as $keyIndex => $thisResponse) {
          echo
            sprintf (
              '<b>Create Single Account #%s (Requested Data)</b><pre>%s</pre>',
              $keyIndex + 1,
              print_r($data['Single'][$keyIndex], true)
            ),

            sprintf (
              '<b>Single Account Creation #%s (Response)</b><pre>%s</pre>',
              $keyIndex + 1,
              print_r($thisResponse, true)
            );
        }
      }
    }
  });

}