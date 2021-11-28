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

                <h1 class="h3 mb-4 text-gray-800">Mijn Profiel</h1>
                <div class="status alert alert-success" style="display: none"></div>

                <div class="container-md float-left">
                    <form class="form-horizontal" id="addperson_form" role="form" method="post" name="addperson_form" action="profiel-submit.php">
                        <h3>Persoonsinformatie</h3>
                        <div class="row form-group">
                            <div class="col-4">
                                <input type="text" class="form-control" name="roepnaam" id="roepnaam" placeholder="Roepnaam" required>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" name="voorletters" id="voorletters" placeholder="Voorletters" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="tussenvoegsels" id="tussenvoegsels" placeholder="Tussenvoegsels">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="achternaam" id="achternaam" placeholder="Achternaam" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label class="radio-inline">
                                    <input type="radio" name="geslacht" id="man" value="M" required=""> Man
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="geslacht" id="vrouw" value="V" required=""> Vrouw
                                </label>
                            </div>

                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4">
                                <div class="input-group date" id="geboortedatumdiv">
                                    <input type="text" id="geboortedatum" class="form-control" name="gdat">
                                </div>
                            </div>
                        </div>
                        <legend>Adres informatie</legend>
                        <div class="row form-group">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="straatnaam" id="straatnaam" placeholder="Straatnaam">
                            </div>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" name="huisnummer" id="nummer" placeholder="Nummer">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="achtervoegsels" id="achtervoegsels" placeholder="Achtervoegsels">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="postcode" id="postcode" placeholder="Postcode">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="woonplaats" id="woonplaats" placeholder="Woonplaats">
                            </div>
                        </div>
                        <legend>Contact Informatie</legend>
                        <div class="row form-group">
                            <div class="col-sm-4">
                                <input type="tel" class="form-control" name="telefoonnummer" id="telefoonnummer" placeholder="Telefoonnummer">
                            </div>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required="">
                            </div>
                        </div>

<!--                        <legend>Spelersinformatie</legend>-->
<!--                        <div class="row form-group">-->
<!--                            <div class="col-sm-2">-->
<!--                                <label>Spelersnummer </label>-->
<!--                            </div>-->
<!--                            <div class="col-sm-4">-->
<!--                                <input class="form-control" name="spelersnummer" id="spelersnummer" disabled>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="row form-group">-->
<!--                            <div class="col-sm-2">-->
<!--                                <label>Team </label>-->
<!--                            </div>-->
<!--                            <div class="col-sm-4">-->
<!--                                <input class="form-control" name="team" id="team" disabled>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="row form-group">-->
<!--                            <div class="col-sm-2">-->
<!--                                <label>Type speler </label>-->
<!--                            </div>-->
<!--                            <div class="col-sm-4">-->
<!--                                <input class="form-control" name="typespeler" id="typespeler" disabled>-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="row form-group">
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-warning" name="submitchange" id="submitchange">Aanpassen</button>
                            </div>
                            <div class="col-sm-2">
                                <button type="reset" class="btn btn-danger" onclick="location.href='/portal/profiel.php'" value="reset">Reset</button>
                            </div>
                            <div class="col-sm-12">
                                <i><b style="color: #C9302C;">Wijzigingen worden ook verzonden naar de penningmeester en secretaris van ABTF</b></i>
                            </div>

                        </div>
                    </form>
                </div>
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

        $('#geboortedatum').datepicker({
            changeMonth: true,
            changeYear: true
        });

        $.ajax({
            type: 'POST',
            url: '/portal/profiel-return.php',
            dataType: 'json',
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#roepnaam').val(value.roepnaam);
                    $('#voorletters').val(value.voorletters);
                    $('#tussenvoegsels').val(value.tussenvoegsels);
                    $('#achternaam').val(value.achternaam);
                    $('#straatnaam').val(value.straatnaam);
                    $('#nummer').val(value.huisnummer);
                    $('#achtervoegsels').val(value.achtervoegsels);
                    $('#postcode').val(value.postcode);
                    $('#woonplaats').val(value.woonplaats);
                    $('#telefoonnummer').val(value.telefoon);
                    $('#email').val(value.email);
                    // $('#spelersnummer').val(value.spelersnummer);
                    // $('#team').val(value.naam + " " + value.teamnummer);
                    // $('#typespeler').val(value.type_omschrijving);
                    if (value.geslacht === "M") {
                        $('#man').prop('checked', true);
                    } else if (value.geslacht === 'V') {
                        $('#vrouw').prop('checked', true);
                    }

                    var date = new Date(moment(value.geboortedatum, "YYYY-MM-DD"));
                    $("#geboortedatum").datepicker('setDate', date);
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            },
            complete: function () {
            }
        });
    });
</script>
</body>
</html>