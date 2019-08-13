<html>

        <head>
                <meta charset="utf-8">
                <meta http-equiv="Content-Type" context="text/html; charset=utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

                <meta name="description" content="">

                <title>BadGeek</title>

                <link href="<?php echo base_url('assets/node_modules/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
                <link href="<?php echo base_url('assets/css/fontello.css') ?>" rel="stylesheet">
                <link href="<?php echo base_url('assets/css/badgeek.css') ?>" rel="stylesheet">
                <script src="<?php echo base_url('assets/node_modules/jquery/dist/jquery.min.js')?>"></script>
                <script src="<?php echo base_url('assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js')?>"></script>
                <script src="<?php echo base_url('assets/js/badgeek.js')?>"></script>
                <?php 
                if(isset($extras) && is_array($extras) && is_array($extras["js"]))
                {
                        foreach($extras["js"] as $extra_js_file)
                        {
                                echo "<script src=\"".base_url($extra_js_file)."\"></script>";
                        }
                }
                ?>
        </head>

        <body>
        <div class="page-header">
                <h1 style='font-family:BGFont;'><font style='color:red;'>&</font>BadGeek</h1>
        </div>