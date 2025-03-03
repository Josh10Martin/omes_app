<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<?php include 'includes/header.php';

if($_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){

  ?>
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
        <div class="dialog"></div>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Frequency distribution reports</h4>
                    </div>
                </div>

                <div class="row border border-secondary br-3 p-3">
                    <div class="col-md-6">
                    <form id="curveParamerForm">
                        <div class="row">
                
                            <div class="col-md-4">
                            <label for="subject">SUBJECT</label>
                            <select name="subject" class="select" id="subject" required>
                                <option value="" selected> Select Subject</option>
                            </select>
                            </div>
                            <div class="col-md-4">
                            <label for="paper">PAPER</label>
                            <select name="paper" class="select" id="paper" required>
                                <option value="" selected> Select Paper</option>
                            </select>
                            </div>
                            <div class="col-md-4">
                                <p>Center Type
                                <select name="centre_type" class="select" id="center_type" required>
                                </select>
                                </p>
                            </div>
                            <div class="col-md-4 my-auto mx-auto">
                                <button type="submit" class="btn btn-primary my-auto">GENERATE REPORT</button>
                            </div>
               
                        </div>
                                
                        </form>
                    </div>
                    
                </div>

                <div class="row" id="searchResults" class="d-none">
                
                    <div class="col-md-8">
                        <div class="card card-body p-0 m-0">
                            <span id="ogivechart" ></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p>INFORMATION</p>

                        <div class="row m-1">
                            <div class="col-md-8 border border primary d-flex justify-content-between p-1 ">
                               <span class="h4 my-auto">MAXIMUM MARK</span> 
                               <span class="h4 my-auto" id="max-mark">30</span>
                            </div>
                        </div>
                        <div class="row m-1">
                            <div class="col-md-8 border border primary d-flex justify-content-between p-1 ">
                               <span class="h4 my-auto">MEAN MARK</span> 
                               <span class="h4 my-auto" id="mean-mark">30</span>
                            </div>
                        </div>
                        <div class="row m-1">
                            <div class="col-md-8 border border primary d-flex justify-content-between p-1 ">
                               <span class="h4 my-auto">MINIMUM MARK</span> 
                               <span class="h4 my-auto" id="low-mark">30</span>
                            </div>
                        </div>
                        <br>
                        <p>CANDIDATURE</p>

                        <div class="row m-1">
                            <div class="col-md-8 border border primary d-flex justify-content-between p-1 ">
                               <span class="h4 my-auto">TOTAL NUMBER OF CANDIDATES</span> 
                               <span class="h4 my-auto" id="max-cands">30</span>
                            </div>
                        </div>
                        <div class="row m-1">
                            <div class="col-md-8 border border primary d-flex justify-content-between p-1 ">
                               <span class="h4 my-auto">ABSENTEES</span> 
                               <span class="h4 my-auto" id="absentees">30</span>
                            </div>
                        </div>
                        <div class="row m-1">
                            <div class="col-md-8 border border primary d-flex justify-content-between p-1 ">
                               <span class="h4 my-auto">MISSING MARKS</span> 
                               <span class="h4 my-auto" id="missing-mark">30</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <?php include 'includes/scripts.php' ?>
    
   

</body>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- <script src="js/ogive.js"></script> -->
<script>
            $(document).ready(function() {
                get_subjects()
                get_paper()
                get_centre_type()
                $("#searchResults").addClass('d-none');
                //make_graph()
       
function get_subjects(){
    $.ajax({
          url: 'php/get_subject.php',
          method: 'POST',
          dataType: 'json',
          success:function(data){
            $('select[name=subject] option').remove();
              $('select[name=subject]').append(
                '<option selected disabled>Select Subject</option>'
              );
              $.each(data,function(){
                $('select[name=subject]').append(
                '<option value="'+this["subject_code"]+'">'+this["subject_code"]+' - '+this["subject_name"]+'</option>'
              );
              });
              $('select[name=subject]').select2({
                data:data
              });
          }
        });
  }
  
  function get_paper(){
    $('select[name=subject]').change(function(){
          var subject_code = $(this).val();
          $.ajax({
            url: 'php/get_paper.php',
            method: 'POST',
            data:{subject_code:subject_code},
            dataType: 'json',
            success:function(data){
              $('select[name=paper] option').remove();
              $('select[name=paper]').append(
                '<option value="" selected disabled>Select Paper Number</option>'
              );
              $.each(data,function(){
                $('select[name=paper]').append(
                '<option value="'+this["paper_no"]+'">'+this["paper_no"]+'</option>'
              );
              });
            }
          });
         // get_apportioned_belts(subject_code);
         // get_belt(subject_code);
        });


  }
            

  function get_centre_type(){
    $.ajax({
      url: 'php/get_centre_type.php',
      method: 'POST',
      dataType: 'json',
      success: function(data){
        $('select[name=centre_type] option').remove();
        $.each(data,function(){
          $('select[name=centre_type]').append(
            '<option value="'+this["centre_type"]+'">'+this["centre_type_name"]+'</option>'
          );
        });
        $('select[name=centre_type] option[value=undefined]').remove();
      }
    });
  }


  function make_graph(marks,candidates){

   // var ctx = document.getElementById('ogivechart').getContext('2d');
    var options = {
                series: [{
                    name: 'Number of Candidates',
                    data: candidates.map(Number)  // Convert strings to numbers
                }],
                chart: {
                    height: 350,
                    type: 'line'
                },
                title: {
                    text: 'Marks vs. Number of Candidates'
                },
                xaxis: {
                    categories: marks,
                    title: {
                        text: 'Number of Candidates'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Marks'
                    },
                    min: 0
                }
            };

            var chart = new ApexCharts(document.querySelector("#ogivechart"), options);
            chart.render();
    }


    $('#curveParamerForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
                
            var query = $('#search').val();
            if (query !== '') {
                $.ajax({
                    url: 'php/frequency_data.php',
                    method: 'POST',
                    data: { 
                            subject:$("#subject").val(),
                            paper:$("#paper").val(),
                            centre_type:$("#center_type").val()

                             },
                       
                        success: function(data) {
                          
                            if(data.status == '400'){

                           }else{


                            $("#searchResults").removeClass('d-none');
                            $("#ogivechart").html('')
                            
                        //console.log(data)
                        const jsonData = JSON.parse(data);
                        console.log(jsonData)
                        if (!jsonData.status) {
                            //console.error("Invalid Ajax response format (missing status)");
                            return;
                            }

                            const chartData = [];
                            for (const [key, entry] of Object.entries(jsonData)) {
                            if (key !== "status" && entry.mark && entry.no_of_candidates) {
                                chartData.push({
                                x: parseInt(entry.mark, 10),
                                y: parseInt(entry.no_of_candidates, 10),
                                });
                            }
                            }

                            //console.log(chartData);


                            var totalCandidates = 0;
                            var weightedSum = 0;

                            // Loop through data
                            $.each(chartData, function(index, item) {
                                totalCandidates += item.y; // Add frequency (y) for total candidates
                                weightedSum += item.x * item.y; // Multiply mark (x) by frequency (y) and add
                            });

                            // Calculate mean
                            var mean = weightedSum / totalCandidates;

                            // Display result (replace with your desired output method)
                            //console.log("Mean:", mean);
                            var total_cands=jsonData[0]["total_no_of_candidates"]
                            var absentees=jsonData[0]["no_of_absentees"]
                            var missing_marks=jsonData[0]["no_of_missing_mark"]
                            //console.log("DATA",absentees)
                            var max_mark=jsonData[0]["highest_mark"]
                            var low_mark=jsonData[0]["lowest_mark"]
                            //console.log("DATA",absentees)
                            $("#max-cands").html(total_cands)
                            $("#absentees").html(absentees)
                            $("#missing-mark").html(missing_marks)
                            
                            $("#mean-mark").html(mean)
                            $("#max-mark").html(max_mark)
                            $("#low-mark").html(low_mark)



                                var options = {
                                    annotations: {
                                            xaxis: [
                                                {
                                                x: mean,
                                                borderColor: "#FEB019",
                                                label: {
                                                borderColor: "#FEB019",
                                                style: {
                                                    color: "#fff",
                                                    background: "#FEB019"
                                                },
                                                orientation: "horizontal",
                                                text: "Mean Mark: "+mean+""
                                                }
                                            }
                                            ]
                                            },
                                        chart: {
                                            type: "line"
                                        },
                                        series: [{
                                            name: "Marks",
                                            data: chartData
                                        }],
                                        stroke: {
                                        curve: 'smooth'
                                        },
                                        xaxis: {
                                            title: {
                                            text: "Marks"
                                            }
                                        },
                                        yaxis: {
                                            title: {
                                            text: "Number of Candidates"
                                            },
                                            min: 0 // Set minimum to 0 for ogive chart
                                        },
                                        responsive: [{
                                        breakpoint: 480,
                                        options: {
                                            chart: {
                                            width: 100
                                            },
                                            legend: {
                                            position: 'bottom'
                                            }
                                        }
                                        }],
                                        

                                        };

                                        var chart = new ApexCharts(document.querySelector("#ogivechart"), options);

                                        chart.render();

                    }
                        }
                    });
                }
            });
        });
    </script>

<?php
}else{
  header('location: ../');
}
?>
</html>