<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>CpnClassiPhyR: a cpn60 universal target-based classification tool for phytoplasma</title>

<!-- Bootstrap Core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

<div id="wrapper">

<?php
	include 'nav_menu.php';
?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Welcome to CpnClassiPhyR</h1>
                    </div>



<?php
echo "<div class=\"row\">";
echo "<div class=\"col-lg-12\">";
echo "<p>Phytoplasmas (‘<i>Candidatus</i> Phytoplasma’), first known as mycoplasma-like organisms, are wall-less, insect vectored bacteria that cause disease in more than a thousand different plant hosts, affecting weedy, ornamental and crop plants worldwide. Phytoplasmas have not been successfully isolated in axenic cultures, so traditional taxonomic characteristics are difficult to measure and phytoplasma taxonomy remains under the classification criteria specified for uncultured microorganisms. In addition to the species classifications, phytoplasma taxonomy is supported by the 16S rRNA gene using restriction fragment length polymorphism (RFLP) of the 16S rRNA F2nR2 fragment with a set of seventeen endonucleases. This approach has identified more than 30 groups of phytoplasmas, designated 16SrI-16SrXXX, with each group containing subgroups designated by letters. The validation of a computer-simulated (<i>in silico</i>) RFLP as an alternative to the actual (<i>in vitro</i>) RFLP, along with the development of the interactive online phytoplasma classification tool <a href=\"https://plantpathology.ba.ars.usda.gov/cgi-bin/resource/iphyclassifier.cgi\"><i>i</i>PhyClassifier</a>, has increased the accuracy of phytoplasma classification based on 16S rRNA gene sequences.</p>";
    
echo "<p>Limitations of using solely the 16S rRNA-encoding locus for the phylogenetic characterization of phytoplasmas include their limited resolution of closely related taxa, and the fact that the two copies of this locus found in the phytoplasma genome can provide distinct RFLP typing results (16S rRNA gene heterogeneity). These considerations have led to the inclusion of other gene markers for the characterization of phytoplasma, such as the single-copy <i>cpn60</i> universal target (<i>cpn60</i> UT).</p>";
    
echo "<p>Following the strategy previously used in the phytoplasma classification scheme based on the 16S rRNA gene, we developed a complementary, coherent system to classify phytoplasmas based on RFLP analysis of <i>cpn60</i> UT sequences with seven endonucleases. This classification scheme allows a finer differentiation of phytoplasma strains within the same 16Sr RFLP subgroups, with the identification of <i>cpn60</i> UT groups and subgroups. This <i>cpn60</i> UT-based classification system is the basis of the CpnClassiPhyR, an interactive on line tool that facilitates the classification of phytoplasma strains based on in silico RFLP analysis of the <i>cpn60</i> UT sequence.</p>";
echo "<p>Welcome!</p>";
    echo "</div>";
    echo "</div>";
    
    echo "<div style=\"margin-top: 20px\">";
    echo "</div>";
    echo "<div class=\"row\">";
    echo "<div class=\"col-lg-12\">";
    echo "<a href=\"/CpnClassiPhyR.php\" class=\"btn btn-lg btn-primary btn-block\">Start CpnClassiPhyR</a>";
    echo "</div>";
    echo "</div>";
    echo "<div style=\"margin-top: 20px\">";
    echo "</div>";
    echo "<div class=\"row\">";
    echo "<div class=\"col-lg-12\">";
    echo "<a href=\"/subgroups.php\" class=\"btn btn-lg btn-primary btn-block\">View Cpn60 UT Groups and Subgroups</a>";
    echo "</div>";
    echo "</div>";
    echo "<div style=\"margin-bottom: 30px\">";
    
    
    echo "</div>";
echo "<div class=\"panel panel-default\">";
    echo "<div class=\"panel-heading\">";
    echo "<div class=\"row\">";
    echo "<div class=\"col-sm-7\">";
    echo "<img class=\"img-responsive\" src=\"images/reg-canola.png\" alt=\"reg-canola\" style=\"width:100%; object-fit: cover\">";
    echo "</div>";
echo "<div class=\"col-sm-5\">";
echo "<img class=\"img-responsive\" src=\"images/AY-canola.png\" alt=\"AY-Canola\" style=\"width:100%; object-fit: cover\">";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    
    echo "<div class=\"panel-body\">";
    echo "<div class=\"row\">";
    echo "<div class=\"col-lg-12\"><p>Canola (<i>Brassica napus</i>) plants that are unaffected (left) and affected (right) by phytoplasma. PCR amplification and sequencing of the phytoplasma taxonomic markers <i>cpn60</i> and F2nR2 (16S rRNA-encoding gene) revealed that the plant was infected by a strain of ‘<i>Candidatus</i> Phytoplasma’ asteris (16SrI). Analysis of the amplicon sequences suggested that the strain possesses two distinct copies of the 16S rRNA-encoding gene (which type as 16SrI-A and 16SrI-B) along with a single copy of <i>cpn60</i> (which types as <i>cpn60</i> UT I-IB (F=1.00). This observation was corroborated by whole genome sequencing of this strain (Whole Genome Shotgun project has been deposited at DDBJ/ENA/GenBank under the accession <a href=\"https://www.ncbi.nlm.nih.gov/nuccore/QGKT00000000.1\">QGKT00000000</a>).</p></div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";


?>

            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- jQuery -->
        <script src="/vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="/vendor/metisMenu/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="/dist/js/sb-admin-2.js"></script>

    </body>
<?php
	include 'footer.php';
?>
</html>
