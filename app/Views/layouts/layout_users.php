<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProjetoGeral - Users</title>

    <!-- css -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/app.css') ?>">




</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center bg-dark text-light p-3">
                <h3>PROJETO GERAL - Users</h3>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <?php $this->renderSection('conteudo') ?>
            </div>
        </div>
    </div>





    <!-- Javascript -->
    <script src="<?php echo base_url('assets/js/jquery-3.5.1.slim.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/popper.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/app.js') ?>"></script>


</body>

</html>