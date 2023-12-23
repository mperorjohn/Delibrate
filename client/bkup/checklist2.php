<?php
include "token.php";
include LIL . "encodeString.php";
include LIL . "decodeString.php";
include LIL . "truncateWord.php";
include_once 'apiCalls.php';
include_once 'secureApiCalls.php';

if (isset($_GET['q'])) {
    $queryString = decodeString($_GET['q']);
    
    // Decode the query string into an array
    $data = array();
    echo parse_str($queryString, $data);
    $standardId     = $data['Id'];
    $standard       = $data['Standards'];
    $description    = $data['Description'];
    $status         = $data['Status'];
    $title          = $data['Title'];
    $checklistCount = $_GET['count'];
}


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => getenv('API_ROOT_DIR').'customers/getCustomer.php?customerId='.$_SESSION['companyId'],
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

$customers             = $response['results'][0];
$customerId            = $customers['Id'];
$firstName             = $customers['FirstName'];
$lastName              = $customers['LastName'];
$companyName           = $customers['CompanyName'];
$companyEmail          = $customers['CompanyEmail'];
$role                  = $customers['Role'];
$industry              = $customers['Industry'];
$emailAddress          = $customers['EmailAddress'];
$phoneNumber           = $customers['PhoneNumber'];
$services              = $customers['Services'];
$otherServices         = $customers['OtherServices'];
$standards             = $customers['Standards'];
$additionalInformation = $customers['AdditionalInformation'];
$salesFunnel           = $customers['SalesFunnel'];
$dateCreated           = $customers['DateCreated'];
$dateUpdated           = $customers['DateUpdated'];

// $fullName         = ucwords(strtolower($firstName.' '.$lastName));
// $countOfService   = count(explode(",", $services));
// $countOfStandards = count(explode(",", $standards));
// $standards        = explode(",", $standards);


// Get All Standards
$sresponse   = getAllStandards('standards/getAllStandards.php', "getAllStandards");

// Get Checklists
$checklist = getGapAssessmentChecklistClient('gapAssessment/getGapAssessmentChecklistClient.php?standardId='.$standardId, "getGapAssessmentChecklistClient", $accessToken);
$questions = $checklist['results'];
?>

<!DOCTYPE html>
<html lang="en" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Page Title  -->
    <title>Dashboard  | <?php echo getenv('APP_NAME'); ?></title>
    <meta name="description" content="<?php echo getenv('APP_DESCRIPTION'); ?>">
    
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../ops_assets/images/favicon.ico">

    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../ops_assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="../ops_assets/css/theme.css?ver=3.1.3">
    <link rel="stylesheet" href="../ops_assets/css/libs/fontawesome-icons.css?ver=3.1.3">


    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .section {
            margin-bottom: 40px;
            border: 1px solid;
            border-radius: 6px;
            padding: 10px;
        }
        .question {
            margin-bottom: 20px;
            border: 1px solid #73C1A4;
            border-radius: 5px;
            padding: 5px;
        }
        .subquestion{
            margin-bottom: 20px;
            border: 1px solid #C19273;
            border-radius: 6px;
            padding: 10px;
        }
        .btn {
            margin-bottom: 20px;
        }
        .nested {
            margin-left: 20px;
        }
    </style>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
                <?php $page = "index"; include "components/sidebar.php" ?>
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?php include "components/header.php" ?>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title"><?php echo $standard; ?> Gap Assessment (<?php echo $checklistCount ?>)</h3>
                                            <div class="nk-block-des text-soft">
                                                <h6 class="nk-block-title title"><?php echo $_SESSION['company']; ?> Workspace</h6>
                                            </div>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                    <ul class="nk-block-tools g-3">

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-block" >
                                    <div class="container-fluid">
                                        <div class="nk-content-inner">
                                            <div class="nk-content-body">
                                                <div class="nk-block">
                                                    <div class="card">
                                                        <div class="card-aside-wrap">
                                                            <div class="card-inner card-inner-lg"  id="content-container">
                                                                <h5>Select A Clause From The Menu</h5>
                                                            </div>
                                                            <div class="card-aside card-aside-left user-aside" data-toggle-screen="lg" data-toggle-overlay="true">
                                                                <div class="card-inner-group" data-simplebar>
                                                                    <div class="card-inner">
                                                                        <div class="user-card">
                                                                            <div class="user-avatar bg-primary">
                                                                                <span>AB</span>
                                                                            </div>
                                                                            <div class="user-info">
                                                                                <h5 class=""><?php echo $standard ?></h5>
                                                                                <h6 class="lead-text"><strong><?php echo count($checklist['results']); ?> Clauses</strong></h6>
                                                                            </div>
                                                                            <div class="user-action">
                                                                                <div class="dropdown">
                                                                                    <a class="btn btn-icon btn-trigger me-n2" data-bs-toggle="dropdown" href="#"><em class="icon ni ni-more-v"></em></a>
                                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                                        <ul class="link-list-opt no-bdr">
                                                                                            <li><a href="#"><em class="icon ni ni-camera-fill"></em><span>Change Photo</span></a></li>
                                                                                            <li><a href="#"><em class="icon ni ni-edit-fill"></em><span>Update Profile</span></a></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-inner">
                                                                        <div class="user-account-info py-0">
                                                                            <h6 class="overline-title-alt">Progress Status</h6>
                                                                            
                                                                            <div class="progress progress-lg">
                                                                                <div class="progress-bar" data-progress="50">50%</div>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-inner p-0">
                                                                        <ul class="link-list-menu">
                                                                            <?php foreach ($questions as $clauseData): ?>
                                                                                
                                                                                <li>
                                                                                    <a class="active load-content" href="clauses.php?c=<?php echo $clauseData['clauseNo'];?>&q=<?php echo $_GET['q']?>&count=$_GET['count']">
                                                                                        <em class="icon ni ni-user-fill-c"></em>
                                                                                        <span>Clause: <?php echo $clauseData['clauseNo']; ?></span>
                                                                                    </a>
                                                                                </li>

                                                                            <?php endforeach; ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- footer @s -->
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; <?php echo date('Y') ?> <a href="<?php echo getenv('COPYRIGHT_URL')?>" class="text-secondary"><?php echo getenv('APP_NAME')?>.</a> All Rights Reserved.
                            </div>
                            <div class="nk-footer-links"></div>
                        </div>
                    </div>
                </div>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- select region modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="region">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="title mb-4">Select Your Country</h5>
                    <div class="nk-country-region">
                        <ul class="country-list text-center gy-2">

                        </ul>
                    </div>
                </div>
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div><!-- .modal -->
    <!-- JavaScript -->
    <script src="../ops_assets/js/bundle.js?ver=3.1.3"></script>
    <script src="../ops_assets/js/scripts.js?ver=3.1.3"></script>
    <script src="../ops_assets/js/charts/chart-ecommerce.js?ver=3.1.3"></script>


    <script>

        // Function to load content via AJAX
        function loadContent(url) {
            // Use the XMLHttpRequest object to make an AJAX request
            var xhr = new XMLHttpRequest();

            // Set up the request
            xhr.open('GET', url, true);

            // Define a function to handle the response
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // If the request is successful, update the content
                    document.getElementById('content-container').innerHTML = xhr.responseText;
                }
            };

            // Send the request
            xhr.send();
        }

        // Attach a click event handler to each link with the class "load-content"
        var loadContentLinks = document.querySelectorAll('.load-content');
        loadContentLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the default link behavior (page refresh)
                var url = link.getAttribute('href');
                loadContent(url); // Load content via AJAX
            });
        });


        function handleResponse(response, element) {
            const questionContainer = element.closest('.question');
            const nested = questionContainer.querySelector('.nested');

            if (nested) {
                if (response === 'YES') {
                    nested.style.display = 'block';
                } 
                else {
                    nested.style.display = 'none';
                }
            }
        }


        function handleResponse2(response, element) {
            const questionContainer = element.closest('.question');
            const answerBox = questionContainer.querySelector('.answer-box');

            if (answerBox) {
                if (response === 'YES') {
                    answerBox.style.display = 'block';
                } 
                else {
                    answerBox.style.display = 'none';
                }
            }
        }
    </script>
</body>

</html>