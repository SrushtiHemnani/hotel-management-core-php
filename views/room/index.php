<?php include('partial/header.php'); ?>
<link rel="stylesheet" type="text/css" href="assets/css/vendors/datatables.css">


<?php include('partial/loader.php'); ?>


<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <?php include('partial/topbar.php'); ?>
    <!-- Page Header Ends -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php include('partial/sidebar.php'); ?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <?php include('partial/breadcrumb.php'); ?>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <!-- Row Selection And Deletion (Single Row) Starts-->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header pb-0 card-no-border">
                                <h3 class="mb-3">Rooms</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display" id="roomTable">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Room Number</th>
                                            <th>Is Available</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Hotel Name</th>
                                            <th>Hotel Location</th>
                                            <th>Room Price</th>
                                            <th>Pricing Start Date</th>
                                            <th>Room Category</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- DataTables will populate this -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row Selection And Deletion (Single Row) Ends-->

                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>

        <?php include('partial/footer.php'); ?>
    </div>
</div>

<?php include('partial/scripts.php'); ?>
<script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
<?php include('partial/footer-end.php'); ?>
<script>
$(document).ready(function() {
    $('#roomTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'get-rooms', // Path to your server-side script
            type: 'GET',
            dataSrc: 'data' // Specify the data source key
        },
        columns: [
            { data: 'id' },
            { data: 'room_number' },
            { data: 'is_available' },
            { data: 'created_at' },
            { data: 'updated_at' },
            { data: 'hotel_name' },
            { data: 'hotel_location' },
            { data: 'room_price' },
            { data: 'pricing_start_date' },
            { data: 'room_category_name' },
            { data: 'action' }
        ],
        order: [[0, 'asc']] // Sort by id
    });
});
</script>
