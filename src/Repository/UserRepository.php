<?php

namespace Jsdecena\Bridge\Repository;

use App\User;
use Exception;

class UserRepository
{
    /**
     * @param string $column
     * @param string $where
     * @return User
     */
    public function fetchOne(string $column, string $where)
    {
        return User::where($column, $where)->first();
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data) : User
    {
        return User::create($data);
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function call(string $endpoint, array $data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT           => "3000",
            CURLOPT_URL            => env('LEGACY_AUTH_ENDPOINT', 'http://localhost:3000/') . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_HTTPHEADER     => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new Exception('cURL Error #:' . $err);
        } else {
            return json_decode($response);
        }
    }
}