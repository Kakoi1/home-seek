@extends('layouts.app')

@section('dashboard')

@section('content')


<style>
    .chart-container {
        width: 80%;
        height: 500px;
        /* Add height here to ensure enough space for chart */
        margin: 0 auto;
    }

    #userMetricsChart,
    #propertyInsightsChart {
        width: 100% !important;
        /* Ensure canvas takes up full width */
        height: 100% !important;
        /* Ensure canvas height matches container height */
    }

    .popuper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .popuper.hidden {
        display: none;
    }

    .popup-contenter {
        background: white;
        padding: 20px;
        border-radius: 8px;
        width: 70%;
        max-height: 80%;
        overflow-y: auto;
        position: relative;
        text-align: center;
    }

    .popuper table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .popuper table th,
    .popuper table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .popuper table th {
        background: #f4f4f4;
        font-weight: bold;
    }

    .close-btner {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }

    .pagination {
        margin: 20px 0;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .pagination button {
        padding: 5px 10px;
        border: 1px solid #ddd;
        background: linear-gradient(to right, rgba(11, 136, 147, 0.911), rgba(54, 0, 51, 0.877));
        border-radius: 6px;
        cursor: pointer;
        color: white;
    }

    .pagination button:disabled {
        background: #ddd;
        cursor: not-allowed;
    }

    #shortenedAddress th {
        color: black;
    }
</style>


<!-- main  content -->

<div class="container">
    <h2>Dashboard</h2>
    <div class="overview-boxes">
        <div class="box" data-type="owners" onclick="showPopup(this)">
            <i class='bx bx-user'></i>
            <div class="text">
                <h3>Total Owners</h3>
                <p class="number">{{$ownersCount->count()}}</p>
            </div>
        </div>
        <div class="box" data-type="listings" onclick="showPopup(this)">
            <i class='bx bx-home'></i>
            <div class="text">
                <h3>Total Listings</h3>
                <p class="number">{{$totalProperties->count()}}</p>
            </div>
        </div>
        <div class="box" data-type="users" onclick="showPopup(this)">
            <i class='bx bx-group'></i>
            <div class="text">
                <h3>Total Users</h3>
                <p class="number">{{$usersCount->count()}}</p>
            </div>
        </div>
    </div>

    <div class="metrics">
        <h3>User Metrics</h3>
        <div class="chart-container">
            <canvas id="userMetricsChart" width="800" height="400"></canvas>
        </div>

        <h3>Accommodation Insights</h3>
        <div class="chart-container">
            <canvas id="propertyInsightsChart" width="800" height="400"></canvas>
        </div>
    </div>
    <div id="dataPopup" class="popuper hidden">
        <div class="popup-contenter">
            <button class="close-btner" onclick="closePopuper()">&times;</button>
            <h3 id="popupTitle">Popup Title</h3>
            <table>
                <thead id="popupTableHeader"></thead>
                <tbody id="popupTableBody"></tbody>
            </table>
            <div id="popupPagination" class="pagination"></div>
        </div>
    </div>

    <script>
        // Log the data to check for errors

        // User Metrics Chart
        const userMetricsCtx = document.getElementById('userMetricsChart').getContext('2d');
        const userMetricsChart = new Chart(userMetricsCtx, {
            type: 'bar',
            data: {
                labels: ['Active Users', 'Inactive Users', 'Tenants', 'Owners'],
                datasets: [{
                    label: 'User Metrics',
                    data: [
                        {!! json_encode($activeUsersCount) !!},
                        {!! json_encode($inactiveUsersCount) !!},
                        {!! json_encode($tenantsCount) !!},
                        {!! json_encode($ownersCount->count()) !!}
                    ],
                    backgroundColor: ['#4CAF50', '#FF6347', '#36A2EB', '#FFCE56']
                }]
            },
            options: {
                responsive: true,
                aspectRatio: 2, // Change aspectRatio to control chart's proportion
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Property Insights Chart
        const propertyInsightsCtx = document.getElementById('propertyInsightsChart').getContext('2d');
        const propertyInsightsChart = new Chart(propertyInsightsCtx, {
            type: 'bar',
            data: {
                labels: ['Total Accommodation', 'Available', 'Unavailable', 'Archived', 'Inactive'],
                datasets: [{
                    label: 'Accommodation Insights',
                    data: [
                        {!! json_encode($totalProperties->count()) !!},
                        {!! json_encode($availableProperties) !!},
                        {!! json_encode($unavailableProperties) !!},
                        {!! json_encode($archivedProperties) !!},
                        {!! json_encode($flaggedProperties) !!}
                    ],
                    backgroundColor: ['#4CAF50', '#36A2EB', '#FF6347', '#9C27B0', '#FFC107']
                }]
            },
            options: {
                responsive: true,
                aspectRatio: 2, // Change aspectRatio to control chart's proportion
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        async function fetchAndDisplayData(url, type) {
            const popupTitle = document.getElementById('popupTitle');
            const popupTableHeader = document.getElementById('popupTableHeader');
            const popupTableBody = document.getElementById('popupTableBody');
            const paginationContainer = document.getElementById('popupPagination');

            // Clear previous content
            popupTableHeader.innerHTML = '';
            popupTableBody.innerHTML = '';
            paginationContainer.innerHTML = '';

            // Fetch data
            const response = await fetch(url);
            const { data, links } = await response.json();

            // Set title
            popupTitle.textContent = type === 'owners' ? 'All Owners' : type === 'users' ? 'All Users' : 'All Listings';

            // Define headers based on type
            const headers = {
                users: ['Name', 'Email', 'Status', 'Joined'],
                owners: ['Name', 'Email', 'Status', 'Joined'],
                listings: ['Name', 'Address', 'Availability', 'Status'],
            };

            const selectedHeaders = headers[type];
            selectedHeaders.forEach(header => {
                const th = document.createElement('th');
                th.textContent = header;
                th.style.color = 'white'
                th.style.backgroundColor = 'black'
                popupTableHeader.appendChild(th);
            });

            // Populate rows
            data.forEach(row => {
                const tr = document.createElement('tr');
                Object.values(row).forEach(value => {
                    const td = document.createElement('td');
                    td.textContent = value;
                    tr.appendChild(td);
                });
                popupTableBody.appendChild(tr);
            });

            // Add pagination links
            const currentPage = links.find(link => link.active)?.label || 1;
            const totalPages = links.length ? links[links.length - 2].label : 1; // Assuming the second last link is the last page number

            // Create "Previous" button
            const prevButton = document.createElement('button');
            prevButton.textContent = 'Previous';
            prevButton.disabled = !links.find(link => link.label.includes('&laquo;'))?.url;
            prevButton.onclick = () => fetchAndDisplayData(links.find(link => link.label.includes('&laquo;')).url, type);
            paginationContainer.appendChild(prevButton);

            // Add "Page X of Y" label
            const pageInfo = document.createElement('span');
            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
            pageInfo.style.margin = '0 10px'; // Add some spacing
            paginationContainer.appendChild(pageInfo);

            // Create "Next" button
            const nextButton = document.createElement('button');
            nextButton.textContent = 'Next';
            nextButton.disabled = !links.find(link => link.label.includes('&raquo;'))?.url;
            nextButton.onclick = () => fetchAndDisplayData(links.find(link => link.label.includes('&raquo;')).url, type);
            paginationContainer.appendChild(nextButton);

            // Show popup
            document.getElementById('dataPopup').classList.remove('hidden');
        }

        function showPopup(box) {
            const type = box.dataset.type;
            let url = '';
            switch (type) {
                case 'owners':
                    url = '/owners-data';
                    break;
                case 'users':
                    url = '/users-data';
                    break;
                case 'listings':
                    url = '/properties-data';
                    break;
            }
            fetchAndDisplayData(url, type);
        }

        function closePopuper() {
            document.getElementById('dataPopup').classList.add('hidden');
        }

    </script>

    @endsection