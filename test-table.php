<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Information</title>
 <style>
     /* Basic styling */
     table {
         width: 100%;
         border-collapse: collapse;
     }

     th, td {
         border: 1px solid #ddd;
         padding: 8px;
         text-align: left;
     }

     th {
         background-color: #f2f2f2;
     }

     .customerRow {
         cursor: pointer;
     }

     .detailsRow {
         display: none; /* Hide details by default */
     }

     .detailsTable {
         width: 100%;
         border: 1px solid #ddd;
         margin-top: 10px;
     }

     .detailsTable th, .detailsTable td {
         border: 1px solid #ddd;
         padding: 8px;
     }

 </style>
</head>
<body>
<table id="bookingTable">
    <thead>
    <tr>
        <th>Customer Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Number of Rooms</th>
        <th>Total Price</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <!-- Example Row -->
    <tr class="customerRow" data-customer-id="1">
        <td>Baker Sargent</td>
        <td>jenolas@mailinator.com</td>
        <td>+1 (908) 348-2253</td>
        <td>2</td>
        <td>$8000</td>
        <td><button class="viewDetails">View Details</button></td>
    </tr>
    <!-- Expandable Details Row -->
    <tr class="detailsRow" data-customer-id="1">
        <td colspan="6">
            <table class="detailsTable">
                <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>964</td>
                    <td>DOUBLE_ROOM</td>
                    <td>08/12/2024</td>
                    <td>08/13/2024</td>
                    <td>$4000</td>
                </tr>
                <tr>
                    <td>101</td>
                    <td>DOUBLE_ROOM</td>
                    <td>08/12/2024</td>
                    <td>08/13/2024</td>
                    <td>$4000</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <!-- Repeat for other customers -->
    </tbody>
</table>

<script >

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.viewDetails').forEach(button => {
            button.addEventListener('click', function() {
                const customerId = this.closest('.customerRow').dataset.customerId;
                const detailsRow = document.querySelector(`.detailsRow[data-customer-id="${customerId}"]`);

                // Toggle visibility of the details row
                if (detailsRow.style.display === 'table-row') {
                    detailsRow.style.display = 'none';
                } else {
                    detailsRow.style.display = 'table-row';
                }
            });
        });
    });

</script> <!-- Include your JavaScript file -->
</body>
</html>
