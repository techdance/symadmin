<?php
namespace App\Manager;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class UserManager 
{
   
    public function __construct()
    {
       
    }

    public function updateUserToExternalApi($userName)
    {
        $userNameToken = base64_encode(rand(1000000000, 9999999999) . $userName);

        $httpClient = HttpClient::create();

        try {
           $response = $httpClient->request(
                'GET',
                "http://137.117.70.79/local/profileupdate/client/client.php?user=${userNameToken}",
                [
                    'timeout' => 1
                ]
            );

             return [
                'contentType' => $response->getHeaders()['content-type'][0],
                'statusCode' => $response->getStatusCode(),
                'content' => $response->getContent(),
                'data' => $response->getContent()
            ];
        } catch (TransportExceptionInterface $e) {
           
            return [
                'contentType' => '',
                'statusCode' => 99
            ];
        }
        
       
    }


    

}


