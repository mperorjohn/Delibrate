<?php
session_start();
if (!isset($_SESSION['accessToken']) || empty($_SESSION['accessToken'])) {
    header("location:../auth/logout.php");
}

require dirname(__DIR__) . '/vendor/autoload.php'; // Load Composer's autoloader

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();

/** Set ABSPATH for execution */
define('ABSPATH', dirname(__DIR__) . "/");

define('LIL', ABSPATH . 'includes/');

// Retrieve the JWT token from the session or cookie
$accessToken = $_SESSION['accessToken'];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => getenv('API_ROOT_DIR').'auth/verifyToken.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $accessToken
    ),
));

$response = json_decode(curl_exec($curl),true);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

// Check the HTTP response code
if ($httpCode === 200) {
    $userId           = $response['data']['Id'];
    $firstName        = $response['data']['FirstName'];
    $lastName         = $response['data']['LastName'];
    $company          = $response['data']['Company'];
    $emailAddress     = $response['data']['EmailAddress'];
    $phoneNumber      = $response['data']['PhoneNumber'];
    $roleId           = $response['data']['RoleId'];
    $role             = $response['data']['Role'];
    $designation      = $response['data']['Designation'];
    $userType         = $response['data']['UserType'];
    $onboardingStatus = $response['data']['OnboardingStatus'];
    $verified         = $response['data']['Verified'];
    $accountStatus    = $response['data']['AccountStatus'];


    $_SESSION['myUserId']       = $userId;
    $_SESSION['myFirstName']    = $firstName;
    $_SESSION['myLastName']     = $lastName;
    $_SESSION['myEmailAddress'] = $emailAddress;
    $_SESSION['myPhoneNumber']  = $phoneNumber;
    $_SESSION['myRoleId']       = $roleId;
    $_SESSION['myDesignation']  = $designation;

    // Check if Account is Activated
    if ($verified == "0") {
        
    }
    else{

    }


    // Check if Account is Active, Pending or Inactive  
    if ($accountStatus == "active") {
        // code...
    }
    else if ($accountStatus == "pending") {
        // code...
    }
    else{

    }


    // Check Onboarding Status
    if ($onboardingStatus == "no" || $onboardingStatus == "in progress") {
        // code...
    }
    else{

    }
} 
elseif ($httpCode === 401) {
    // Token verification failed, the user is not authenticated
    // Redirect the user to the login page
    header('location: ../auth/login.php');
    exit;
} else {
    // Other error codes, display a generic error message
    echo "An error occurred. Please try again later.";
}
?>