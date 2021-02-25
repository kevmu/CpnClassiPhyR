<?php
        echo "Hello World!";
    
//    function read_fas_file($x) { // Check for Empty File
//        if (!file_exists($x)) {
//            print "File Not Exist!!";
//            //            exit();
//            die;
//        } else {
//            $fh = fopen($x, 'r');
//            if (filesize($x) == 0) {
//                print "File is Empty!!";
//                fclose($fh);
//                die;
//            } else {
//                $f = fread($fh, filesize($x));
//                fclose($fh);
//                return $f;
//            }
//        }
//    }
//    
//    function fas_check($x) { // Check FASTA File Format
//        $gt = substr($x, 0, 1);
//        //        echo $gt;
//        if ($gt != ">") {
//            echo "Invalid FASTA file format! Hint: The first line must have a fasta header line starting with a greater than symbol '>' followed by a unique sequence identifier. Please edit your fasta file and resubmit!";
//            die;
//            //            exit();
//        } else {
//            return $x;
//        }
//    }
//    //
////        $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads';
//    $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyRWebUI/uploads';
//    
//    //    $uploads_dir = '/var/www/CpnClassiPhyRWebUI/uploads';
//    
//    if (!file_exists($uploads_dir)) {
//        //        echo "The file $uploads_dir exists";
//        mkdir($uploads_dir);
//    }
//    
//    $remote_ip_address = $_SERVER['REMOTE_ADDR'];
//    //$long = ip2long($remote_ip_address);
//    $long = "test";
//    $time = time();
//    
////    $output_dir = $_SERVER['DOCUMENT_ROOT'] . '/output_dir';
//    $output_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyRWebUI/output_dir';
//    //    $output_dir = '/var/www/CpnClassiPhyRWebUI/output_dir';
//    
//    if (!file_exists($output_dir)) {
//        //        echo "The file $output_dir exists";
//        mkdir($output_dir);
//    }
//    
//    $current_output_dir = $output_dir . '/' . 'output_dir' . '_' . $long . '_' . $time;
//    if (!file_exists($output_dir)) {
//        //        echo "The file $output_dir exists";
//        mkdir($current_output_dir);
//    }
//    
//    $textarea = $_POST['file'];
//    
//    //echo $textarea;
//    //    die;
//    //    $info = pathinfo($_FILES['file']['name']);
//    //    $ext = $info['extension']; // get the extension of the file
//    //
//    //    $filename = $_FILES['file']['name'];
//    //    $target_filepath = $uploads_dir . '/' . $filename;
//    $target_filepath = $uploads_dir . '/' . $long . '-' . $time . '.fa.txt';
//    
//    //	echo '<br>' . $target_path;
//    
//    //    move_uploaded_file($_FILES['file']['tmp_name'], $target_filepath);
//    //    echo '<br>' . $target_filepath . '<br>';
//    
//    //    $textarea = read_fas_file($target_filepath);
//    //    echo $textarea;
//    if(fas_check($textarea)){
//        $fh = fopen($target_filepath, 'w');
//        fwrite($fh, $textarea);
//        fclose($fh);
//        
//        //        echo "The file $filename has been uploaded sucessfully!" . "<br>";
//        
//    }else{
//        unlink($target_filepath);
//        echo "Invalid FASTA Format";
//        die;
//    }
//    
//    //    echo "Running CpnClassiPhyR on input file....." . "<br>";
//    
////    $cpnClassiPhyRCommand = escapeshellcmd('/usr/bin/python3.5' . ' ' . $_SERVER['DOCUMENT_ROOT'] . '/' . "CpnClassiPhyR/phyto_RFLP_digest.py -i $target_filepath -o $current_output_dir");
//    $cpnClassiPhyRCommand = escapeshellcmd('/usr/local/bin/python3.6' . ' ' . $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyRWebUI' . '/' . 'CpnClassiPhyR' . '/' . "phyto_RFLP_digest.py -i $target_filepath -o $current_output_dir");
//    //    $cpnClassiPhyRCommand = escapeshellcmd('/usr/bin/python' . ' ' . "/var/www/CpnClassiPhyRWebUI/CpnClassiPhyR/phyto_RFLP_digest.py -i $target_filepath -o $current_output_dir");
//    //    echo "<br>" . $cpnClassiPhyRCommand;
//    $output = shell_exec($cpnClassiPhyRCommand);
//    //    Strain,Subgroup Match,Similarity Coefficient Calculation,F Value
//    //    echo $output;
//    
//    
//    $subgroup_matches_infile = $current_output_dir . '/' . 'metadata' . '/' . 'data' . '/' . 'subgroup_matches.csv';
//    
//    $numbands_infile = $current_output_dir . '/' . 'metadata' . '/' . 'data' . '/' . 'num_bands.csv';
//    $sc_matrix_infile = $current_output_dir . '/' . 'metadata' . '/' . 'data' . '/' . 'similarity_coefficient_matrix.csv';
//    
//    $input_RFLP_digests_infile = $current_output_dir . '/' . 'metadata' . '/' . 'json' . '/' . 'RFLP_digests.json';
//    
//    $string1 = file_get_contents($input_RFLP_digests_infile);
//    $input_digests_json = json_decode($string1, true);
//    
//    $sc_matrix_json = $current_output_dir . '/' . 'metadata' . '/' . 'json' . '/' . 'sc_matrix.json';
//    
//    $string2 = file_get_contents($sc_matrix_json);
//    $sc_matrix_json = json_decode($string2, true);
//    //    /Applications/MAMP/htdocs/CpnClassiPhyRWebUI/CpnClass
//    
//    
//    
//    ksort($input_digests_json);
//    $strain_array = array();
//    foreach ($input_digests_json as $strain_id => $value) {
//        // $arr[3] will be updated with each value from $arr...
//        //        echo "{$subgroup_id} => {$value} ";
//        
//        array_push($strain_array, $strain_id);
//    }
//    
//    $subgroup_RFLP_digests_infile = $_SERVER['DOCUMENT_ROOT'] . '/CpnClassiPhyRWebUI/CpnClassiPhyR/subgroup_metadata/json/subgroup_RFLP_digests.json';
////    $subgroup_RFLP_digests_infile = $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyR/subgroup_metadata/json/subgroup_RFLP_digests.json';
//    $string3 = file_get_contents($subgroup_RFLP_digests_infile);
//    $subgroup_digests_json = json_decode($string3, true);
//    
//    ksort($subgroup_digests_json);
//    $subgroup_array = array();
//    foreach ($subgroup_digests_json as $subgroup_id => $value) {
//        // $arr[3] will be updated with each value from $arr...
//        //        echo "{$subgroup_id} => {$value} ";
//        
//        array_push($subgroup_array, $subgroup_id);
//        
//    }
//    
//    $all_trimmed_sense_file= 'output_dir/output_dir' . '_' . $long . '_' . $time . '/CpnIdentiPhyR' . '/' . 'all-trimmed-sense.fasta';
//    $clean_up_metadata_file = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/CpnIdentiPhyR' . '/' . 'clean_up_metadata.csv';
//    $subgroup_matches_file = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/metadata/data' . '/' . 'subgroup_matches.csv';
//    $num_bands_file = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/metadata/data' . '/' . 'num_bands.csv';
//    $sc_matrix_file = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/metadata/data' . '/' . 'similarity_coefficient_matrix.csv';
//    
//    
//    
//    echo "<ul class=\"nav nav-tabs\">";
//    echo "<li class=\"active\"><a data-toggle=\"tab\" href=\"#home\">CpnClassiPhyR Overview</a></li>";
//    echo "<li><a data-toggle=\"tab\" href=\"#menu1\">Best Subgroup Matches</a></li>";
//    echo "<li><a data-toggle=\"tab\" href=\"#menu2\">Number of Bands</a></li>";
//    echo "<li><a data-toggle=\"tab\" href=\"#menu3\">Similarity Coefficient Matrix</a></li>";
//    echo "</ul>";
//    
//    echo "<div class=\"tab-content\">";
//    echo "<div id=\"home\" class=\"tab-pane fade in active\">";
//    echo "<h3>CpnClassiPhyR Overview</h3>";
//    echo "<a download=\"all_trimmed_sense.fasta.txt\" target=\"_blank\" href=\"$all_trimmed_sense_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download FASTA</a>";
//    echo "<a href=\"$clean_up_metadata_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download CSV</a>";
//    
//    echo "<br>";
//    echo "<br>";
//    echo "<div class=\"table-responsive\">";
//    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\">";
//    echo "<thead>";
//    echo "<tr role=\"row\">";
//    echo "<th>Sequence ID</th>";
//    echo "<th>Description</th>";
//    echo "<th>Best Match</th>";
//    echo "<th>Classification</th>";
//    echo "<th>Coverage</th>";
//    echo "<th>Percent Identity</th>";
//    echo "<th>Length</th>";
//    echo "<th>Mismatch</th>";
//    echo "<th>Gap Open</th>";
//    echo "<th>Query Start</th>";
//    echo "<th>Query End</th>";
//    echo "<th>Target Start</th>";
//    echo "<th>Target End</th>";
//    echo "<th>Strandedness</th>";
//    echo "<th>E-Value</th>";
//    echo "<th>Bit Score</th>";
//    echo "</tr>";
//    echo "</thead>";
//    echo "<tbody>";
//    
//    $clean_up_metadata_infile = $_SERVER['DOCUMENT_ROOT'] . '/CpnClassiPhyRWebUI/' . $clean_up_metadata_file;
//    $row1 = 0;
//    if (($handle1 = fopen($clean_up_metadata_infile, "r")) !== FALSE) {
//        while (($data1 = fgetcsv($handle1, 1000, ",")) !== FALSE) {
//            if ($row1 != 0){
//                
//                
//                $seqid = $data1[0];
//                $desc = $data1[1];
//                $qseqid = $data1[2];
//                $salltitles = $data1[3];
//                $qcovhsp = $data1[4];
//                $pident = $data1[5];
//                $length = $data1[6];
//                $mismatch = $data1[7];
//                $gapopen = $data1[8];
//                $qstart = $data1[9];
//                $qend = $data1[10];
//                $sstart = $data1[11];
//                $send = $data1[12];
//                $sstrand = $data1[13];
//                $evalue = $data1[14];
//                $bitscore = $data1[15];
//                $classification = $data1[16];
//                $blast_url = $data1[17];
//                
//                echo "<tr role=\"row\">";
//                echo "<td style=\"white-space: nowrap\">$seqid</td>";
//                
//                
//                echo "<td>$desc</td>";
//                echo "<td>$salltitles</td>";
//                echo "<td>$classification</td>";
//                echo "<td>$qcovhsp</td>";
//                echo "<td>$pident</td>";
//                echo "<td>$length</td>";
//                echo "<td>$mismatch</td>";
//                echo "<td>$gapopen</td>";
//                echo "<td>$qstart</td>";
//                echo "<td>$qend</td>";
//                echo "<td>$sstart</td>";
//                echo "<td>$send</td>";
//                echo "<td>$sstrand</td>";
//                echo "<td>$evalue</td>";
//                echo "<td>$bitscore</td>";
//                
//                
//                echo "</tr>";
//            }
//            $row1++;
//        }
//        fclose($handle1);
//    }
//    
//    echo "</tbody>";
//    echo "</table>";
//    echo "</div>";
//    echo "</div>";
//    
//    echo "<div id=\"menu1\" class=\"tab-pane fade\">";
//    echo "<h3>Best Subgroup Matches</h3>";
//    echo "<a href=\"$subgroup_matches_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download CSV</a>";
//    echo "<br>";
//    echo "<br>";
//    echo "<div class=\"table-responsive\">";
//    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\">";
//    echo "<thead>";
//    echo "<tr role=\"row\">";
//    echo "<th>Strain Name</th>";
//    echo "<th>Best Subgroup Match</th>";
//    echo "<th>Similarity Coefficient Calculation</th>";
//    //        echo "<th>Similarity Coefficient Calculation</th>";
//    echo "<th>F Value</th>";
//    echo "<th>Classification</th>";
//    echo "<th>Virtual Gel Strain x</th>";
//    echo "<th>Virtual Gel Strain y</th>";
//    echo "</tr>";
//    echo "</thead>";
//    echo "<tbody>";
//    
//    $row = 0;
//    if (($handle = fopen($subgroup_matches_infile, "r")) !== FALSE) {
//        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//            if ($row != 0){
//                
//                
//                $strain_name = $data[0];
//                $best_match = $data[1];
//                $sc_calc = $data[2];
//                $F_value = $data[3];
//                $classification = $data[4];
//                
//                
//                $subgroup_metadata = $subgroup_digests_json[$best_match];
//                $subgroup_filename = $subgroup_metadata['Filename'];
//
//                if($F_value < 0.59){
//                    $classification = $classification . " " . "Please consider registering (link) this as a new group.";
//                }
//                if($F_value >= 0.59 and $F_value <= 0.97){
//                    $classification = $classification . " " . "Please consider registering this as a new subgroup";
//                }
//                //                $vgel_strain_x_file = $input_digests_json[$strain_name]['virtual_gel_filepath'];
//                $vgel_strain_x_file = 'output_dir/output_dir' . '_' . $long . '_' . $time . '/metadata/gels' . '/' . "$strain_name.png";
//                $vgel_strain_y_file = 'CpnClassiPhyR/subgroup_metadata/gels' . '/' . "$subgroup_filename.png";
//                echo "<tr role=\"row\">";
//                echo "<td style=\"white-space: nowrap\">$strain_name</td>";
//                
//                
//                echo "<td>$best_match</td>";
//                echo "<td>F = ( 2 * Nxy ) / ( Nx + Ny )<br>$sc_calc</td>";
//                   echo "<td>$F_value</td>";
//                   echo "<td>$classification</td>";
//
//                echo "<td><a download=\"$strain_name.png\" target=\"_blank\" href=\"$vgel_strain_x_file\" ><img id=\"myImg1\" src=\"$vgel_strain_x_file\" alt=\"$strain_name.png\" width=\"300\" height=\"200\"></a></td>";
//                echo "<td><a download=\"$best_match.png\" target=\"_blank\" href=\"$vgel_strain_y_file\" ><img id=\"myImg2\" src=\"$vgel_strain_y_file\" alt=\"$subgroup_filename.png\" width=\"300\" height=\"200\"></a></td>";
//                
//                
//                echo "</tr>";
//            }
//            $row++;
//        }
//        fclose($handle);
//    }
//    
//    echo "</tbody>";
//    echo "</table>";
//    echo "</div>";
//    echo "</div>";
//    echo "<div id=\"menu2\" class=\"tab-pane fade\">";
//    echo "<h3>Number of Bands</h3>";
//    echo "<a href=\"$num_bands_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download CSV</a>";
//    echo "<br>";
//    echo "<br>";
//    echo "<div class=\"table-responsive\">";
//    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\">";
//    echo "<thead>";
//    echo "<tr role=\"row\">";
//    echo "<th>Strain Name</th>";
//    echo "<th>Description</th>";
//    $renzyme_list = ['AluI','BfaI','HinfI','HpaI','MseI','RsaI','TaqI'];
//    for ($i = 0; $i < count($renzyme_list); $i++) {
//        echo "<th>$renzyme_list[$i]</th>";
//    }
//    echo "</tr>";
//    echo "</thead>";
//    echo "<tbody>";
//    
//    foreach ($input_digests_json as $input_id => $value) {
//        // $arr[3] will be updated with each value from $arr...
//        //        echo "{$subgroup_id} => {$value} ";
//        
//        $metadata = $input_digests_json[$input_id];
//        $strain_id = $metadata['ID'];
//        $strain_name = $metadata['Strain Name'];
//        $strain_desc = $metadata['Description'];
//        
//        echo "<tr>";
//        echo "<td width=\"150\" align=\"center\" valign=\"top\">$strain_id</td>";
//        echo "<td width=\"300\" align=\"center\" valign=\"top\">$strain_desc</td>";
//        for($i = 0; $i < count($renzyme_list); $i++){
//            
//            $renzyme_entry = $renzyme_list[$i];
//            $band_sizes = $metadata["('$renzyme_entry', 'Band Sizes')"];
//            $num_bands = $metadata["('$renzyme_entry', 'Number of Bands')"];
//            
//            
//            $band_sizes_string = json_encode($band_sizes);
//            echo "<td style='white-space: nowrap;' width=\"300\" align=\"center\" valign=\"top\">Number of Bands: $num_bands<br>Band Sizes: $band_sizes_string</td>";
//            //            echo "<td width=\"300\" align=\"center\" valign=\"top\"></td>";
//            
//        }
//        echo "</tr>";
//    }
//    
//    
//    echo "</tbody>";
//    echo "</table>";
//    echo "</div>";
//    echo "</div>";
//    echo "<div id=\"menu3\" class=\"tab-pane fade\">";
//    echo "<h3>Similarity Coefficient Matrix</h3>";
//    echo "<a href=\"$sc_matrix_file\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\"><i class=\"fa fa-download\" aria-hidden=\"true\"></i> Download CSV</a>";
//    echo "<br>";
//    echo "<br>";
//    echo "<div class=\"table-responsive\">";
//    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\" role=\"grid\" aria-describedby=\"dataTables-example_info\" style=\"width: 100%;\">";
//    echo "<thead>";
//    echo "<tr>";
//    
//    
//    echo "<th>Cpn60 UT</th>";
//    for ($x = 0; $x < count($strain_array); $x++) {
//        echo "<th>$strain_array[$x]</th>";
//    }
//    for ($x = 0; $x < count($subgroup_array); $x++) {
//        echo "<th>$subgroup_array[$x]</th>";
//    }
//    echo "</tr>";
//    echo "</thead>";
//    echo "<tbody>";
//    
//    
//    for ($i = 0; $i < count($strain_array); $i++) {
//        echo "<tr>";
//        echo "<td>$strain_array[$i]</td>";
//        
//        for ($j = 0; $j < count($strain_array); $j++) {
//            
//            $strain_pair = "('" . $strain_array[$i] . "', '" . $strain_array[$j] . "')";
//            
//            $sc_matrix_data = $sc_matrix_json[$strain_pair];
//            
//            echo "<td>$sc_matrix_data</td>";
//        }
//        for ($j = 0; $j < count($subgroup_array); $j++) {
//            
//            $strain_pair = "('" . $strain_array[$i] . "', '" . $subgroup_array[$j] . "')";
//            
//            $sc_matrix_data = $sc_matrix_json[$strain_pair];
//            
//            echo "<td>$sc_matrix_data</td>";
//        }
//        
//        echo "</tr>";
//        
//    }
//    for ($i = 0; $i < count($subgroup_array); $i++) {
//        echo "<tr>";
//        echo "<td>$subgroup_array[$i]</td>";
//        
//        for ($j = 0; $j < count($strain_array); $j++) {
//            
//            $strain_pair = "('" . $subgroup_array[$i] . "', '" . $strain_array[$j] . "')";
//            
//            $sc_matrix_data = $sc_matrix_json[$strain_pair];
//            
//            echo "<td>$sc_matrix_data</td>";
//        }
//        for ($j = 0; $j < count($subgroup_array); $j++) {
//            
//            $strain_pair = "('" . $subgroup_array[$i] . "', '" . $subgroup_array[$j] . "')";
//            
//            $sc_matrix_data = $sc_matrix_json[$strain_pair];
//            
//            echo "<td>$sc_matrix_data</td>";
//        }
//        
//        echo "</tr>";
//    }
//    echo "</tbody>";
//    echo "</table>";
//    echo "</div>";
//    echo "</div>";
//    
//    echo "</div>";
//    echo "<a href=\"CpnClassiPhyR.php\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\">Refresh</a>";
//    //    echo "<button type=\"submit\" id=\"refresh\" class=\"btn btn-default\"><a href=\"CpnClassiPhyR.php\"><i class=\"fa redo-alt fa-fw\"></i>Refresh</a></button";
//    //        echo $output;
//    
    ?>
