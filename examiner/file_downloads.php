<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marking Centre Documents</title>
    <?php include 'includes/header.php'; 
    
    if($_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'ADMIN'){
    ?>
    <!-- Add your additional CSS styles here -->
    <style>
        /* Add your custom CSS styles */
        .documents h5 {
            margin-bottom: 20px;
        }
        .documents .file-link {
            display: block;
            text-align: center;
            padding: 7px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 10px;
            color: #007bff;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .documents .file-link:hover {
            background-color: lightblue;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <?php include 'includes/navbar.php'; ?>     
        <?php include 'includes/sidebar.php'; ?>

        <div class="page-wrapper">
            <div class="content documents">
                <h5 class="blue-ecz"><i class="fa fa-flag-o" aria-hidden="true"></i> MARKING CENTRE DOCUMENTS:</h5>

                <hr class="hr hr-blur">
                <div class="row justify-content-around mt-5" id="fileLinksContainer">
                    <!-- File links will be added here dynamically -->
                </div>
            </div>
            <div id="confirmationDialog" title="Confirm Deletion">
            </div>
            <div class="sidebar-overlay" data-reff=""></div>
        </div>
    </div>
    
    <?php include 'includes/scripts.php'; ?>

    <script>
$(document).ready(function(){
    get_files();

    function get_files(){
        $.ajax({
            url: 'php/get_files.php',
            method: 'POST',
            dataType: 'json',
            success: function(data){
                var fileLinksContainer = $('#fileLinksContainer');
                
                $.each(data, function(){
                  var fileLinkTemplate = '<div class="col-md-6 col-lg-4 mb-3">' +

                                            '<div class="d-flex  align-items-center">' +
                                              '<a href="' + this["url"] + '" class="text-primary h4 file-link" download>' +
                                              '<i class="fa fa-download" aria-hidden="true"></i>' +' '+ this["file_description"] +
                                              '</a>' +
                                              <?php
                                                if($_SESSION['user_type']  == 'ECZ'){
                                                ?>
                                              '<button class="btn btn-warning delete-file" data-url="' + this["url"] + '" data-id="'+this["id"]+'">Delete</button>' +
                                              <?php }
                                                ?>
                                              '</div>' +
                                              
                                                // '<button class="btn btn-warning delete-file" data-url="' + this["url"] + '">Delete</button>' +
                                              
                                                
              
                                              '</div>' +
                                          '</div>';
                    $('#fileLinksContainer').append(fileLinkTemplate);
                });
            }
        });
    }

    $(document).on('click', '.delete-file', function() {
        var fileUrl = $(this).data('url');

        $("#confirmationDialog").html("Are you sure you want to delete this file?");
        // Show a jQuery UI confirmation dialog
        $("#confirmationDialog").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Delete": function() {
                    // Execute the deletion logic
                    $.ajax({
                        url: 'php/delete_file.php', // Replace with your delete file PHP script
                        method: 'POST',
                        data: { fileUrl: fileUrl },
                        success: function(response) {
                            location.reload();
                            // Handle the response after file is deleted, if needed
                            // For example, you can update the file links without refreshing the page
                            get_files();
                        }
                    });
                    $(this).dialog("close");
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });
    });

});

    </script>

    <?php
    }else{
        header('location: ../');
    }
    ?>
</html>
