<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

$message = filter_input(INPUT_GET, 'message', $filter = FILTER_SANITIZE_STRING);
$type = filter_input(INPUT_GET, 'type', $filter = FILTER_SANITIZE_STRING);
?>

<!DOCTYPE html>
<html lang="en">

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/portal/inc-head.php";
?>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/portal/inc-menu.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/portal/inc-topbar.php"; ?>

            <?php if ($message) : ?>
                <div class="box" id="message" style="background-color:
            <?php
                switch ($type) {
                    case "success":
                        echo "#2ecc71";
                        break;
                    case "warning":
                        echo "#d58512";
                        break;
                    case "error":
                        echo "#c9302c";
                        break;
                    default:
                        echo "white";
                }
                ?>">
                    <h3><?php echo $message ?></h3>
                </div>
            <?php endif; ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Blank Page</h1>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/portal/inc-footer.php"; ?>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<!--    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"-->
<!--        aria-hidden="true">-->
<!--        <div class="modal-dialog" role="document">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-header">-->
<!--                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>-->
<!--                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">-->
<!--                        <span aria-hidden="true">×</span>-->
<!--                    </button>-->
<!--                </div>-->
<!--                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>-->
<!--                <div class="modal-footer">-->
<!--                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>-->
<!--                    <a class="btn btn-primary" href="login.html">Logout</a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

</body>

</html>