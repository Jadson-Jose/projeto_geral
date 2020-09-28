<?php 
$this->extend('layouts/layout_users');
$session = session();
$s = session();

?>

<?php $this->section('conteudo') ?>

<div>Olá, <?php echo $s->name . '.' ?></div>

<div>O meu perfil é de: <?php echo $s->profile ?></div>

<a href="<?php echo site_url('users/logout') ?>">Logout</a>

<?php $this->endSection() ?>