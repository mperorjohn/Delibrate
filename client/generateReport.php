<?php
include "token.php";
include LIL . "encodeString.php";
include LIL . "decodeString.php";


$page = "Generate Report";

$curl  = curl_init();

$page = "Gap Assessment";




curl_setopt_array($curl, array(
    CURLOPT_URL => getenv('API_ROOT_DIR').'report/getQuestions.php',
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
  
$fetchedQuestions = json_decode(curl_exec($curl), true);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);



if ($fetchedQuestions['status'] == "success") {
    $questions = [];

    
    foreach ($fetchedQuestions['result'] as $row) {
        if (isset($row['Question'])) {
            $questions[] = $row['Question'];
        }
    }

   
   
} else {
    echo "<h3>Error getting questions from API</h3>" . $httpCode;
}


$standard = "ISO 20000";

$standard_description = "ISO 20000 is the international standard for IT Service Management (ITSM). It provides a framework for organizations to implement and manage IT services effectively, ensuring the quality and reliability of IT service delivery.";





?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="<?php echo getenv('APP_DESCRIPTION'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../ops_assets/images/favicon.ico">
    <!-- Page Title  -->
    <title><?php echo $page ?>  | <?php echo getenv('APP_NAME'); ?></title>
    <meta name="description" content="<?php echo getenv('APP_DESCRIPTION'); ?>">
    
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../ops_assets/css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="../ops_assets/css/theme.css?ver=3.1.3">
    <link rel="stylesheet" href="../ops_assets/css/libs/jstree.css?ver=3.1.3">
    <!-- <link rel="stylesheet" href="../ops_assets/css/libs/jstree.search.css"> -->
    <!-- <script src="../ops_assets/js/libs/jstree.search.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/dashlite.css?ver=3.1.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.1.3">

    
</head>
<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
                <?php $page="gap_assessment"; include "components/sidebar.php" ?>
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?php include "components/header.php" ?>
                <!-- main header @e -->
                    <!-- **************************************** MAIN CONTENT -->
                    <!-- <div class="nk-content "> -->
                        <div class="container-fluid">
                            <div class="nk-content-inner">
                                <div class="nk-content-body">
                                    <!-- <div class="components-preview wide-md mx-auto"> -->
                                        <div class="nk-block-head nk-block-head-lg wide-sm">
                                            <div class="nk-block-head-content">
                                                <div class="nk-block-head-sub"><a class="back-to" href="index.php"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                                            </div>
                                        </div><!-- .nk-block-head -->
                                        <!-- MAIN CONTENT -->
                                        <!-- <div class="col-md-6 col-xxl-3"> -->
                                            <div class="card h-100">
                                                <div class="card-inner">
                                                    <h4 class="nk-block-title text-center fw-bold">Gap Assessment Results for <?php echo $standard; ?></h4>
                                                    <div class="card-title-group">
                                                        <div class="card-title card-title-sm">
                                                            <h4 class="title">Gap Assessment Report</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-8 col-md-6 p-5">
                                                        <p class="nk-block fw-bold">Standard: <span class="fw-normal"><?php echo $standard; ?></span></p>
                                                        <p class=" fw-bold">Standard Description: <span class="fw-normal"><?php echo $standard_description; ?></span></p>
                                                    </div>
                                                    <div>
                                                        <ul>
                                                            <h4 class="text-center text-decoration-underline">Assessments</h4>
                                                            <?php for($i = 0; $i < count($questions); $i++):  ;?>
                                                                 <li class="mt-3"><?php echo  $i + 1 ."."  .   " "  .  " " . $questions[$i] ?>
                                                                 <span class="fw-bold">Answer:</span>
                                                         <?php endfor;?>
                                                        </ul>
                                                    </div>
                                                    <div class="traffic-channel mt-5">
                                                        <div class="traffic-channel-doughnut-ck">
                                                            <canvas class="analytics-doughnut" id="TrafficChannelDoughnutData"></canvas>
                                                        </div>
                                                        <div class="traffic-channel-group g-2">
                                                            <div class="traffic-channel-data">
                                                                <div class="title"><span class="dot dot-lg sq" data-bg="#9cabff"></span><span>Yes</span></div>
                                                                <div class="amount">4,305 <small>58.63%</small></div>
                                                            </div>
                                                            <div class="traffic-channel-data">
                                                                <div class="title"><span class="dot dot-lg sq" data-bg="#b8acff"></span><span>No</span></div>
                                                                <div class="amount">859 <small>23.94%</small></div>
                                                            </div>
                                                            <div class="traffic-channel-data">
                                                                <div class="title"><span class="dot dot-lg sq" data-bg="#ffa9ce"></span><span>Not Applicable</span></div>
                                                                <div class="amount">482 <small>12.94%</small></div>
                                                            </div>
                                                        </div><!-- .traffic-channel-group -->
                                                    </div><!-- .traffic-channel -->
                                                </div>
                                            <!-- </div>.card -->
                                        

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('TrafficChannelDoughnutData').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Yes', 'No', 'Not Applicable'],
                datasets: [{
                    data: [4305, 859, 482],
                    backgroundColor: ['#9cabff', '#b8acff', '#ffa9ce'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    });
</script>


                                           
                    <!-- ************************* MAIN CONTENT -->
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

<!-- Script -->
    <script src="./js/bundle.js?ver=3.1.3"></script>
    <script src="./js/scripts.js?ver=3.1.3"></script>
    <script src="./js/charts/chart-analytics.js?ver=3.1.3"></script>
    <script src="./js/libs/jqvmap.js?ver=3.1.3"></script>

   <!-- JavaScript -->
   <!-- <script src="../ops_assets/js/bundle.js?ver=3.1.3"></script> --> 
    <!-- <script src="../ops_assets/js/scripts.js?ver=3.1.3"></script> -->
    <!-- <script src="../ops_assets/js/libs/jstree.js?ver=3.1.3"></script>
    <script src="../ops_assets/js/example-tree.js?ver=3.1.3"></script>