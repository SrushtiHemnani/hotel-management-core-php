<?php
include( 'partial/header.php' ); ?>

<link rel="stylesheet" type="text/css" href="<?=BASE_PATH?>assets/css/vendors/daterange-picker.css">
<link rel="stylesheet" type="text/css" href="<?=BASE_PATH?>assets/css/vendors/sweetalert2.css">
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
		
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Edit Room</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="roomForm" class="theme-form mega-form" method="post">


                                            <!-- Other code -->

                                            <div class="mb-3">
                                                <label class="col-form-label">Room Type</label>
                                                <select class="form-select" id="roomType" name="room_type" required>
                                                    <option selected disabled value="">Choose...</option>
                                                    <option value="SINGLE_ROOM" <?php
													echo $room->room_type == 'SINGLE_ROOM' ? 'selected' : ''; ?>>Single
                                                        Room
                                                    </option>
                                                    <option value="DOUBLE_ROOM" <?php
													echo $room->room_type == 'DOUBLE_ROOM' ? 'selected' : ''; ?>>Double
                                                        Room
                                                    </option>
                                                    <option value="TRIPLE_ROOM" <?php
													echo $room->room_type == 'TRIPLE_ROOM' ? 'selected' : ''; ?>>Triple
                                                        Room
                                                    </option>
                                                    <option value="EXTRA_BED" <?php
													echo $room->room_type == 'EXTRA_BED' ? 'selected' : ''; ?>>Extra Bed
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label">Room Price</label>
                                                <input class="form-control" type="number" id="roomPrice"
                                                       name="room_price" value="<?php
												echo $room->room_price; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label">Capacity</label>
                                                <input class="form-control" type="number" id="capacity" name="capacity"
                                                       value="<?php
												       echo $room->capacity; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label">Room Count</label>
                                                <input class="form-control" type="number" id="roomCount"
                                                       name="room_count" value="<?php
												echo $room->room_count; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label">Is Extra</label>
                                                <select class="form-select" id="isExtra" name="is_extra" required>
                                                    <option selected disabled value="">Choose...</option>
                                                    <option value="1" <?php
													echo $room->is_extra == 1 ? 'selected' : ''; ?>>True
                                                    </option>
                                                    <option value="0" <?php
													echo $room->is_extra == 0 ? 'selected' : ''; ?>>False
                                                    </option>
                                                </select>
                                            </div>

                                            <!-- Other code -->

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
<script src="<?=BASE_PATH?>assets/js/tooltip-init.js"></script>
<?php
include( 'partial/footer-end.php' ); ?>
