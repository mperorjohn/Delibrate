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

// var_dump($response);
// die;

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
                                                            <h4 class="nk-block-title">Team Members</h4>
                                                            <div class="nk-block-des">
                                                                
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-sm btn-outline-primary" style="margin: 0 5px;" type="button"  data-bs-toggle="modal" data-bs-target="#profile-edit" style="float: right;">Manage Roles</button>

                                                            <button class="btn btn-sm btn-primary" style="margin: 0 5px;" type="button"  data-bs-toggle="modal" data-bs-target="#invite-user" style="float: right;">Invite Someone</button>
                                                        </div>
                                                        
                                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                                    <thead>
                                                        <tr class="nk-tb-item nk-tb-head">
                                                            <th class="nk-tb-col"><span class="sub-text">Name</span></th>
                                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Email Address</span></th>
                                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Role</span></th>
                                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Verified</span></th>
                                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Last Login</span></th>
                                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                                                            <th class="nk-tb-col nk-tb-col-tools text-end">
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="nk-tb-item">
                                                            <td class="nk-tb-col">
                                                                <div class="user-card">
                                                                    <div class="user-info">
                                                                        <span class="tb-lead">Abu Bin Ishtiyak <span class="dot dot-success d-md-none ms-1"></span></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                                                                <span class="tb-amount">35040.34 <span class="currency">USD</span></span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span>+811 847-4958</span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-lg" data-order="Email Verified - Kyc Unverified">
                                                                <ul class="list-status">
                                                                    <li><em class="icon text-success ni ni-check-circle"></em> <span>Email</span></li>
                                                                    <li><em class="icon ni ni-alert-circle"></em> <span>KYC</span></li>
                                                                </ul>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-lg">
                                                                <span>05 Oct 2019</span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span class="tb-status text-success">Active</span>
                                                            </td>
                                                            <td class="nk-tb-col nk-tb-col-tools">
                                                                <ul class="nk-tb-actions gx-1">
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Wallet">
                                                                            <em class="icon ni ni-wallet-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Email">
                                                                            <em class="icon ni ni-mail-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspend">
                                                                            <em class="icon ni ni-user-cross-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <div class="drodown">
                                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-repeat"></em><span>Transaction</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Activities</span></a></li>
                                                                                    <li class="divider"></li>
                                                                                    <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-shield-off"></em><span>Reset 2FA</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend User</span></a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        <tr class="nk-tb-item">
                                                            <td class="nk-tb-col">
                                                                <div class="user-card">
                                                                    <div class="user-info">
                                                                        <span class="tb-lead">Jane Montgomery <span class="dot dot-success d-md-none ms-1"></span></span>
                                                                        <span>jane84@example.com</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-mb" data-order="0.00">
                                                                <span class="tb-amount">0.00 <span class="currency">USD</span></span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span>+439 271-5360</span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-lg" data-order="Email Unverified - Kyc Unverified">
                                                                <ul class="list-status">
                                                                    <li><em class="icon ni ni-check-circle"></em> <span>Email</span></li>
                                                                    <li><em class="icon ni ni-alert-circle"></em> <span>KYC</span></li>
                                                                </ul>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-lg">
                                                                <span>01 Feb 2020</span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span class="tb-status text-danger">Suspend</span>
                                                            </td>
                                                            <td class="nk-tb-col nk-tb-col-tools">
                                                                <ul class="nk-tb-actions gx-1">
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Wallet">
                                                                            <em class="icon ni ni-wallet-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Email">
                                                                            <em class="icon ni ni-mail-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspend">
                                                                            <em class="icon ni ni-user-cross-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <div class="drodown">
                                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-repeat"></em><span>Transaction</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Activities</span></a></li>
                                                                                    <li class="divider"></li>
                                                                                    <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-shield-off"></em><span>Reset 2FA</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend User</span></a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr><!-- .nk-tb-item  -->
                                                        <tr class="nk-tb-item">
                                                            <td class="nk-tb-col">
                                                                <div class="user-card">
                                                                    <div class="user-info">
                                                                        <span class="tb-lead">Frances Burns <span class="dot dot-success d-md-none ms-1"></span></span>
                                                                        <span>info@softnio.com</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-mb" data-order="42.50">
                                                                <span class="tb-amount">42.50 <span class="currency">USD</span></span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span>+639 130-3150</span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-lg" data-order="Email Submited - Kyc Unverified">
                                                                <ul class="list-status">
                                                                    <li><em class="icon text-info ni ni-check-circle"></em> <span>Email</span></li>
                                                                    <li><em class="icon ni ni-alert-circle"></em> <span>KYC</span></li>
                                                                </ul>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-lg">
                                                                <span>31 Jan 2020</span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span class="tb-status text-success">Active</span>
                                                            </td>
                                                            <td class="nk-tb-col nk-tb-col-tools">
                                                                <ul class="nk-tb-actions gx-1">
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Wallet">
                                                                            <em class="icon ni ni-wallet-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Email">
                                                                            <em class="icon ni ni-mail-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspend">
                                                                            <em class="icon ni ni-user-cross-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <div class="drodown">
                                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-repeat"></em><span>Transaction</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Activities</span></a></li>
                                                                                    <li class="divider"></li>
                                                                                    <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-shield-off"></em><span>Reset 2FA</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend User</span></a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr><!-- .nk-tb-item  -->
                                                        <tr class="nk-tb-item">
                                                            <td class="nk-tb-col">
                                                                <div class="user-card">
                                                                    <div class="user-info">
                                                                        <span class="tb-lead">Alan Butler<span class="dot dot-success d-md-none ms-1"></span></span>
                                                                        <span>butler@example.com</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-mb" data-order="440.34">
                                                                <span class="tb-amount">440.34 <span class="currency">USD</span></span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span>+963 309-1706</span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-lg" data-order="Email Submited - Kyc More Info">
                                                                <ul class="list-status">
                                                                    <li><em class="icon text-info ni ni-check-circle"></em> <span>Email</span></li>
                                                                    <li><em class="icon text-warning ni ni-alert-circle"></em> <span>KYC</span></li>
                                                                </ul>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-lg">
                                                                <span>18 Jan 2020</span>
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span class="tb-status text-info">Inactive</span>
                                                            </td>
                                                            <td class="nk-tb-col nk-tb-col-tools">
                                                                <ul class="nk-tb-actions gx-1">
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Wallet">
                                                                            <em class="icon ni ni-wallet-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Email">
                                                                            <em class="icon ni ni-mail-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspend">
                                                                            <em class="icon ni ni-user-cross-fill"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <div class="drodown">
                                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-repeat"></em><span>Transaction</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Activities</span></a></li>
                                                                                    <li class="divider"></li>
                                                                                    <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-shield-off"></em><span>Reset 2FA</span></a></li>
                                                                                    <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend User</span></a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr><!-- .nk-tb-item  -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                                <div class="card-inner-group" data-simplebar>
                                                    <div class="card-inner">
                                                        <div class="user-card">
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
                                                    </div><!-- .card-inner -->
                                                    
                                                    <div class="card-inner p-0">
                                                        <ul class="link-list-menu">
                                                            <li><a href="profile.php"><em class="icon ni ni-user-fill-c"></em><span>Personal Infomation</span></a></li>
                                                            <li><a href="profileActivities.php"><em class="icon ni ni-activity-round-fill"></em><span>Account Activity</span></a></li>
                                                            <li><a class="active" href="team.php"><em class="icon ni ni-users"></em><span>Team</span></a></li>
                                                            <li><a href="profileSecurity.php"><em class="icon ni ni-lock-alt-fill"></em><span>Security Settings</span></a></li>
                                                        </ul>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .card-inner-group -->
                                            </div><!-- card-aside -->
                                        </div><!-- .card-aside-wrap -->
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

    <!-- @@ Profile Edit Modal @e -->
    <div class="modal fade" role="dialog" id="invite-user">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Invite Team Member</h5>
                    <ul class="nk-nav nav nav-tabs">
                        <!--<li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personal">Single</a>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#address">Bulk</a>
                        </li> -->
                    </ul><!-- .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Email Address</label>
                                        <input type="text" class="form-control form-control-lg" id="full-name" placeholder="Enter Email Address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="display-name">Choose Role</label>
                                        <select name="" id="" class="form-control form-control-lg">
                                            <option value="">Select Role</option>
                                            <option value="IMS Manager">IMS Manager</option>
                                            <option value="IMS Manager - assist">IMS Manager - assist</option>
                                            <option value="QMS Manager">QMS Manager</option>
                                            <option value="BCMS Manager">BCMS Manager</option>
                                            <option value="BCMS Manager-assist">BCMS Manager-assist</option>
                                            <option value="ISMS Manager">ISMS Manager</option>
                                            <option value="ISMS Manager-assist">ISMS Manager-assist</option>
                                            <option value="SMS Manager">SMS Manager</option>
                                            <option value="Records Manager">Records Manager</option>
                                            <option value="Lead Internal Auditor">Lead Internal Auditor</option>
                                            <option value="Internal Auditor">Internal Auditor</option>
                                            <option value="Service Catalogue Manager">Service Catalogue Manager</option>
                                            <option value="Product Owner">Product Owner</option>
                                            <option value="Service Owner">Service Owner</option>
                                            <option value="Asset Manager">Asset Manager</option>
                                            <option value="Capacity and Demand Manager">Capacity and Demand Manager</option>
                                            <option value="Incident Manager">Incident Manager</option>
                                            <option value="Request manager">Request manager</option>
                                            <option value="Compliance and Legal">Compliance and Legal</option>
                                            <option value="Problem Manager">Problem Manager</option>
                                            <option value="Document Controller">Document Controller</option>
                                            <option value="Availability Manager">Availability Manager</option>
                                            <option value="Business Relationship Manager">Business Relationship Manager</option>
                                            <option value="QA Service Owner">QA Service Owner</option>
                                            <option value="Supplier Manager">Supplier Manager</option>
                                            <option value="Configuration Manager">Configuration Manager</option>
                                            <option value="Change Manager">Change Manager</option>
                                            <option value="Service Level Manager">Service Level Manager</option>
                                            <option value="Design, Build and Transition manager">Design, Build and Transition manager</option>
                                            <option value="Release and deployment manager">Release and deployment manager</option>
                                            <option value="R & D Manager">R & D Manager</option>
                                        </select>
                                    </div>
                                </div>
                                

                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <a href="#" data-bs-dismiss="modal" class="btn btn-md btn-primary">Invite Team Member</a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" id="profile-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Update Profile</h5>
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personal">Personal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#address">Address</a>
                        </li>
                    </ul><!-- .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">First Name</label>
                                        <input type="text" class="form-control form-control-lg" id="full-name" value="<?php echo $firstName ?>" placeholder="Enter First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="display-name">Last Name</label>
                                        <input type="text" class="form-control form-control-lg" id="display-name" value="<?php echo $lastName ?>" placeholder="Enter Last Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="phone-no">Phone Number</label>
                                        <input type="text" class="form-control form-control-lg" id="phone-no" value="<?php echo $phoneNumber ?>" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="birth-day">Personal Email</label>
                                        <input type="text" class="form-control form-control-lg" value="<?php echo $emailAddress ?>" placeholder="Personal Email Address">
                                    </div>
                                </div>
                                

                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <a href="#" data-bs-dismiss="modal" class="btn btn-lg btn-primary">Update Profile</a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .tab-pane -->
                        <div class="tab-pane" id="address">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-l1">Address Line 1</label>
                                        <input type="text" class="form-control form-control-lg" id="address-l1" value="2337 Kildeer Drive">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-l2">Address Line 2</label>
                                        <input type="text" class="form-control form-control-lg" id="address-l2" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-st">State</label>
                                        <input type="text" class="form-control form-control-lg" id="address-st" value="Kentucky">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-county">Country</label>
                                        <select class="form-select js-select2" id="address-county" data-ui="lg">
                                            <option>Canada</option>
                                            <option>United State</option>
                                            <option>United Kindom</option>
                                            <option>Australia</option>
                                            <option>India</option>
                                            <option>Bangladesh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <a href="#" class="btn btn-lg btn-primary">Update Address</a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .tab-pane -->
                    </div><!-- .tab-content -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div>

    <script src="../ops_assets/js/bundle.js?ver=3.1.3"></script>
    <script src="../ops_assets/js/scripts.js?ver=3.1.3"></script>
    <script src="../ops_assets/js/charts/chart-ecommerce.js?ver=3.1.3"></script>
</body>

</html>