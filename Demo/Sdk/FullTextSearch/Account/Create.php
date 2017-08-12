<?php

namespace Demo\Sdk\FullTextSearch\Account;

use Demo\Helper\Printer;
use Epignosis\Sdk\FullTextSearch\Account;

require
  rtrim(dirname(dirname(dirname(__DIR__))), \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR .
  'Helper' . \DIRECTORY_SEPARATOR .
  'Bootstrap.php';

require
  rtrim(dirname(dirname(dirname(__DIR__))), \DIRECTORY_SEPARATOR) . \DIRECTORY_SEPARATOR .
  'Data' . \DIRECTORY_SEPARATOR .
  'Account' . \DIRECTORY_SEPARATOR .
  'Create.php';

try {

  $responseList = [];
  $fullTextSearchAccountSdk = new Account($configuration);

  foreach ($data as $account) {
    $responseList[] = $fullTextSearchAccountSdk->Create($account);
  }

} catch (\Exception $exception) {

  Printer::PrintError($exception);

} finally {

  Printer::PrintResponse (function() use ($responseList, $data) {
    foreach ($responseList as $keyIndex => $thisResponse) {
      echo
        sprintf (
          '<b>Create Account #%s (Requested Data)</b><pre>%s</pre>',
          $keyIndex + 1,
          print_r($data[$keyIndex], true)
        ),

        sprintf (
          '<b>Create Account #%s (Response)</b><pre>%s</pre>',
          $keyIndex + 1,
          print_r($thisResponse, true)
        );
    }
  });

}
