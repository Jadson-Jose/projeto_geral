<?php 
$this->extend('layouts/layout_users');
$session = session();

?>

<?php $this->section('conteudo') ?>

<div>Olá, <?php echo $session->name ?></div>

<a href="<?php echo site_url('users/logout') ?>">Logout</a>

<?php $this->endSection() ?>