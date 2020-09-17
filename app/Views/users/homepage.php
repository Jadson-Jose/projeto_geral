<?php 
$this->extend('layouts/layout_users');
$session = session();

?>

<?php $this->section('conteudo') ?>

<div>Olá, <?php echo $session->name ?></div>

<?php $this->endSection() ?>