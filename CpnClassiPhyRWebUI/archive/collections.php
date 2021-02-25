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
<h1 class="page-header">Cpn60 Plasmid Clone Collection</h1>
</div>



<div class="row">
<div class="col-lg-12">

<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" role=
"grid" aria-describedby="dataTables-example_info">
<tbody>
<tr>
<td colspan="11" width="945">
<p><em>cpn</em>60 clone panel. Plasmid DNA containing the cloned <em>cpn</em>60 UT sequence from each of the samples described below is available to the phytoplasma research community upon request (www.addgene.org). In all cases except O2L and SF1, amplicon was generated using the phytoplasma <em>cpn</em>60 UT primers described on the &ldquo;primer sets&rdquo; tab.</p>
</td>
</tr>
<tr>
<td>
<p>clone name</p>
</td>
<td
<p><em>cpn60</em> UT classification</p>
</td>
<td
<p><em>cpn60</em> UT GenBank accession</p>
</td>
<td
<p>cpnDB ID<sup>1</sup></p>
</td>
<td
<p>16S classification</p>
</td>
<td
<p>16S GenBank accession</p>
</td>
<td
<p>Phytoplasma species</p>
</td>
<td
<p>host</p>
</td>
<td
<p>country of origin</p>
</td>
<td
<p>literature reference</p>
</td>
<td
<p>Plasmid accession no.<sup>2</sup></p>
</td>
</tr>
<tr>
<td>
<p>O2L<sup>3</sup></p>
</td>
<td
<p>I-IA</p>
</td>
<td
<p>KJ939998</p>
</td>
<td
<p>b27096</p>
</td>
<td
<p>16SrI-A</p>
</td>
<td
<p>MH279536</p>
</td>
<td
<p><em>&lsquo;Ca. P.</em> asteris&rsquo;</p>
</td>
<td
<p>onion</p>
</td>
<td
<p>Canada (Saskatchewan)</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123000</p>
</td>
</tr>
<tr>
<td>
<p>SF1<sup>4</sup></p>
</td>
<td
<p>I-IB</p>
</td>
<td
<p>KJ940013</p>
</td>
<td
<p>b27105</p>
</td>
<td
<p>16SrI-B</p>
</td>
<td
<p>MH279534</p>
</td>
<td
<p><em>&lsquo;Ca. P.</em> asteris&rsquo;</p>
</td>
<td
<p>flax</p>
</td>
<td
<p>Canada (Saskatchewan)</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123001</p>
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
<p>KU523402</p>
</td>
<td
<p>b27454</p>
</td>
<td
<p>16SrI-E/AI<sup>5</sup></p>
</td>
<td
<p>MH279523 (E); MH279522 (AI)</p>
</td>
<td
<p><em>&lsquo;Ca. P.</em> asteris&rsquo;</p>
</td>
<td
<p>blueberry</p>
</td>
<td
<p>Canada (Nova Scotia)</p>
</td>
<td
<p>(2)</p>
</td>
<td
<p>123002</p>
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
<p>KJ939995</p>
</td>
<td
<p>b27145</p>
</td>
<td
<p>16SrI-F</p>
</td>
<td
<p>MH279545</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. asteris&rsquo;</p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Italy</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123003</p>
</td>
</tr>
<tr>
<td>
<p>AY-col</p>
</td>
<td
<p>I-IC</p>
</td>
<td
<p>KJ939994</p>
</td>
<td
<p>b27144</p>
</td>
<td
<p>16SrI-R</p>
</td>
<td
<p>MH279535</p>
</td>
<td
<p><em>&lsquo;Ca. </em>P<em>.</em> asteris</p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Italy</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123004</p>
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
<p>MH279495</p>
</td>
<td
<p>b31187</p>
</td>
<td
<p>16SrII-C</p>
</td>
<td
<p>MH266698</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. aurantifolia&rsquo;</p>
</td>
<td
<p>lime</p>
</td>
<td
<p>Iran</p>
</td>
<td
<p>(3)</p>
</td>
<td
<p>123005</p>
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
<p>MH922781</p>
</td>
<td
<p>b32834</p>
</td>
<td
<p>16SrIV-C</p>
</td>
<td
<p>MH922778</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. cocostanzaniae&rsquo;</p>
</td>
<td
<p>coconut</p>
</td>
<td
<p>Tanzania</p>
</td>
<td
<p>(3)</p>
</td>
<td
<p>123007</p>
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
<p>MH922782</p>
</td>
<td
<p>b32835</p>
</td>
<td
<p>16SrIV-D</p>
</td>
<td
<p>MH922779</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. palmae&rsquo;</p>
</td>
<td
<p>palm</p>
</td>
<td
<p>USA (Florida)</p>
</td>
<td
<p>(3)</p>
</td>
<td
<p>123008</p>
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
<p>MH922783</p>
</td>
<td
<p>b32836</p>
</td>
<td
<p>16SrIV-E</p>
</td>
<td
<p>MH922780</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. palmae&rsquo;</p>
</td>
<td
<p>coconut</p>
</td>
<td
<p>Dominican Republic</p>
</td>
<td
<p>(3)</p>
</td>
<td
<p>123009</p>
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
<p>KJ939992</p>
</td>
<td
<p>b27153</p>
</td>
<td
<p>16SrV</p>
</td>
<td
<p>NA<sup>6</sup></p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. ulmi&rsquo;</p>
</td>
<td
<p>grape</p>
</td>
<td
<p>France</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123010</p>
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
<p>KJ939991</p>
</td>
<td
<p>b27154</p>
</td>
<td
<p>16SrV-C</p>
</td>
<td
<p>MH279539</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. ulmi&rsquo;</p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Germany</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123011</p>
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
<p>KJ939990</p>
</td>
<td
<p>b27155</p>
</td>
<td
<p>16SrV-C</p>
</td>
<td
<p>MH279544</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. rubi&rsquo;</p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Germany</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123012</p>
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
<p>KJ939989</p>
</td>
<td
<p>b27158</p>
</td>
<td
<p>16SrIX-A</p>
</td>
<td
<p>NA<sup>7</sup></p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. phoenicium&rsquo;</p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Cuba</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123014</p>
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
<p>KJ939977</p>
</td>
<td
<p>b27159</p>
</td>
<td
<p>16SrX-A</p>
</td>
<td
<p>MH279542</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. mali&rsquo;</p>
</td>
<td
<p>apple</p>
</td>
<td
<p>Germany</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123016</p>
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
<p>KJ940010</p>
</td>
<td
<p>b27165</p>
</td>
<td
<p>16SrX-C</p>
</td>
<td
<p>MH279541</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. pyri&rsquo;</p>
</td>
<td
<p>pear</p>
</td>
<td
<p>USA</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123017</p>
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
<p>KJ940007</p>
</td>
<td
<p>b27166</p>
</td>
<td
<p>16SrX-F</p>
</td>
<td
<p>MH279543</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. prunorum&rsquo;</p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Italy</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123018</p>
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
<p>MH279493</p>
</td>
<td
<p>b31184</p>
</td>
<td
<p>16SrXI-D</p>
</td>
<td
<p>KC295286</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. oryzae&rsquo;</p>
</td>
<td
<p>Sugarcane</p>
</td>
<td
<p>China</p>
</td>
<td
<p>(3)</p>
</td>
<td
<p>123019</p>
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
<p>KJ939979</p>
</td>
<td
<p>b27168</p>
</td>
<td
<p>16SrXII-A</p>
</td>
<td
<p>MH279537</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. solani&rsquo;</p>
</td>
<td
<p>Periwinkle</p>
</td>
<td
<p>Germany</p>
</td>
<td
<p>(1)</p>
</td>
<td
<p>123020</p>
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
<p>KT444666</p>
</td>
<td
<p>b27178</p>
</td>
<td
<p>16SrXIII-A/I<sup>8</sup></p>
</td>
<td
<p>KT444665 (A); KT444664 (I)</p>
</td>
<td
<p><em>&lsquo;Ca. P.</em> hispanicum&rsquo;</p>
</td>
<td
<p>strawberry</p>
</td>
<td
<p>Mexico (Michoacan)</p>
</td>
<td
<p>(4)</p>
</td>
<td
<p>123021</p>
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
<p>MH279494</p>
</td>
<td
<p>b31186</p>
</td>
<td
<p>16SrXV-B</p>
</td>
<td
<p>KX810334</p>
</td>
<td
<p><em>&lsquo;Ca.</em> P. brasiliense&rsquo;</p>
</td>
<td
<p>papaya</p>
</td>
<td
<p>Peru</p>
</td>
<td
<p>(3, 5)</p>
</td>
<td
<p>123023</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p><sup>1</sup>chaperonin database ID (<a href="http://cpndb.ca" target="_blank">http://cpndb.ca</a>).</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p><sup>2</sup>accession number of plasmid at addgene (<a href="http://www.addgene.org" target="_blank">www.addgene.org</a>). Plasmids are available to the scientific community via this repository.</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p><sup>3</sup>plasmid contains the 826 bp product of groELF/H280p primers (1). Contains <em>cpn</em>60 UT and flanking <em>cpn</em>60 sequences</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p><sup>4</sup>plasmid contains the 1.4 kb product of groEL F/R primers (6). Contains <em>cpn</em>60 UT and flanking <em>cpn</em>60 sequences</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p><sup>5</sup>sample had F2nR2 sequence heterogeneity (7). The sequence MH279522 was suggested as a new subgroup, 16SrI-AI</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p><sup>6</sup>insufficient template volume remains to generate F2nR2 sequence; 16Sr group information provided by S. Malembic-Maher (personal communication)</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p><sup>7</sup>NA, not available. The 16S sequence generated from this sample was too short for iPhyclassifier (714 bp), but showed 100% id to GenBank KF941131 , which is 16SrIX-A.</p>
</td>
</tr>
<tr>
<td colspan="11" width="945">
<p><sup>8</sup>sample had F2nR2 sequence heterogeneity (4).</p>
</td>
</tr>
</tbody>
</table>
</br>
<ol>
<li>Dumonceaux TJ, Green M, Hammond C, Perez E, Olivier C. 2014. Molecular diagnostic tools for detection and differentiation of phytoplasmas based on chaperonin-60 reveal differences in host plant infection patterns. PLoS ONE 9:e116039.</li>
<li>P&eacute;rez-L&oacute;pez E, Olivier CY, Luna-Rodr&iacute;guez M, Dumonceaux TJ. 2016. Phytoplasma classification and phylogeny based on <em>in silico</em> and <em>in vitro</em> RFLP analysis of <em>cpn60</em> universal target sequences. International Journal of Systematic and Evolutionary Microbiology 66:5600-5613.</li>
<li>Muirhead K, P&eacute;rez-L&oacute;pez E, Bahder BW, Hill JE, Dumonceaux T. 2019. The CpnClassiPhyR facilitates phytoplasma classification and taxonomy using cpn60 universal target sequences, p in press. <em>In</em> Olivier C, Dumonceaux T, Perez-Lopez E (ed), Sustainable management of phytoplasma diseases in crops grown in the tropical belt.</li>
<li>P&eacute;rez-L&oacute;pez E, Dumonceaux TJ. 2016. Detection and identification of the heterogeneous novel subgroup 16SrXIII-(A/I)I phytoplasma associated with strawberry green petal disease and Mexican periwinkle virescence. International Journal of Systematic and Evolutionary Microbiology 66:4406-4415.</li>
<li>Wei W, P&eacute;rez-L&oacute;pez E, Davis RE, Berm&uacute;dez-D&iacute;az L, Granda-Wong C, Wang J, Zhao Y. 2017. &lsquo;Candidatus Phytoplasma brasiliense&rsquo;-related strains associated with papaya bunchy top disease in northern Peru represent a distinct geographic lineage. Crop Protection 92:99-106.</li>
<li>Mitrović J, Kakizawa S, Duduk B, Oshima K, Namba S, Bertaccini A. 2011. The <em>groEL</em> gene as an additional marker for finer differentiation of '<em>Candidatus </em>Phytoplasma asteris'-related strains. Annals of Applied Biology 159:41-48.</li>
<li>Perez-Lopez E, Vincent C, Moreau D, Hammond C, Town J, Dumonceaux TJ. 2018. A novel &lsquo;Candidatus Phytoplasma asteris&rsquo; subgroup 16SrI-(E/AI)AI associated with blueberry stunt disease in eastern Canada. International Journal of Systematic and Evolutionary Microbiology doi:10.1099/ijsem.0.003100.</li>
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
