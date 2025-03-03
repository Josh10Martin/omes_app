$(document).ready(function() {
	
	// Bar Chart
	//bargraph
	var barChartData = {
		labels: ['Center1', 'Center2', 'Center3', 'Center4', 'Center5', 'Center6'],
		datasets: [{
			label: 'Dataset 1',
			backgroundColor: 'rgba(29, 157, 117, 0.603)', //rgba(0, 158, 251, 0.5)
			borderColor: 'rgba(29, 157, 117, 1.103)',//rgba(0, 158, 251, 1)
			borderWidth: 1,
			data: [35, 59, 80, 81, 56, 55, 40]
		}, {
			label: 'Dataset 2',
			backgroundColor: 'rgba(255, 188, 53, 0.5)',
			borderColor: 'rgba(255, 188, 53, 1)',
			borderWidth: 1,
			data: [28, 48, 40, 19, 86, 27, 90]
		}]
	};

	// var ctx = document.getElementById('bargraph').getContext('2d');
	// window.myBar = new Chart(ctx, {
	// 	type: 'bar',
	// 	data: barChartData,
	// 	options: {
	// 		responsive: true,
	// 		legend: {
	// 			display: false,
	// 		}
	// 	}
	// });

	// Line Chart

	var lineChartData = {
		labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12","13", "14", "15", "16", "17", "18", "19", "20", "21"],
		datasets: [{
			label: "My First dataset",
//			backgroundColor: "rgba(29, 157, 117, 0.603)",
			data: [99, 90, 82, 90, 98, 88, 89, 91, 92, 95, 98, 105,99, 80, 82, 90, 98, 88, 89,80]
		}, 
		// {
		// label: "My Second dataset",
		// backgroundColor: "rgba(255, 188, 53, 0.5)",
		// fill: true,
		// data: [28, 48, 40, 19, 86, 27, 20, 90, 50, 20, 90, 20]
		// }
	]
	};
	
	var linectx = document.getElementById('linegraph').getContext('2d');
	window.myLine = new Chart(linectx, {
		type: 'line',
		data: lineChartData,
		options: {
			responsive: true,
			legend: {
				display: false,
			},
			tooltips: {
				mode: 'index',
				intersect: false,
			}
		}
	});
	
	// Bar Chart 2
	
    barChart();
    
    $(window).resize(function(){
        barChart();
    });
    
    function barChart(){
        $('.bar-chart').find('.item-progress').each(function(){
            var itemProgress = $(this),
            itemProgressWidth = $(this).parent().width() * ($(this).data('percent') / 100);
            itemProgress.css('width', itemProgressWidth);
        });
    };
});