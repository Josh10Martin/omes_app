

attendance();
 subject_script_no();
//setInterval(attendance,500); 
//setInterval(attendance,500);
// console.log("ATTENDANCE REQUEST")
function attendance(){
  
$.ajax({
  url: 'php/attendance_number.php',
  method: 'POST',
  dataType: 'json',
  success: function(data){
    var present=Number(data.present)
    
    var absent=Number(data.absent)
    var options = {
      series: [present, absent],
      colors:['#1d9d74','#ed3237a3'],
      //series: [10, 20],
      chart: {
      width: 290,
      margin:{
        right:0,
      },
      type: 'pie',
    },
    labels: ['PRESENT', 'ABSENT'],
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      }
    }]
    };
    
    var chart = new ApexCharts(document.querySelector("#attendance"), options);
    chart.render();
    

  }
});
}





//Scripts per subject
var data2=[]
var data1=[]
function subject_script_no(){
  
  //console.log("IN SCRIPTS")
  $.ajax({
    url: 'php/subject_script_no.php',
    method: 'POST',
    dataType: 'json',
    success: function(data){
     $.each(data,function( key,value){
      data2.push(this["no_of_scripts"]);
      data1.push(this["subject_code"]);
     });


var options={
  chart:{
    type:'bar',
    height:195,
  },
  plotOptions: {
    bar: {
      horizontal: false,
    },
  },
  dataLabels: {
    enabled: false, // Set to false to remove labels
  },

  series:[{
   name:'No of Scripts',
   data:data2.slice(0,10)
  }],
  xaxis: {
    categories: data1.slice(0,10),
  },
  
}

 
var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();
}
});
}
var currentPage=0;
var itemsPerPage=10;

function updateChart() {
  var start = currentPage * itemsPerPage;
  var end = start + itemsPerPage;
  var newData = data2.slice(start, end);
  var newCategories = data1.slice(start, end);

  chart.updateOptions({
    xaxis: {
      categories: newCategories,
    },
  });

  chart.updateSeries([
    {
      name: 'No of Scripts',
      data: newData,
    },
  ]);
}

function nextPage(){
  if (currentPage <Math.ceil(data2.length / itemsPerPage)-1){
    currentPage++;
    updateChart();
    console.log("PAGE",currentPage)
    $('#prev').removeClass('btn-off')
  }else{
    $('#next').addClass('btn-off')
    $('#prev').removeClass('btn-off')
  }
}

function previousPage() {
  if (currentPage > 0) {
    currentPage--;
    updateChart();
    console.log("PAGE",currentPage)
    $('#next').removeClass('btn-off')
  }
  if(currentPage == 0){
    $('#prev').addClass('btn-off')
    $('#nex').removeClass('btn-off')
  }
  
}
  
