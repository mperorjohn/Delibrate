<?php 
// Get API response using cURL Template
function getSecureApiResponse($endpoint, $jwt) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $endpoint,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $jwt
      ),
    ));

    $response = json_decode(curl_exec($curl), true);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    return $response;
}

// /*
// * Get All Tasks
// */
// function getTasks($endpoint, $sessionName, $jwt) {
//     $endpoint    = getenv('API_ROOT_DIR').$endpoint;
//     $responseKey = md5($endpoint);

//     // Check if the API response is already cached in session
//     // if (isset($_SESSION[$sessionName][$responseKey])) {
//     //     return $_SESSION[$sessionName][$responseKey];
//     // } 
//     // else {
//         $response = getSecureApiResponse($endpoint, $jwt);
//         // $_SESSION[$sessionName][$responseKey] = $response;
//         return $response;
//     // }
// }


/*
* Get All Clauses
*/
function getClauses($endpoint, $sessionName, $jwt) {
    $endpoint    = getenv('API_ROOT_DIR').$endpoint;
    $responseKey = md5($endpoint);

    // Check if the API response is already cached in session
    if (isset($_SESSION[$sessionName][$responseKey])) {
        return $_SESSION[$sessionName][$responseKey];
    } 
    else {
        $response = getSecureApiResponse($endpoint, $jwt);
        $_SESSION[$sessionName][$responseKey] = $response;
        return $response;
    }
}


/*
* Get Phase Questions
*/
function getPhaseQuestions($endpoint, $sessionName, $jwt) {
    $endpoint    = getenv('API_ROOT_DIR').$endpoint;
    $responseKey = md5($endpoint);

    // Check if the API response is already cached in session
    if (isset($_SESSION[$sessionName][$responseKey])) {
        return $_SESSION[$sessionName][$responseKey];
    } 
    else {
        $response = getSecureApiResponse($endpoint, $jwt);
        $_SESSION[$sessionName][$responseKey] = $response;
        return $response;
    }
}


/*
* Get All Responses
*/
function getAllResponses($endpoint, $sessionName, $jwt) {
    $endpoint    = getenv('API_ROOT_DIR').$endpoint;
    $responseKey = md5($endpoint);

    // Check if the API response is already cached in session
    if (isset($_SESSION[$sessionName][$responseKey])) {
        return $_SESSION[$sessionName][$responseKey];
    } 
    else {
        $response = getSecureApiResponse($endpoint, $jwt);
        $_SESSION[$sessionName][$responseKey] = $response;
        return $response;
    }
}





function getGapAssessmentChecklist($endpoint, $sessionName, $jwt) {
    $endpoint    = getenv('API_ROOT_DIR').$endpoint;
    $responseKey = md5($endpoint);

    // Check if the API response is already cached in session
    if (isset($_SESSION[$sessionName][$responseKey])) {
        return $_SESSION[$sessionName][$responseKey];
    } 
    else {
        $response = getSecureApiResponse($endpoint, $jwt);
        $_SESSION[$sessionName][$responseKey] = $response;
        return $response;
    }
}


function getChecklistCount($endpoint, $sessionName, $jwt) {
    $endpoint    = getenv('API_ROOT_DIR').$endpoint;
    $responseKey = md5($endpoint);

    // Check if the API response is already cached in session
    if (isset($_SESSION[$sessionName][$responseKey])) {
        return $_SESSION[$sessionName][$responseKey];
    } 
    else {
        $response = getSecureApiResponse($endpoint, $jwt);
        $_SESSION[$sessionName][$responseKey] = $response;
        return $response;
    }
}


function getGapAssessmentChecklistClient($endpoint, $sessionName, $jwt) {
    $endpoint    = getenv('API_ROOT_DIR').$endpoint;
    $responseKey = md5($endpoint);

    // Check if the API response is already cached in session
    if (isset($_SESSION[$sessionName][$responseKey])) {
        return $_SESSION[$sessionName][$responseKey];
    } 
    else {
        $response = getSecureApiResponse($endpoint, $jwt);
        $_SESSION[$sessionName][$responseKey] = $response;
        return $response;
    }
}
?>