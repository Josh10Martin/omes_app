  var options = {
    series: [100, 200],
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





var data2= [3000, 3500, 1045, 2050, 3049,960,3370,3991,4125,3000,3500,1045,2050,3049,960,3370,3991,4125,4125,3000,3500,1045,2050,3049,960,3370,3991,4125,4125,3000,3500,1045,2050,3049,960,3370,3991,4125,3000,3500,1045,2050,3049,960,3370,3991,4125];
var data1= ['1122/1','1122/1','1122/1', '1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1', '1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1', '1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1','1122/1'];
// console.log("Hellow",data1.slice(1,4))
// console.log("Data2",data2.slice(27,50))

var options={
  chart:{
    type:'bar',
    height: 200,
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
   name:'Centers',
   data:data2.slice(0,10)
  }],
  
}
var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();
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
      name: 'Centers',
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