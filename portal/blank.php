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

    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . "/portal/inc-menu.php";
    ?>

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


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . "/portal/inc-footer.php";
        ?>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<!-- Bootstrap core JavaScript-->
<script type="text/javascript" src="/portal/vendor/jquery/jquery.min.js"></script>
<script src="/portal/vendor/jqueryui/jquery-ui.js"></script>
<script src="/js/jquery.ui.datepicker-nl.js"></script>
<script src="/js/moment.js"></script>
<script type="text/javascript" src="/portal/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script type="text/javascript" src="/portal/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script type="text/javascript" src="js/sb-admin-2.min.js"></script>


<script type="text/javascript">
    $(document).ready(function () {

        // Fadeout Message div is present
        $("#message").delay(1000).fadeOut();


    });
</script>
</body>
</html>