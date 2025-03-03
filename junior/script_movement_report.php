<?php
session_start();
if(isset($_POST['province'])){
  $province_code = explode(':',$_POST['province'])[0];
  $province_name = explode(':',$_POST['province'])[1];

?>
<!DOCTYPE html>
<html lang="en">



<?php include 'includes/header.php'?>

<body>
    <style>
        .form-check{
            padding: 5rem !important; 
        }
    </style>
<div class="main-wrapper">

    <?php include 'includes/navbar.php'?>     
    <?php include 'includes/sidebar.php'?>
<div class="page-wrapper">
    <div class="content">
        <div class="row justify-content-between px-2">
            <div class="col-xs-4">
                <h4 class="page-title">SCRIPT MOVEMENT REPORT</h4>
            </div>
            <div class="col-xs-6">
              <span class="align-middle h4" id="province"><?php echo $province_name; ?> PROVINCE</span>                
            </div>
            <div class="col-xs-2">
              <span class="align-middle">Download</span>                
                 <a id="pdf" href="javascript:void(0)"  class="btn bg-light btn-sm"> <i class="fa fa-file-pdf-o red-ecz" aria-hidden="true"></i> pdf</a>
            </div>
        </div>

        <div class="row">
          <form action="">
            <input type="hidden" name="province_code" value="<?php echo $province_code; ?>">
          </form>
          <div class="col-md-12">
           
              <table class="table table-bordered" id="script_movement">
                <thead>
                  <tr>
                  <th>Marking Centre</th>
                  <th>Subject</th>
                  <th>Dstrict</th>
                  <th>no. of centres</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <!-- <td>01</td>
                    <td>02</td>
                    <td>03</td> -->
                  </tr>
                </tbody>
              </table>

            
           
          </div>
        </div>
       

        

    <?php include 'includes/notifications.php' ?>
    </div> <!--End  content-->
</div> <!--End page wrapper-->



<div class="sidebar-overlay" data-reff=""></div>
</div>	
<?php include 'includes/scripts.php' ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://unpkg.com/jspdf-autotable@3.5.22/dist/jspdf.plugin.autotable.js"></script>
<script>
  $(document).ready(function(){
    get_province_script_summary();
    var province_name= $('#province').text()
    //console.log("Province:",province_name)
    $('a#pdf').click(function(){
      var headStyles={
      fillColor: [255, 255, 255] ,
      textColor: [0, 0, 0],
      lineWidth: 0.1,             // Set border width
      lineColor: [0, 0, 25] ,
  }
      var doc = new jsPDF();
      doc.autoTable({ 
        html: '#script_movement' ,
        margin: { top: 55 },
       // fillColor:  [255, 255, 255],
        headStyles:headStyles,
        //styles: cellStyles,
       // columnStyles: columnStyles,
        didDrawPage: function (data) {
          doc.setFontSize(13);
          doc.text('EXAMINATIONS COUNCIL OF ZAMBIA', 67,40);
          doc.text('SCRIPT MOVEMENT REPORT', 77,45);
          doc.text(province_name,77,50)

          var str = "Page " + doc.internal.getNumberOfPages();
                        
                        doc.setFontSize(10);
                    
                        // jsPDF 1.4+ uses getWidth, <1.4 uses .width
                        var pageSize = doc.internal.pageSize;
                        var pageHeight = pageSize.height
                          ? pageSize.height
                          : pageSize.getHeight();
                        doc.text(str, data.settings.margin.left, pageHeight - 10);
        },
       
    
      });
      const img=new Image();
      img.src='../assets/img/eczlogo_tr_sm1.jpg';
      img.onload=()=>{
        //doc.addImage(img, 'PNG', logoX, logoY, logoWidth, logoHeight);
        doc.addImage(img,'PNG',90,10,25,25);
        doc.save('script_Movement.pdf');
      }
      
      
  });
    
   function get_province_script_summary(){
        var province_code = $('input[type=hidden][name=province_code]').val();
        $.ajax({
          url: 'php/get_provincial_script_summary.php',
          method: 'POST',
          data: {province_code:province_code},
          dataType: 'json',
          success:function(data){
            if(data.status == '400'){
              $('table#script_movement tbody').append('<tr class="null">'+
              '<td colspan="4">No script movement done</td>'+
              '</tr>');
            }else{
             
              $('table#script_movement tbody tr.null').remove();
              $.each(data,function(){
                $('table#script_movement tbody').append('<tr class="'+this["apportion_id"]+'">'+
                '<td>'+this["marking_centre"]+'</td>'+
                '<td>'+this["subjects"]+'</td>'+
                '<td>'+this["districts"]+'</td>'+
                '<td>'+this["no_of_centres"]+'</td>'+
                '</tr>');
              });
              $('table#script_movement tbody tr.undefined').remove();
            }
          }
        });
   }   


  });
</script>
</body>

<?php
}else{
  header('location: marks_reports.php');
}

?>

</html>