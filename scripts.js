document.addEventListener("DOMContentLoaded", function() {
    fetchFlights();
});

function fetchFlights() {
    fetch('airline_db.php')
    .then(response => response.json())
    .then(data => {
        const table = document.getElementById('flightsTable').getElementsByTagName('tbody')[0];
        data.forEach(flight => {
            let row = table.insertRow();
            row.onclick = () => fetchFlightDetails(flight.flight_id); // Adding click handler
            row.insertCell(0).textContent = flight.schedule_id;
            row.insertCell(1).textContent = flight.date;
            row.insertCell(2).textContent = flight.airline;
            row.insertCell(3).textContent = flight.available_seats;
            row.insertCell(4).textContent = '$' + flight.fare;
        });

        function fetchFlightDetails(flightId) {
            
            fetch(`getFlightDetails.php?flightId=${flightId}`)
            .then(response => response.json())
            .then(data => {
                const details = document.getElementById('flightDetails');
                details.innerHTML = `Airline: ${data.airline}<br>From: ${data.origin_city} to ${data.destination_city}<br>Departure: ${data.departure_time}<br>Arrival: ${data.arrival_time}`;
            })
            .catch(error => console.error('Error fetching flight details:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetch('fetchFlights.php')
            .then(response => response.json())
            .then(data => populateFlights(data))
            .catch(error => console.error('Error:', error));
        });
        
        function populateFlights(data) {
            const tableBody = document.getElementById('flightsTable').querySelector('tbody');
            data.forEach(flight => {
                let row = tableBody.insertRow();
                row.innerHTML = `<td>${flight.flight_id}</td><td>${flight.airline}</td><td>${flight.departure}</td><td>${flight.destination}</td>`;
            });
        }
    })
    .catch(error => console.error('Error loading the flights:', error));
}

