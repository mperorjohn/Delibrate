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

// Get All Standards
$sresponse   = getAllStandards('standards/getAllStandards.php', "getAllStandards");

// Get Checklists
$checklist = getGapAssessmentChecklistClient('gapAssessment/getGapAssessmentChecklistClient.php?standardId='.$standardId, "getGapAssessmentChecklistClient", $accessToken);
$questions = $checklist['results'];

$clause = $_GET['c'];

$extractedClause = [];

$clausesNumbers = array();

// var_dump($questions);
// die;
foreach ($questions as $key => $item) {
    $clausesIds[] = $item['clauseId'];
    $clausesNumbers[] = $item['clauseNo'];
    // echo $key."<br>";
    if (isset($item['clauseNo']) && $item['clauseNo'] === $clause) {
        $extractedClause[] = $item;
        $activeKey = $key;
        $clauseId = $clausesIds[$key];
    }
}

$previousKey   = $activeKey - 1;
$nextKey       = $activeKey + 1;
$clauseContext = $extractedClause[0]['clause'];

$previousClause = empty($clausesNumbers[$previousKey]) ? "" : $clausesNumbers[$previousKey];
$activeClause   = $clausesNumbers[$activeKey];
$nextClause     = empty($clausesNumbers[$nextKey]) ? "" : $clausesNumbers[$nextKey];

$prevButtonStatus = ($previousKey < 0) ? "disabled" : "";
$nextButtonStatus = (empty($nextClause)) ? "disabled" : "";

// var_dump($clausesIds);
// echo "<br>";
// echo $clauseId;

// echo "<br>";
// echo "Previous: ".$clausesNumbers[$previousKey];
// echo "<br>";
// echo "Current: ".$clausesNumbers[$activeKey];
// echo "<br>";
// echo "Next: ".$clausesNumbers[$nextKey];
?>

<!DOCTYPE html>

<script>
    var currentClauseIndex = <?php echo $clause; ?>;
    var totalClauses = <?php echo $checklistCount; ?>;

    document.addEventListener("DOMContentLoaded", function () {


    });
  </script>

<div class="nk-block-head nk-block-head-lg">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h4 class="nk-block-title">
                Clause <?php echo $clause; ?> 
            </h4>
            <div class="nk-block-des">
                <h5><?php echo $clauseContext ?></h5>
            </div>
        </div>
        <div class="nk-block-head-content align-self-start d-lg-none">
            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
        </div>
    </div>
</div>


<form id="cbtForm">

    <!-- <input type="text" id="clauseId" value="<?php //echo $clauseId; ?>"> -->
    <div id="question-bank">

        <!-- Level One Questions -->
        <?php
        // Initialize variables
        $totalQuestions       = 0; // Count of all questions
        $currentQuestionIndex = 0; // Current question index
        foreach ($extractedClause as $clause) {
             // Count the main questions
            $totalQuestions += count($clause['Questions']);

            foreach ($clause['Questions'] as $mainQuestion) {

                // Count the sub questions
                $totalQuestions += count($mainQuestion['P2Questions']);
                
                // Increment the current question index
                $currentQuestionIndex++;

                echo '<div class="custom-question question">';
                echo '<h5 class="title d-lg-block">' . $mainQuestion['question'] . '</h5>';
                ?>
                <br>
                <div class="custom-control custom-control-sm custom-radio custom-control-pro" style="margin-left:3px;">
                    <div class="custom-control custom-control-md custom-radio">
                        <input type="radio" id="customRadio1<?php echo $mainQuestion['questionId']; ?>" name="q<?php echo $mainQuestion['questionId']; ?>" class="custom-control-input" value="yes">
                        <label class="custom-control-label" for="customRadio1<?php echo $mainQuestion['questionId']; ?>"><b>YES</b></label>
                    </div>
                </div>
                <div class="custom-control custom-control-sm custom-radio custom-control-pro" style="float: right; margin-right:20px; padding-right:20px ;">
                    <div class="custom-control custom-control-md custom-radio">
                        <input type="radio" id="customRadio2<?php echo $mainQuestion['questionId']; ?>" name="q<?php echo $mainQuestion['questionId']; ?>" class="custom-control-input" value="no">
                        <label class="custom-control-label" for="customRadio2<?php echo $mainQuestion['questionId']; ?>"><b>NO</b></label>
                    </div>
                </div>

                
                <div class="nk-msg-reply nk-reply" data-simplebar>
                    <div class="nk-reply-form">
                        <div class="nk-reply-form-header">
                            <ul class="nav nav-tabs-s2 nav-tabs nav-tabs-sm">
                                <li class="nav-item">
                                    <?php if (!empty($mainQuestion['responseId'])): ?>                                        
                                        <a class="nav-link active text-danger" data-bs-toggle="tab" href="#reply-form"><?php echo $mainQuestion['responseName'] ?></a>
                                    <?php endif ?>
                                    <?php if (empty($mainQuestion['responseId'])): ?>                                        
                                        <a class="nav-link active" data-bs-toggle="tab" href="#reply-form">Additional Information</a>
                                    <?php endif ?>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#note-form">Private Note</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Additional Info -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="reply-form">
                                <div class="nk-reply-form-editor" style="margin-bottom: -15px;">
                                    <div class="nk-reply-form-field">
                                        <?php if (!empty($mainQuestion['responseId'])): ?>
                                            <code><b>Required (*)</b></code>
                                        <?php endif ?>

                                        <textarea class="form-control form-control-simple no-resize" placeholder="<?php echo (!empty($mainQuestion['responseId'])) ? $mainQuestion['responseName'] . ' (Required)' : 'Type your feedback here (Optional)';?>"></textarea>
                                    </div>
                                    <div class="nk-reply-form-tools" style="padding: 0px 10px;">
                                        <ul class="nk-reply-form-actions g-1">
                                            <li>
                                                <a class="btn btn-icon btn-sm" data-bs-toggle="dropdown" href="#"><em class="icon ni ni-hash" data-bs-toggle="tooltip" data-bs-placement="top" title="Insert URL"></em></a>
                                            </li>
                                            <li>
                                                <a class="btn btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Attachment" href="#"><em class="icon ni ni-clip-v"></em></a>
                                            </li>
                                            <li>
                                                <a class="btn btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Images" href="#"><em class="icon ni ni-img"></em></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Private Info -->
                            <div class="tab-pane" id="note-form">
                                <div class="nk-reply-form-editor" style="margin-bottom: -15px;">
                                    <div class="nk-reply-form-field">
                                        <textarea class="form-control form-control-simple no-resize" placeholder="Type your private note, that only visible to internal team."></textarea>
                                    </div>
                                    <div class="nk-reply-form-tools" style="padding: 0px 10px;">
                                        <ul class="nk-reply-form-actions g-1">
                                            <li>
                                                <a class="btn btn-icon btn-sm" data-bs-toggle="dropdown" href="#"><em class="icon ni ni-hash" data-bs-toggle="tooltip" data-bs-placement="top" title="Insert URL"></em></a>
                                            </li>
                                            <li>
                                                <a class="btn btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Attachment" href="#"><em class="icon ni ni-clip-v"></em></a>
                                            </li>
                                            <li>
                                                <a class="btn btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Images" href="#"><em class="icon ni ni-img"></em></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Level Two Questions -->
                <?php
                echo '</div>';
                
                foreach ($mainQuestion['P2Questions'] as $subQuestion) {

                    // Increment the current question index
                    $currentQuestionIndex++;

                    echo '<div class="custom-question question">';
                    echo '<h4 class="title d-lg-block">'. $subQuestion['question']. '</h4>';
                    // echo '<label>' . $subQuestion['question'] . '</label>';
                    ?>
                    <br>
                    <div class="custom-control custom-control-sm custom-radio custom-control-pro" style="margin-left:3px;">
                        <div class="custom-control custom-control-md custom-radio">
                            <input type="radio" id="customRadio1<?php echo $subQuestion['questionId']; ?>" name="q<?php echo $subQuestion['questionId']; ?>" class="custom-control-input" value="yes">
                            <label class="custom-control-label" for="customRadio1<?php echo $subQuestion['questionId']; ?>"><b>YES</b></label>
                        </div>
                    </div>
                    <div class="custom-control custom-control-sm custom-radio custom-control-pro" style="float: right; margin-right:20px; padding-right:20px ;">
                        <div class="custom-control custom-control-md custom-radio">
                            <input type="radio" id="customRadio2<?php echo $subQuestion['questionId']; ?>" name="q<?php echo $subQuestion['questionId']; ?>" class="custom-control-input" value="no">
                            <label class="custom-control-label" for="customRadio2<?php echo $subQuestion['questionId']; ?>"><b>NO</b></label>
                        </div>
                    </div>
                    


                    <div class="nk-msg-reply nk-reply" data-simplebar>
                        <div class="nk-reply-form">
                            <div class="nk-reply-form-header">
                                <ul class="nav nav-tabs-s2 nav-tabs nav-tabs-sm">
                                    <li class="nav-item">
                                        <?php if (!empty($subQuestion['responseId'])): ?>                                        
                                            <a class="nav-link active text-danger" data-bs-toggle="tab" href="#reply-form"><?php echo $subQuestion['responseName'] ?></a>
                                        <?php endif ?>
                                        <?php if (empty($subQuestion['responseId'])): ?>                                        
                                            <a class="nav-link active" data-bs-toggle="tab" href="#reply-form">Additional Information</a>
                                        <?php endif ?>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#note-form">Private Note</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Additional Info -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="reply-form">
                                    <div class="nk-reply-form-editor" style="margin-bottom: -15px;">
                                        <div class="nk-reply-form-field">
                                            <?php if (!empty($subQuestion['responseId'])): ?>
                                                <code><b>Required (*)</b></code>
                                            <?php endif ?>

                                            <textarea class="form-control form-control-simple no-resize" placeholder="<?php echo (!empty($subQuestion['responseId'])) ? $subQuestion['responseName'] . ' (Required)' : 'Type your feedback here (Optional)';?>" id="response_text"></textarea>
                                        </div>
                                        <div class="nk-reply-form-tools" style="padding: 0px 10px;">
                                            <ul class="nk-reply-form-actions g-1">
                                                <li>
                                                    <a class="btn btn-icon btn-sm" data-bs-toggle="dropdown" href="#"><em class="icon ni ni-hash" data-bs-toggle="tooltip" data-bs-placement="top" title="Insert URL"></em></a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Attachment" href="#"><em class="icon ni ni-clip-v"></em></a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Images" href="#"><em class="icon ni ni-img"></em></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Private Info -->
                                <div class="tab-pane" id="note-form">
                                    <div class="nk-reply-form-editor" style="margin-bottom: -15px;">
                                        <div class="nk-reply-form-field">
                                            <textarea class="form-control form-control-simple no-resize" placeholder="Type your private note, that only visible to internal team."></textarea>
                                        </div>
                                        <div class="nk-reply-form-tools" style="padding: 0px 10px;">
                                            <ul class="nk-reply-form-actions g-1">
                                                <li>
                                                    <a class="btn btn-icon btn-sm" data-bs-toggle="dropdown" href="#"><em class="icon ni ni-hash" data-bs-toggle="tooltip" data-bs-placement="top" title="Insert URL"></em></a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Attachment" href="#"><em class="icon ni ni-clip-v"></em></a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Images" href="#"><em class="icon ni ni-img"></em></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo '</div>';
                    
                }
            }

            ?>
            <?php
        }
        $showNav = isset($mainQuestion['question']) && !empty($mainQuestion['question']) ? "1" :  "0";
        ?>

        <?php 
            
        ?>
        <br>
        <?php if ($showNav == "1"): ?>
            <button id="prevButton" class="btn btn-sm btn-primary" type="button" disabled>Previous</button>
            <button id="nextButton" class="btn btn-sm btn-primary" type="button" onclick="">Next</button>

            <div style="float: right;">
                <button class="btn btn-sm btn-primary" style="" type="button" style="margin-left: 5px">Save</button>
                <button class="btn btn-sm btn-danger" style="" type="button" style="margin-right: 5px">Submit</button>
            </div>

            <br>
            <hr>
        <?php endif ?>
    </div>
    

    <?php if (!empty($prevButtonStatus) && $prevButtonStatus == "disabled"): ?>
        <button id="prevClauseButton" class="btn btn-sm btn-warning" type="button" <?php echo $prevButtonStatus; ?>>
            <em class="icon ni ni-arrow-long-left"></em>
            <span>Previous Clause</span>
        </button>
    <?php endif ?>

    <?php if (empty($prevButtonStatus)): ?>
        <a class="active btn btn-sm btn-warning" onclick="loadClause(<?php echo $previousClause;?>)" href="#">
            <em class="icon ni ni-arrow-long-left"></em>
            <span>Previous Clause</span>
        </a>
    <?php endif ?>
    
    <div style="float: right;">
        <?php if (!empty($nextButtonStatus) && $nextButtonStatus == "disabled"): ?>
            <button id="nextClauseButton" class="btn btn-sm btn-success" type="button"  <?php echo $nextButtonStatus; ?>>
                <span>Next Clause</span>
                 <em class="icon ni ni-arrow-long-right"></em>
            </button>
        <?php endif ?>

        <?php if (empty($nextButtonStatus)): ?>
            <a class="active btn btn-sm btn-success" onclick="loadClause(<?php echo $nextClause;?>)" href="#">
                <span>Next Clause</span>
                <em class="icon ni ni-arrow-long-right"></em>
            </a>
        <?php endif ?>
    </div>
    

    <div id="endMessage" style="display: none;">
        Congratulations! You have reached the end of the questions.
    </div>
</form>

<?php

$totalQuestions = 0; // Count of all questions
$currentQuestionIndex = 0; // Current question index
foreach ($extractedClause as $clause) {
    // Count the main questions
    $totalQuestions += count($clause['Questions']);

    foreach ($clause['Questions'] as $mainQuestion) {
        // Count the sub questions
        $totalQuestions += count($mainQuestion['P2Questions']);
    }
}

?>
<!-- Add this script tag to include jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->

<script>
    function saveResponses(qId) {
        alert(qId);
    }
</script>