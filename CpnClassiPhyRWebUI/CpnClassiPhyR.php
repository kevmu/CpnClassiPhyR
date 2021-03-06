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
                        <h1 class="page-header">CpnClassiPhyR: a cpn60 universal target-based classification tool for phytoplasma</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div id="msg"></div>

                        <div id="upload_panel" class="panel panel-default">
                            <div class="panel-body">
                                        


                                        <form action="" method="post">
                                            <div id="file_upload" "class="form-group">


                                                <label>Paste your sequence in FASTA Format</label>
                                                <textarea style="margin: 0px 537px 0px 0px; height: 281px; width: 558px;" id="textarea" name="textarea" class="form-control" rows="3"></textarea>



<!--
                                                <label>Upload your sequence file in FASTA Format:</label>
                                                <input type="file" id="file" name="file" />
-->
<br>
<div
                                                <button type="submit" id="submit" class="btn btn-primary active">SUBMIT</button>

</div>
                                            </div>
<!--
                                            <button type="reset" class="btn btn-default">RESET</button>
-->
</form>

                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
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
        <script type="text/javascript">
        $(document).ready(function (e) {
        $('#submit').on('click', function () {
//        var file_input = $('#file').prop('files')[0];
        var textarea_input = $('#textarea').val();
//        alert(file_input);
//        alert(textarea_input);
                       
        var form_data = new FormData();
//        if((file_input == undefined) && (textarea_input != "")){
//                        alert(file_input);
            if(textarea_input.match(/^>/) != null){
                        
                var d1 = document.getElementById('file_upload');
                d1.insertAdjacentHTML('beforeend', '<i class="fa fa-spinner fa-pulse" style="font-size:24px"></i>');
                
                form_data.append('file', textarea_input);
//                form_data.append('input_data_type', "textarea_input");

            }
//
//            
//        }else if ((file_input != undefined) && (textarea_input == "")){
////        }else if ((file_input != undefined)){
//            var d1 = document.getElementById('file_upload');
//            d1.insertAdjacentHTML('beforeend', '<i class="fa fa-spinner fa-pulse" style="font-size:24px"></i>');
//            form_data.append('file', file_input);
//            form_data.append('input_data_type', "file_input");
//        }
        else{
//            if(file_input == undefined){
//                $('#msg').html("File input Undefined!");
//            }
                        
            if(textarea_input == ""){
                $('#msg').html("Text input empty. Please resubmit a nucleotide sequence in fasta format!");
                die;
            }
            
            
        }
        
//        var file_data = $('#textarea').val();
                        
//
//        $('#msg').html(file_data.match(/^>/))
        
        

//        alert(file_data + " " + file_data.match(/^>/));
        $.ajax({
             url: 'php/uploads.php', // point to server-side PHP script
             dataType: 'text', // what to expect back from the PHP script
             cache: false,
             contentType: false,
             processData: false,
             data: form_data,
             type: 'post',
             success: function (response) {
               
               if(response.indexOf("Invalid") < 0){
            
                    $('#upload_panel').html("")
               }
               
               $('#msg').html(response); // display error response from the PHP script
               
             },
             error: function (response) {
               $('#msg').html(response); // display error response from the PHP script
             }
             });
        });
        });
    </script>
    </body>
<?php
   include 'footer.php';
?>
</html>
