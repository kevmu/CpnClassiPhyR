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
.ordered-list{
    margin-top: 10px;
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
<h1 class="page-header"><i>cpn</i>60 Plasmid Clone Collection</h1>
</div>



<div class="row">
<div class="col-lg-12">

<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" role=
"grid" aria-describedby="dataTables-example_info">
<tbody>
<tr>
<td colspan="11" width="945">
<p><i>cpn</i>60 clone panel. Plasmid DNA containing the cloned <i>cpn</i>60 UT sequence from each of the samples described below is available to the phytoplasma research community upon request (<a href="http://www.addgene.org" target="_blank">www.addgene.org</a>). In all cases except O2L and SF1, amplicon was generated using the phytoplasma <i>cpn</i>60 UT primers described on the &ldquo;primer sets&rdquo; tab.</p>
</td>
</tr>
<tr>
<td>
<p><b>Clone Name</b></p>
</td>
<td
<p><b><i>cpn60</i> UT Classification</b></p>
</td>
<td
<p><b><i>cpn60</i> UT GenBank Accession</b></p>
</td>
<td
<p><b>cpnDB ID<a href="#superscript-1"><sup>1</sup></a></b></p>
</td>
<td
<p><b>16S Classification</b></p>
</td>
<td
<p><b>16S GenBank Accession</b></p>
</td>
<td
<p><b>Phytoplasma Species</b></p>
</td>
<td
<p><b>Host</b></p>
</td>
<td
<p><b>Country of Origin</b></p>
</td>
<td
<p><b>Literature Reference</b></p>
</td>
<td
<p><b>Plasmid Accession No.<a href="#superscript-2"><sup>2</sup></a></b></p>
</td>
</tr>
<tr>
<td>
<p>O2L<a href="#superscript-3"><sup>3</sup></a></p>
</td>
<td
<p>I-IA</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ939998" target="_blank">KJ939998</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27096" target="_blank">b27096</a></p>
</td>
<td
<p>16SrI-A</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279536" target="_blank">MH279536</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. asteris&rsquo;</i></p>
</td>
<td
<p>Onion</p>
</td>
<td
<p>Canada </br>(Saskatchewan)</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123000" target="_blank">123000</a></p>
</td>
</tr>
<tr>
<td>
<p>SF1<a href="#superscript-4"><sup>4</sup></a></p>
</td>
<td
<p>I-IB</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ940013" target="_blank">KJ940013</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27105" target="_blank">b27105</a></p>
</td>
<td
<p>16SrI-B</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279534" target="_blank">MH279534</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. asteris&rsquo;</i></p>
</td>
<td
<p>Flax</p>
</td>
<td
<p>Canada </br>(Saskatchewan)</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123001" target="_blank">123001</a></p>
</td>
</tr>
<tr>
<td>
<p>BbSP</p>
</td>
<td
<p>I-I(E/AI)AI</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KU523402" target="_blank">KU523402</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27454" target="_blank">b27454</a></p>
</td>
<td
<p>16SrI-E/AI<a href="#superscript-5"><sup>5</sup></a></p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279523" target="_blank">MH279523</a> (E); <a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279522" target="_blank">MH279522</a> (AI)</p>
</td>
<td
<p><i>&lsquo;Ca. P. asteris&rsquo;</i></p>
</td>
<td
<p>Blueberry</p>
</td>
<td
<p>Canada </br>(Nova Scotia)</p>
</td>
<td
<p>(<a href="#reference-2">2</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123002" target="_blank">123002</a></p>
</td>
</tr>
<tr>
<td>
<p>CVB</p>
</td>
<td
<p>I-IF</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ939995" target="_blank">KJ939995</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27145" target="_blank">b27145</a></p>
</td>
<td
<p>16SrI-F</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279545" target="_blank">MH279545</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. asteris&rsquo;</i></p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Italy</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123003" target="_blank">123003</a></p>
</td>
</tr>
<tr>
<td>
<p>AY-Col</p>
</td>
<td
<p>I-IC</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ939994" target="_blank">KJ939994</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27144" target="_blank">b27144</a></p>
</td>
<td
<p>16SrI-R</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279535" target="_blank">MH279535</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. asteris&rsquo;</i></p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Italy</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123004" target="_blank">123004</a></p>
</td>
</tr>
<tr>
<td>
<p>R018</p>
</td>
<td
<p>II-IC</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279495" target="_blank">MH279495</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b31187" target="_blank">b31187</a></p>
</td>
<td
<p>16SrII-C</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH266698" target="_blank">MH266698</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. aurantifolia&rsquo;</i></p>
</td>
<td
<p>Lime</p>
</td>
<td
<p>Iran</p>
</td>
<td
<p>(<a href="#reference-3">3</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123005" target="_blank">123005</a></p>
</td>
</tr>
<tr>
<td>
<p>TagTall</p>
</td>
<td
<p>IV-IC</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH922781" target="_blank">MH922781</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b32834" target="_blank">b32834</a></p>
</td>
<td
<p>16SrIV-C</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH922778" target="_blank">MH922778</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. cocostanzaniae&rsquo;</i></p>
</td>
<td
<p>Coconut</p>
</td>
<td
<p>Tanzania</p>
</td>
<td
<p>(<a href="#reference-3">3</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123007" target="_blank">123007</a></p>
</td>
</tr>
<tr>
<td>
<p>Sab4</p>
</td>
<td
<p>IV-IE</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH922782" target="_blank">MH922782</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b32835" target="_blank">b32835</a></p>
</td>
<td
<p>16SrIV-D</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH922779" target="_blank">MH922779</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. palmae&rsquo;</i></p>
</td>
<td
<p>Palm</p>
</td>
<td
<p>USA </br>(Florida)</p>
</td>
<td
<p>(<a href="#reference-3">3</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123008" target="_blank">123008</a></p>
</td>
</tr>
<tr>
<td>
<p>Palm A-DR</p>
</td>
<td
<p>IV-IE</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH922783" target="_blank">MH922783</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b32836" target="_blank">b32836</a></p>
</td>
<td
<p>16SrIV-E</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH922780" target="_blank">MH922780</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. palmae&rsquo;</i></p>
</td>
<td
<p>Coconut</p>
</td>
<td
<p>Dominican Republic</p>
</td>
<td
<p>(<a href="#reference-3">3</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123009" target="_blank">123009</a></p>
</td>
</tr>
<tr>
<td>
<p>FD</p>
</td>
<td
<p>V-IC</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ939992" target="_blank">KJ939992</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27153" target="_blank">b27153</a></p>
</td>
<td
<p>16SrV</p>
</td>
<td
<p>NA<a href="#superscript-6"><sup>6</sup></a></p>
</td>
<td
<p><i>&lsquo;Ca. P. ulmi&rsquo;</i></p>
</td>
<td
<p>Grape</p>
</td>
<td
<p>France</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123010" target="_blank">123010</a></p>
</td>
</tr>
<tr>
<td>
<p>PGY</p>
</td>
<td
<p>V-IC</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ939991" target="_blank">KJ939991</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27154" target="_blank">b27154</a></p>
</td>
<td
<p>16SrV-C</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279539" target="_blank">MH279539</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. ulmi&rsquo;</i></p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Germany</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123011" target="_blank">123011</a></p>
</td>
</tr>
<tr>
<td>
<p>RS</p>
</td>
<td
<p>V-IC</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ939990" target="_blank">KJ939990</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27155" target="_blank">b27155</a></p>
</td>
<td
<p>16SrV-C</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279544" target="_blank">MH279544</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. rubi&rsquo;</i></p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Germany</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123012" target="_blank">123012</a></p>
</td>
</tr>
<tr>
<td>
<p>Cr</p>
</td>
<td
<p>IX-IH</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ939989" target="_blank">KJ939989</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27158" target="_blank">b27158</a></p>
</td>
<td
<p>16SrIX-A</p>
</td>
<td
<p>NA<a href="#superscript-7"><sup>7</sup></a></p>
</td>
<td
<p><i>&lsquo;Ca. P. phoenicium&rsquo;</i></p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Cuba</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123014" target="_blank">123014</a></p>
</td>
</tr>
<tr>
<td>
<p>AP</p>
</td>
<td
<p>X-IA</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ939977" target="_blank">KJ939977</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27159" target="_blank">b27159</a></p>
</td>
<td
<p>16SrX-A</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279542" target="_blank">MH279542</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. mali&rsquo;</i></p>
</td>
<td
<p>Apple</p>
</td>
<td
<p>Germany</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123016" target="_blank">123016</a></p>
</td>
</tr>
<tr>
<td>
<p>PYLR</p>
</td>
<td
<p>X-IC</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ940010" target="_blank">KJ940010</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27165" target="_blank">b27165</a></p>
</td>
<td
<p>16SrX-C</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279541" target="_blank">MH279541</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. pyri&rsquo;</i></p>
</td>
<td
<p>Peach</p>
</td>
<td
<p>USA</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123017" target="_blank">123017</a></p>
</td>
</tr>
<tr>
<td>
<p>ESFY</p>
</td>
<td
<p>X-IF</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ940007" target="_blank">KJ940007</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27166" target="_blank">b27166</a></p>
</td>
<td
<p>16SrX-F</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279543" target="_blank">MH279543</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. prunorum&rsquo;</i></p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Italy</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123018" target="_blank">123018</a></p>
</td>
</tr>
<tr>
<td>
<p>SCWL</p>
</td>
<td
<p>XI-ID</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279493" target="_blank">MH279493</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b31184" target="_blank">b31184</a></p>
</td>
<td
<p>16SrXI-D</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KC295286" target="_blank">KC295286</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. oryzae&rsquo;</i></p>
</td>
<td
<p>Sugarcane</p>
</td>
<td
<p>China</p>
</td>
<td
<p>(<a href="#reference-3">3</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123019" target="_blank">123019</a></p>
</td>
</tr>
<tr>
<td>
<p>BN44948</p>
</td>
<td
<p>XII-IA</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KJ939979" target="_blank">KJ939979</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27168" target="_blank">b27168</a></p>
</td>
<td
<p>16SrXII-A</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279537" target="_blank">MH279537</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. solani&rsquo;</i></p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Germany</p>
</td>
<td
<p>(<a href="#reference-1">1</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123020" target="_blank">123020</a></p>
</td>
</tr>
<tr>
<td>
<p>SbGP-1</p>
</td>
<td
<p>XIII-(A/I)I</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KT444666" target="_blank">KT444666</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b27178" target="_blank">b27178</a></p>
</td>
<td
<p>16SrXIII-A/I<a href="#superscript-8"><sup>8</sup></a></p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KT444665" target="_blank">KT444665</a> (A); <a href="https://www.ncbi.nlm.nih.gov/nuccore/KT444664" target="_blank">KT444664</a> (I)</p>
</td>
<td
<p><i>&lsquo;Ca. P.hispanicum&rsquo;</i></p>
</td>
<td
<p>Strawberry</p>
</td>
<td
<p>Mexico </br>(Michoacan)</p>
</td>
<td
<p>(<a href="#reference-4">4</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123021" target="_blank">123021</a></p>
</td>
</tr>
<tr>
<td>
<p>PeruPBT</p>
</td>
<td
<p>XV-IB</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279494" target="_blank">MH279494</a></p>
</td>
<td
<p><a href="http://cpndb.ca/getRecord.php?id=b31186" target="_blank">b31186</a></p>
</td>
<td
<p>16SrXV-B</p>
</td>
<td
<p><a href="https://www.ncbi.nlm.nih.gov/nuccore/KX810334" target="_blank">KX810334</a></p>
</td>
<td
<p><i>&lsquo;Ca. P. brasiliense&rsquo;</i></p>
</td>
<td
<p>Papaya</p>
</td>
<td
<p>Peru</p>
</td>
<td
<p>(<a href="#reference-3">3</a>, <a href="#reference-5">5</a>)</p>
</td>
<td
<p><a href="https://www.addgene.org/123023" target="_blank">123023</a></p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p id="superscript-1"><sup>1</sup>chaperonin database ID (<a href="http://cpndb.ca" target="_blank">http://cpndb.ca</a>).</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p id="superscript-2"><sup>2</sup>accession number of plasmid at addgene (<a href="http://www.addgene.org" target="_blank">www.addgene.org</a>). Plasmids are available to the scientific community via this repository.</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p id="superscript-3"><sup>3</sup>plasmid contains the 826 bp product of <i>groEL</i> F/H280p primers (<a href="#reference-1">1</a>). Contains <i>cpn</i>60 UT and flanking <i>cpn</i>60 sequences</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p id="superscript-4"><sup>4</sup>plasmid contains the 1.4 kb product of <i>groEL</i> F/R primers (<a href="#reference-6">6</a>). Contains <i>cpn</i>60 UT and flanking <i>cpn</i>60 sequences</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p id="superscript-5"><sup>5</sup>sample had F2nR2 sequence heterogeneity (<a href="#reference-7">7</a>). The sequence <a href="https://www.ncbi.nlm.nih.gov/nuccore/MH279522" target="_blank">MH279522</a> was suggested as a new subgroup, 16SrI-AI</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p id="superscript-6"><sup>6</sup>insufficient template volume remains to generate F2nR2 sequence; 16Sr group information provided by S. Malembic-Maher (personal communication)</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p id="superscript-7"><sup>7</sup>NA, not available. The 16S sequence generated from this sample was too short for <i>i</i>Phyclassifier (714 bp), but showed 100% id to GenBank <a href="https://www.ncbi.nlm.nih.gov/nuccore/KF941131" target="_blank">KF941131</a>, which is 16SrIX-A.</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p id="superscript-8"><sup>8</sup>sample had F2nR2 sequence heterogeneity (<a href="#reference-4">4</a>).</p>
</td>
</tr>
</tbody>
</table>
</br>
<ol>
<li class="ordered-list" id="reference-1">Dumonceaux TJ, Green M, Hammond C, Perez E, Olivier C. 2014. Molecular diagnostic tools for detection and differentiation of phytoplasmas based on chaperonin-60 reveal differences in host plant infection patterns. PLoS ONE 9:e116039.</li>
<li class="ordered-list" id="reference-2">P&eacute;rez-L&oacute;pez E, Olivier CY, Luna-Rodr&iacute;guez M, Dumonceaux TJ. 2016. Phytoplasma classification and phylogeny based on <i>in silico</i> and <i>in vitro</i> RFLP analysis of <i>cpn60</i> universal target sequences. International Journal of Systematic and Evolutionary Microbiology 66:5600-5613.</li>
<li class="ordered-list" id="reference-3">Muirhead K, P&eacute;rez-L&oacute;pez E, Bahder BW, Hill JE, Dumonceaux T. 2019. The CpnClassiPhyR facilitates phytoplasma classification and taxonomy using cpn60 universal target sequences, p in press. <i>In</i> Olivier C, Dumonceaux T, Perez-Lopez E (ed), Sustainable management of phytoplasma diseases in crops grown in the tropical belt.</li>
<li class="ordered-list" id="reference-4">P&eacute;rez-L&oacute;pez E, Dumonceaux TJ. 2016. Detection and identification of the heterogeneous novel subgroup 16SrXIII-(A/I)I phytoplasma associated with strawberry green petal disease and Mexican periwinkle virescence. International Journal of Systematic and Evolutionary Microbiology 66:4406-4415.</li>
<li class="ordered-list" id="reference-5">Wei W, P&eacute;rez-L&oacute;pez E, Davis RE, Berm&uacute;dez-D&iacute;az L, Granda-Wong C, Wang J, Zhao Y. 2017. &lsquo;Candidatus Phytoplasma brasiliense&rsquo;-related strains associated with papaya bunchy top disease in northern Peru represent a distinct geographic lineage. Crop Protection 92:99-106.</li>
<li class="ordered-list" id="reference-6">Mitrović J, Kakizawa S, Duduk B, Oshima K, Namba S, Bertaccini A. 2011. The <i>groEL</i> gene as an additional marker for finer differentiation of '<i>Candidatus </i>Phytoplasma asteris'-related strains. Annals of Applied Biology 159:41-48.</li>
<li class="ordered-list" id="reference-7">Perez-Lopez E, Vincent C, Moreau D, Hammond C, Town J, Dumonceaux TJ. 2018. A novel &lsquo;Candidatus Phytoplasma asteris&rsquo; subgroup 16SrI-(E/AI)AI associated with blueberry stunt disease in eastern Canada. International Journal of Systematic and Evolutionary Microbiology doi:10.1099/ijsem.0.003100.</li>
</ol>
</br>
</div>

</div>
</div>
	

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
