var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',
    

    // The data for our dataset
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "",
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            borderColor: '#ff0085',
            borderWidth: 2,
            pointColor: 'rgba(255, 255, 255, 1)',
            data: [0, 10, 5, 2, 20, 30, 45, 50, 45, 55, 65, 70],
            tension: 0,
            // pointHoverBorderWidth: '20',
            pointRadius: 4,
            pointBackgroundColor: '#ff0085',
            
        }]
    },
    // Configuration options go here
    options: {
        legend: {
            display: false,
        },
        scales:{
            yAxes: [{
                display: false,
                gridLines: {
                    display: false
                }
            }]
        }
    }
});


var ctx = document.getElementById('myDougnut').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',
    

    // The data for our dataset
    data: {
        datasets: [{
            label: "",
            backgroundColor: [
                'rgba(28, 213, 206, 1)',
                'rgba(255, 99, 132, 0.1)'
                ],
            borderColor: [
                'rgba(100, 0, 52, 0)',
                'rgba(100, 0, 52, 0)'
                ],
            data: [70, 30],
            
            // pointHoverBorderWidth: '',
        }]
    },
    // Configuration options go here
    options: {
        cutoutPercentage: 97
    }
});



$( '#calendar' ).calendario();