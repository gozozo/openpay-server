<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Openpay Errors Lines
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    '1000' => 'An error happened in the internal Openpay server.',
    '1001' => 'The request is not JSON valid format, the fields don’t have the correct format, or the request doesn’t have the required fields.',
    '1002' => 'The request is not authenticated or is incorrect.',
    '1003' => 'The operation couldn’t be processed because one or more parameters are incorrect.',
    '1004' => 'A required service is not available.',
    '1005' => 'A required resource doesn’t exist.',
    '1006' => 'There is already a transaction with the same ID order.',
    '1008' => 'One of the required accounts is deactivated.',
    '1007' => 'The funds transfer between the bank account or card and the Openpay account was rejected.',
    '1009' => 'The request body is too large.',
    '1010' => 'The public key is being used to make a request that requires the private key, or the private key is being using from Javascript.',
    '1011' => 'The resource was previously deleted.',
    '1012' => 'The transaction amount is out of the limits.',
    '1013' => 'The operation is not allowed on the resource.',
    '1014' => 'The account is inactive.',
    '1015' => 'Could not get any response from gateway.',
    '1016' => 'The merchant email has been already processed.',
    '1017' => 'The payment gateway is not available at the moment, please try again later.',
    '1018' => 'The number of retries of charge is greater than allowed.',
    '2001' => 'The CLABE of the bank account is already registered.',
    '2002' => 'The number of this card is already registered.',
    '2003' => 'The customer with this external ID already exists.',
    '2004' => 'The identifier digit of this card number is invalid according to Luhn algorithm.',
    '2005' => 'The card expiration date is prior to the current date.',
    '2006' => 'The card security code (CVV2) wasn’t provided.',
    '2007' => 'The card number is just for testing, it can only be used in Sandbox.',
    '2008' => 'The card is not valid for Santander points.',
    '2009' => 'The card security code (CVV2) is invalid.',
    '3001' => 'Card declined.',
    '3002' => 'Card is expired.',
    '3003' => 'Card has not enough funds.',
    '3004' => 'Card has been flagged as stolen.',
    '3005' => 'Card has been rejected by the antifraud system.',
    '3006' => 'The operation is not allowed for this customer or transaction.',
    '3007' => 'Deprecated. The card was rejected.',
    '3008' => 'The card doesn’t support online transactions.',
    '3009' => 'Card has been flagged as lost.',
    '3010' => 'The card has been restricted by the bank.',
    '3011' => 'The bank has requested to hold this card. Please contact the bank.',
    '3012' => 'Bank authorization is required to make this payment.',
    '4001' => 'The Openpay account doesn’t have enough funds.',
    '4002' => 'The operation can’t be completed until pending fees are paid.',
    '5001' => 'The external_order_id already exists.',
    '6001' => 'The webhook has already been processed.',
    '6002' => 'Could not connect with webhook service.',
    '6003' => 'Service responded with an error.'
];