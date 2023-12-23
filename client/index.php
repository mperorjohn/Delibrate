<?php
include "token.php";
include LIL . "encodeString.php";
include LIL . "truncateWord.php";
include_once 'apiCalls.php';
include_once 'secureApiCalls.php';

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

$fullName         = ucwords(strtolower($firstName.' '.$lastName));
$countOfService   = count(explode(",", $services));
$countOfStandards = count(explode(",", $standards));
$standards        = explode(",", $standards);


// Get All Standards
$sresponse   = getAllStandards('standards/getAllStandards.php', "getAllStandards");
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
                                            <h3 class="nk-block-title page-title"><?php echo $_SESSION['company']; ?> Workspace</h3>
                                            <div class="nk-block-des text-soft">
                                                <h6 class="nk-block-title title">Welcome, <?php echo $_SESSION['firstName'] ?></h6>
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
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="nk-content-inner">
                                        <div class="nk-content-body">

                                            <div class="nk-block nk-block-lg">

                                                <div class="card card-bordered card-preview">
                                                    <div class="card-inner">
                                                        <div class="nk-block-head">
                                                            <div class="nk-block-head-content">
                                                                <h6 class="title nk-block-title">Gap Assessment (<?php echo $countOfStandards; ?>) </h6>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <?php 
                                                            if ($sresponse['status'] == "success") {
                                                                for ($i=0; $i < sizeof($sresponse['results']); $i++) { 
                                                                    $allStandards = $sresponse['results'][$i];
                                                                    $standardId   = $allStandards['Id'];
                                                                    $standard     = $allStandards['Standards'];
                                                                    $description  = $allStandards['Description'];
                                                                    $status       = $allStandards['Status'];
                                                                    $title        = $allStandards['Title'];

                                                                    $thisStatus  = ($status == "1") ? "Active" : "Archived";
                                                                    $statusColor = ($status == "1") ? "bg-success" : "bg-danger";



                                                                    // Check if the string exactly occurs in the array
                                                                    if (in_array($standard, $standards)) {
                                                                        // Get Checklist Count 
                                                                        $checklistCount   = getChecklistCount('gapAssessment/getChecklistCount.php?standardId='.$standardId, "getChecklistCount", $accessToken);

                                                                        $queryString = http_build_query($allStandards);
                                                                        ?>
                                                                        <div class="col-md-4 col-lg-3">
                                                                            <div class="card">
                                                                                <div class="card-inner">
                                                                                    <div class="project">
                                                                                        <div class="project-head">
                                                                                            <a href="#" class="project-title">
                                                                                                <!-- <div class="user-avatar sq bg-purple"><span>DD</span></div> -->
                                                                                                <div class="project-info">
                                                                                                    <h6 class="title"><?php echo $standard ?></h6>
                                                                                                    <span class="sub-text"><?php echo $title; ?></span>
                                                                                                </div>
                                                                                            </a>
                                                                                            <div class="drodown">
                                                                                                <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger mt-n1 me-n1" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                                                    <ul class="link-list-opt no-bdr">
                                                                                                        <li><a href="#"><em class="icon ni ni-eye"></em><span>View Project</span></a></li>
                                                                                                        <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit Project</span></a></li>
                                                                                                        <li><a href="#"><em class="icon ni ni-check-round-cut"></em><span>Mark As Done</span></a></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="project-details">
                                                                                            <p><?php echo truncateWord($description, 90) ?></p>
                                                                                        </div>
                                                                                        <div class="project-progress">
                                                                                            <div class="project-progress-details">
                                                                                                <div class="project-progress-task"><em class="icon ni ni-check-round-cut"></em><span><?php echo $checklistCount['count']; ?> Tasks</span></div>
                                                                                                <div class="project-progress-percent">93.5%</div>
                                                                                            </div>
                                                                                            <div class="progress progress-pill progress-md bg-light">
                                                                                                <div class="progress-bar" data-progress="93.5"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="project-meta">
                                                                                            <ul class="project-users g-1">
                                                                                                <li>
                                                                                                    <div class="user-avatar sm bg-primary"><span>A</span></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="user-avatar sm bg-blue"><img src="./images/avatar/b-sm.jpg" alt=""></div>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <div class="user-avatar bg-light sm"><span>+12</span></div>
                                                                                                </li>
                                                                                            </ul>

                                                                                            <a href="checklist.php?q=<?php echo encodeString($queryString)?>&count=<?php echo $checklistCount['count']?>" class="btn btn-secondary btn-sm">Continue</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <?php
                                                                    }
                                                                }                                                                    
                                                            } 
                                                            ?>
                                                        </div>


                                                    </div>
                                                </div><!-- .card-preview -->
                                                <br>
                                            </div>
                                        </div>
                                    </div>                                                        
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
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


<script src="js/bootstrap.min.js"></script>
<!-- bootstrap progress js -->
<script src="js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="js/nicescroll/jquery.nicescroll.min.js"></script>
<!-- icheck -->
<script src="js/icheck/icheck.min.js"></script>
<script src="js/custom.js"></script>
<!-- pace -->
<script src="js/pace/pace.min.js"></script>

</body>

</html>