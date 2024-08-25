<?php
include( 'partial/header.php' ); ?>

<link rel="stylesheet" type="text/css" href="assets/css/vendors/daterange-picker.css">
<link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">

<?php
include( 'partial/loader.php' ); ?>

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
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>New Room</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="roomForm" class="theme-form mega-form" method="post"
                                              action="room-create">
                                           

                                            <div class="mb-3">
                                                <label class="col-form-label">Room Type</label>
                                                <select class="form-select" id="roomType" name="room_type" required>
                                                    <option selected disabled value="">Choose...</option>
                                                    <option value="SINGLE_ROOM">Single Room</option>
                                                    <option value="DOUBLE_ROOM">Double Room</option>
                                                    <option value="TRIPLE_ROOM">Triple Room</option>
                                                    <option value="EXTRA_BED">Extra Bed</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label">Room Price</label>
                                                <input class="form-control" type="number" id="roomPrice"
                                                       name="room_price" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label">Capacity</label>
                                                <input class="form-control" type="number" id="capacity" name="capacity"
                                                       required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label">Room Count</label>
                                                <input class="form-control" type="number" id="roomCount"
                                                       name="room_count" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label">Is Extra</label>
                                                <select class="form-select" id="isExtra" name="is_extra" required>
                                                    <option selected disabled value="">Choose...</option>
                                                    <option value="1">True</option>
                                                    <option value="0">False</option>
                                                </select>
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="button" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
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
<script src="assets/js/tooltip-init.js"></script>
<?php
include( 'partial/footer-end.php' ); ?>
