<?php
    //    echo "Hello World!";
    
    function read_fas_file($x) { // Check for Empty File
        if (!file_exists($x)) {
            print "File Not Exist!!";
            //            exit();
            die;
        } else {
            $fh = fopen($x, 'r');
            if (filesize($x) == 0) {
                print "File is Empty!!";
                fclose($fh);
                die;
            } else {
                $f = fread($fh, filesize($x));
                fclose($fh);
                return $f;
            }
        }
    }
    
    function fas_check($x) { // Check FASTA File Format
        $gt = substr($x, 0, 1);
        //        echo $gt;
        if ($gt != ">") {
            echo "Invalid FASTA file format! Hint: The first line must have a fasta header line starting with a greater than symbol '>' followed by a unique sequence identifier. Please edit your fasta file and resubmit!";
            die;
            //            exit();
        } else {
            return $x;
        }
    }
    //
        $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads';
//    $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyRWebUI/uploads';
    
    //    $uploads_dir = '/var/www/CpnClassiPhyRWebUI/uploads';
    
    if (!file_exists($uploads_dir)) {
        //        echo "The file $uploads_dir exists";
        mkdir($uploads_dir);
    }
    
    $remote_ip_address = $_SERVER['REMOTE_ADDR'];
    $long = ip2long($remote_ip_address);
   // $long = "test";
    $time = time();
    
    $output_dir = $_SERVER['DOCUMENT_ROOT'] . '/output_dir';
//    $output_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyRWebUI/output_dir';
    //    $output_dir = '/var/www/CpnClassiPhyRWebUI/output_dir';
    
    if (!file_exists($output_dir)) {
        //        echo "The file $output_dir exists";
        mkdir($output_dir);
    }
    
    $current_output_dir = $output_dir . '/' . 'output_dir' . '_' . $long . '_' . $time;
    if (!file_exists($current_output_dir)) {
        //        echo "The file $output_dir exists";
        mkdir($current_output_dir);
    }
    
    $textarea = $_POST['file'];
    
    //echo $textarea;
    //    die;
    //    $info = pathinfo($_FILES['file']['name']);
    //    $ext = $info['extension']; // get the extension of the file
    //
    //    $filename = $_FILES['file']['name'];
    //    $target_filepath = $uploads_dir . '/' . $filename;
    $target_filepath = $uploads_dir . '/' . $long . '-' . $time . '.fa.txt';
    
    //	echo '<br>' . $target_path;
    
    //    move_uploaded_file($_FILES['file']['tmp_name'], $target_filepath);
    //    echo '<br>' . $target_filepath . '<br>';
    
    //    $textarea = read_fas_file($target_filepath);
    //    echo $textarea;
    if(fas_check($textarea)){
        $fh = fopen($target_filepath, 'w');
        fwrite($fh, $textarea);
        fclose($fh);
        
        //        echo "The file $filename has been uploaded sucessfully!" . "<br>";
        
    }else{
        unlink($target_filepath);
        echo "Invalid FASTA Format";
        die;
    }
    
    //    echo "Running CpnClassiPhyR on input file....." . "<br>";
    
    $cpnClassiPhyRCommand = escapeshellcmd('/usr/bin/python3.5' . ' ' . $_SERVER['DOCUMENT_ROOT'] . '/' . "CpnClassiPhyR/phyto_RFLP_digest.py -i $target_filepath -o $current_output_dir");
//    $cpnClassiPhyRCommand = escapeshellcmd('/usr/local/bin/python3.6' . ' ' . $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyRWebUI' . '/' . 'CpnClassiPhyR' . '/' . "phyto_RFLP_digest.py -i $target_filepath -o $current_output_dir");
    //    $cpnClassiPhyRCommand = escapeshellcmd('/usr/bin/python' . ' ' . "/var/www/CpnClassiPhyRWebUI/CpnClassiPhyR/phyto_RFLP_digest.py -i $target_filepath -o $current_output_dir");
    //    echo "<br>" . $cpnClassiPhyRCommand;
    $output = shell_exec($cpnClassiPhyRCommand);
    //    Strain,Subgroup Match,Similarity Coefficient Calculation,F-Value
    //    echo $output;
    
    
    $subgroup_matches_infile = $current_output_dir . '/' . 'metadata' . '/' . 'data' . '/' . 'subgroup_matches.csv';
    
    $numbands_infile = $current_output_dir . '/' . 'metadata' . '/' . 'data' . '/' . 'num_bands.csv';
    $sc_matrix_infile = $current_output_dir . '/' . 'metadata' . '/' . 'data' . '/' . 'similarity_coefficient_matrix.csv';
    
    $input_RFLP_digests_infile = $current_output_dir . '/' . 'metadata' . '/' . 'json' . '/' . 'RFLP_digests.json';
    
    $string1 = file_get_contents($input_RFLP_digests_infile);
    $input_digests_json = json_decode($string1, true);
    
    $sc_matrix_json = $current_output_dir . '/' . 'metadata' . '/' . 'json' . '/' . 'sc_matrix.json';
    
    $string2 = file_get_contents($sc_matrix_json);
    $sc_matrix_json = json_decode($string2, true);
    //    /Applications/MAMP/htdocs/CpnClassiPhyRWebUI/CpnClass
    
    //$subgroup_information_infile = $_SERVER['DOCUMENT_ROOT'] . '/CpnClassiPhyRWebUI/data/cpn60_ut_subgroup_information.json';
    $subgroup_information_infile = $_SERVER['DOCUMENT_ROOT'] . '/data/cpn60_ut_subgroup_information.json';
    
    $string3 = file_get_contents($subgroup_information_infile);
    $subgroup_information_json = json_decode($string3, true);
    
    ksort($input_digests_json);
    $strain_array = array();
    foreach ($input_digests_json as $strain_id => $value) {
        // $arr[3] will be updated with each value from $arr...
        //        echo "{$subgroup_id} => {$value} ";
        
        array_push($strain_array, $strain_id);
    }
    
 //   $subgroup_RFLP_digests_infile = $_SERVER['DOCUMENT_ROOT'] . '/CpnClassiPhyRWebUI/CpnClassiPhyR/subgroup_metadata/json/subgroup_RFLP_digests.json';
    $subgroup_RFLP_digests_infile = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyR/subgroup_metadata/json/subgroup_RFLP_digests.json';
    $string4 = file_get_contents($subgroup_RFLP_digests_infile);
    $subgroup_digests_json = json_decode($string4, true);
    
    ksort($subgroup_digests_json);
    $subgroup_array = array();
    foreach ($subgroup_digests_json as $subgroup_id => $value) {
        // $arr[3] will be updated with each value from $arr...
        //        echo "{$subgroup_id} => {$value} ";
        
        array_push($subgroup_array, $subgroup_id);
        
    }
    
    $all_trimmed_sense_file= 'output_dir/output_dir' . '_' . $long . '_' . $time . '/CpnIdentiPhyR' . '/' . 'all-trimmed-sense.fasta';
    $clean_up_metadata_file = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/CpnIdentiPhyR' . '/' . 'clean_up_metadata.csv';
    $subgroup_matches_file = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/metadata/data' . '/' . 'subgroup_matches.csv';
    $num_bands_file = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/metadata/data' . '/' . 'num_bands.csv';
    $sc_matrix_file = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/metadata/data' . '/' . 'similarity_coefficient_matrix.csv';
    
    
    $subgroups_tree = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyR/subgroup_metadata/phylogenetics/subgroups_tree.fasta';
    $tree_output_dir = $current_output_dir . '/' . 'phylogenetics';
    
    $all_trimmed_sense_fasta = $_SERVER['DOCUMENT_ROOT'] . '/' . 'output_dir/output_dir' . '_' . $long . '_' . $time . '/CpnIdentiPhyR' . '/' . 'all-trimmed-sense.fasta';
    
    $megaTreeCommand = escapeshellcmd('/usr/bin/python3.5' . ' ' . $_SERVER['DOCUMENT_ROOT'] . '/' . "CpnClassiPhyR/generate_cpnclassiphr_tree.py -i $all_trimmed_sense_fasta -s $subgroups_tree  -o $tree_output_dir");
    
    //echo $megaTreeCommand;
    $output = shell_exec($megaTreeCommand);
    
    $tree_php_dir = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/phylogenetics';
    
    $phyloxml_tree = 'all-trimmed-sense_mega_tree.xml';
    $PhyD3_tree_php_outfile = $tree_output_dir . '/CpnClassiPhyR_PhyD3_tree.php';
    
    
    $PhyD3_tree_php_file = $tree_php_dir . '/CpnClassiPhyR_PhyD3_tree.php';
    $PhyD3_tree_php_template = $_SERVER['DOCUMENT_ROOT'] . '/' . 'templates/PhyD3_tree_template.php';

    $CpnClassiPhyR_fasta_file = $tree_php_dir . '/CpnIdentiPhyR_tree_sequences.fasta';
    $CpnClassiPhyR_align_file = $tree_php_dir . '/all-trimmed-sense_clustalw_align.meg';
    $CpnClassiPhyR_align_options = $tree_php_dir . '/clustalw_align.mao';
    $CpnClassiPhyR_align_summary = $tree_php_dir . '/all-trimmed-sense_clustalw_align_summary.txt';
    $CpnClassiPhyR_xml_tree_file = $tree_php_dir . '/all-trimmed-sense_mega_tree.xml';
    $CpnClassiPhyR_nwk_tree_file = $tree_php_dir . '/all-trimmed-sense_mega_tree.nwk';
    $CpnClassiPhyR_tree_options = $tree_php_dir . '/NJ_nucleotide.mao';
    $CpnClassiPhyR_tree_summary = $tree_php_dir . '/all-trimmed-sense_mega_tree_summary.txt';
    
    $fh1 = fopen($PhyD3_tree_php_template, "r") or die("Unable to open file!");
    $fh2 = fopen($PhyD3_tree_php_outfile, "w") or die("Unable to open file!");
    while(!feof($fh1)) {
        
        $line = fgets($fh1);
        if(preg_match('/tree_file/', $line)){
            
            fwrite($fh2, preg_replace('/tree_file/', $phyloxml_tree, $line));
        }
        else{
            fwrite($fh2, $line);
        }
    }
    fclose($fh2);
    fclose($fh2);
    
    echo "<ul class=\"nav nav-tabs\">";
    echo "<li class=\"active\"><a data-toggle=\"tab\" href=\"#home\">CpnClassiPhyR Overview</a></li>";
    echo "<li><a data-toggle=\"tab\" href=\"#menu1\">Best Subgroup Matches</a></li>";
    echo "<li><a data-toggle=\"tab\" href=\"#menu2\">Number of Bands</a></li>";
    echo "<li><a data-toggle=\"tab\" href=\"#menu3\">Similarity Coefficient Matrix</a></li>";
    echo "<li><a data-toggle=\"tab\" href=\"#menu4\">CpnClassiPhyR Tree</a></li>";
    echo "</ul>";
    
    echo "<div class=\"tab-content\">";

    echo "<div id=\"menu1\" class=\"tab-pane fade\">";
    echo "<h3>Best Subgroup Matches</h3>";
    echo "<a href=\"$subgroup_matches_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download CSV</a>";
    echo "<br>";
    echo "<br>";
    echo "<div class=\"table-responsive\">";
    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\">";
    echo "<thead>";
    echo "<tr role=\"row\">";
    echo "<th>Strain Name</th>";
    echo "<th>Best Subgroup Match</th>";
    echo "<th>Similarity Coefficient Calculation</th>";
    //        echo "<th>Similarity Coefficient Calculation</th>";
    echo "<th>F-Value</th>";
    echo "<th>Classification</th>";
    echo "<th>Virtual Gel Strain x</th>";
    echo "<th>Virtual Gel Strain y</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    $subgroup_matches = array();
    
    $row = 0;
    if (($handle = fopen($subgroup_matches_infile, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($row != 0){
                
                
                $strain_name = $data[0];
                $best_match = $data[1];
                $sc_calc = $data[2];
                $F_value = $data[3];
                $classification = $data[4];
                
                $subgroup_matches[$strain_name] = $data;

                
                $subgroup_metadata = $subgroup_digests_json[$best_match];
                $subgroup_filename = $subgroup_metadata['Filename'];

                if($F_value < 0.59){
                    $classification = $classification . " " . "Please consider registering ( <a href=\"submit_sequences.php\" target=\"_blank\">link</a> ) this as a new group.";
                }
                if($F_value >= 0.59 and $F_value <= 0.97){
                    $classification = $classification . " " . "Please consider registering ( <a href=\"submit_sequences.php\" target=\"_blank\">link</a> ) this as a new subgroup";
                }
                //                $vgel_strain_x_file = $input_digests_json[$strain_name]['virtual_gel_filepath'];
                $vgel_strain_x_file = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/metadata/gels' . '/' . "$strain_name.png";
                $vgel_strain_y_file = 'CpnClassiPhyR/subgroup_metadata/gels' . '/' . "$subgroup_filename.png";
                echo "<tr role=\"row\">";
                
                
                $strain_modal = str_replace(".","-",$strain_name);
                $strain_modal = str_replace("_","-",$strain_modal);
                echo "<td width=\"150\" align=\"center\" valign=\"top\"><a href=\"#\" data-toggle=\"modal\" data-target=\"#$strain_modal-modal\">$strain_name</a></td>";
                
                echo "<td width=\"150\" align=\"center\" valign=\"top\"><a href=\"#\" data-toggle=\"modal\" data-target=\"#$subgroup_filename-modal\">$best_match</a></td>";
                echo "<td>F = ( 2 * Nxy ) / ( Nx + Ny )<br>$sc_calc</td>";
                   echo "<td>$F_value</td>";
                   echo "<td>$classification</td>";

                echo "<td><a download=\"$strain_name.png\" target=\"_blank\" href=\"$vgel_strain_x_file\" ><img id=\"myImg1\" src=\"$vgel_strain_x_file\" alt=\"$strain_name.png\" width=\"300\" height=\"200\"></a></td>";
                echo "<td><a download=\"$best_match.png\" target=\"_blank\" href=\"$vgel_strain_y_file\" ><img id=\"myImg2\" src=\"$vgel_strain_y_file\" alt=\"$subgroup_filename.png\" width=\"300\" height=\"200\"></a></td>";
                
                
                echo "</tr>";
            }
            $row++;
        }
        fclose($handle);
    }
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
    echo "<div id=\"home\" class=\"tab-pane fade in active\">";
    echo "<h3>CpnClassiPhyR Overview</h3>";
    echo "<a download=\"all_trimmed_sense.fasta.txt\" target=\"_blank\" href=\"$all_trimmed_sense_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download FASTA</a>";
    echo "<a href=\"$clean_up_metadata_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download CSV</a>";
    
    echo "<br>";
    echo "<br>";
    echo "<div class=\"table-responsive\">";
    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\">";
    echo "<thead>";
    echo "<tr role=\"row\">";
    echo "<th>Sequence ID</th>";
    echo "<th>BLAST Annotation</th>";
    echo "<th>Phytoplasma Sequence (Y/N)</th>";
    echo "<th>Classification</th>";
    echo "<th>Query Coverage</th>";
    echo "<th>Percent Identity</th>";
    echo "<th>Alignment Length</th>";
    echo "<th>E-Value</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    //    $clean_up_metadata_infile = $_SERVER['DOCUMENT_ROOT'] . '/CpnClassiPhyRWebUI/' . $clean_up_metadata_file;
    
    $overview_metadata = array();
    $subgroup_matches_metadata = array();
    $clean_up_metadata_infile = $_SERVER['DOCUMENT_ROOT'] . '/' . $clean_up_metadata_file;
    $row1 = 0;
    if (($handle1 = fopen($clean_up_metadata_infile, "r")) !== FALSE) {
        while (($data1 = fgetcsv($handle1, 1000, ",")) !== FALSE) {
            if ($row1 != 0){
                
                
                $seqid = $data1[0];
                $desc = $data1[1];
                $qseqid = $data1[2];
                $salltitles = $data1[3];
                $qcovhsp = $data1[4];
                $pident = $data1[5];
                if(is_float($pident)){
                    $pident = sprintf('%0.2f', $pident);
                }
                $length = $data1[6];
                $mismatch = $data1[7];
                $gapopen = $data1[8];
                $qstart = $data1[9];
                $qend = $data1[10];
                $sstart = $data1[11];
                $send = $data1[12];
                $sstrand = $data1[13];
                $evalue = $data1[14];
                $bitscore = $data1[15];
                $cpnclassification = $data1[16];
                // $blast_url = $data1[17];
                
                $overview_metadata[$seqid] = $data1;
                
                $strain_modal = str_replace(".","-",$seqid);
                $strain_modal = str_replace("_","-",$strain_modal);
                echo "<tr role=\"row\">";
                echo "<td width=\"150\" align=\"center\" valign=\"top\"><a href=\"#\" data-toggle=\"modal\" data-target=\"#$strain_modal-modal\">$seqid</a></td>";
                
                echo "<td>$salltitles</td>";
                echo "<td>$cpnclassification</td>";
                if(array_key_exists($qseqid,$subgroup_matches)){
                    $subgroup_matches_metadata = $subgroup_matches[$qseqid];
                    $best_match = $subgroup_matches_metadata[1];
                    $sc_calc = $subgroup_matches_metadata[2];
                    $F_value = $subgroup_matches_metadata[3];
                    $classification = $subgroup_matches_metadata[4];
                    echo "<td>Best Subgroup Match: $best_match; F-Value: $F_value; $classification</td>";
                }
                else{
                    
                    echo "<td>N/A</td>";
                }
                echo "<td>$qcovhsp</td>";
                echo "<td>$pident</td>";
                echo "<td>$length</td>";
                echo "<td>$evalue</td>";
                
                
                echo "</tr>";
            }
            $row1++;
        }
        fclose($handle1);
    }
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
    
    echo "<div id=\"menu2\" class=\"tab-pane fade\">";
    echo "<h3>Number of Bands</h3>";
    echo "<a href=\"$num_bands_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download CSV</a>";
    echo "<br>";
    echo "<br>";
    echo "<div class=\"table-responsive\">";
    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\">";
    echo "<thead>";
    echo "<tr role=\"row\">";
    echo "<th>Strain Name</th>";
    $renzyme_list = ['AluI','BfaI','HinfI','HpaI','MseI','RsaI','TaqI'];
    for ($i = 0; $i < count($renzyme_list); $i++) {
        echo "<th>$renzyme_list[$i]</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    foreach ($input_digests_json as $input_id => $value) {
        // $arr[3] will be updated with each value from $arr...
        //        echo "{$subgroup_id} => {$value} ";
        
        $metadata = $input_digests_json[$input_id];
        $strain_id = $metadata['ID'];
        $strain_desc = $metadata['Description'];
        
        echo "<tr>";
        
        $strain_modal = str_replace(".","-",$strain_id);
        $strain_modal = str_replace("_","-",$strain_modal);
        
        
        $subgroup_matches_metadata = $subgroup_matches[$strain_id];
        $best_match = $subgroup_matches_metadata[1];
        $subgroup_metadata = $subgroup_digests_json[$best_match];
        $subgroup_filename = $subgroup_metadata['Filename'];
        
        $best_subgroup_modal = str_replace(".","-",$best_match);
        $best_subgroup_modal = str_replace("_","-",$best_subgroup_modal);
        
        echo "<td width=\"150\" align=\"center\" valign=\"top\"><a href=\"#\" data-toggle=\"modal\" data-target=\"#$strain_modal-modal\">$strain_id</a><br><br><a href=\"#\" data-toggle=\"modal\" data-target=\"#$subgroup_filename-modal\">Best Match: $best_match</a></td>";
        for($i = 0; $i < count($renzyme_list); $i++){
            
            $renzyme_entry = $renzyme_list[$i];
            $band_sizes = $metadata["('$renzyme_entry', 'Band Sizes')"];
            $num_bands = $metadata["('$renzyme_entry', 'Number of Bands')"];
            
            
            $subgroup_band_sizes = $subgroup_metadata["('$renzyme_entry', 'Band Sizes')"];
            $subgroup_num_bands = $subgroup_metadata["('$renzyme_entry', 'Number of Bands')"];
            
            $band_sizes_string = json_encode($band_sizes);
            $subgroup_band_sizes_string = json_encode($subgroup_band_sizes);
            echo "<td style='white-space: nowrap;' width=\"300\" align=\"center\" valign=\"top\">Number of Bands: $num_bands<br>Band Sizes: $band_sizes_string<br><br>Number of Bands: $subgroup_num_bands<br>Band Sizes: $subgroup_band_sizes_string</td>";
            //            echo "<td width=\"300\" align=\"center\" valign=\"top\"></td>";
            
        }
        echo "</tr>";
        
    }
    
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
    echo "<div id=\"menu3\" class=\"tab-pane fade\">";
    echo "<h3>Similarity Coefficient Matrix</h3>";
    echo "<a href=\"$sc_matrix_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download CSV</a>";
    echo "<br>";
    echo "<br>";
    echo "<div class=\"table-responsive\">";
    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\" style=\"width: 100%;\">";
    echo "<thead>";
    echo "<tr>";
    
    
    echo "<th>Cpn60 UT</th>";
    for ($x = 0; $x < count($strain_array); $x++) {
        echo "<th>$strain_array[$x]</th>";
    }
    for ($x = 0; $x < count($subgroup_array); $x++) {
        echo "<th>$subgroup_array[$x]</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    
    $counter = 0;
    for ($i = 0; $i < count($strain_array); $i++) {
        echo "<tr>";
        $strain_x = $strain_array[$i];
        
        $strain_modal = str_replace(".","-",$strain_x);
        $strain_modal = str_replace("_","-",$strain_modal);
        echo "<td width=\"150\" align=\"center\" valign=\"top\"><a href=\"#\" data-toggle=\"modal\" data-target=\"#$strain_modal-modal\">$strain_x</a></td>";
        
        for ($j = 0; $j < count($strain_array); $j++) {
            if($j <= $counter){
                $strain_pair = "('" . $strain_array[$i] . "', '" . $strain_array[$j] . "')";
                
                $sc_matrix_data = $sc_matrix_json[$strain_pair];
                
                echo "<td>$sc_matrix_data</td>";
            }else{
                echo "<td>-</td>";
            }
        }
        for ($j = 0; $j < count($subgroup_array); $j++) {
            if(($j + (count($strain_array) - 1)) < $counter){

                $strain_pair = "('" . $strain_array[$i] . "', '" . $subgroup_array[$j] . "')";
                
                $sc_matrix_data = $sc_matrix_json[$strain_pair];
                
                echo "<td>$sc_matrix_data</td>";
            }else{
                echo "<td>-</td>";
            }
        }
        
        echo "</tr>";
        $counter++;
    }
    
    for ($i = 0; $i < count($subgroup_array); $i++) {
        $subgroup_metadata = $subgroup_digests_json[$subgroup_array[$i]];
        $subgroup_filename = $subgroup_metadata['Filename'];
        
        echo "<tr>";
        echo "<td width=\"150\" align=\"center\" valign=\"top\"><a href=\"#\" data-toggle=\"modal\" data-target=\"#$subgroup_filename-modal\">$subgroup_array[$i]</a></td>";
        
        for ($j = 0; $j < count($strain_array); $j++) {
            if($j <= $counter){
            
                $strain_pair = "('" . $subgroup_array[$i] . "', '" . $strain_array[$j] . "')";
                
                $sc_matrix_data = $sc_matrix_json[$strain_pair];
                
                echo "<td>$sc_matrix_data</td>";
            }else{
                echo "<td>-</td>";
            }
        }
        for ($j = 0; $j < count($subgroup_array); $j++) {
            if(($j + (count($strain_array) - 1)) < $counter){
            
                $strain_pair = "('" . $subgroup_array[$i] . "', '" . $subgroup_array[$j] . "')";
                
                $sc_matrix_data = $sc_matrix_json[$strain_pair];
                
                echo "<td>$sc_matrix_data</td>";
            }else{
                echo "<td>-</td>";
            }
        }
        
        echo "</tr>";
        $counter++;
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
        echo "<div id=\"menu4\" class=\"tab-pane fade\">";
    echo "<h3>CpnClassiPhyR Tree Overview</h3>";
    echo "<a download=\"CpnIdentiPhyR_tree_sequences.fasta.txt\" href=\"" . $CpnClassiPhyR_fasta_file . "\"class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download Tree Fasta</a>";
    echo "<a href=\"" . $PhyD3_tree_php_file . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i> View Interactive Tree</a>";

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
    echo "<td><a download=\"all-trimmed-sense_clustalw_align.meg.txt\" href=\"" . $CpnClassiPhyR_align_file . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> MEG File</a></td>";
    echo "<td><a download=\"clustalw_align.mao.txt\" href=\"" . $CpnClassiPhyR_align_options . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Alignment Options</a></td>";
    echo "<td><a download=\"all-trimmed-sense_clustalw_align_summary.txt\" href=\"" . $CpnClassiPhyR_align_summary . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Alignment Summary</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Neighbor-Joining Tree (MEGA)</td>";
    echo "<td><a download=\"all-trimmed-sense_mega_tree.xml.txt\" href=\"" . $CpnClassiPhyR_xml_tree_file . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> XML File</a></td>";
    //<br><a download=\"" . $CpnClassiPhyR_nwk_tree_file . "\" href=\"" . $CpnClassiPhyR_nwk_tree_file . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> NEWICK File</a>
    echo "<td><a download=\"NJ_nucleotide.mao.txt\" href=\"" . $CpnClassiPhyR_tree_options . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Tree Options</a></td>";
    echo "<td><a download=\"all-trimmed-sense_mega_tree_summary.txt\" href=\"" . $CpnClassiPhyR_tree_summary . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\" target=\"_blank\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Tree Summary</a></td>";
    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<a href=\"CpnClassiPhyR.php\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\">Refresh</a>";
    
    
    //    echo "<button type=\"submit\" id=\"refresh\" class=\"btn btn-default\"><a href=\"CpnClassiPhyR.php\"><i class=\"fa redo-alt fa-fw\"></i>Refresh</a></button";
    //        echo $output;
    foreach ($overview_metadata as $input_id => $value){
        $data1 = $overview_metadata[$input_id];
        $seqid = $data1[0];
        $desc = $data1[1];
        $qseqid = $data1[2];
        $salltitles = $data1[3];
        $qcovhsp = $data1[4];
        $pident = $data1[5];
        if(is_float($pident)){
            $pident = sprintf('%0.2f', $pident);
        }
        $length = $data1[6];
        $mismatch = $data1[7];
        $gapopen = $data1[8];
        $qstart = $data1[9];
        $qend = $data1[10];
        $sstart = $data1[11];
        $send = $data1[12];
        $sstrand = $data1[13];
        $evalue = $data1[14];
        $bitscore = $data1[15];
        $cpnclassification = $data1[16];

        if(preg_match("/Not a Phytoplasma sequence/", $cpnclassification)){
            
            // $blast_url = $data1[17];
            $strain_modal = str_replace(".","-",$input_id);
            $strain_modal = str_replace("_","-",$strain_modal);
            
            echo "<div>";
            echo "<div id=\"$strain_modal-modal\" class=\"modal fade\" role=\"dialog\">";
            echo "<div class=\"modal-dialog modal-lg\">";
            
            echo "<div class=\"modal-content\">";
            echo "<div class=\"modal-header\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>";
            echo "<h4 class=\"modal-title\">CpnClassiPhyR Overview ($seqid)</h4>";
            echo "</div>";
            echo "<div class=\"modal-body\">";
            echo "<div class=\"table-responsive\">";
            echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\" style=\"width: 100%;\">";
            
            echo "<tbody>";
            
            
            echo "<tr>";
            echo "<td style=\"white-space: no-wrap; text-align: left;\">Sequence ID</td>";
            echo "<td style=\"white-space: no-wrap; text-align: left;\">$seqid</td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td style=\"white-space: no-wrap; text-align: left;\">Description</td>";
            echo "<td style=\"white-space: no-wrap; text-align: left;\">$desc</td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td style=\"white-space: no-wrap; text-align: left;\">BLAST Annotation</td>";
            echo "<td style=\"white-space: no-wrap; text-align: left;\">$salltitles</td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td style=\"white-space: no-wrap; text-align: left;\">Phytoplasma Sequence (Y/N)</td>";
            echo "<td style=\"white-space: no-wrap; text-align: left;\">$cpnclassification</td>";
            echo "</tr>";
            
            echo "<tr>";
            echo "<td style=\"white-space: no-wrap; text-align: left;\">Classification</td>";
            echo "<td style=\"white-space: no-wrap; text-align: left;\">N/A</td>";
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
    }

    
    
    foreach ($input_digests_json as $input_id => $value) {
        // $arr[3] will be updated with each value from $arr...
        //        echo "{$subgroup_id} => {$value} ";
        
        $metadata = $input_digests_json[$input_id];
        $strain_id = $metadata['ID'];
        $split_desc = explode(" ", $metadata['Description'], 2)[1];
        
        $data = $subgroup_matches[$strain_id];
        $strain_name = $data[0];
        $best_match = $data[1];
        $sc_calc = $data[2];
        $F_value = $data[3];
        $classification = $data[4];
        
        $data1 = $overview_metadata[$input_id];
        $salltitles = $data1[3];
        $qcovhsp = $data1[4];
        $pident = $data1[5];
        if(is_float($pident)){
            $pident = sprintf('%0.2f', $pident);
        }
        $length = $data1[6];
        $mismatch = $data1[7];
        $gapopen = $data1[8];
        $qstart = $data1[9];
        $qend = $data1[10];
        $sstart = $data1[11];
        $send = $data1[12];
        $sstrand = $data1[13];
        $evalue = $data1[14];
        $bitscore = $data1[15];
        $cpnclassification = $data1[16];
        
        
        if($F_value < 0.59){
            $classification = $classification . " " . "Please consider registering ( <a href=\"submit_sequences.php\" target=\"_blank\">link</a> )this as a new group.";
        }
        if($F_value >= 0.59 and $F_value <= 0.97){
            $classification = $classification . " " . "Please consider registering ( <a href=\"submit_sequences.php\" target=\"_blank\">link</a> ) this as a new subgroup";
        }
        
        $subgroup_metadata = $subgroup_digests_json[$best_match];
        $subgroup_filename = $subgroup_metadata['Filename'];
        
        $vgel_strain_x_file = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/metadata/gels' . '/' . "$strain_name.png";
        $vgel_strain_y_file = 'CpnClassiPhyR/subgroup_metadata/gels' . '/' . "$subgroup_filename.png";
        
        $raw_sequence = $metadata['Nucleotide UT Sequence'];
        $seq_length = $metadata['Nucleotide UT Sequence Length'];
        $amino_acid_sequence = $metadata['Peptide UT Sequence'];
        $amino_acid_seq_length = $metadata['Peptide UT Sequence Length'];
        
        
        $strain_modal = str_replace(".","-",$strain_id);
        $strain_modal = str_replace("_","-",$strain_modal);
        
        echo "<div>";
        echo "<div id=\"$strain_modal-modal\" class=\"modal fade\" role=\"dialog\">";
        echo "<div class=\"modal-dialog modal-lg\">";
        
        echo "<div class=\"modal-content\">";
        echo "<div class=\"modal-header\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>";
        echo "<h4 class=\"modal-title\">CpnClassiPhyR Overview ($strain_id)</h4>";
        echo "</div>";
        echo "<div class=\"modal-body\">";
        echo "<div class=\"table-responsive\">";
        echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\" style=\"width: 100%;\">";
        
        echo "<tbody>";
        
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Sequence ID</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$strain_id</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Description</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$strain_desc</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">BLAST Annotation</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$salltitles</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Phytoplasma Sequence (Y/N)</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$cpnclassification</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Classification</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Best Subgroup Match: $best_match; F-Value: $F_value; $classification</td>";
        echo "</tr>";
        
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Query Coverage</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$qcovhsp</td>";
        echo "</tr>";
        
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Percent Identity</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$pident</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Alignment Length</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$length</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Number of Mismatches</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$mismatch</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Number of Gaps</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$gapopen</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Query Start</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$qstart</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Query End</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$qend</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Target Start</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$sstart</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Target End</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$send</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Target Strand</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$sstrand</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">E-Value</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$evalue</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Bit Score</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$bitscore</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Best Subgroup Match</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$best_match</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Similarity Coefficient Calculation</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">F = ( 2 * Nxy ) / ( Nx + Ny )<br>$sc_calc</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">F-Value</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">$F_value</td>";
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

        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Virtual Gel Strain x</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\"><img id=\"myImg\" src=\"$vgel_strain_x_file\" alt=\"$strain_name.png\" width=\"600\" height=\"400\"></td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\">Virtual Gel Strain y</td>";
        echo "<td style=\"white-space: no-wrap; text-align: left;\"><img id=\"myImg\" src=\"$vgel_strain_y_file\" alt=\"$subgroup_filename.png\" width=\"600\" height=\"400\"></td>";
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
