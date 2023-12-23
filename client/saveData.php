<?php
include "token.php";
include_once LIL . 'apiCalls.php';
include_once LIL . 'secureApiCalls.php';
include LIL . "activityLogs.php";
include LIL . "logs.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the serialized form data
    $serializedFormData = $_POST['formData'];

    // Decode the serialized form data into an associative array
    $formData = [];
    parse_str($serializedFormData, $formData);

    // 1. Profile
    if ($_GET['src'] == "profile") {

    	$requiredFields = array($formData['userId'], $formData['firstName'], $formData['lastName'], $formData['phoneNumber'], $formData['emailAddress']);

		if (in_array(null, $requiredFields, true) || in_array("", $requiredFields, true)) {
			logs("Update My Profile", "User Management", "error: Bad Request: Missing Required Data.");
		    
		    // http_response_code(400);
		    echo json_encode(
		        array(
		            "status" => "error",
		            "message" => "Bad Request: Missing Required Data.",
		            "count" => 0,
		            "results" => ""
		        )
		    );
		    exit();
		}
		else{
			// Access individual form fields using their names
			$postData = [
				"userId"       => $formData['userId'],
				"firstName"    => $formData['firstName'],
				"lastName"     => $formData['lastName'],
				"phoneNumber"  => $formData['phoneNumber'],
				"emailAddress" => $formData['emailAddress']
		    ];
		    
		    list($response, $httpCode) = processApiRequest(getenv('API_ROOT_DIR').'profile/updateUser.php', $postData, $accessToken, "PUT");

		    // Reload Profile

		    echo json_encode($response);
		    logs("Updated Profile Id: ". $formData['userId'], "User Management", $response["message"]);

		    exit();
		}
    }
} 
else {
    // If the request method is not POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method Not Allowed"));
    exit();
}
?>
