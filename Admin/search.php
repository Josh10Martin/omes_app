<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <style>
        #search{
            width: 50%;
            padding: 5.5px;
            border-radius: 5px;
            border: 1px solid gray;
        }

        #search:focus{
            border: 1px solid #28a745;
        }

    </style>
    <?php include 'includes/header.php'?>
</head>
<body>
    <div class="main-wrapper">
        <?php include 'includes/navbar.php'?>     
        <?php include 'includes/sidebar.php'?>

        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Search</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8 col-12 mb-5">
                        <form id="searchForm">
                                <input type="search" name="search" id="search">
                                <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>

                <div class="row" id="searchResults">
                <table class="searchResultsTable table table-sm table-border table-striped custom-table mb-0"  >  <!---->
                    <thead class="sticky sticky-top" id="table-head">
                        <tr>
                            <th>CENTRE CODE</th>
                            <th>EXAM NO.</th>
                            <th>FIRST NAME</th>
                            <th>LAST NAME</th>
                            <th>MARK</th>
                            <th>STATUS</th>
                            <th>SEN</th>
                            <th>MARKING CENTRE</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
				</table>
                    <?php
                        if (isset($_POST['searchQuery'])) {
                            $searchQuery = $_POST['searchQuery'];
                            
                            // Include your database connection configuration
                            include '../config.php';
                            
                            try {
                                // Perform the search query
                                $query = "SELECT * FROM marks WHERE 
                                        exam_no LIKE :searchQuery OR 
                                        centre_code LIKE :searchQuery OR 
                                        subject_code LIKE :searchQuery OR 
                                        status LIKE :searchQuery";
                                
                                $stmt = $db_12_gce->prepare($query);
                                $stmt->bindValue(':searchQuery', "%$searchQuery%", PDO::PARAM_STR);
                                $stmt->execute();
                                
                                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if (count($results) > 0) {
                                    // Generate table rows for each result
                                    foreach ($results as $result) {
                                        echo '<tr>';
                                        echo '<td>' . $result['centre_code'] . '</td>';
                                        echo '<td>' . $result['exam_no'] . '</td>';
                                        echo '<td>' . $result['first_name'] . '</td>';
                                        echo '<td>' . $result['last_name'] . '</td>';
                                        echo '<td>' . $result['mark'] . '</td>';
                                        echo '<td>' . $result['status'] . '</td>';
                                        echo '<td>' . $result['sen'] . '</td>';
                                        echo '<td>' . $result['marking_centre'] . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="9">No information related to your search item</td></tr>';
                                }
                                
                            } catch (PDOException $e) {
                                echo 'Error: ' . $e->getMessage();
                            }
                        }
                    ?>
                </div>

            </div>
        </div>
    </div>
    
    <?php include 'includes/scripts.php' ?>
    
    <script>
        $(document).ready(function() {
            $('.searchResultsTable').hide();

            $('#searchForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                
                var query = $('#search').val();
                if (query !== '') {
                    $.ajax({
                        url: 'search.php',
                        method: 'POST',
                        data: { searchQuery: query },
                        success: function(response) {
                            
                            if (response.trim() === '') {
                                $('.searchResultsTable').hide();
                                
                            } else {
                                $('.searchResultsTable tbody').html(response);
                                $('.searchResultsTable').show();
                            }
                            $('#searchForm').find('input[name="search"]').val(query); // Preserve the search query in the input field
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>