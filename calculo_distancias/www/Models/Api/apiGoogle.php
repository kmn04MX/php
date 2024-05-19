<?php

class apiGoogle{
    var $urlApi="https://maps.googleapis.com/maps/api/distancematrix/json";
    var $GoogleAPIKey="AIzaSyD9QOYq_SdTZ8a1IOoELnoayNA78eqFqXY";

    function calculaDistancia($origen, $destino){

        $options = array(
            "departure_time"=>"now",
            "traffic_model"=>"best_guess",
            "mode"=>"driving",
            "origins" => $origen['latitud'].",".$origen['longitud'],
            "destinations" => $destino['latitud'].",".$destino['longitud'],
            "units" => "metric",
            "language" => "es-419",
            "key" =>$this->GoogleAPIKey
        );
        
        $requestUrl = $this->urlApi."?".http_build_query($options);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $requestUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        // CURLOPT_PROXY=> 'http://proxymia.ltm.mapfre.net',
        // CURLOPT_PROXYPORT=>'8080',

        $res = curl_exec($curl);
        curl_close($curl);

        if($res  === false){
            $response=array("status"=>"error","mensaje"=>curl_error($curl),"url"=>$requestUrl);
        }else{
           $response= json_decode(stripcslashes($res),true);

           if(count($response)<=0){
              $response= json_decode($res,JSON_UNESCAPED_UNICODE);
           }
        }  
        return $response;
    }
}

?>