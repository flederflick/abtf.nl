<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db_connect.php';
//include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

//sec_session_start();

// We need to use sessions, so you should always start sessions using the below code.
session_start();

if (isset($mysqli)) {
    $wedstrijdklasse = filter_input(INPUT_POST, 'klasse', FILTER_SANITIZE_SPECIAL_CHARS);

    $query = 'SELECT w.Wedstrijdnummer,v1.Naam as NaamT,t1.Teamnummer as TeamNummerT,v2.Naam as NaamU,t2.Teamnummer as TeamNummerU,w.Jaar,w.Weeknummer,t1.Speeldag,date_format(t1.Speeltijd,\'%k:%i\') as Tijd,date_format(w.AlternatieveDatum,\'%d-%m-%Y\') as AlternatieveDatum,wu.scoreThuis,wu.scoreUit FROM wedstrijden w inner join teams t1 on w.ThuisTeam = t1.TeamID inner join teams t2 on w.UitTeam = t2.TeamID inner join verenigingen v1 on t1.Verenigingsnummer = v1.Verenigingsnummer inner join verenigingen v2  on t2.Verenigingsnummer = v2.Verenigingsnummer left join wedstrijduitslag wu on w.Wedstrijdnummer = wu.wedstrijdnummer where t1.Klasse = ' . $wedstrijdklasse . ' order by w.Weeknummer,t1.Speeldag,w.wedstrijdnummer';

    printf("<table class='table table-striped'>");
    printf("<colgroup><col class='col-md-2'><col class='col-md-1'><col class='col-md-3'><col class='col-md-3'><col class='col-md-1'><col class='col-md-1'><col class='col-md-1'></colgroup>");
    printf("<thead><tr><th>Datum</th><th>Wedstrijd#</th><th>Thuis</th><th>Uit</th><th>Tijd</th><th>Score</th><th>Bekijk</th>");
    printf("</tr></thead>");
    printf("<tbody>");
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            printf("<tr>");
            printf("<td>");
            if (is_null($row['AlternatieveDatum'])) {
                $date = new DateTime();
                $date->setISODate($row['Jaar'], $row['Weeknummer'], $row['Speeldag']); //year , week num , day
                printf($date->format('d-m-Y') . "\n");
            } else {
                printf($row['AlternatieveDatum']);
            }


            printf("</td>");
            printf("<td>");
            printf("%s", $row['Wedstrijdnummer']);
            printf("</td>");
            printf("<td>");
            printf("%s %s", $row['NaamT'], $row['TeamNummerT']);
            printf("</td>");
            printf("<td>");
            printf("%s %s", $row['NaamU'], $row['TeamNummerU']);
            printf("</td>");
            printf("<td>");
            printf("%s", $row['Tijd']);
            printf("</td>");
            printf("<td>");
            printf("%s - %s", $row['scoreThuis'], $row['scoreUit']);
            printf("</td>");
            printf("<td>");
            printf("<button type='button' class='btn btn-info btn-md' data-toggle='modal' data-target='#SetsModal' data-set-id='%s'>Sets</button>", $row['Wedstrijdnummer']);
            printf("</td>");
            printf("</tr>");
        }
        printf("</tbody></table>");
        /* free result set */
        $result->close();
    }

}

?>
<!-- Modal -->
<div id="SetsModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="padding-top: 150px">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Overzicht gespeelde sets</h4>
            </div>
            <div class="modal-body">
                <div id="wedstrijdsets">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<script>

    $('#SetsModal').on('show.bs.modal', function (e) {
        var WedstrijdNummer = $(e.relatedTarget).data('set-id');
        $("#wedstrijdsets").load("overzicht_wedstrijden-setsreturn.php", {WedstrijdNummer: WedstrijdNummer});

    });
</script>