<?php
/*************************************************************************************************

Use the CIM JSON API to retrieve a payment profile

SAMPLE REQUEST
--------------------------------------------------------------------------------------------------
{
   "getCustomerPaymentProfileRequest":{
      "merchantAuthentication":{
         "name":"",
         "transactionKey":""
      },
      "customerProfileId":"31390172",
      "customerPaymentProfileId":"28393490"
   }
}

SAMPLE RESPONSE
--------------------------------------------------------------------------------------------------
{
   "paymentProfile":{
      "customerPaymentProfileId":"28393490",
      "payment":{
         "creditCard":{
            "cardNumber":"XXXX1111",
            "expirationDate":"XXXX"
         }
      },
      "customerTypeSpecified":false,
      "billTo":{
         "phoneNumber":"800-555-1234",
         "firstName":"John",
         "lastName":"Smith",
         "address":"123 Main Street",
         "city":"Townsville",
         "state":"NJ",
         "zip":"12345"
      }
   },
   "messages":{
      "resultCode":"Ok",
      "message":[
         {
            "code":"I00001",
            "text":"Successful."
         }
      ]
   }
}

*************************************************************************************************/

namespace JohnConde\Authnet;

use Exception;

require '../../config.inc.php';

try {
    $request = AuthnetApiFactory::getJsonApiHandler(
        AUTHNET_LOGIN,
        AUTHNET_TRANSKEY,
        AuthnetApiFactory::USE_DEVELOPMENT_SERVER
    );
    $response = $request->getCustomerPaymentProfileRequest([
        'customerProfileId' => '31390172',
        'customerPaymentProfileId' => '28393490'
    ]);
} catch (Exception $e) {
    echo $e;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CIM :: Get Payment Profile</title>
    <style type="text/css">
        table { border: 1px solid #cccccc; margin: auto; border-collapse: collapse; max-width: 90%; }
        table td { padding: 3px 5px; vertical-align: top; border-top: 1px solid #cccccc; }
        pre { white-space: pre-wrap; }
        table th { background: #e5e5e5; color: #666666; }
        h1, h2 { text-align: center; }
    </style>
</head>
<body>
    <h1>
        CIM :: Get Payment Profile
    </h1>
    <h2>
        Results
    </h2>
    <table>
        <tr>
            <th>Response</th>
            <td><?= $response->messages->resultCode ?></td>
        </tr>
        <tr>
            <th>code</th>
            <td><?= $response->messages->message[0]->code ?></td>
        </tr>
        <tr>
            <th>Successful?</th>
            <td><?= $response->isSuccessful() ? 'yes' : 'no' ?></td>
        </tr>
        <tr>
            <th>Error?</th>
            <td><?= $response->isError() ? 'yes' : 'no' ?></td>
        </tr>
        <tr>
            <th>firstName</th>
            <td><?= $response->paymentProfile->billTo->firstName ?></td>
        </tr>
        <tr>
            <th>lastName</th>
            <td><?= $response->paymentProfile->billTo->lastName ?></td>
        </tr>
        <tr>
            <th>address</th>
            <td><?= $response->paymentProfile->billTo->address ?></td>
        </tr>
        <tr>
            <th>city</th>
            <td><?= $response->paymentProfile->billTo->city ?></td>
        </tr>
        <tr>
            <th>state</th>
            <td><?= $response->paymentProfile->billTo->state ?></td>
        </tr>
        <tr>
            <th>zip</th>
            <td><?= $response->paymentProfile->billTo->zip ?></td>
        </tr>
        <tr>
            <th>phoneNumber</th>
            <td><?= $response->paymentProfile->billTo->phoneNumber ?></td>
        </tr>
        <tr>
            <th>customerPaymentProfileId</th>
            <td><?= $response->paymentProfile->customerPaymentProfileId ?></td>
        </tr>
        <tr>
            <th>cardNumber</th>
            <td><?= $response->paymentProfile->payment->creditCard->cardNumber ?></td>
        </tr>
        <tr>
            <th>expirationDate</th>
            <td><?= $response->paymentProfile->payment->creditCard->expirationDate ?></td>
        </tr>
    </table>
    <h2>
        Raw Input/Output
    </h2>
<?= $request, $response ?>
</body>
</html>
