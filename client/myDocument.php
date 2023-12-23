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
<!-- <div class="nk-block-head-content"> -->
<!-- <h3 class="nk-block-title page-title"> -->
    <?php 
    // echo $_SESSION['company']; 
    ?> 
    <!-- Workspace</h3> -->
<!-- <div class="nk-block-des text-soft"> -->
<!-- <h6 class="nk-block-title title">Welcome,  -->
    <?php 
    // echo $_SESSION['firstName'] 
    ?>
<!-- </h6> -->
<!-- </div> -->
<!-- </div> -->
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




<div class="nk-fmg">
<div class="nk-fmg-aside" data-content="files-aside" data-toggle-overlay="true" data-toggle-body="true" data-toggle-screen="lg" data-simplebar>
<div class="nk-fmg-aside-wrap">
<div class="nk-fmg-aside-top" data-simplebar>
<ul class="nk-fmg-menu">
<li class="active">
<a class="nk-fmg-menu-item" href="#">
<em class="icon ni ni-home-alt"></em>
<span class="nk-fmg-menu-text">Home</span>
</a>
</li>
<li>
<a class="nk-fmg-menu-item" href="#">
<em class="icon ni ni-file-docs"></em>
<span class="nk-fmg-menu-text">Files</span>
</a>
<ul>
<li><a href="#" class="nk-fmg-menu-item"><span class="nk-fmg-menu-text">New Files</span></a></li>
<li><a href="#" class="nk-fmg-menu-item"><span class="nk-fmg-menu-text">This Months</span></a></li>
<li><a href="#" class="nk-fmg-menu-item"><span class="nk-fmg-menu-text">Older Files</span></a></li>
</ul>
</li>
<li>
<a class="nk-fmg-menu-item" href="#">
<em class="icon ni ni-star"></em>
<span class="nk-fmg-menu-text">Starred</span>
</a>
</li>
<li>
<a class="nk-fmg-menu-item" href="#">
<em class="icon ni ni-share-alt"></em>
<span class="nk-fmg-menu-text">Shared</span>
</a>
</li>
<li>
<a class="nk-fmg-menu-item" href="#">
<em class="icon ni ni-trash-alt"></em>
<span class="nk-fmg-menu-text">Recovery</span>
</a>
</li>
<li>
<a class="nk-fmg-menu-item" href="#">
<em class="icon ni ni-setting-alt"></em>
<span class="nk-fmg-menu-text">Settings</span>
</a>
</li>
</ul>
</div>
<div class="nk-fmg-aside-bottom">
<div class="nk-fmg-status">
<h6 class="nk-fmg-status-title"><em class="icon ni ni-hard-drive"></em><span>Storage</span></h6>
<div class="progress progress-md bg-light">
<div class="progress-bar" data-progress="5"></div>
</div>
<div class="nk-fmg-status-info">12.47 GB of 50 GB used</div>
<div class="nk-fmg-status-action">
<a href="#" class="link link-primary link-sm">Upgrade Storage</a>
</div>
</div>
<div class="nk-fmg-switch">
<div class="dropup">
<a href="#" data-bs-toggle="dropdown" data-offset="-10, 12" class="dropdown-toggle dropdown-indicator-unfold">
<div class="lead-text">Personal</div>
<div class="sub-text">Only you</div>
</a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-opt no-bdr">
<li><a href="#"><span>Team Plan</span></a></li>
<li><a class="active" href="#"><span>Personal</span></a></li>
<li class="divider"></li>
<li><a class="link" href="#"><span>Upgrade Plan</span></a></li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div><!-- .nk-fmg-aside -->
<div class="nk-fmg-body">
<div class="nk-fmg-body-head d-none d-lg-flex">
<div class="nk-fmg-search">
<em class="icon ni ni-search"></em>
<input type="text" class="form-control border-transparent form-focus-none" placeholder="Search files, folders">
</div>
<div class="nk-fmg-actions"></div>
</div>
<div class="nk-fmg-body-content">
<div class="nk-block-head nk-block-head-sm">
<div class="nk-block-between position-relative">
<div class="nk-block-head-content">
<h3 class="nk-block-title page-title">Documents</h3>
</div>
<div class="nk-block-head-content">
<ul class="nk-block-tools g-1">
<li class="d-lg-none">
<a href="#" class="btn btn-trigger btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
</li>
<li class="d-lg-none">
<div class="dropdown">
<a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-opt no-bdr">
<li><a href="#file-upload" data-bs-toggle="modal"><em class="icon ni ni-upload-cloud"></em><span>Upload File</span></a></li>
<li><a href="#"><em class="icon ni ni-file-plus"></em><span>Create File</span></a></li>
<li><a href="#"><em class="icon ni ni-folder-plus"></em><span>Create Folder</span></a></li>
</ul>
</div>
</div>
</li>
<li class="d-lg-none me-n1"><a href="#" class="btn btn-trigger btn-icon toggle" data-target="files-aside"><em class="icon ni ni-menu-alt-r"></em></a></li>
</ul>
</div>
<div class="search-wrap px-2 d-lg-none" data-search="search">
<div class="search-content">
<a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
<input type="text" class="form-control border-transparent form-focus-none" placeholder="Search by user or message">
<button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
</div>
</div><!-- .search-wrap -->
</div>
</div>
<div class="nk-fmg-quick-list nk-block">
<div class="nk-block-head-xs">
<div class="nk-block-between g-2">
<div class="nk-block-head-content">
<h6 class="nk-block-title title">Recently Accessed</h6>
</div>
<div class="nk-block-head-content">
<a href="#" class="link link-primary toggle-opt active" data-target="quick-access">
<div class="inactive-text">Show</div>
<div class="active-text">Hide</div>
</a>
</div>
</div>
</div><!-- .nk-block-head -->
<div class="toggle-expand-content expanded" data-content="quick-access">
<div class="nk-files nk-files-view-grid">
<div class="nk-files-list">
<div class="nk-file-item nk-file">
<div class="nk-file-info">
<a href="#" class="nk-file-link">
<div class="nk-file-title">
<div class="nk-file-icon">
<span class="nk-file-icon-type">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
<g>
    <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611" />
    <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c" />
    <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222" />
</g>
</svg>
</span>
</div>
<div class="nk-file-name">
<div class="nk-file-name-text">
<span class="title">ISO/IEC 27001 Toolkit</span>
</div>
</div>
</div>
</a>
</div>
<div class="nk-file-actions hideable">
<a href="#" class="btn btn-sm btn-icon btn-trigger"><em class="icon ni ni-cross"></em></a>
</div>
</div>
</div>
</div><!-- .nk-files -->
</div>
</div>
<div class="nk-fmg-listing nk-block-lg">
<div class="nk-block-head-xs">
<div class="nk-block-between g-2">
<div class="nk-block-head-content">
<h6 class="nk-block-title title">Browse Files</h6>
</div>
<div class="nk-block-head-content">
<ul class="nk-block-tools g-3 nav">
<li><a data-bs-toggle="tab" href="#file-grid-view" class="nk-switch-icon active"><em class="icon ni ni-view-grid3-wd"></em></a></li>
<li><a data-bs-toggle="tab" href="#file-group-view" class="nk-switch-icon"><em class="icon ni ni-view-group-wd"></em></a></li>
<li><a data-bs-toggle="tab" href="#file-list-view" class="nk-switch-icon"><em class="icon ni ni-view-row-wd"></em></a></li>
</ul>
</div>
</div>
</div><!-- .nk-block-head -->
<div class="tab-content">
<div class="tab-pane active" id="file-grid-view">
<div class="nk-files nk-files-view-grid">
<div class="nk-files-head">
<div class="nk-file-item">
<div class="nk-file-info">
<div class="dropdown">
.

</div>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-opt no-bdr">
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
</ul>
</div>
</div>
</div>
</div>
</div>
<div class="nk-files-list">
<div class="nk-file-item nk-file">
<div class="nk-file-info">
<div class="nk-file-title">
<div class="nk-file-icon">
<a class="nk-file-icon-link" href="#">
<span class="nk-file-icon-type">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
    <g>
        <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611" />
        <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c" />
        <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222" />
        <path d="M42.2227,40H41.5V37.4443a5.5,5.5,0,0,0-11,0V40h-.7227A2.8013,2.8013,0,0,0,27,42.8184v6.3633A2.8013,2.8013,0,0,0,29.7773,52H42.2227A2.8013,2.8013,0,0,0,45,49.1816V42.8184A2.8013,2.8013,0,0,0,42.2227,40ZM36,48a2,2,0,1,1,2-2A2.0023,2.0023,0,0,1,36,48Zm3.5-8h-7V37.4443a3.5,3.5,0,0,1,7,0Z" style="fill:#c67424" />
    </g>
</svg>
</span>
</a>
</div>
<div class="nk-file-name">
<div class="nk-file-name-text">
<a href="#" class="title">ISO/IEC 27001 Toolkit</a>
<div class="asterisk"><a href="#"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
</div>
</div>
</div>
<ul class="nk-file-desc">
<li class="date">Today</li>
<li class="size">4.5 MB</li>
<li class="members">3 Members</li>
</ul>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-plain no-bdr">
<li><a href="#file-details" data-bs-toggle="modal"><em class="icon ni ni-eye"></em><span>Details</span></a></li>
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-pen"></em><span>Rename</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
</ul>
</div>
</div>
</div>
</div><!-- .nk-file -->
<div class="nk-file-item nk-file">
<div class="nk-file-info">
<div class="nk-file-title">
<div class="nk-file-icon">
<a class="nk-file-icon-link" href="#">
<span class="nk-file-icon-type">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
    <g>
        <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611" />
        <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c" />
        <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222" />
    </g>
</svg>
</span>
</a>
</div>
<div class="nk-file-name">
<div class="nk-file-name-text">
<a href="#" class="title">ISO 45001 Implementation</a>
<div class="asterisk"><a href="#" class="active"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
</div>
</div>
</div>
<ul class="nk-file-desc">
<li class="date">Today</li>
<li class="size">4.5 MB</li>
<li class="members">3 Members</li>
</ul>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-plain no-bdr">
<li><a href="#file-details" data-bs-toggle="modal"><em class="icon ni ni-eye"></em><span>Details</span></a></li>
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-pen"></em><span>Rename</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
</ul>
</div>
</div>
</div>
</div><!-- .nk-file -->
<div class="nk-file-item nk-file">
<div class="nk-file-info">
<div class="nk-file-title">
<div class="nk-file-icon">
<a class="nk-file-icon-link" href="#">
<span class="nk-file-icon-type">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
    <g>
        <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611" />
        <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c" />
        <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222" />
        <path d="M29.6309,37.36a3.0236,3.0236,0,0,1-.86-2.39A4.3748,4.3748,0,0,1,32.9961,31h.0078a4.36,4.36,0,0,1,4.22,3.9121,3.0532,3.0532,0,0,1-.8545,2.4482A4.4158,4.4158,0,0,1,33.23,38.53c-.0771,0-.1533-.002-.23-.0049A4.519,4.519,0,0,1,29.6309,37.36ZM43.4668,40.1a1,1,0,1,0-.9336,1.77c.7207.38,1.4658,2.126,1.4668,4.39v1.7256a1,1,0,0,0,2,0V46.26C45.999,43.33,45.0049,40.9119,43.4668,40.1ZM40.165,37.3816c-.1445.084-.29.168-.4316.2549a1,1,0,0,0,.5215,1.8535.9887.9887,0,0,0,.52-.1465c.1289-.0781.2607-.1543.3916-.23a4.2311,4.2311,0,0,0,2.1465-2.124.9839.9839,0,0,0,.0313-.1045A3.8411,3.8411,0,0,0,40.5,32.52a1,1,0,1,0-.4922,1.9395,1.8773,1.8773,0,0,1,1.4,1.9092A2.835,2.835,0,0,1,40.165,37.3816ZM36.5,41h-7c-2.5234,0-4.5,2.7822-4.5,6.333V48.5a.8355.8355,0,0,0,.0588.2914.9731.9731,0,0,0,.3508.4946C26.4646,50.2812,29.4614,51,33,51s6.5353-.7187,7.59-1.7139a.9726.9726,0,0,0,.3509-.4949A.8361.8361,0,0,0,41,48.5V47.333C41,43.7822,39.0234,41,36.5,41Z" style="fill:#c67424" />
    </g>
</svg>
</span>
</a>
</div>
<div class="nk-file-name">
<div class="nk-file-name-text">
<a href="#" class="title">Projects</a>
<div class="asterisk"><a href="#"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
</div>
</div>
</div>
<ul class="nk-file-desc">
<li class="date">Yesterday</li>
<li class="size">35 MB</li>
<li class="members">3 Members</li>
</ul>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-plain no-bdr">
<li><a href="#file-details" data-bs-toggle="modal"><em class="icon ni ni-eye"></em><span>Details</span></a></li>
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-pen"></em><span>Rename</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
</ul>
</div>
</div>
</div>
</div><!-- .nk-file -->                                                    
</div>
</div><!-- .nk-files -->
</div><!-- .tab-pane -->
<div class="tab-pane" id="file-group-view">
<div class="nk-files nk-files-view-group">
<div class="nk-files-head">
<div class="nk-file-item">
<div class="nk-file-info">
<div class="dropdown">
<div class="tb-head dropdown-toggle dropdown-indicator-caret" data-bs-toggle="dropdown">Last Opened</div>
<div class="dropdown-menu dropdown-menu-xs">
<ul class="link-list-opt no-bdr">
<li><a class="active" href="#"><span>Last Opened</span></a></li>
<li><a href="#"><span>Name</span></a></li>
<li><a href="#"><span>Size</span></a></li>
</ul>
</div>
</div>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-opt no-bdr">
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
</ul>
</div>
</div>
</div>
</div>
</div><!-- .nk-files-head -->
<div class="nk-files-group">
<h6 class="title">Folder</h6>
<div class="nk-files-list">
<div class="nk-file-item nk-file">
<div class="nk-file-info">
<div class="nk-file-title">
<div class="nk-file-icon">
<span class="nk-file-icon-type">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
    <g>
        <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611" />
        <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c" />
        <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222" />
    </g>
</svg>
</span>
</div>
<div class="nk-file-name">
<div class="nk-file-name-text">
<a href="#" class="title">ISO/IEC 27001 Toolkit</a>
<div class="asterisk"><a href="#"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
</div>
</div>
</div>
<ul class="nk-file-desc">
<li class="date">Today</li>
<li class="size">4.5 MB</li>
<li class="members">3 Members</li>
</ul>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-plain no-bdr">
<li><a href="#file-details" data-bs-toggle="modal"><em class="icon ni ni-eye"></em><span>Details</span></a></li>
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-pen"></em><span>Rename</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
</ul>
</div>
</div>
</div>
</div><!-- .nk-file -->
<div class="nk-file-item nk-file">
<div class="nk-file-info">
<div class="nk-file-title">
<div class="nk-file-icon">
<span class="nk-file-icon-type">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
    <g>
        <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611" />
        <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c" />
        <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222" />
    </g>
</svg>
</span>
</div>
<div class="nk-file-name">
<div class="nk-file-name-text">
<a href="#" class="title">ISO 45001 Implementation</a>
<div class="asterisk"><a href="#" class="active"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
</div>
</div>
</div>
<ul class="nk-file-desc">
<li class="date">Today</li>
<li class="size">4.5 MB</li>
<li class="members">3 Members</li>
</ul>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-plain no-bdr">
<li><a href="#file-details" data-bs-toggle="modal"><em class="icon ni ni-eye"></em><span>Details</span></a></li>
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-pen"></em><span>Rename</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
</ul>
</div>
</div>
</div>
</div><!-- .nk-file -->
<div class="nk-file-item nk-file">
<div class="nk-file-info">
<div class="nk-file-title">
<div class="nk-file-icon">
<span class="nk-file-icon-type">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
    <g>
        <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611" />
        <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c" />
        <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222" />
        <path d="M29.6309,37.36a3.0236,3.0236,0,0,1-.86-2.39A4.3748,4.3748,0,0,1,32.9961,31h.0078a4.36,4.36,0,0,1,4.22,3.9121,3.0532,3.0532,0,0,1-.8545,2.4482A4.4158,4.4158,0,0,1,33.23,38.53c-.0771,0-.1533-.002-.23-.0049A4.519,4.519,0,0,1,29.6309,37.36ZM43.4668,40.1a1,1,0,1,0-.9336,1.77c.7207.38,1.4658,2.126,1.4668,4.39v1.7256a1,1,0,0,0,2,0V46.26C45.999,43.33,45.0049,40.9119,43.4668,40.1ZM40.165,37.3816c-.1445.084-.29.168-.4316.2549a1,1,0,0,0,.5215,1.8535.9887.9887,0,0,0,.52-.1465c.1289-.0781.2607-.1543.3916-.23a4.2311,4.2311,0,0,0,2.1465-2.124.9839.9839,0,0,0,.0313-.1045A3.8411,3.8411,0,0,0,40.5,32.52a1,1,0,1,0-.4922,1.9395,1.8773,1.8773,0,0,1,1.4,1.9092A2.835,2.835,0,0,1,40.165,37.3816ZM36.5,41h-7c-2.5234,0-4.5,2.7822-4.5,6.333V48.5a.8355.8355,0,0,0,.0588.2914.9731.9731,0,0,0,.3508.4946C26.4646,50.2812,29.4614,51,33,51s6.5353-.7187,7.59-1.7139a.9726.9726,0,0,0,.3509-.4949A.8361.8361,0,0,0,41,48.5V47.333C41,43.7822,39.0234,41,36.5,41Z" style="fill:#c67424" />
    </g>
</svg>
</span>
</div>
<div class="nk-file-name">
<div class="nk-file-name-text">
<a href="#" class="title">Projects</a>
<div class="asterisk"><a href="#"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
</div>
</div>
</div>
<ul class="nk-file-desc">
<li class="date">Today</li>
<li class="size">235 KB</li>
<li class="members">3 Members</li>
</ul>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-plain no-bdr">
<li><a href="#file-details" data-bs-toggle="modal"><em class="icon ni ni-eye"></em><span>Details</span></a></li>
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-pen"></em><span>Rename</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>

</div><!-- .nk-files -->
</div><!-- .tab-pane -->
<div class="tab-pane" id="file-list-view">
<div class="nk-files nk-files-view-list">
<div class="nk-files-head">
<div class="nk-file-item">
<div class="nk-file-info">
<div class="tb-head dropdown-toggle dropdown-indicator-caret" data-bs-toggle="dropdown">Name</div>
<div class="dropdown-menu dropdown-menu-xs">
<ul class="link-list-opt no-bdr">
<li class="opt-head"><span>ORDER BY</span></li>
<li><a href="#"><span>Descending</span></a></li>
<li><a href="#"><span>Ascending</span></a></li>
</ul>
</div>
<div class="tb-head"></div>
</div>
<div class="nk-file-meta">
<div class="dropdown">
<div class="tb-head dropdown-toggle dropdown-indicator-down" data-bs-toggle="dropdown">Last Opened</div>
<div class="dropdown-menu dropdown-menu-xs">
<ul class="link-list-opt ui-colored no-bdr">
<li class="opt-head"><span>ORDER BY</span></li>
<li><a class="active" href="#"><span>Descending</span></a></li>
<li><a href="#"><span>Ascending</span></a></li>
<li class="divider"></li>
<li class="opt-head"><span>SHOW</span></li>
<li><a class="active" href="#"><span>Last Opened</span></a></li>
<li><a href="#"><span>Name</span></a></li>
<li><a href="#"><span>Size</span></a></li>
</ul>
</div>
</div>
</div>
<div class="nk-file-members">
<div class="tb-head">Members</div>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-opt no-bdr">
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
</ul>
</div>
</div>
</div>
</div>
</div><!-- .nk-files-head -->
<div class="nk-files-list">
<div class="nk-file-item nk-file">
<div class="nk-file-info">
<div class="nk-file-title">
<div class="custom-control custom-control-sm custom-checkbox notext">
<input type="checkbox" class="custom-control-input" id="file-check-n1">
<label class="custom-control-label" for="file-check-n1"></label>
</div>
<div class="nk-file-icon">
<span class="nk-file-icon-type">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
<g>
    <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611" />
    <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c" />
    <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222" />
</g>
</svg>
</span>
</div>
<div class="nk-file-name">
<div class="nk-file-name-text">
<a href="#" class="title">ISO/IEC 27001 Toolkit</a>
<div class="nk-file-star asterisk"><a href="#"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
</div>
</div>
</div>
</div>
<div class="nk-file-meta">
<div class="tb-lead">Today, 08:29 AM</div>
</div>
<div class="nk-file-members">
<div class="tb-lead">Only Me</div>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-plain no-bdr">
<li><a href="#file-details" data-bs-toggle="modal"><em class="icon ni ni-eye"></em><span>Details</span></a></li>
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-pen"></em><span>Rename</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
</ul>
</div>
</div>
</div>
</div><!-- .nk-file -->
<div class="nk-file-item nk-file">
<div class="nk-file-info">
<div class="nk-file-title">
<div class="custom-control custom-control-sm custom-checkbox notext">
<input type="checkbox" class="custom-control-input" id="file-check-n2">
<label class="custom-control-label" for="file-check-n2"></label>
</div>
<div class="nk-file-icon">
<span class="nk-file-icon-type">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
<g>
    <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611" />
    <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c" />
    <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222" />
</g>
</svg>
</span>
</div>
<div class="nk-file-name">
<div class="nk-file-name-text">
<a href="#" class="title"> ISO 45001 Implementation</a>
<div class="nk-file-star asterisk"><a href="#" class="active"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
</div>
</div>
</div>
</div>
<div class="nk-file-meta">
<div class="tb-lead">Today, 11:19 AM</div>
</div>
<div class="nk-file-members">
<div class="tb-lead">Only Me</div>
<div class="tb-shared"><em class="ni ni-link" data-bs-toggle="tooltip" data-bs-placement="left" title="People with the link can view"></em></div>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-plain no-bdr">
<li><a href="#file-details" data-bs-toggle="modal"><em class="icon ni ni-eye"></em><span>Details</span></a></li>
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-pen"></em><span>Rename</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
</ul>
</div>
</div>
</div>
</div>
<div class="nk-file-item nk-file">
<div class="nk-file-info">
<div class="nk-file-title">
<div class="custom-control custom-control-sm custom-checkbox notext">
<input type="checkbox" class="custom-control-input" id="file-check-n7">
<label class="custom-control-label" for="file-check-n7"></label>
</div>
<div class="nk-file-icon">
<span class="nk-file-icon-type">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72">
<g>
    <rect x="32" y="16" width="28" height="15" rx="2.5" ry="2.5" style="fill:#f29611" />
    <path d="M59.7778,61H12.2222A6.4215,6.4215,0,0,1,6,54.3962V17.6038A6.4215,6.4215,0,0,1,12.2222,11H30.6977a4.6714,4.6714,0,0,1,4.1128,2.5644L38,24H59.7778A5.91,5.91,0,0,1,66,30V54.3962A6.4215,6.4215,0,0,1,59.7778,61Z" style="fill:#ffb32c" />
    <path d="M8.015,59c2.169,2.3827,4.6976,2.0161,6.195,2H58.7806a6.2768,6.2768,0,0,0,5.2061-2Z" style="fill:#f2a222" />
    <path d="M29.6309,37.36a3.0236,3.0236,0,0,1-.86-2.39A4.3748,4.3748,0,0,1,32.9961,31h.0078a4.36,4.36,0,0,1,4.22,3.9121,3.0532,3.0532,0,0,1-.8545,2.4482A4.4158,4.4158,0,0,1,33.23,38.53c-.0771,0-.1533-.002-.23-.0049A4.519,4.519,0,0,1,29.6309,37.36ZM43.4668,40.1a1,1,0,1,0-.9336,1.77c.7207.38,1.4658,2.126,1.4668,4.39v1.7256a1,1,0,0,0,2,0V46.26C45.999,43.33,45.0049,40.9119,43.4668,40.1ZM40.165,37.3816c-.1445.084-.29.168-.4316.2549a1,1,0,0,0,.5215,1.8535.9887.9887,0,0,0,.52-.1465c.1289-.0781.2607-.1543.3916-.23a4.2311,4.2311,0,0,0,2.1465-2.124.9839.9839,0,0,0,.0313-.1045A3.8411,3.8411,0,0,0,40.5,32.52a1,1,0,1,0-.4922,1.9395,1.8773,1.8773,0,0,1,1.4,1.9092A2.835,2.835,0,0,1,40.165,37.3816ZM36.5,41h-7c-2.5234,0-4.5,2.7822-4.5,6.333V48.5a.8355.8355,0,0,0,.0588.2914.9731.9731,0,0,0,.3508.4946C26.4646,50.2812,29.4614,51,33,51s6.5353-.7187,7.59-1.7139a.9726.9726,0,0,0,.3509-.4949A.8361.8361,0,0,0,41,48.5V47.333C41,43.7822,39.0234,41,36.5,41Z" style="fill:#c67424" />
</g>
</svg>
</span>
</div>
<div class="nk-file-name">
<div class="nk-file-name-text">
<a href="#" class="title">Projects</a>
<div class="nk-file-star asterisk"><a href="#"><em class="asterisk-off icon ni ni-star"></em><em class="asterisk-on icon ni ni-star-fill"></em></a></div>
</div>
</div>
</div>
</div>
<div class="nk-file-meta">
<div class="tb-lead">20 Apr, 03:32 AM</div>
<div class="tb-sub">by Iliash Hossain</div>
</div>
<div class="nk-file-members">
<div class="user-avatar-group">
<div class="user-avatar xs bg-pink">
<span>AB</span>
</div>
<div class="user-avatar xs bg-purple">
<span>IH</span>
</div>
<div class="user-avatar xs">
<img src="./images/avatar/b-sm.jpg" alt="">
</div>
</div>
</div>
<div class="nk-file-actions">
<div class="dropdown">
<a href="" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
<div class="dropdown-menu dropdown-menu-end">
<ul class="link-list-plain no-bdr">
<li><a href="#file-details" data-bs-toggle="modal"><em class="icon ni ni-eye"></em><span>Details</span></a></li>
<li><a href="#file-share" data-bs-toggle="modal"><em class="icon ni ni-share"></em><span>Share</span></a></li>
<li><a href="#file-copy" data-bs-toggle="modal"><em class="icon ni ni-copy"></em><span>Copy</span></a></li>
<li><a href="#file-move" data-bs-toggle="modal"><em class="icon ni ni-forward-arrow"></em><span>Move</span></a></li>
<li><a href="#" class="file-dl-toast"><em class="icon ni ni-download"></em><span>Download</span></a></li>
<li><a href="#"><em class="icon ni ni-pen"></em><span>Rename</span></a></li>
<li><a href="#"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
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
</body>

</html>