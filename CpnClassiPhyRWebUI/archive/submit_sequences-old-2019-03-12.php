<?php
	require('db.php');
	include("auth.php");
    include("parse_fasta.php");
    
    $message = "";
    $result = "";
    
    $email = $_SESSION['email'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $academictitle = $_SESSION['academictitle'];
    
    $name = $firstname . ' ' . $lastname;
    
    if($academictitle != 'None'){
        $name = $academictitle . ' ' . $name;
    }

    $species = "";
    $strain = "";
    $proposed_group_subgroup = "";
    $genbank_cpn60ut_accession = "";
    $group_16s_subgroup = "";
    $host = "";
    $country = "";
    $reference = "";
    

?>


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
                        <h1 class="page-header">Cpn60 UT Group/Subgroup Submission</h1>
<ol class="breadcrumb">
  <li><a href="dashboard.php">Dashboard</a></li>
  <li class="active">Cpn60 UT Group/Subgroup Submission</li>
</ol>
		    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">

<div id="submission-panel" class="panel panel-default">
<div class="panel-body">
<?php
    if (isset($_REQUEST['genbank_cpn60ut_accession'])){
        
        $species = stripslashes($_REQUEST['species']);
        $species = pg_escape_string($con,$species);
        
        
        $strain = stripslashes($_REQUEST['strain']);
        $strain = pg_escape_string($con,$strain);
        
        $proposed_group_subgroup = stripslashes($_REQUEST['proposed_group_subgroup']);
        $proposed_group_subgroup = pg_escape_string($con,$proposed_group_subgroup);
        
        $genbank_cpn60ut_accession = stripslashes($_REQUEST['genbank_cpn60ut_accession']);
        //escapes special characters in a string
        $genbank_cpn60ut_accession = pg_escape_string($con,$genbank_cpn60ut_accession);
        
        $group_16s_subgroup = stripslashes($_REQUEST['group_16s_subgroup']);
        //escapes special characters in a string
        $group_16s_subgroup = pg_escape_string($con,$group_16s_subgroup);
        
        $genbank_16s_accession = stripslashes($_REQUEST['genbank_16s_accession']);
        $genbank_16s_accession = pg_escape_string($con,$genbank_16s_accession);
        
        $host = stripslashes($_REQUEST['host']);
        $host = pg_escape_string($con,$host);
        
        $country = stripslashes($_REQUEST['country']);
        $country = pg_escape_string($con,$country);
        
        $reference = stripslashes($_REQUEST['reference']);
        $reference = pg_escape_string($con,$reference);
        
        $_SESSION['genbank_cpn60ut_accession'] = $genbank_cpn60ut_accession;
        
        $trn_date = date("Y-m-d H:i:s");
        
//        $_SESSION['email'] = $email;
        $remote_ip_address = $_SERVER['REMOTE_ADDR'];
        $long = ip2long($remote_ip_address);
        // $long = "test";
        $time = time();
        
        $output_dir = $_SERVER['DOCUMENT_ROOT'] . '/submissions_dir';
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

            
    //    $filepath = $current_output_dir . '/' . $genbank_cpn60ut_accession . ".summary.txt";
    //    $myfile = fopen($filepath, "w") or die("Unable to open file: $filepath!");
        
        $genbank_cpn60ut_fasta = $current_output_dir . '/' . $genbank_cpn60ut_accession . ".fasta";
            
        $curlCommand = '/usr/bin/curl --url "https://www.ncbi.nlm.nih.gov/sviewer/viewer.fcgi?tool=portal&sendto=on&log$=seqview&db=nuccore&dopt=fasta&val=' . $genbank_cpn60ut_accession . '&extrafeat=0&maxplex=1" -o ' . $genbank_cpn60ut_fasta;
        //echo $curlCommand;
        $output = shell_exec($curlCommand);
        $f = read_fas_file($genbank_cpn60ut_fasta);
        
        if(preg_match("/Failed to understand id: $genbank_cpn60ut_accession/", $f)){
            echo "$genbank_cpn60ut_accession does not exist! Please check the Cpn60 UT Genbank Accession ID and submit again.";
        }else{
        
            $cpnClassiPhyRCommand = escapeshellcmd('/usr/bin/python3.5' . ' ' . $_SERVER['DOCUMENT_ROOT'] . '/' . "CpnClassiPhyR/phyto_RFLP_digest.py -i $genbank_cpn60ut_fasta -o $current_output_dir");
            //    $cpnClassiPhyRCommand = escapeshellcmd('/usr/local/bin/python3.6' . ' ' . $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyRWebUI' . '/' . 'CpnClassiPhyR' . '/' . "phyto_RFLP_digest.py -i $target_filepath -o $current_output_dir");
            //    $cpnClassiPhyRCommand = escapeshellcmd('/usr/bin/python' . ' ' . "/var/www/CpnClassiPhyRWebUI/CpnClassiPhyR/phyto_RFLP_digest.py -i $target_filepath -o $current_output_dir");
            //    echo "<br>" . $cpnClassiPhyRCommand;
            $output = shell_exec($cpnClassiPhyRCommand);
            //    Strain,Subgroup Match,Similarity Coefficient Calculation,F-Value
            //    echo $output;
            
            
            $subgroup_metadata_src_dir =  $_SERVER['DOCUMENT_ROOT'] . '/CpnClassiPhyR/subgroup_metadata';
            $subgroup_metadata_dest_dir =  $_SERVER['DOCUMENT_ROOT'] . '/CpnClassiPhyR/subgroup_metadata-' . $time;
            
            $output = shell_exec("cp -rf $subgroup_metadata_src_dir $subgroup_metadata_dest_dir && rm -rf $subgroup_metadata_src_dir");
            
            $subgroups_fasta_infile = $_SERVER['DOCUMENT_ROOT'] . '/CpnClassiPhyR/db/cpn60_UT_phytoplasma_subgroups.fasta';
            
            $subgroups_fasta_outfile = $_SERVER['DOCUMENT_ROOT'] . '/CpnClassiPhyR/db/cpn60_UT_phytoplasma_subgroups' . '_' . $long . '_' . $time . '.fasta';
            
            $subgroups_fasta_temp = $_SERVER['DOCUMENT_ROOT'] . '/CpnClassiPhyR/db/cpn60_UT_phytoplasma_subgroups-temp' . '_' . $long . '_' . $time . '.fasta';

            $trimmed_sense_fasta_temp = $current_output_dir . '/' . $genbank_cpn60ut_accession . '-temp' . '_' . $long . '_' . $time . '.fasta';
            
            $trimmed_sense_fasta = $current_output_dir . "/CpnIdentiPhyR/all-trimmed-sense.fasta";

            $subgroup_matches_csv = $current_output_dir . "/metadata/data/subgroup_matches.csv";
        
            $row = 0;
            $best_match = "";
            $F_value = "";
            if (($handle = fopen($subgroup_matches_csv, "r")) !== FALSE) {
                
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    
                    $best_match = $data[1];
                    $F_value = $data[3];
                    
                    
                    $row++;
                    
                }
                fclose($handle);
            }
        
        
            if(($F_value < 0.59) or ($F_value >= 0.59 and $F_value <= 0.97)){
                $content = read_fas_file($trimmed_sense_fasta);
                $fasta = fas_check($content);
                $seq = fas_get($fasta);
                $fh = fopen($trimmed_sense_fasta_temp, 'w');
                foreach($seq as $header => $fasta_seq) {
            
                    $header = preg_replace("/length=\d+ \(\+ strand\)/", "", $header);
		    $header = preg_replace("/\(\w+\) /", "", $header);
		    $fasta_seq = wordwrap($fasta_seq, 60, "\n", 1);
                    fwrite($fh, '>' . $proposed_group_subgroup . ' ' . 'bxxxxx' . ' ' . $genbank_cpn60ut_accession . ' ' . $header . ' ' . $best_match . '; ' . 'F=' . $F_value . ' ' . '(' . $strain . ')' . "\n" . $fasta_seq . "\n");
                }
                fclose($fh);
                
                $cpRefFastaCommand = "cp $subgroups_fasta_infile $subgroups_fasta_outfile && cat $trimmed_sense_fasta_temp $subgroups_fasta_infile > $subgroups_fasta_temp && cp $subgroups_fasta_temp $subgroups_fasta_infile && rm $subgroups_fasta_temp";
                $output = shell_exec($cpRefFastaCommand);
                
                $subgroupMetadataCommand = escapeshellcmd('/usr/bin/python3.5' . ' ' . $_SERVER['DOCUMENT_ROOT'] . '/CpnClassiPhyR/generate_subgroup_metadata.py');
                //    $$subgroupMetadataCommand = escapeshellcmd('/usr/local/bin/python3.6' . ' ' . $_SERVER['DOCUMENT_ROOT'] . '/' . 'CpnClassiPhyRWebUI' . '/' . 'CpnClassiPhyR' . '/' . "phyto_RFLP_digest.py -i $target_filepath -o $current_output_dir");
                //    $$subgroupMetadataCommand = escapeshellcmd('/usr/bin/python' . ' ' . "/var/www/CpnClassiPhyRWebUI/CpnClassiPhyR/phyto_RFLP_digest.py -i $target_filepath -o $current_output_dir");
                //    echo "<br>" . $cpnClassiPhyRCommand;
                $output = shell_exec($subgroupMetadataCommand);
                //    echo $output;
                
            //echo $con . " " . "TESTING\n";
            // If form submitted, insert values into the database.
            // removes backslashes
            
            
            
                
                //Checking is genbank_cpn60ut_accession existing in the database or not
//                $submission_query = "SELECT * FROM submissions WHERE genbank_cpn60ut_accession='$genbank_cpn60ut_accession'";
//                $submission_result = pg_query($con,$submission_query) or die(pg_last_error());
//                $rows = pg_num_rows($submission_result);
                $subgroup_info_infile = $_SERVER['DOCUMENT_ROOT'] . '/data/cpn60_ut_subgroup_information.json';
                $subgroup_info_outfile = $_SERVER['DOCUMENT_ROOT'] . '/data/cpn60_ut_subgroup_information' . '_' . $long . '_' . $time . '.json';
                $subgroup_info_json = file_get_contents($subgroup_info_infile);
                $subgroup_info_data = json_decode($subgroup_info_json, true);
                
                $subgroup_cpn60ut_accessions = [];
                
                foreach($subgroup_info_data as $key => $value) {
                    
                    $subgroup_cpn60ut_accessions[$value["GenBank accession"]] = $key;
                    echo $key;
                }
                
                if(isset($subgroup_cpn60ut_accessions[$genbank_cpn60ut_accession])){
                    $message = "A sequence entry for Cpn60 UT Genbank Accession: $genbank_cpn60ut_accession already exists. New Cpn60 UT group/subgroup not added successfully!";
                    $genbank_cpn60ut_accession = "";
                }else{
                    
                    $query = "INSERT into submissions (email, species, strain, proposed_group_subgroup, genbank_cpn60ut_accession, group_16s_subgroup, genbank_16s_accession, host, country, reference, trn_date)
                    VALUES ('$email', '$species', '$strain', '$proposed_group_subgroup', '$genbank_cpn60ut_accession', '$group_16s_subgroup', '$genbank_16s_accession', '$host', '$country', '$reference', '$trn_date')";
                    $result = pg_query($con,$query);

                    $new_subgroup["clone name"] = $strain;
                    $new_subgroup["cpn60 UT group/subgroup"] = $proposed_group_subgroup;
                    $new_subgroup["GenBank accession"] = $genbank_cpn60ut_accession;
                    $new_subgroup["16S group/subgroup"] = $group_16s_subgroup;
		    $new_subgroup["16S GenBank accession"] = $genbank_16s_accession;
		    $new_subgroup["Phytoplasma species"] = $species;
		    $new_subgroup["host-Latin name"] = $host;
		    $new_subgroup["host-common name"] = $host;
		    $new_subgroup["country of origin"] = $country;
                    $new_subgroup["reference"] = $reference;

                    $new_subgroup_json = json_encode($new_subgroup);
                    $subgroup_info_data[$proposed_group_subgroup] = $new_subgroup;
                    $new_subgroup_info_json = json_encode($subgroup_info_data, JSON_PRETTY_PRINT);
                    
                    //echo $new_subgroup_info_json;
                    //echo $new_subgroup_json;
                    
                    $submission_metadata_file = $_SERVER['DOCUMENT_ROOT'] . '/submissions_dir/output_dir' . '_' . $long . '_' . $time . "/$genbank_cpn60ut_accession.json";
                    $fp = fopen($submission_metadata_file, 'w');
                    fwrite($fp, $new_subgroup_json);
                    fclose($fp);

                    $cpSubgroupJSONCommand = "cp $subgroup_info_infile $subgroup_info_outfile";
                    $output = shell_exec($cpSubgroupJSONCommand);
                    
                    $tar_filename = 'output_dir' . '_' . $long . '_' . $time;
                    
                    $tar_filepath = $_SERVER['DOCUMENT_ROOT'] . "/submissions_dir/$tar_filename.tar.gz";
                    
                    $tarCommand = "/bin/tar -cvzf $tar_filepath -C $current_output_dir .";
                    $output = shell_exec($tarCommand);
                    
                    //echo $tarCommand;

		    $fp = fopen($subgroup_info_infile, 'w');
		    fwrite($fp, $new_subgroup_info_json);
		    fclose($fp);
                    
                    //        fwrite($myfile, $output);
                    $email_body = "$name,\n\nYour Cpn60 UT group/subgroup sequence registration request has been received!\n\nSpecies: $species\n\nStrain: $strain\n\nProposed cpn60 UT group/subgroup: $proposed_group_subgroup\n\nCpn60 UT GenBank Accession: $genbank_cpn60ut_accession\n\n16S group/subgroup: $group_16s_subgroup\n\n16S Genbank Accession: $genbank_16s_accession\n\nHost (plant or insect): $host\n\nCountry of Isolation: $country\n\nJournal Reference (If available): $reference\n\nIf you require assistance please contact us using the following email address help.cpnclassiphyr@gmail.com.\n\nPlease do not reply to this email.\n\nCheers,\n\nThe CpnClassiPhyR curator";
                    
                    $attachments = "";
                    $automailerCommand = "";
                    if(file_exists($tar_filepath)){
                        $attachments = "-A $tar_filepath";
                        
                        $automailerCommand = 'echo "' . $email_body . '" | mail -s "Registration Service Submission"' . ' ' . $attachments . ' ' . $email;
                    }else{
                        $automailerCommand = 'echo "' . $email_body . '" | mail -s "Registration Service Submission"' . ' ' . $email;
                    }
                    
                    
                    
                    
                    //echo $automailerCommand;
                    $output = shell_exec($automailerCommand);
                    //        fwrite($myfile, $output);
                    //        fclose($myfile);
                    
                    echo "<div class='form-group'>
                    <h3>You have registered a new Cpn60 UT group/subgroup sequence successfully!</h3>
                    <br>
                    <p>$name,</p>
                    <br>
                    <p>Confirmation of your submission has been sent to the following email address;</p>
                    <br>
                    <p>$email</p>
                    <br>
                    <p>CpnClassiPhyR Results will be sent to your email address via *.tar.gz compressed file as an attachment.
                    <br>
                    <p>Click here to return to the <a href='dashboard.php'>dashboard</a>! or Click here to <a href='submit_sequences.php'>submit </a>another Cpn60 UT group/subgroup sequence for assessment.</p>
                        </div>";

                    
                }
            }else{
                $message = "This sequence is not a phytoplasma sequence. New Cpn60 UT group/subgroup not added successfully";
            }
            }
        }
        else{
        
?>

<form name="submission" action="" method="post">
<div class="form-group">

<label>Species<font color="red">*</font></label>
<input type="text" class="form-control" name="species" required />

<label>Strain<font color="red">*</font></label>
<input type="text" class="form-control" name="strain" required />

<label>Proposed cpn60 UT group/subgroup<font color="red">*</font></label>
<input type="text" class="form-control" name="proposed_group_subgroup" required />

<label>Cpn60 UT GenBank Accession<font color="red">*</font></label>
<input type="text" class="form-control" name="genbank_cpn60ut_accession" required />

<label>16S group/subgroup<font color="red">*</font></label>
<input type="text" class="form-control" name="group_16s_subgroup" required />

<label>16S Genbank Accession<font color="red">*</font></label>
<input type="text" class="form-control" name="genbank_16s_accession" required />

<label>Host (plant or insect)<font color="red">*</font></label>
<input type="text" class="form-control" name="host" required />

<label>Country of Isolation<font color="red">*</font></label>
<input type="text" class="form-control" name="country" required />

<label>Journal Reference (If available)</label>
<input type="text" class="form-control" name="reference" />

<input class="btn btn-primary active" type="submit" name="submit" value="SUBMIT" />
</div>

</form>
<?php
    }
?>
</div>
</div>
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

<!-- DataTables JavaScript -->
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</body>
<?php
   include 'footer.php';
?>
</html>
