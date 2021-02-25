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

<style>
p {
    line-height: 20px;
}
</style>


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
<h1 class="page-header">PRIMER SETS</h1>
</div>



<?php
    echo "<div class=\"row\">";
    echo "<div class=\"col-lg-12\">";
    echo "<p style=\"font-size:24px\">Universal primers for amplification of cpn60 sequences from ‘<i>Candidatus</i> Phytoplasma’ species</p>";
    echo "<br>";
    echo "<p>These primer sets amplify the \"universal target\" - the region of the cpn60 gene corresponding to nucleotides 274-828 of the <i>E. coli</i> cpn60 sequence (not including primer landing sites). The primers are meant to be used on DNA samples taken from infected plant or insect tissue. Since the cpn60 universal target is present is essentially all bacteria (see cpnDB for additional information), there is always the risk that the amplicon will be from bacteria other than phytoplasma – similar to the situation with nested PCR targeting 16S rRNA-encoding genes. We have evaluated the rate of false positives compared to nested PCR targeting the F2nR2 sequence and found similar results with the two targets (Perez-Lopez et al. <i>Scientific Reports</i> 2017;7(1):950). It is always recommended to determine the sequence of PCR products generated using these primers to ensure that they derive from phytoplasma.</p>";
    
    echo "<p>These primers are described in Dumonceaux et al. <i>PLoS ONE</i> 2014;9(12):e116039 and are presented here for convenience.<br>";
    echo "<p>PCR products for cloning and sequencing</p>";
    echo "<p>(I=inosine, Y=C or T, R=G or A, K=G or T, M=A or C, W=A or T)</p>";

    echo "<p><b>H279p</b> 5'-GATIIIGCAGGIGATGGAACMACIAC-3'</p>";
    echo "<p><b>H280p</b> 5'-TGRTTITCICCAAAACCAGGIGCATT-3'</p>";

    echo "<br>";
    
    echo "<p>Primer cocktail</p>";
    echo "<p>The examination of some more disparate cpn60 sequences from 16SrII (Peanut Witches’ Broom phytoplasma – Chung et al. <i>PLoS ONE</i> 2013;8(4):e62770) led to the implementation of a primer cocktail consisting of a defined mixture of H279p/H280p with primers D0317/D0318 at a 1:7 molar ratio (H279p/H280p:D0317/D0318). The sequences of these primers are below:</p>";
    echo "<p><b>D0317</b> 5'-GATIIIKCIGGIGAYGGIACIACIAC-3'</p>";
    echo "<p><b>D0318</b> 5'-TGRTKITCICCAAAACYWGGIGCWTC-3'</p>";
    echo "<br>";
    echo "<p>We typically prepare this primer cocktail as a 10 µM solution of each upstream and downstream primer mixture, as follows: </p>";
    
    echo "<p>volume of stocks to prepare: 200 µl H279p OR H280p, 100 µM 2.5 µl D0317 OR D0318, 100 µM 17.5 µl 10 mM Tris-Cl pH 8.0 180 µl";
    
    echo "</p>";
    
    echo "<br>";
    
    echo "<p>PCR setup</p>";
    echo "<p>We have used a typical PCR setup containing 2.5 mM MgCl2, 500 nM each dNTP, 400 nM (0.4 µM) of each primer (or primer cocktail), and Taq polymerase (any brand) in a 50 µl reaction volume.</p>";
    echo "<p>Template volume is usually 2 µl – however PCR inhibition is a constant problem with both plant and insect DNA extracts, so dilution optimization is often necessary.</p>";
    
    echo "<br>";
    
    echo "<p>Thermocycling parameters</p>";
    echo "<p>We use BioRad C1000 with 0.2mL thin-wall strip tubes for thermocycling. We use a relatively low annealing temperature of 42°C, which takes advantage of the low G/C content of phytoplasma genomes. Most organisms with higher G/C content do not amplify well under these conditions.</p>";
    echo "<p>5 min at 94°C</p>";
    echo "<p>40 cycles of [30 sec at 94°C, 30 sec at 42°C, 30 sec at 72°C]</p>";
    echo "<p>10 min at 72°C</p>";
    
    echo "<br>";
    
    echo "<p>PCR product purification and sequencing</p>";
    echo "<p>Check the products of your reaction by loading 5-10 µL on to a 1.5% agarose gel. Because mixed infections are not uncommon, it is important to clone the PCR product using a standard PCR product cloning vector and sequence several clones in order to determine the sequence.</p>";
    
    echo "<br>";
    
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
