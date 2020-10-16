<?php 
$this->extend('layouts/layout_users');
$session = session();
$s = session();

?>

<?php $this->section('conteudo') ?>

    <div><a href="" class="btn btn-primary">Novo utilizador...</a></div>
        
        <div>
        
            <table>
                <thead>
                    <th></th>
                    <th>Username</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Último login</th>
                    <th>Profile</th>
                    <th>Ativo</th>
                    <th>Eliminado</th>
                </thead>

                <tbody>
                    <?php foreach($users as $user) : ?>
                        <tr>
                            <td>ed | el</td>
                            <td><?php echo $user['username'] ?></td>
                            <td><?php echo $user['name'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $user['last_login'] ?></td>
                            <td>[profile]</td>
                            <td>[profile]</td>
                            <td>[elimindo]</td>
                        </tr>
                    <?php endforeach ; ?>
                
                </tbody>
            </table>
        
        </div>
    
    <div>Total: <strong><?php echo count($users) ?></strong></div>

    


<?php $this->endSection() ?>