<?php
function  read_fas_file($x) { // Check for Empty File
 if (!file_exists($x)) {
  print "File Not Exist!!";
  exit();
 } else {
  $fh = fopen($x, 'r');
  if (filesize($x) == 0) {
   print "File is Empty!!";
   fclose($fh);
   exit();
  } else {
   $f = fread($fh, filesize($x));
   fclose($fh);
   return $f;
  }
 }
}

function fas_check($x) { // Check FASTA File Format
 $gt = substr($x, 0, 1);
 if ($gt != ">") {
  print "Not FASTA File!!";
  exit();
 } else {
  return $x;
 }
}

function get_seq($x) { // Get Sequence and Sequence Name
 $fl = explode(PHP_EOL, $x);
 $sh = trim(array_shift($fl));
 if($sh == null) {
  $sh = "UNKNOWN SEQUENCE";
 }
 $fl = array_filter($fl);
 $seq = "";
 foreach($fl as $str) {
  $seq .= trim($str);
 }
 $seq = strtoupper($seq);
 $seq = preg_replace("/[^ACDEFGHIKLMNPQRSTVWY]/i", "", $seq);
 if ((count($fl) < 1) || (strlen($seq) == 0)) {
  print "Sequence is Empty!!";
  exit();
 } else {
  return array($sh, $seq);
 }
}

function fas_get($x) { // Read Multiple FASTA Sequences
 $gtr = substr($x, 1);
 $sqs = explode(">", $gtr);
 if (count($sqs) > 1) {
  foreach ($sqs as $sq) {
   $spair = get_seq($sq);
   $spairs[$spair[0]] = $spair[1];
  }
  return $spairs;
 } else {
  $spair = get_seq($gtr);
  return array($spair[0] => $spair[1]);
 }
}

?>
