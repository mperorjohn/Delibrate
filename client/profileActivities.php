<?php
include "token.php";
include LIL . "encodeString.php";
include LIL . "decodeString.php";
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
$principalFirstName    = $customers['FirstName'];
$principalLastName     = $customers['LastName'];
$companyName           = $customers['CompanyName'];
$companyEmail          = $customers['CompanyEmail'];
$role                  = $customers['Role'];
$industry              = $customers['Industry'];
$principalEmailAddress = $customers['EmailAddress'];
$principalPhoneNumber  = $customers['PhoneNumber'];
$services              = $customers['Services'];
$otherServices         = $customers['OtherServices'];
$standards             = $customers['Standards'];
$additionalInformation = $customers['AdditionalInformation'];
$salesFunnel           = $customers['SalesFunnel'];
$dateCreated           = $customers['DateCreated'];
$dateUpdated           = $customers['DateUpdated'];



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => getenv('API_ROOT_DIR').'auth/getUserLogs.php',
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

$activities = json_decode(curl_exec($curl),true);
$httpCode   = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);
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
            padding: 20px;
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

        .custom-question {
            display: none;
        }

        .current {
            display: block;
        }
    </style>


    <script>   
        function loadClause(clauseNo){
            var q = '<?php echo $_GET['q']; ?>';
            var count = '<?php echo $checklistCount; ?>';
            

            $.ajax({
                    type:"post",
                    url:"clauses.php?c="+clauseNo+"&q="+q+"&count="+count,
                    data:"",
                    success:function(data){
                     $("#content-container").html(data);

                     loadScript('question-handler.js', function () {
                        // Script has been loaded and executed
                        // You can now call functions or perform actions from the loaded script
                    });
                 }
            });


            // Function to load an external script dynamically
            function loadScript(url, callback) {
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = url;
                script.onload = callback; // Trigger the callback function when the script has loaded
                document.head.appendChild(script);
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
        }   
    </script>
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
                                <div class="nk-block">
                                    <div class="card">
                                        <div class="card-aside-wrap">
                                            <div class="card-inner card-inner-lg">
                                                <div class="nk-block-head nk-block-head-lg">
                                                    <div class="nk-block-between">
                                                        <div class="nk-block-head-content">
                                                            <h4 class="nk-block-title">Login Activity</h4>
                                                            <div class="nk-block-des">
                                                                <p>Here is your last 20 login activities log. <span class="text-soft"><em class="icon ni ni-info"></em></span></p>
                                                            </div>
                                                        </div>
                                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block-head -->
                                                <div class="nk-block card">
                                                    <table class="table table-ulogs">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <!-- <th></th> -->
                                                                <th class="tb-col-os"><span class="overline-title">Browser <span class="d-sm-none">/ IP</span></span></th>
                                                                <th class="tb-col-ip"><span class="overline-title">IP</span></th>
                                                                <th class="tb-col-time"><span class="overline-title">Time</span></th>
                                                                <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                if ($activities['count'] > 0 && is_array($activities['results'])){
                                                                    for ($i=0; $i < count($activities['results']); $i++) { 
                                                                        $activity     = $activities['results'][$i];
                                                                        $browser      = $activity['BrowserName'];
                                                                        $deviceType   = $activity['DeviceType'];
                                                                        $ipAddress    = $activity['IPAddress'];
                                                                        $activityDate = $activity['ActivityDate'];
                                                                        $activityTime = $activity['ActivityTime'];
                                                                        ?>
                                                                            <tr>
                                                                                <!-- <td class="tb-col-ip"><span class="sub-text"><?php //echo ($i+1) ?></span></td> -->
                                                                                <td class="tb-col-os"><span class="sub-text"><?php echo $browser ?> - <?php echo $deviceType ?></span></td>
                                                                                <td class="tb-col-ip"><span class="sub-text"><?php echo $ipAddress ?></span></td>
                                                                                <td class="tb-col-time"><span class="sub-text"><?php echo date("M j, Y, H:i:s a", strtotime($activityDate." ".$activityTime)) ?></span></td>
                                                                                <td class="tb-col-action"></td>
                                                                            </tr>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div><!-- .nk-block-head -->
                                            </div>
                                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                                <div class="card-inner-group">
                                                    <div class="card-inner">
                                                        <div class="user-card">
                                                            <div class="user-avatar bg-primary">
                                                                <span>AB</span>
                                                            </div>
                                                            <div class="user-info">
                                                                <span class="lead-text"><?php echo $firstName ?> <?php echo $lastName ?></span>
                                                                <span class="sub-text"><?php echo $companyName; ?></span>
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
                                                        </div><!-- .user-card -->
                                                    </div>
                                                    <div class="card-inner p-0">
                                                        <ul class="link-list-menu">
                                                            <li><a href="profile.php"><em class="icon ni ni-user-fill-c"></em><span>Personal Infomation</span></a></li>
                                                            <li><a class="active" href="profileActivities.php"><em class="icon ni ni-activity-round-fill"></em><span>Account Activity</span></a></li>
                                                            <li><a href="team.php"><em class="icon ni ni-users"></em><span>Team</span></a></li>
                                                            <li><a href="profileSecurity.php"><em class="icon ni ni-lock-alt-fill"></em><span>Security Settings</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div><!-- .card-inner-group -->
                                            </div><!-- card-aside -->
                                        </div><!-- card-aside-wrap -->
                                    </div><!-- .card -->
                                </div><!-- .nk-block -->
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
</body>

</html>