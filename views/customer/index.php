<!-- views/customer/index.php -->
<?php include('partial/header.php'); ?>
<link rel="stylesheet" type="text/css" href="assets/css/custom-tree-view.css">

<?php include('partial/loader.php'); ?>

<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <?php include('partial/topbar.php'); ?>
    <div class="page-body-wrapper">
        <?php include('partial/sidebar.php'); ?>
        <div class="page-body">
            <?php include('partial/breadcrumb.php'); ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header pb-0 card-no-border">
                                <h3 class="mb-3">Customers</h3>
                            </div>
                            <div class="card-body">
                                <ul id="customerTreeView" class="tree-view">
                                    <!-- Tree view will be dynamically loaded here -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('partial/footer.php'); ?>
        </div>
    </div>
</div>

<?php include('partial/scripts.php'); ?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/custom-tree-view.js"></script>
<?php include('partial/footer-end.php'); ?>
<style>
    /* Basic CSS for the tree view */
    .tree-view {
        list-style-type: none;
        padding-left: 20px;
    }

    .tree-view .caret {
        cursor: pointer;
        user-select: none;
    }

    .tree-view .caret::before {
        content: "\25B6"; /* Right-pointing triangle */
        color: black;
        display: inline-block;
        margin-right: 6px;
    }

    .tree-view .caret-down::before {
        transform: rotate(90deg); /* Down-pointing triangle */
    }

    .tree-view .nested {
        display: none;
        padding-left: 20px;
    }

    .tree-view .active {
        display: block;
    }
</style>

<script>
    $(document).ready(function() {
        $('#customerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'get-customers', // Path to your server-side script
                type: 'GET'
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                {data: 'email'},
                { data: 'phone' },
                { data: 'age' },
                { data: 'guest' },
                { data: 'action' }
            ],
            order: [[0, 'asc']] // Sort by id
        });
    });
</script>
 tree view