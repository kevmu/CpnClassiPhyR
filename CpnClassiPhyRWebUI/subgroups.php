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
<style type="text/css">

td {
    white-space: pre-wrap;
    text-align: center;
}

th {
	white-space: nowrap;
	text-align: center;
}
th,  td,  thead th,  tbody td,  tfoot td,  tfoot th {
	width: auto !important;
}
</style>


    </head>

    <body>
        
        <div id="wrapper">
            
<?php
	include 'nav_menu.php'
?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Cpn60 UT Phytoplasma Subgroups</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">


<?php
    $subgroup_reference_file = 'CpnClassiPhyR/db/cpn60_UT_phytoplasma_subgroups.fasta';
    $num_bands_file = 'CpnClassiPhyR/subgroup_metadata/data/num_bands_subgroups.csv';
    $sc_matrix_file = 'CpnClassiPhyR/subgroup_metadata/data/similarity_coefficient_matrix_subgroups.csv';
    
    echo "<ul class=\"nav nav-tabs\">";
    echo "<li class=\"active\"><a data-toggle=\"tab\" href=\"#home\">Subgroup Overview</a></li>";
    echo "<li><a data-toggle=\"tab\" href=\"#menu1\">Number of Bands</a></li>";
    echo "<li><a data-toggle=\"tab\" href=\"#menu2\">Similarity Coefficient Matrix</a></li>";
    echo "<li><a data-toggle=\"tab\" href=\"#menu3\">Subgroups Tree</a></li>";
    echo "</ul>";
    
    echo "<div class=\"tab-content\">";
    echo "<div id=\"home\" class=\"tab-pane fade in active\">";
    echo "<h3>Subgroup Overview</h3>";
    
    echo "<a download=\"cpn60_UT_phytoplasma_subgroups.fasta.txt\" target=\"_blank\" href=\"$subgroup_reference_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download FASTA</a>";
    echo "<br>";
    echo "<br>";
    echo "<div class=\"table-responsive\">";
    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\" style=\"width: 100%;\">";
    echo "<thead>";
    echo "<tr>";
    
//    $subgroup_RFLP_digests_infile = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyRWebUI/CpnClassiPhyR/subgroup_metadata/json/subgroup_RFLP_digests.json';
    $subgroup_RFLP_digests_infile = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyR/subgroup_metadata/json/subgroup_RFLP_digests.json';
    $string1 = file_get_contents($subgroup_RFLP_digests_infile);
    $subgroup_digests_json = json_decode($string1, true);
    
//    $subgroup_sc_matrix_infile = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyRWebUI/CpnClassiPhyR/subgroup_metadata/json/subgroup_sc_matrix.json';
    $subgroup_sc_matrix_infile = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyR/subgroup_metadata/json/subgroup_sc_matrix.json';
    $string2 = file_get_contents($subgroup_sc_matrix_infile);
    $subgroup_sc_matrix_json = json_decode($string2, true);

//    $subgroup_information_infile = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyRWebUI/data/cpn60_ut_subgroup_information.json';
    $subgroup_information_infile = $_SERVER['DOCUMENT_ROOT'] . '/' . 'data/cpn60_ut_subgroup_information.json';
    $string3 = file_get_contents($subgroup_information_infile);
    $subgroup_information_json = json_decode($string3, true);
//    /Applications/MAMP/htdocs/CpnClassiPhyRWebUI/CpnClass



    echo "<th>Subgroup ID</th>";
    echo "<th>CpnDB ID</th>";
    echo "<th>Cpn60 UT Genbank Accession ID</th>";
    echo "<th>16S Genbank Accession ID</th>";
    echo "<th>Strain Name</th>";
    echo "<th>Description</th>";
    echo "<th>Sequence Length</th>";
    echo "<th>Virtual Gel</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    ksort($subgroup_digests_json);
    $subgroup_array = array();
    foreach ($subgroup_digests_json as $subgroup_id => $value) {
        // $arr[3] will be updated with each value from $arr...
//        echo "{$subgroup_id} => {$value} ";
        
        array_push($subgroup_array, $subgroup_id);
        $subgroup_metadata = $subgroup_digests_json[$subgroup_id];
        $subgroup_info = $subgroup_information_json[$subgroup_id];
        
        $subgroup_id = $subgroup_metadata['ID'];
        
        $cpndb_id = $subgroup_metadata['CpnDB ID'];
        
        $gb_accession_id = $subgroup_metadata['Genbank Accession ID'];
        
        
        $supgroup_16S_gb_accession = $subgroup_info['16S GenBank accession'];
        
        $strain_name = $subgroup_metadata['Strain Name'];
        $strain_desc = $subgroup_metadata['Description'];
        $seq_length = $subgroup_metadata['Nucleotide UT Sequence Length'];
//        
//        echo "<br>" . $subgroup_id;
//        echo "<br>" . ;
//        echo "<br>" . $gb_accession_id;
//        echo "<br>" . $strain_name;
	//        echo "<br>" . $strain_desc;
        $subgroup_filename = $subgroup_metadata['Filename'];
        $vgel_file = "CpnClassiPhyR/subgroup_metadata/gels/$subgroup_filename.png";
        
        echo "<tr>";
        echo "<td width=\"150\" align=\"center\" valign=\"top\"><a href=\"#\" data-toggle=\"modal\" data-target=\"#$subgroup_filename-modal\">$subgroup_id</a></td>";
        echo "<td width=\"150\" align=\"center\" valign=\"top\"><a href=\"http://www.cpndb.ca/getRecord.php?id=$cpndb_id\" target=\"_blank\">$cpndb_id</a></td>";
        echo "<td width=\"250\" align=\"center\" valign=\"top\"><a href=\"https://www.ncbi.nlm.nih.gov/nuccore/$gb_accession_id\" target=\"_blank\">$gb_accession_id</a></td>";
        # if(ereg("Not Available",$supgroup_16S_gb_accession)){
            echo "<td width=\"250\" align=\"center\" valign=\"top\"><a href=\"https://www.ncbi.nlm.nih.gov/nuccore/$supgroup_16S_gb_accession\" target=\"_blank\">$supgroup_16S_gb_accession</a></td>";
        #  }else{
        #       echo "<td width=\"250\" align=\"center\" valign=\"top\">Not Available</td>";
        #   }
        echo "<td width=\"150\" align=\"center\" valign=\"top\">$strain_name</td>";
        echo "<td width=\"300\" align=\"center\" valign=\"top\">$strain_desc</td>";
        echo "<td width=\"350\" align=\"center\" valign=\"top\">$seq_length bps</td>";
        echo "<td align=\"center\" valign=\"top\"><a download=\"$subgroup_filename.png\" target=\"_blank\" href=\"$vgel_file\" ><img id=\"myImg\" src=\"$vgel_file\" alt=\"$subgroup_filename.png\" width=\"300\" height=\"200\"></a></td>";

        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
    echo "<div id=\"menu1\" class=\"tab-pane fade\">";
    echo "<h3>Number of Bands</h3>";
    echo "<a href=\"$num_bands_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download CSV</a>";
    echo "<br>";
    echo "<br>";
    echo "<div class=\"table-responsive\">";
    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\" style=\"width: 100%;\">";
    echo "<thead>";
    echo "<tr>";
    
    echo "<th>Subgroup ID</th>";
    echo "<th>CpnDB ID</th>";
    echo "<th>Description</th>";
    
    $renzyme_list = ['AluI','BfaI','HinfI','HpaI','MseI','RsaI','TaqI'];
    for ($i = 0; $i < count($renzyme_list); $i++) {
        echo "<th>$renzyme_list[$i]</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($subgroup_digests_json as $subgroup_id => $value) {
        // $arr[3] will be updated with each value from $arr...
        //        echo "{$subgroup_id} => {$value} ";
        
        $subgroup_metadata = $subgroup_digests_json[$subgroup_id];
        $subgroup_id = $subgroup_metadata['ID'];
        $cpndb_id = $subgroup_metadata['CpnDB ID'];
        
        $gb_accession_id = $subgroup_metadata['Genbank Accession ID'];
        
        $strain_name = $subgroup_metadata['Strain Name'];
        $strain_desc = $subgroup_metadata['Description'];
        $seq_length = $subgroup_metadata['Nucleotide UT Sequence Length'];
        
        $subgroup_filename = $subgroup_metadata['Filename'];

        echo "<tr>";
        echo "<td width=\"150\" align=\"center\" valign=\"top\"><a href=\"#\" data-toggle=\"modal\" data-target=\"#$subgroup_filename-modal\">$subgroup_id</a></td>";
        echo "<td width=\"150\" align=\"center\" valign=\"top\"><a href=\"http://www.cpndb.ca/getRecord.php?id=$cpndb_id\" target=\"_blank\">$cpndb_id</a></td>";
        echo "<td width=\"300\" align=\"center\" valign=\"top\">$strain_desc</td>";
        for($i = 0; $i < count($renzyme_list); $i++){
            
            $band_sizes = $subgroup_metadata["('$renzyme_list[$i]', 'Band Sizes')"];
            $num_bands = $subgroup_metadata["('$renzyme_list[$i]', 'Number of Bands')"];
            
            
            $band_sizes_string = json_encode($band_sizes);
            echo "<td style='white-space: nowrap;' width=\"300\" align=\"center\" valign=\"top\">Number of Bands: $num_bands<br>Band Sizes: $band_sizes_string</td>";
//            echo "<td width=\"300\" align=\"center\" valign=\"top\"></td>";

        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
    

    echo "<div id=\"menu2\" class=\"tab-pane fade\">";
    echo "<h3>Similarity Coefficient Matrix</h3>";
    echo "<a href=\"$sc_matrix_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download CSV</a>";
    echo "<br>";
    echo "<br>";
    echo "<div class=\"table-responsive\">";
    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\" style=\"width: 100%;\">";
    echo "<thead>";
    echo "<tr>";
    
    echo "<th>Cpn60 UT Subgroups</th>";
    for ($x = 0; $x < count($subgroup_array); $x++) {
        echo "<th>$subgroup_array[$x]</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
   
    for ($i = 0; $i < count($subgroup_array); $i++) {
        echo "<tr>";
	$subgroup_id = $subgroup_array[$i];
	$subgroup_metadata = $subgroup_digests_json[$subgroup_id];

	$subgroup_filename = $subgroup_metadata['Filename'];
	
	echo "<td><a href=\"#\" data-toggle=\"modal\" data-target=\"#$subgroup_filename-modal\">$subgroup_id</a></td>";
        for ($j = 0; $j <= $i; $j++) {
            
            $subgroup_pair = "('" . $subgroup_array[$i] . "', '" . $subgroup_array[$j] . "')";
            
            $subgroup_sc_matrix_data = $subgroup_sc_matrix_json[$subgroup_pair];
            

            $f_value = $subgroup_sc_matrix_data['F Value'];
            echo "<td>$f_value</td>";
        }
        for ($j = $i + 1; $j < count($subgroup_array); $j++) {
            echo "<td>-</td>";
            
        }
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";

    
    $subgroups_fasta_file = 'CpnClassiPhyR/subgroup_metadata/phylogenetics/subgroups_tree.fasta';
    $subgroups_align_file = 'CpnClassiPhyR/subgroup_metadata/phylogenetics/subgroups_clustalw_align.meg';
    $subgroups_align_options = 'CpnClassiPhyR/config/clustalw_align.mao';
    $subgroups_align_summary = 'CpnClassiPhyR/subgroup_metadata/phylogenetics/subgroups_clustalw_align_summary.txt';
    $subgroups_xml_tree_file = 'CpnClassiPhyR/subgroup_metadata/phylogenetics/subgroups_mega_tree.xml';
    $subgroups_nwk_tree_file = 'CpnClassiPhyR/subgroup_metadata/phylogenetics/subgroups_mega_tree.nwk';
    $subgroups_tree_options = 'CpnClassiPhyR/config/NJ_nucleotide.mao';
    $subgroups_tree_summary = 'CpnClassiPhyR/subgroup_metadata/phylogenetics/subgroups_mega_tree_summary.txt';

    echo "<div id=\"menu3\" class=\"tab-pane fade\">";
    echo "<h3>Subgroups Tree</h3>";
    echo "<a download=\"subgroups_tree.fasta.txt\" href=\"" . $subgroups_fasta_file . "\"class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download Tree Fasta</a>";
    echo "<a href=\"CpnClassiPhyR/subgroup_metadata/phylogenetics/subgroups_PhyD3_tree.php\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i> View Interactive Tree</a>";
    
    echo "<br>";
    echo "<br>";
    echo "<div class=\"table-responsive\">";
    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\">";
    echo "<thead>";
    echo "<tr role=\"row\">";
    echo "<th>Program</th>";
    echo "<th>Data</th>";
    echo "<th>Options</th>";
    echo "<th>Summary</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    echo "<tr>";
    echo "<td>Multiple Sequence Alignment (CLUSTALW)</td>";
    echo "<td><a download=\"subgroups_clustalw_align.meg.txt\" href=\"" . $subgroups_align_file . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> MEG File</a></td>";
    echo "<td><a download=\"clustalw_align.mao.txt\" href=\"" . $subgroups_align_options . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Alignment Options</a></td>";
    echo "<td><a download=\"subgroups_clustalw_align_summary.txt\" href=\"" . $subgroups_align_summary . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Alignment Summary</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Neighbor-Joining Tree (MEGA)</td>";
    echo "<td><a download=\"subgroups_mega_tree.xml.txt\" href=\"" . $subgroups_xml_tree_file . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> XML File</a></td>";
    //<br><a download=\"" . $subgroups_nwk_tree_file . "\" href=\"" . $subgroups_nwk_tree_file . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> NEWICK File</a>
    echo "<td><a download=\"NJ_nucleotide.mao.txt\" href=\"" . $subgroups_tree_options . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Tree Options</a></td>";
    echo "<td><a download=\"subgroups_mega_tree_summary.txt\" href=\"" . $subgroups_tree_summary . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Tree Summary</a></td>";
    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    
    foreach ($subgroup_digests_json as $subgroup_id => $value) {
        
        $subgroup_metadata = $subgroup_digests_json[$subgroup_id];
        $subgroup_info = $subgroup_information_json[$subgroup_id];
        
        $subgroup_id = $subgroup_metadata['ID'];
        $cpndb_id = $subgroup_metadata['CpnDB ID'];
        
        $gb_accession_id = $subgroup_metadata['Genbank Accession ID'];
        
        $strain_name = $subgroup_metadata['Strain Name'];
        $strain_desc = $subgroup_metadata['Description'];
        
        $supgroup_16S = $subgroup_info['16S group/subgroup'];
        
        $supgroup_16S_gb_accession = $subgroup_info['16S GenBank accession'];
        $host_latin_name = $subgroup_info['host-Latin name'];
        $host_common_name = $subgroup_info['host-common name'];
        $country_of_origin = $subgroup_info['country of origin'];
        $reference = $subgroup_info['reference'];
        
        
        $raw_sequence = $subgroup_metadata['Nucleotide UT Sequence'];
        $seq_length = $subgroup_metadata['Nucleotide UT Sequence Length'];
        $amino_acid_sequence = $subgroup_metadata['Peptide UT Sequence'];
        $amino_acid_seq_length = $subgroup_metadata['Peptide UT Sequence Length'];

        $subgroup_filename = $subgroup_metadata['Filename'];

        
        $vgel_file = "CpnClassiPhyR/subgroup_metadata/gels/$subgroup_filename.png";
        
        echo "<div>";
        echo "<div id=\"$subgroup_filename-modal\" class=\"modal fade\" role=\"dialog\">";
        echo "<div class=\"modal-dialog modal-lg\">";
        
        echo "<div class=\"modal-content\">";
        echo "<div class=\"modal-header\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>";
        echo "<h4 class=\"modal-title\">Cpn60 UT $subgroup_id ($strain_name)</h4>";
        echo "</div>";
        echo "<div class=\"modal-body\">";
        echo "<div class=\"table-responsive\">";
        echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\" style=\"width: 100%;\">";
    
        echo "<tbody>";
    
    
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Subgroup ID</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$subgroup_id</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">CpnDB ID</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\"><a href=\"http://www.cpndb.ca/getRecord.php?id=$cpndb_id\" target=\"_blank\">$cpndb_id</a></td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Genbank Accession ID</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\"><a href=\"https://www.ncbi.nlm.nih.gov/nuccore/$gb_accession_id\" target=\"_blank\">$gb_accession_id</a></td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Description</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$strain_desc</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Strain Name</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$strain_name</td>";
        echo "</tr>";
        
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">16S Group/Subgroup</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$supgroup_16S</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">16S Genbank Accession ID</td>";
        
        # if(ereg("Not Available",$supgroup_16S_gb_accession)){
            echo "<td style=\"white-space: no-wrap; text-align: left;\"><a href=\"https://www.ncbi.nlm.nih.gov/nuccore/$supgroup_16S_gb_accession\" target=\"_blank\">$supgroup_16S_gb_accession</a></td>";
            # }else{
            #     echo "<td style=\"white-space: no-wrap; text-align: left;\">Not Available</td>";
            #  }
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Host Latin Name</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\"><i>$host_latin_name</i></td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Host Common Name</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$host_common_name</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Country of Origin</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$country_of_origin</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">References</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$reference</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Virtual Gel</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\"><img id=\"myImg\" src=\"$vgel_file\" alt=\"$subgroup_filename.png\" width=\"600\" height=\"400\"></td>";
        echo "</tr>";
        
        
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Nucledotide UT Length </td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$seq_length bp</td>";
        echo "</tr>";
        
        $pretty_raw_sequence = chunk_split($raw_sequence, 60);
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Nucledotide UT Sequence</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$pretty_raw_sequence</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Peptide UT Length</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$amino_acid_seq_length aa</td>";
        echo "</tr>";
        
    
        $pretty_amino_acid_sequence = chunk_split($amino_acid_sequence, 60);
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Peptide UT Sequence</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$pretty_amino_acid_sequence</td>";
        echo "</tr>";
        
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "<div class=\"modal-footer\">";
        echo "<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close Window</button>";
        echo "</div>";
        echo "</div>";
        
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
?>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->
            
        </div>
        <!-- /#wrapper -->
        

<!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="vendor/metisMenu/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="dist/js/sb-admin-2.js"></script>

</body>

<?php
       include 'footer.php';
?>
</html>
