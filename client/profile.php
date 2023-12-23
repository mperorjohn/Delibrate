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
        function saveData(formId) {
            
            // Serialize the form data
            const formDataSerialized = $("#" + formId).serialize();
            $.ajax({
                type: "POST",
                url: "saveData.php?src=" + formId,
                data: {
                    formData: formDataSerialized
                },
                success: function (response) {
                    // Parse the JSON response
                    var responseData = JSON.parse(response);

                    console.log(responseData);
                    // Handle the success response
                    if (responseData.status == "success") {
                        // Reset the form content
                        $("#" + formId)[0].reset();

                        if (formId == "profile") {
                            var titleText   = 'Profile Undated Successfully';
                            var textText    = 'You Have Successfully Updated Your Profile';
                            var confirmText = 'OK';
                            var cancelText  = "Close";
                            var footerText  = 'NB: This Page Will Reload';
                        }

                        Swal.fire({
                            title: titleText,
                            text: textText,
                            icon: 'success',
                            showCancelButton: cancelText !== "", // Conditionally include the cancel button
                            cancelButtonText: cancelText,
                            confirmButtonText: confirmText,
                            footer: '<span style="font-weight:600; text-align:center; font-size:12px; color: #FC8787">' + footerText + '</span>'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (formId == "profile") {
                                    setTimeout(function () {
                                        location.reload(); // Reload the page
                                    }, 100);
                                }
                            } 
                            else if (result.isDenied) {
                                if (formId == "profile") {
                                    setTimeout(function () {
                                        location.reload(); // Reload the page
                                    }, 100);
                                }
                                else {
                                    Swal.fire('Changes are not saved', '', 'info');
                                    // Reset the form content
                                    $("#" + formId)[0].reset();
                                }
                            }
                            else{
                                if (formId == "profile") {
                                    setTimeout(function () {
                                        location.reload(); // Reload the page
                                    }, 100);
                                }
                            }
                        });
                    } else {
                        // Handle error response 
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: responseData.message,
                            footer: '<span style="font-weight:700; text-align:center; font-size:20px; color:red">Check Your Form, and Correct All Errors. Asterisk (*) Fields Are Required</span>'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Handle the error response
                    console.log("Error: " + error);
                }
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
                                                            <h4 class="nk-block-title">Personal Information</h4>
                                                            <div class="nk-block-des">
                                                                <p>Basic info, like your name and address, that you use on <?php echo getenv('APP_NAME') ?> Platform.</p>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-sm btn-primary" type="button"  data-bs-toggle="modal" data-bs-target="#profile-edit" style="float: right;">Update</button>
                                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-block">
                                                    <div class="nk-data data-list">
                                                        <div class="data-head">
                                                            <h6 class="overline-title">Basics</h6>
                                                        </div>
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                            <div class="data-col">
                                                                <span class="data-label">Full Name</span>
                                                                <span class="data-value"><?php echo $firstName ?> <?php echo $lastName ?></span>
                                                            </div>
                                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                                        </div>
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                            <div class="data-col">
                                                                <span class="data-label">Personal Email</span>
                                                                <span class="data-value"><?php echo $emailAddress ?></span>
                                                            </div>
                                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                                        </div>
                                                        <div class="data-item">
                                                            <div class="data-col">
                                                                <span class="data-label">Cooporate Email</span>
                                                                <span class="data-value"><?php echo $companyEmail ?></span>
                                                            </div>
                                                            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                                        </div>
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                            <div class="data-col">
                                                                <span class="data-label">Phone Number</span>
                                                                <span class="data-value text-soft"><?php echo $phoneNumber ?></span>
                                                            </div>
                                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                                        </div>
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                                            <div class="data-col">
                                                                <span class="data-label">Date Joined</span>
                                                                <span class="data-value"><?php echo $formattedDate = date("D, j F Y - g:ia", strtotime($dateCreated)); ?></span>
                                                            </div>
                                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                                        </div>
                                                        <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit" data-tab-target="#address">
                                                            <div class="data-col">
                                                                <span class="data-label">Company </span>
                                                                <span class="data-value"><?php echo $companyName; ?></span>
                                                            </div>
                                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                                        </div>
                                                    </div><!-- data-list -->
                                                    <div class="nk-data data-list">
                                                        <div class="data-head">
                                                            <h6 class="overline-title">Preferences</h6>
                                                        </div>
                                                        <div class="data-item">
                                                            <div class="data-col">
                                                                <span class="data-label">Language</span>
                                                                <span class="data-value">English (United State)</span>
                                                            </div>
                                                            <div class="data-col data-col-end"><a href="#" class="link link-primary">Change Language</a></div>
                                                        </div>
                                                        <div class="data-item">
                                                            <div class="data-col">
                                                                <span class="data-label">Date Format</span>
                                                                <span class="data-value">D d, M YYYY</span>
                                                            </div>
                                                            <div class="data-col data-col-end"><a href="#" class="link link-primary">Change</a></div>
                                                        </div>
                                                        <div class="data-item">
                                                            <div class="data-col">
                                                                <span class="data-label">Timezone</span>
                                                                <span class="data-value">Lagos/Africa (GMT +1)</span>
                                                            </div>
                                                            <div class="data-col data-col-end"><a href="#" class="link link-primary">Change</a></div>
                                                        </div>
                                                    </div><!-- data-list -->
                                                </div><!-- .nk-block -->
                                            </div>
                                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                                <div class="card-inner-group" data-simplebar>
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
                                                    </div><!-- .card-inner -->
                                                    
                                                    <div class="card-inner p-0">
                                                        <ul class="link-list-menu">
                                                            <li><a class="active" href="profile.php"><em class="icon ni ni-user-fill-c"></em><span>Personal Infomation</span></a></li>
                                                            <li><a href="profileActivities.php"><em class="icon ni ni-activity-round-fill"></em><span>Account Activity</span></a></li>
                                                            <li><a href="team.php"><em class="icon ni ni-users"></em><span>Team</span></a></li>
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
                            <!-- <a class="nav-link" data-bs-toggle="tab" href="#address">Address</a> -->
                        </li>
                    </ul><!-- .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <form id="profile">
                                <input type="hidden" name="userId" value="<?php echo $userId ?>">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name">First Name</label>
                                            <input type="text" class="form-control form-control-lg" name="firstName" value="<?php echo $firstName ?>" placeholder="Enter First Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="display-name">Last Name</label>
                                            <input type="text" class="form-control form-control-lg" name="lastName" value="<?php echo $lastName ?>" placeholder="Enter Last Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="phone-no">Phone Number</label>
                                            <input type="text" class="form-control form-control-lg" name="phoneNumber" value="<?php echo $phoneNumber ?>" placeholder="Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="birth-day">Personal Email</label>
                                            <input type="text" class="form-control form-control-lg" name="emailAddress" value="<?php echo $emailAddress ?>" placeholder="Personal Email Address">
                                        </div>
                                    </div>
                                    

                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <button type="button" onclick="saveData('profile');" class="btn btn-lg btn-primary">Update Profile</button>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../ops_assets/js/bundle.js?ver=3.1.3"></script>
    <script src="../ops_assets/js/scripts.js?ver=3.1.3"></script>
    <script src="../ops_assets/js/charts/chart-ecommerce.js?ver=3.1.3"></script>
</body>

</html>