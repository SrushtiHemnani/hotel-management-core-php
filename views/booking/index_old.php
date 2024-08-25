<?php
include( 'partial/header.php' ); ?>
<!-- Add these lines in the `views/booking/index.php` file where other CSS files are included -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

<?php
include( 'partial/loader.php' ); ?>


<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
	<?php
	include( 'partial/topbar.php' ); ?>
    <!-- Page Header Ends -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
		<?php
		include( 'partial/sidebar.php' ); ?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
			<?php
			include( 'partial/breadcrumb.php' ); ?>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <!-- Add rows  Starts-->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header pb-0 card-no-border">
                                <h3 class="mb-3">Bookings</h3></div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="bookingTable" class="display">
                                        <thead>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Total Price</th>
                                            <th>Check-In</th>
                                            <th>Check-Out</th>
                                            <th>Rooms</th>
                                            <th>Guests</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- Data will be loaded here by DataTables -->
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>

		<?php
		include( 'partial/footer.php' ); ?>
    </div>
</div>


<?php
include( 'partial/scripts.php' ); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowgroup/1.1.4/css/rowGroup.dataTables.min.css"/>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.1.4/js/dataTables.rowGroup.min.js"></script>
<!-- Add these lines in the `views/booking/index.php` file where other JS files are included -->
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<?php
include( 'partial/footer-end.php' ); ?>


<!-- Modify the DataTable initialization script in the `views/booking/index.php` file -->
<script>
    $(document).ready(function() {
        $('#bookingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'get-booking', // Path to your server-side script
                type: 'GET'
            },
            columns: [
                { data: 'customer_name' },
                { data: 'total_price' },
                { data: 'check_in' },
                { data: 'check_out' },
                { data: 'guest', orderable: false, searchable: false, render: function(data) {
                    return data.map(function(guest) {
                        return guest.name + ' (' + guest.age + ' years)';
                    }).join('<br>');
                }},
                { data: 'rooms', orderable: false, searchable: false }
            ],
            order: [[0, 'asc'], [2, 'asc']], // Sort by customer_name and check_in
            rowGroup: {
                dataSrc: ['customer_name', 'check_in']
            },
            dom: 'Bfrtip', // Add this line to include the export buttons
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print' // Add the buttons you want
            ]
        });
    });
</script>

