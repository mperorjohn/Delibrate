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

// echo $clause;

$extractedClause = [];

foreach ($questions as $item) {
    if (isset($item['clauseNo']) && $item['clauseNo'] === $clause) {
        $extractedClause[] = $item;
    }
}

$clauseContext = $extractedClause[0]['clause'];
?>

<div class="nk-block-head nk-block-head-lg">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h4 class="nk-block-title">Clause <?php echo $clause; ?></h4>
            <div class="nk-block-des">
                <h5><?php echo $clauseContext ?></h5>
            </div>
        </div>
        <div class="nk-block-head-content align-self-start d-lg-none">
            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
        </div>
    </div>
</div>

<div  style="height: 600px; overflow-y: scroll;">


    <?php foreach ($extractedClause[0]['Questions'] as $question): ?>
        <?php //var_dump($question) ?>
        <div class="question">

            <div class="nk-content p-0">
                <div class="nk-content-inner">
                    <div class="nk-content-body">  
                        <div class="">

                            <div class=" bg-white profile-shown">
                                <div class="nk-msg-head">
                                    <h4 class="title d-lg-block"><?php echo $question['question']; ?></h4>
                                    <div class="nk-msg-head-meta">
                                        <div class="d-lg-block">
                                            <ul class="nk-msg-tags">
                                                <li><a href="#" class="btn btn-dim btn-sm btn-outline-light"><b><em class="icon ni ni-check"></em><span>YES</span></b></a></li>
                                            </ul>
                                        </div>
                                        <!-- <div class="d-lg-none"><a href="#" class="btn btn-icon btn-trigger nk-msg-hide ms-n1"><em class="icon ni ni-arrow-left"></em></a></div> -->
                                        <ul class="nk-msg-actions">
                                            <li><a href="#" class="btn btn-dim btn-sm btn-outline-light"><b><em class="icon ni ni-check"></em><span>NO</span></b></a></li>
                                            <!-- <li class="d-lg-none"><a href="#" class="btn btn-icon btn-sm btn-white btn-light profile-toggle"><em class="icon ni ni-info-i"></em></a></li> -->

                                        </ul>
                                    </div>
                                    <!-- <a href="#" class="nk-msg-profile-toggle profile-toggle active"><em class="icon ni ni-arrow-left"></em></a> -->
                                </div>
                                <div class="nk-msg-reply nk-reply" data-simplebar>


                                    <div class="nk-reply-form">
                                        <div class="nk-reply-form-header">
                                            <ul class="nav nav-tabs-s2 nav-tabs nav-tabs-sm">
                                                <li class="nav-item">
                                                    <?php if (!empty($question['responseId'])): ?>                                        
                                                        <a class="nav-link active text-danger" data-bs-toggle="tab" href="#reply-form"><?php echo $question['responseName'] ?></a>
                                                    <?php endif ?>
                                                    <?php if (empty($question['responseId'])): ?>                                        
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
                                                        <?php if (!empty($question['responseId'])): ?>
                                                            <code><b>Required (*)</b></code>
                                                        <?php endif ?>

                                                        <textarea class="form-control form-control-simple no-resize" placeholder="Type your feedback here"></textarea>
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

