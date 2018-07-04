<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="pt-br" class="h-100">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PoaDoc's Mobile</title>
	<link rel="stylesheet" href="<?= base_url('assets/bootstrap/bootstrap.min.css')?>" >
</head>
<body class="h-100">

	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
        <a class="navbar-brand" href="#">PoaLab Doc's</a>
        </div>
    </nav>


    <div class="container h-100">

        <div class="row h-100">
            <div class="col-xl-12 d-flex align-items-center">
                <div class="card mx-auto">
                    <?php if(!$isLoggedIn){

                        $this->load->view('login');

                     }else{ ?>
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-xl-10">
                                    <h2>Enviar Arquivo</h2>
                                </div>
                                <div class="col-xl-2 pl-0">
                                    <a href="<?= base_url().'index.php/media/logout' ?>" id="logout" class="btn btn-info">Sair</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <?php if($this->session->flashdata('success')) { ?>
                                <div class="container">
                                    <div class="alert alert-success alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <?= $this->session->flashdata('success'); ?>
                                    </div>
                                </div>
                            <?php } else if($this->session->flashdata('errors')) {
                                foreach($this->session->flashdata('errors') as $err) { ?>
                                    <div class="container">
                                        <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <?= $err; ?>
                                        </div>
                                    </div>
                            <?php }} ?>

                            <form class="form-horizontal" method="POST" action="<?= base_url().'index.php/media/save' ?>" enctype="multipart/form-data">
                                <fieldset>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name">Nome</label>
                                    <div class="col-xl-12">
                                        <input id="name" name="name" type="text" placeholder="nome" class="form-control input-md" required="">

                                    </div>
                                </div>

                                <!-- File Button -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="file">Arquivo</label>
                                    <div class="col-xl-12" style="overflow: hidden;">
                                        <input id="file" name="file" class="input-file" type="file">
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="submit"></label>
                                    <div class="col-xl-12">
                                        <button id="submit" name="submit" class="btn btn-success">Enviar</button>
                                    </div>
                                </div>

                                </fieldset>

                            </form>
                        </div>
                    <?php } ?>
                </div> <!-- end card -->
            </div>
        </div>

    </div>

</body>
<script src="<?= base_url('assets/bootstrap/jquery-3.2.1.slim.min.js')?>"></script>
<script src="<?= base_url('assets/bootstrap/popper.min.js')?>"></script>
<script src="<?= base_url('assets/bootstrap/bootstrap.min.js')?>"></script>
</html>