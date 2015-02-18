<?php

namespace JohnConde\Authnet;

class AuthnetApiFactory
{
    const USE_PRODUCTION_SERVER  = 0;
    const USE_DEVELOPMENT_SERVER = 1;
    const USE_UNIT_TEST_SERVER   = 2;

    public static function getJsonApiHandler($login, $transaction_key, $server = self::USE_PRODUCTION_SERVER, $json = '{}')
    {
        $login           = trim($login);
        $transaction_key = trim($transaction_key);
        $api_url         = static::getWebServiceURL($server);

        if (empty($login) || empty($transaction_key)) {
            throw new AuthnetInvalidCredentialsException('You have not configured your login credentials properly.');
        }

        $processor = self::getProcessorHandler($server);
        $processor->setResponse($json);

        $object = new AuthnetJson($login, $transaction_key, $api_url);
        $object->setProcessHandler($processor);

        return $object;
    }

    private static function getWebServiceURL($server)
    {
        switch ($server) {
            case static::USE_PRODUCTION_SERVER :
                $url = 'https://api.authorize.net/xml/v1/request.api';
            break;

            case static::USE_DEVELOPMENT_SERVER :
                $url = 'https://apitest.authorize.net/xml/v1/request.api';
            break;

            case static::USE_UNIT_TEST_SERVER :
                $url = '';
            break;
        }
        return $url;
    }

    private static function getProcessorHandler($server)
    {
        switch ($server) {
            case static::USE_PRODUCTION_SERVER :
            case static::USE_DEVELOPMENT_SERVER :
                $wrapper = new CurlWrapper();
            break;

            case static::USE_UNIT_TEST_SERVER :
                $wrapper = new UnitTestWrapper($json);
            break;

            default :
                throw new AuthnetInvalidServerException('You did not provide a valid server.');
        }
        return $wrapper;
    }
}