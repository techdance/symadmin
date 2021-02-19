<?php
namespace App\Manager;

use App\Entity\User;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
// set_time_limit(0);
// ini_set('max_execution_time', 0);
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
        //    $response = $httpClient->request(
        //         'GET',
        //         "http://137.117.70.79/local/profileupdate/client/client.php?user=MzQ2MzgyODU4OW1vbHkx"
        //     );

           
        //     return [
        //         'contentType' => $response->getHeaders()['content-type'][0],
        //         'statusCode' => $response->getStatusCode(),
        //         'content' => $response->getContent(),
        //         'data' => $response->getContent()
        //     ];

            



            // // Get cURL resource
        //    -- $curl = curl_init();
            // Set some options - we are passing in a useragent too here
        //    -- curl_setopt($curl, CURLOPT_ENCODING, ''); 
        //    -- curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        //     --curl_setopt($curl, CURLOPT_TIMEOUT, 400);
        //     --curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        //         'Content-Type: application/json',
        //    -- ));
        //    -- curl_setopt_array($curl, [
        //     --    CURLOPT_RETURNTRANSFER => 1,
        //     --    CURLOPT_URL => "http://137.117.70.79/local/profileupdate/client/client.php?user=${userNameToken}",
        //     --    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
        //     --    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //      --   CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4 
        //    -- ]);
            // Send the request & save response to $resp


            // --$response = curl_exec($curl);

            // --$info = curl_getinfo($curl);
        

            // // $curl = curl_init();
            // // curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V6 );
            // // curl_setopt_array($curl, array(
            // //     CURLOPT_URL => "http://137.117.70.79/local/profileupdate/client/client.php?user=${userNameToken}",
            // //     CURLOPT_RETURNTRANSFER => true,
            // //     CURLOPT_ENCODING => "",
            // //     CURLOPT_MAXREDIRS => 10,
            // //     CURLOPT_TIMEOUT => 30,
            // //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // //     CURLOPT_CUSTOMREQUEST => "GET",
            // //     CURLOPT_HTTPHEADER => array(
            // //         "cache-control: no-cache",
            // //         "content-type: application/x-www-form-urlencoded",
            // //         "postman-token: 0b939feb-a581-b3da-a51e-a22927ddc2a9"
            // //     ),
            // // ));

            // $response = curl_exec($curl);
            // $err = curl_error($curl);
            // $info = curl_getinfo($curl);
            // --curl_close($curl);
            // --dump($info);
            // --dd($response);

            return [
                'contentType' => '',
                'statusCode' => 99
            ];

        } catch (TransportExceptionInterface $e) {
           
            return [
                'contentType' => '',
                'statusCode' => 99
            ];
        }



        
        
       
    }


    public function curlTest2()
    {
    

        $httpClient = HttpClient::create();

        try {
        //    $response = $httpClient->request(
        //         'GET',
        //         "http://137.117.70.79/local/profileupdate/client/client.php?user=MzQ2MzgyODU4OW1vbHkx"
        //     );

           
        //     return [
        //         'contentType' => $response->getHeaders()['content-type'][0],
        //         'statusCode' => $response->getStatusCode(),
        //         'content' => $response->getContent(),
        //         'data' => $response->getContent()
        //     ];

            



            // // Get cURL resource
        //    -- $curl = curl_init();
            // Set some options - we are passing in a useragent too here
        //    -- curl_setopt($curl, CURLOPT_ENCODING, ''); 
        //    -- curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        //   --  curl_setopt($curl, CURLOPT_TIMEOUT, 400);
        //   --  curl_setopt_array($curl, [
        //    --     CURLOPT_RETURNTRANSFER => 1,
        //    --     CURLOPT_URL => "https://reqres.in/api/users?page=2",
        //    --     CURLOPT_USERAGENT => 'Sample Request',
        //    --     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //   --      CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4 
        //   --  ]);
            // Send the request & save response to $resp
        //  --   $response = curl_exec($curl);

        //  --   $info = curl_getinfo($curl);
        

            // // $curl = curl_init();
            // // curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V6 );
            // // curl_setopt_array($curl, array(
            // //     CURLOPT_URL => "http://137.117.70.79/local/profileupdate/client/client.php?user=${userNameToken}",
            // //     CURLOPT_RETURNTRANSFER => true,
            // //     CURLOPT_ENCODING => "",
            // //     CURLOPT_MAXREDIRS => 10,
            // //     CURLOPT_TIMEOUT => 30,
            // //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // //     CURLOPT_CUSTOMREQUEST => "GET",
            // //     CURLOPT_HTTPHEADER => array(
            // //         "cache-control: no-cache",
            // //         "content-type: application/x-www-form-urlencoded",
            // //         "postman-token: 0b939feb-a581-b3da-a51e-a22927ddc2a9"
            // //     ),
            // // ));

            // $response = curl_exec($curl);
            // $err = curl_error($curl);
            // $info = curl_getinfo($curl);
        // --    curl_close($curl);
        // --    dump($info);
        // --    dd($response);

            return [
                'contentType' => '',
                'statusCode' => 99
            ];

        } catch (TransportExceptionInterface $e) {
           
            return [
                'contentType' => '',
                'statusCode' => 99
            ];
        }
        
       
    }


    public function moodleApi($userName)
    {
       
        
        $token = '9cf0076a972453fc7cf115a5ce1fdebe';
       
        $userNameToken = base64_encode(rand(1000000000, 9999999999) . $userName);

        $function_name = 'local_update_user_profile';
        $contexts = array(
            array(
                'usertoken' => $userNameToken,
            )
        );
        
        $serverurl = "http://137.117.70.79/webservice/xmlrpc/server.php?wstoken=${token}";
    
        $curl = new CurlManager;
        
        $post = xmlrpc_encode_request($function_name, array($contexts));
        $resp = xmlrpc_decode($curl->post($serverurl, $post));

        dd($resp);
  
    }

    public function curSendPost(User $user) 
    {
        $result = $this->serializeUsers($user);

        $postData =  http_build_query($result);

        $userNameToken = base64_encode(rand(1000000000, 9999999999) . $user->getUsername());


    //    -- $curl = curl_init();

    //    -- curl_setopt($curl, CURLOPT_URL,"http://137.117.70.79/local/profileupdate/client/client.php?user=${userNameToken}");
    //   --  curl_setopt($curl, CURLOPT_ENCODING, ''); 
    //  --   curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
    //  --   curl_setopt($curl, CURLOPT_TIMEOUT, 400);
    //   --  curl_setopt($curl, CURLOPT_POST, 1);
    //    -- curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    //    -- curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //   --  $output = curl_exec($curl);

    //   --  curl_close ($curl);

    //  --   return $output;

     return true;

    }

    private function serializeUsers(User $usr)
    {
        $roles = $usr->getRoles();

        if (count($roles)) {
            $roles = array_values(array_filter($roles, function($val) {
                return $val != 'ROLE_USER';
            }));
        }
        
        
        
        return array(
            'institutionEmail' => $usr->getEmail(),
            'prefix' => $usr->getPrefix(),
            'firstName' => $usr->getFirstname(),
            'middleName' => $usr->getMiddleName(),
            'lastName' => $usr->getLastname(),
            'userName' => $usr->getUsername(),
            'institutionName' => $usr->getInstitutionName(),
            'roles' => count($roles) ? $roles[0] : "",
            'phone' => $usr->getPhone(),
            'position' => $usr->getPosition(),
            'ssn' => $usr->getSsn(),
            'veteran' => $usr->getVetran(),
            'ethnicity' => $usr->getEthinicity(),
            'dateOfBirth' => $usr->getDateOfBirth()->format('Y-m-d'),
            'gender' => $usr->getGender(),
            'emergencyContact' => $usr->getEmergencyContactPerson(),
            'emergencyContactPhone' => $usr->getEmergencyContactPhone(),
            'address1' => $usr->getAddress1(),
            'address2' => $usr->getAddress2(),
            'city' => $usr->getCity(),
            'state' => $usr->getState(),
            'zip' => $usr->getZip(),
            'password' => $usr->getDummyPassword()
            //I have tried using getter method to retrieve image value here but I cannot because image is related to users
        );
    }
    


    

}


