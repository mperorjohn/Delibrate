<?php
include "token.php";
include LIL . "encodeString.php";
include LIL . "decodeString.php";

$curl  = curl_init();
$page = "Gap Assessment";

if (isset($_GET['s'])) {
    $sId          = decodeString($_GET['s']);
    echo $sId;
    $sId          = explode("~~~", $sId);
    $thisStandardId   = $sId[0];
    $standardName = $sId[1];
}
else{
    header("location:index.php");
    exit();
}



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => getenv('API_ROOT_DIR').'gapAssessment/getTasks.php?standardId='.$thisStandardId,
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

curl_setopt_array($curl, array(
  CURLOPT_URL => getenv('API_ROOT_DIR').'gapAssessment/getTaskActions.php',
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

$taskActions = json_decode(curl_exec($curl),true);
$tAhttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
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

    <script type="text/javascript">
        function updateActionAnswer(selectElement) {
            const actionAnswer = document.getElementById('actionAnswer');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const selectedFormats = selectedOption.getAttribute('data-formats');
            actionAnswer.value = selectedFormats;
        }


        function addActionAnswer(selectElement) {
            const aactionAnswer = document.getElementById('aactionAnswer');
            const aselectedOption = selectElement.options[selectElement.selectedIndex];
            const aselectedFormats = aselectedOption.getAttribute('data-formats');
            aactionAnswer.value = aselectedFormats;
        }
    </script>




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
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <!-- <div class="components-preview wide-md mx-auto"> -->
                                    <div class="nk-block-head nk-block-head-lg wide-sm">
                                        <div class="nk-block-head-content">
                                            <div class="nk-block-head-sub"><a class="back-to" href="index.php"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    
                                    <div class="nk-block nk-block-lg">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h4 class="nk-block-title"> Gap Assessment - <?php echo $standardName ?></h4>
                                                <div class="nk-block-des">
                                                    <p>Due Deligence</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-block nk-block-lg">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h4 class="title nk-block-title">Accordion Style3</h4>
                                                <p>Add the class <code>.accordion-s3</code> with <code>.accordion</code> to get this accordion style.</p>
                                            </div>
                                        </div>
                                        <div class="card card-bordered card-preview">
                                            <div class="card-inner">
                                                <div id="accordion-2" class="accordion accordion-s3">
                                                    <div class="accordion-item">
                                                        <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-item-2-1">
                                                            <h6 class="title">What is Dashlite?</h6>
                                                            <span class="accordion-icon"></span>
                                                        </a>
                                                        <div class="accordion-body collapse" id="accordion-item-2-1" data-bs-parent="#accordion-2">
                                                            <div class="accordion-inner">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-item-2-2">
                                                            <h6 class="title">What are some of the benefits of receiving my bill electronically?</h6>
                                                            <span class="accordion-icon"></span>
                                                        </a>
                                                        <div class="accordion-body collapse" id="accordion-item-2-2" data-bs-parent="#accordion-2">
                                                            <div class="accordion-inner">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-item-2-3">
                                                            <h6 class="title">What is the relationship between Dashlite and payment?</h6>
                                                            <span class="accordion-icon"></span>
                                                        </a>
                                                        <div class="accordion-body collapse" id="accordion-item-2-3" data-bs-parent="#accordion-2">
                                                            <div class="accordion-inner">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="card card-bordered card-preview">
                                            <div class="card-inner">
                                                <div class="g-2">
                                                    <div class="btn-toolbar g-2">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text" id="btnGroupAddon"><i class="fa fa-search"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control"  id="search_input" placeholder="Search <?php echo $standardName ?> Tree" aria-label="Input group example" aria-describedby="btnGroupAddon">
                                                        </div>
                                                    </div>
                                                    <div id="folder_jstree"></div>
                                                </div>
                                            </div>
                                            
                                            <hr>

                                            
                                            <div class="card-inner">
                                                <?php
                                                    $folders_arr = array();
                                                    if (isset($response['results']) && is_array($response['results']) && $httpCode == "200") {
                                                        $arraySize = count($response['results']);
                                                        for ($i=0; $i < $arraySize; $i++) { 
                                                            $tasks    = $response['results'][$i];
                                                            $parentid = $tasks['parent'];
                                                            
                                                            if($parentid == '0') $parentid = "#";

                                                            $selected = false;
                                                            $opened   = true;
                                                            $folders_arr[] = array(
                                                                "id"     =>$tasks['id'],
                                                                "parent" =>$parentid,
                                                                "text"   =>$tasks['text'],
                                                                "actionQuestion"   =>$tasks['ActionQuestion'],
                                                                "actionAnswer"   =>$tasks['ActionAnswer'],
                                                                "state" => array(
                                                                    "selected" => $selected,
                                                                    "opened"=>$opened
                                                                ) 
                                                            );
                                                        }
                                                    } 
                                                    else {
                                                        // Handle the case where $response['results'] is not set or not an array
                                                    }   

                                                ?>

                                               



                                                <!-- Store folder list in JSON format -->
                                                <textarea style="display: none;" id='txt_folderjsondata'><?= json_encode($folders_arr) ?></textarea>
                                                
                                                <!-- Store folder list in JSON format -->
                                                <textarea style="display: none;" id='txt_folderjsondata'><?= json_encode($folders_arr) ?></textarea>
                                            </div>
                                        </div>
                                    </div> <!-- nk-block -->
                                    
                                </div><!-- .components-preview -->
                            </div>
                        </div>
                    </div>
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
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- select region modal -->
    <?php //include "regionModal.php"; ?>     

    <!-- HTML Popup Structure -->
    <!-- Rename -->
    <div class="modal fade" id="renamePopup" tabindex="-1" role="dialog" aria-labelledby="renamePopupLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="renamePopupLabel">Edit Task</h5>
                    <button type="button" class="close" onclick="closeRenamePopup()" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editedFolderId">
                    <input type="hidden" id="editedParentId">
                    <p class="text-primary preview-title-lg overline-title" style="font-weight: 600;">Parent: <u><span id="currentParentName"></span></u></p>
                    <input type="text" id="editedFolderName" class="form-control" placeholder="Enter new folder name">

                    <div class="preview-block">
                        <hr>
                        <span class="preview-title-lg overline-title" style="margin-bottom: 10px; font-size: 14px;">Task Settings</span>
                        <div class="row gy-4">
                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2" data-ui="xl" id="actionQuestion" name="actionQuestion" onchange="updateActionAnswer(this)">
                                            <option value="default_option">Required Action</option>
                                            <?php 
                                            if (isset($taskActions['results']) && is_array($taskActions['results'])) {
                                                foreach ($taskActions['results'] as $actions) {
                                                    $actionId = $actions['Id'];
                                                    $name     = $actions['Name']; 
                                                    $formats  = $actions['AllowedFormat']; 
                                                    $required = $actions['Required'];
                                                    ?>
                                                    <option value="<?php echo $actionId; ?>" data-formats="<?php echo $formats; ?>"><?php echo $name; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <label for="actionQuestion">Select Action</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="text" id="actionAnswer" name="actionAnswer" class="form-control form-control-xl form-control-outlined" id="outlined-normal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeRenamePopup()">Cancel</button>

                    <button type="button" class="btn btn-primary" id="submitEditedFolder">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createFolderPopup" tabindex="-1" role="dialog" aria-labelledby="createFolderPopupLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFolderPopupLabel">Create New Task</h5>
                    <button type="button" class="close" onclick="closeCreateFolderPopup()" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="parentFolderId">
                    <input type="text" id="newFolderName" class="form-control" placeholder="Enter new folder name">


                    <div class="preview-block">
                        <hr>
                        <span class="preview-title-lg overline-title" style="margin-bottom: 10px; font-size: 14px;">Task Settings</span>
                        <div class="row gy-4">
                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2" data-ui="xl" id="aactionQuestion" name="aactionQuestion" onchange="addActionAnswer(this)">
                                            <option value="default_option">Required Action</option>
                                            <?php 
                                            if (isset($taskActions['results']) && is_array($taskActions['results'])) {
                                                foreach ($taskActions['results'] as $actions) {
                                                    $actionId = $actions['Id'];
                                                    $name     = $actions['Name']; 
                                                    $formats  = $actions['AllowedFormat']; 
                                                    $required = $actions['Required'];
                                                    ?>
                                                    <option value="<?php echo $actionId; ?>" data-formats="<?php echo $formats; ?>"><?php echo $name; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <label for="aactionQuestion">Select Action</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="text" id="aactionAnswer" name="aactionAnswer" class="form-control form-control-xl form-control-outlined" id="outlined-normal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeCreateFolderPopup()">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitNewFolder">Create Task</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="confirmDeleteFolderModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteFolderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteFolderLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the folder "<span id="folderToDeleteName"></span>"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                </div>
            </div>
        </div>
    </div>




    <!-- JavaScript -->
    <script src="../ops_assets/js/bundle.js?ver=3.1.3"></script>
    <script src="../ops_assets/js/scripts.js?ver=3.1.3"></script>
    <script src="../ops_assets/js/libs/jstree.js?ver=3.1.3"></script>
    <script src="../ops_assets/js/example-tree.js?ver=3.1.3"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var folder_jsondata = JSON.parse($('#txt_folderjsondata').val());

            $('#folder_jstree').jstree({
                'core': {
                    'data': folder_jsondata,
                    'multiple': true
                },
                'checkbox': {
                    'keep_selected_style': false
                },
                'plugins': ['checkbox', 'contextmenu', 'search'],
                'contextmenu': {
                    'items': function(node) {
                        var actions = {
                            'Rename': {
                                'label': 'Edit',
                                'icon': 'fa fa-pencil',
                                'action': function() {
                                    var folderId = node.id;
                                    var folderName = node.text;
                                    var parentId = node.parent;
                                    var parentName = $('#folder_jstree').jstree(true).get_node(parentId).text;
                                    var actionQuestion = $('#folder_jstree').jstree(true).get_node(actionQuestion).text;
                                    var actionAnswer = $('#folder_jstree').jstree(true).get_node(actionAnswer).text;
                                    openRenamePopup(folderId, folderName, actionQuestion, actionAnswer, parentId, parentName);
                                }
                            },
                            // 'Delete': {
                            //     'label': 'Delete',
                            //     'icon': 'fa fa-trash',
                            //     'action': function() {
                            //         var folderId = node.id;
                            //         var folderName = node.text;
                            //         openDeleteFolderPopup(folderId, folderName);
                            //     }
                            // },
                            'Create': {
                                'label': 'Create New Folder',
                                'icon': 'fa fa-plus',
                                'action': function() {
                                    var parentId = node.id;
                                    var parentName = $('#folder_jstree').jstree(true).get_node(parentId).text;
                                    openCreateFolderPopup(parentId, parentName);
                                }
                            }
                            // ... (other context menu items)
                        };
                        return actions;
                    }
                }
            });


            // Initialize the search plugin
            $('#search_input').on('input', function() {
                $('#folder_jstree').jstree(true).search($(this).val());
            });


            // Open the rename popup
            function openRenamePopup(folderId, folderName, actionQuestion, actionAnswer, parentId, parentName) {
                // alert(parentId);
                $('#editedFolderId').val(folderId);
                $('#editedParentId').val(parentId);
                $('#currentParentName').text(parentName);
                $('#editedFolderName').val(folderName); // Populate input field with current folder name
                $('#actionQuestion').val(actionQuestion);
                $('#actionAnswer').val(actionAnswer);
                $('#renamePopup').modal('show'); // Show the popup
                $('#submitEditedFolder').off('click').on('click', function() {
                    var editedName = $('#editedFolderName').val();
                    var actionQuestion = $('#actionQuestion').val();
                    var actionAnswer = $('#actionAnswer').val();
                    var editedFolderId = $('#editedFolderId').val();
                    var editedParentId = $('#editedParentId').val();
                    submitRename(editedFolderId, editedName, actionQuestion, actionAnswer, editedParentId);
                });
            }


            function openCreateFolderPopup(parentId, aactionQuestion, aactionAnswer, parentName) {
                $('#parentFolderId').val(parentId);
                $('#currentParentName').text(parentName);
                $('#newFolderName').val(''); // Clear the input field
                $('#createFolderPopup').modal('show'); // Show the modal
                $('#submitNewFolder').off('click').on('click', function() {
                    var newFolderName   = $('#newFolderName').val();
                    var parentFolderId  = $('#parentFolderId').val();
                    var aactionQuestion = $('#aactionQuestion').val();
                    var aactionAnswer   = $('#aactionAnswer').val();
                    submitCreateFolder(parentFolderId, aactionQuestion, aactionAnswer, newFolderName);
                });
            }


            function openDeleteFolderPopup(folderId, folderName) {
                $('#folderToDeleteId').val(folderId);
                $('#folderToDeleteName').text(folderName);
                $('#deleteFolderPopup').modal('show'); // Show the modal
                $('#confirmDeleteFolder').off('click').on('click', function() {
                    var folderIdToDelete = $('#folderToDeleteId').val();
                    submitDeleteFolder(folderIdToDelete);
                });
            }

            var apiRootDir = '<?php echo getenv('API_ROOT_DIR'); ?>';

            // Submit edited folder name to API
            function submitRename(folderId, editedName, actionQuestion, actionAnswer, parentId) {
                // Prepare the data payload as JSON
                var requestData = {
                    folderId      : folderId,
                    newName       : editedName,
                    actionQuestion: actionQuestion,
                    actionAnswer  : actionAnswer,
                    parentId      : parentId,
                    standardId    : "<?php echo $thisStandardId; ?>",
                    updatedBy     : "<?php echo $_SESSION['thisUserId']; ?>"
                };

                // Make API call to update folder name using folderId and editedName
                $.ajax({
                    // getenv('API_ROOT_DIR').'gapAssessment/updateTask.php'
                    url: apiRootDir + 'gapAssessment/updateTask.php',
                    method: 'PUT',
                    headers: {
                        "Content-Type": "application/json",
                        "X-API-Key": "<?php echo $_SESSION['accessToken'];?>"
                    },
                    data: JSON.stringify(requestData), // Convert to JSON format;
                    success: function(response) {
                        console.log("Success response:", response); // Log the response
                        // Handle success response, update jstree node text if needed
                        $('#renamePopup').modal('hide'); // Hide the popup

                        // Update folder_jsondata with the new name
                        for (var i = 0; i < folder_jsondata.length; i++) {
                            if (folder_jsondata[i].id === folderId) {
                                folder_jsondata[i].text = editedName;
                                break;
                            }
                        }

                        // Refresh the jstree after success
                        $('#folder_jstree').jstree(true).settings.core.data = folder_jsondata; // Set updated data
                        $('#folder_jstree').jstree(true).refresh();
                        
                        // Show SweetAlert success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Task name updated successfully.',
                        });
                    },
                    error: function(error) {
                        console.log("Error response:", error); // Log the error response
                        // Handle error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to update task name. Please try again.',
                        });
                    }
                });
            }



            // Create a new folder under a parent node
            function submitCreateFolder(parentFolderId, aactionQuestion, aactionAnswer, newFolderName) {
                var requestData = {
                    parentId       : parentFolderId,
                    newName        : newFolderName,
                    aactionQuestion: aactionQuestion,
                    aactionAnswer  : aactionAnswer,
                    standardId     : "<?php echo $thisStandardId; ?>",
                    createdBy      : "<?php echo $_SESSION['thisUserId']; ?>"
                };

                // Make API call to create a new folder
                $.ajax({
                    url: apiRootDir + 'gapAssessment/createTask.php',
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "X-API-Key": "<?php echo $_SESSION['accessToken'];?>"
                    },
                    data: JSON.stringify(requestData),
                    success: function(response) {
                        $('#createFolderPopup').modal('hide'); // Hide the modal

                        // Update folder_jsondata with the new entry
                        folder_jsondata.push({
                            id: response.data.folderId, // Use the ID returned by the API
                            parent: parentFolderId,
                            text: newFolderName,
                            state: {
                                selected: false,
                                opened: true
                            }
                        });

                        // Refresh the jstree with updated data
                        $('#folder_jstree').jstree(true).settings.core.data = folder_jsondata;
                        $('#folder_jstree').jstree(true).refresh();

                        // Show SweetAlert success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'New folder created successfully.',
                        });
                    },
                    error: function(error) {
                        // Handle error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to create folder. Please try again.',
                        });
                    }
                });
            }




            function submitDeleteFolder(folderIdToDelete) {
                // Make API call to delete the folder
                $.ajax({
                    url: apiRootDir + 'gapAssessment/deleteFolder.php',
                    method: 'DELETE',
                    headers: {
                        "Content-Type": "application/json",
                        "X-API-Key": "<?php echo $_SESSION['accessToken'];?>"
                    },
                    data: JSON.stringify({ folderId: folderIdToDelete }),
                    success: function(response) {
                        // Refresh the jstree after successful deletion
                        $('#folder_jstree').jstree(true).refresh();

                        // Show SweetAlert success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Folder deleted successfully.',
                        });
                    },
                    error: function(error) {
                        // Handle error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to delete folder. Please try again.',
                        });
                    }
                });
            }



        });



        // Close Modal
        function closeRenamePopup() {
            $('#renamePopup').modal('hide');
        }



        function closeCreateFolderPopup() {
            $('#createFolderPopup').modal('hide');
        }
    </script>
</body>
</html>