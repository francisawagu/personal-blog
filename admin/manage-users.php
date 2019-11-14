<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location: login.php');
} else {
    if (isset($_REQUEST['del'])) {
        $delid = intval($_GET['del']);
        $sql = "DELETE FROM users WHERE id=:delid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':delid', $delid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('User deleted');</script>";
    }

    if (isset($_REQUEST['uaid'])) {
        $uaid = intval($_GET['uaid']);
        $sql = "UPDATE `users` SET `status`=1 WHERE id=:uaid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':uaid', $uaid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('User APPROVED successfully');</script>";
    }


    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Manage Users</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
        <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    </head>

    <body id="page-top">
        <div id="wrapper">

            <!-- sidebar -->
            <?php include 'includes/sidebar.php'; ?>

            <div class="d-flex flex-column" id="content-wrapper">
                <div id="content">

                    <!-- header -->
                    <?php include 'includes/header.php'; ?>

                    <div class="container-fluid">
                        <h3 class="text-dark mb-4">Users</h3>
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 font-weight-bold">Active Users</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 text-nowrap">
                                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                                            <label>Show&nbsp;<select
                                                        class="form-control form-control-sm custom-select custom-select-sm">
                                                    <option value="5" selected="">5</option>
                                                    <option value="10">10</option>
                                                </select>&nbsp;</label></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-md-right dataTables_filter" id="dataTable_filter"><label><input
                                                        type="search" class="form-control form-control-sm"
                                                        aria-controls="dataTable" placeholder="Search"></label></div>
                                    </div>
                                </div>
                                <div class="table-responsive table mt-2" id="dataTable" role="grid"
                                     aria-describedby="dataTable_info">
                                    <table class="table dataTable my-0" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php $sql = "SELECT users.* FROM users WHERE `status`=1";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                $name = htmlentities($result->fname . " " . $result->lname); ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($name); ?></td>
                                                    <td><?php echo htmlentities($result->email); ?></td>
                                                    <td><a href="manage-users.php?del=<?php echo $result->id; ?>"
                                                           onclick="return confirm('Do you want to delete?');">delete</a>
                                                    </td>
                                                </tr>
                                                <?php $cnt = $cnt + 1;
                                            }
                                        } ?>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 align-self-center">
                                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                                            Showing 1 to 5 of 100</p>
                                    </div>
                                    <div class="col-md-6">
                                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                            <ul class="pagination">
                                                <li class="page-item disabled"><a class="page-link" href="#"
                                                                                  aria-label="Previous"><span
                                                                aria-hidden="true">«</span></a></li>
                                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item"><a class="page-link" href="#"
                                                                         aria-label="Next"><span
                                                                aria-hidden="true">»</span></a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 font-weight-bold">Pending Users</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 text-nowrap">
                                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                                            <label>Show&nbsp;<select
                                                        class="form-control form-control-sm custom-select custom-select-sm">
                                                    <option value="5" selected="">5</option>
                                                    <option value="10">10</option>
                                                </select>&nbsp;</label></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-md-right dataTables_filter" id="dataTable_filter"><label><input
                                                        type="search" class="form-control form-control-sm"
                                                        aria-controls="dataTable" placeholder="Search"></label></div>
                                    </div>
                                </div>
                                <div class="table-responsive table mt-2" id="dataTable" role="grid"
                                     aria-describedby="dataTable_info">
                                    <table class="table dataTable my-0" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Approve</th>
                                            <th>Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php $sql = "SELECT users.* FROM users WHERE `status`=0";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                $name = htmlentities($result->fname . " " . $result->lname); ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($name); ?></td>
                                                    <td><?php echo htmlentities($result->email); ?></td>
                                                    <td><a href="manage-users.php?uaid=<?php echo $result->id; ?>"
                                                           onclick="return confirm('Do you want to approve this user?');">approve</a>
                                                    </td>
                                                    <td><a href="manage-users.php?del=<?php echo $result->id; ?>"
                                                           onclick="return confirm('Do you want to delete?');">delete</a>
                                                    </td>
                                                </tr>
                                                <?php $cnt = $cnt + 1;
                                            }
                                        } ?>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 align-self-center">
                                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                                            Showing 1 to 5 of 100</p>
                                    </div>
                                    <div class="col-md-6">
                                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                            <ul class="pagination">
                                                <li class="page-item disabled"><a class="page-link" href="#"
                                                                                  aria-label="Previous"><span
                                                                aria-hidden="true">«</span></a></li>
                                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                <li class="page-item"><a class="page-link" href="#"
                                                                         aria-label="Next"><span
                                                                aria-hidden="true">»</span></a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- Footer -->
                <?php include 'includes/footer.php'; ?>

            </div>
            <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/chart.min.js"></script>
        <script src="assets/js/bs-charts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
        <script src="assets/js/theme.js"></script>
    </body>

    </html>
<?php } ?>