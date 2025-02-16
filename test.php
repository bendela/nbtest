<!DOCTYPE html>
<html>
<head>
<title>Chart Example</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  </head>
<body>
<canvas id="myChart"></canvas>

<script>
function createChart(chartData, labels, options) {
    const ctx = document.getElementById('myChart');

    const chartLabels = Object.keys(chartData); // Months
    const planValues = chartLabels.map(month => chartData[month]['plan']);
    const collectionValues = chartLabels.map(month => chartData[month]['collection']);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels, // Month labels
            datasets: [{
                label: labels[0], // "Plan"
                data: planValues,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: labels[1], // "Collection"
                data: collectionValues,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: options.titleText, // Chart title
                    font: {
                        size: 16
                    }
                }
            }
        }
    });
}


function fetchDataAndCreateChart(collector, year, month) {
    $.ajax({
        url: 'chart_source.php', // Path to your PHP script
        type: 'GET',
        data: { collector: collector, year: year, month: month }, // Pass the parameters
        dataType: 'json', // Expect JSON response
        success: function(response) {
            if (response.error) {
                console.error(response.error);
                return;
            }
            createChart(response.data, response.labels, response.options);
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });
}

// Initial chart creation (e.g., on page load)
fetchDataAndCreateChart(null, null, null); // Or provide initial values if needed


// Example: Call the function when a button is clicked (you'll need to add buttons)
// $('#myButton').click(function() {
//     const collector = $('#collectorDropdown').val(); // Get values from your filter elements
//     const year = $('#yearDropdown').val();
//     const month = $('#monthDropdown').val();
//     fetchDataAndCreateChart(collector, year, month);
// });

</script>

</body>
</html>