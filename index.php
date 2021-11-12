<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
//include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

//sec_session_start();

// We need to use sessions, so you should always start sessions using the below code.
session_start();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title><?php echo SITENAME ?></title>
    <link rel="shortcut icon" href="/images/ico/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <!--    <link rel="stylesheet" href="/css/bootstrap.min.css" >-->
<!--    <link rel="stylesheet" href="/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="/css/main.css">
    <!--[if lt IE 9]
    <script src="/js/html5shiv.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js"></script>
    <script type="application/javascript" src="/js/main.js"></script>
</head><!--/head-->

<body data-spy="scroll" data-target="#navbar" data-offset="0">

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php";
//include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/analyticstracking.php";
?>


<section id="main-slider" class="carousel">
    <div class="carousel-inner">
        <div class="item active">
            <div class="container">
                <div class="carousel-content">
                    <h1>Arnhemse Bedrijfs Tafeltennis Federatie</h1>
                </div>
            </div>
        </div>

        <?php
        if (!$mysqli->connect_errno) {
            $query = "select NieuwsTitel,NieuwsOmschrijving from nieuws where StartDate <= current_timestamp() and (EndDate >= current_timestamp() or EndDate = '0000-00-00 00:00:00')";
            if ($result = $mysqli->query($query)) {
                while ($row = $result->fetch_assoc()) {
                    printf("<div class='item'>");
                    printf("<div class='container'>");
                    printf("<div class='carousel-content'>");
                    printf("<h1>%s</h1>", $row['NieuwsTitel']);
                    printf("<p class='lead'>%s</p>", $row['NieuwsOmschrijving']);
                    printf("</div>");
                    printf("</div>");
                    printf("</div>");
                }
                $result->close();
            }
        }
        ?>

    </div><!--.carousel-inner-->
    <a class="prev" href="#main-slider" data-slide="prev"><i class="icon-angle-left"></i></a>
    <a class="next" href="#main-slider" data-slide="next"><i class="icon-angle-right"></i></a>
</section><!--#main-slider-->


<!-- Probleem moet kleinere paginas -->
<!-- <section id="scmarquee" >
    <div id="marquee">
       <div id="text">Belangrijke informatie - in verband het de corona crisis is het competitieseizoen per direct beeindigd</div>
    </div>
<section> -->


<section id="bestuur">
    <div class="container">
        <div class="box">
            <div class="center">
                <h2>Het bestuur</h2>
                <p class="lead">Hieronder is ons voltallige bestuur te vinden. Via de pijltjes aan de zijkant kan door
                    alle leden van het bestuur gebladerd worden.</p>
            </div>
            <div class="gap"></div>
            <div id="team-scroller" class="carousel scale">
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="member">
                                    <p><img class="img-responsive img-thumbnail img-circle"
                                            src="images/bestuur/voorzitter.jpg" alt=""></p>
                                    <h3>Dhr. Bert Groot Hulze<small class="designation">Voorzitter</small></h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="member">
                                    <p><img class="img-responsive img-thumbnail img-circle"
                                            src="images/bestuur/commissaris.png" alt=""></p>
                                    <h3>Dhr. Ruud Meijer<small class="designation">Commissaris</small></h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="member">
                                    <p><img class="img-responsive img-thumbnail img-circle"
                                            src="images/bestuur/secretaris.jpg" alt=""></p>
                                    <h3>Mevr. Inge van Veen<small class="designation">Secretaris</small></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="member">

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="member">
                                    <p><img class="img-responsive img-thumbnail img-circle"
                                            src="images/bestuur/competitieleider.jpg" alt=""></p>
                                    <h3>Dhr. Jos Hardeman<small class="designation">Competitieleider</small></h3>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="member">
                                    <p><img class="img-responsive img-thumbnail img-circle"
                                            src="images/bestuur/penningmeester.jpg" alt=""></p>
                                    <h3>Dhr. Henny van Rossum<small class="designation">Penningmeester</small></h3>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="member">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="left-arrow" href="#team-scroller" data-slide="prev">
                    <i class="icon-angle-left icon-4x"></i>
                </a>
                <a class="right-arrow" href="#team-scroller" data-slide="next">
                    <i class="icon-angle-right icon-4x"></i>
                </a>
            </div><!--.carousel-->
        </div><!--.box-->
    </div><!--.container-->
</section><!--#bestuur-->


<section id="verenigingen">
    <div class="container">
        <div class="box">
            <div class="row">
                <div class="col-sm-12">
                    <div class="center">
                        <h2>Aangesloten verenigingen</h2>
                    </div>
                    <div>
                        <table class='table table-striped' id="tableverenigingen">
                            <colgroup>
                                <col class='col-md-2'>
                                <col class='col-md-4'>
                                <col class='col-md-2'>
                                <col class='col-md-2'>
                                <col class='col-md-2'>
                            </colgroup>
                            <thead>
                            <tr>
                                <th data-field="Naam">Verenigingsnaam</th>
                                <th data-field="Adres">Adres</th>
                                <th data-field="Plaats">Plaats</th>
                                <th data-field="Gebouw">Gebouw</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (isset($mysqli)) {
                                $query = "SELECT Naam,CONCAT_WS(' ',Straatnaam,Huisnummer,Achtervoegsels,Postcode) As Adres,Plaats,Gebouw,Website FROM verenigingen WHERE Verenigingsnummer != 98 ORDER BY Naam";
                                if ($result = $mysqli->query($query)) {
                                    while ($row = $result->fetch_assoc()) {
                                        printf("<tr>");
                                        printf("<td><a href='%s' target='_blank'>%s</a></td>", $row['Website'], $row['Naam']);
                                        printf("<td>%s</td>", $row['Adres']);
                                        printf("<td>%s</td>", $row['Plaats']);
                                        printf("<td>%s</td>", $row['Gebouw']);
                                        printf("<tr>");
                                    }
                                    $result->close();
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="documenten">
    <div class="container">
        <div class="box">
            <div class="row">
                <section id="ereleden">
                    <div class="col-md-6 col-lg-6">
                        <div class="center">
                            <h2>Ereleden</h2>
                            <p class="text-center">Eervolle vermelding voor onze ereleden.</p>
                            <table class='table table-striped' id="tableereleden">
                                <?php
                                if (isset($mysqli)) {
                                    $query = "select concat_ws(' ', Roepnaam, Voorletters, Tussenvoegsels,Achternaam) as Naam FROM personen where Erelid = 1";
                                    if ($result = $mysqli->query($query)) {
                                        while ($row = $result->fetch_assoc()) {
                                            printf("<tr>");
                                            printf("<td>%s</td>", $row['Naam']);
                                            printf("<tr>");
                                        }
                                        $result->close();
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </section>

                <section id="reglement">
                    <div class="col-md-6 col-lg-6">
                        <div class="center">
                            <h2>Documenten</h2>
                            <p>
                                <?php
                                $path = './uploads/documenten';
                                if (file_exists($path)) {
                                    if (is_dir($path)) {
                                        $FoundFiles = array();
                                        foreach (new DirectoryIterator($path) as $file) {
                                            if ($file->isDot()) continue;
                                            if ($file->isFile()) {
                                                $fileName = $file->getFilename();
                                                $pieces = explode('.', $fileName);
                                                //$date = explode('-', $pieces[2]);
                                                $filetypes = array("pdf", "txt");
                                                $filetype = pathinfo($file, PATHINFO_EXTENSION);
                                                if (in_array(strtolower($filetype), $filetypes)) {
                                                    // Place into an Array
                                                    $FoundFiles[] = array("fileName" => $fileName); //,"date" => $date);
                                                }
                                            }
                                        }
                                        rsort($FoundFiles);
                                        foreach ($FoundFiles as $File) {

                                            print '<i class="fa fa-file-pdf-o uppercase"><a href="' . $path . "/" . rawurlencode($File["fileName"]) . '" target="_blank"> ' . $File["fileName"] . '</a></i><br />';
                                        }
                                    }
                                } else {
                                    print 'Opgegeven directory bestaat niet. </br>Graag de webmaster op de hoogte brengen!';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</section>

<section id="contact">
    <div class="container">
        <div class="box last">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Contact Formulier</h1>
                    <p>Mocht u vragen hebben dan kunt u middels onderstaande contactformulier contact opnemen met het
                        bestuur.</p>
                    <div class="status alert alert-success" style="display: none"></div>

                    <form id="main-contact-form" class="contact-form" name="contact-form" method="post"
                          action="sendmessage.php" role="form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" required placeholder="Naam" name="name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="email" class="form-control" required placeholder="Emailadres"
                                           name="email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <textarea name="message" id="message" required class="form-control" rows="8"
                                              placeholder="Uw bericht"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger btn-lg">Bericht versturen</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!--.col-sm-6-->
                <div class="col-sm-6">
                    <h1>Contactgegevens</h1>
                    <div class="row">
                        <div class="col-md-9">
                            <address>
                                <strong>Arnhemse Bedrijfs Tafeltennis Federatie</strong><br>
                                Valkenburgstraat 79<br>
                                6845HZ Arnhem<br>
                                <i class="fa fa-envelope-o"></i><a href="mailto:info@abtf.nl"> info@abtf.nl</a>
                            </address>
                        </div>

                    </div>
                    <h1>Social Media</h1>
                    <div class="row">
                        <div class="col-md-9">
                            <ul class="social">
                                <li><a href="http://www.facebook.com" target="_blank"><i
                                            class="icon-facebook icon-social"></i> Facebook</a></li>
                                <li><a href="http://www.twitter.com" target="_blank"><i
                                            class="icon-twitter icon-social"></i> Twitter</a></li>
                                <li><a href="http://www.youtube.com" target="_blank"><i
                                            class="icon-youtube icon-social"></i> Youtube</a></li>
                            </ul>
                        </div>
                    </div>
                </div><!--.col-sm-6-->
            </div><!--.row-->
        </div><!--.box-->
    </div><!--.container-->
</section><!--#contact-->

<?php include_once "includes/footer.php"; ?>


</body>
</html>
