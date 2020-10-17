<?php 
$this->extend('layouts/layout_users');
$session = session();
$s = session();

?>

<?php $this->section('conteudo') ?>

    <div class= "mt-2 mb-2"><a href="" class="btn btn-primary">Novo utilizador...</a></div>
        
        <div>
        
            <table class = "table table-striped">
                <thead class = "thead-dark">
                    <th></th>
                    <th>Username</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Último login</th>
                    <th class = "text-center">Profile</th>
                    <th class = "text-center">Ativo</th>
                    <th class = "text-center">Eliminado</th>
                </thead>

                <tbody>
                    <?php foreach($users as $user) : ?>
                        <tr>
                            <!-- editar e eliminar -->
                            <td>
                                <a href="" class= "btn btn-primary btn-sm "><i class = "fa fa-pencil"></i></a>
                                <a href="" class= "btn btn-danger btn-sm "><i class = "fa fa-trash"></i></a>
                            </td>
                            
                           
                            <td><?php echo $user['username'] ?></td>
                            <td><?php echo $user['name'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $user['last_login'] ?></td>
                            
                                
                            <!-- admin ou outro tipo de user -->
                            <?php if(preg_match("/admin/", $user['profile'])) : ?>
                                <td class = "text-center"><i class = "fa fa-user" title= "Admin"></i></td>
                            <?php else: ?>
                                <td class = "text-center"><i class = "fa fa-user-o" title = "Not admin"></i></td>
                            <?php endif; ?>
                            
                            <!-- ativo ou inativo  -->
                            <?php if($user['active'] == 1) : ?>
                                <td class = "text-center"><i class ="fa fa-check text-success"></i></td>
                            <?php else : ?>
                                <td class = "text-center"><i class = "fa fa-times text-danger"></i></td>
                            <?php endif ; ?>
                            
                            <!-- eliminado ou não -->
                            <?php if($user['deleted'] != 0) : ?>
                                <td class = "text-center"><i class = "fa fa-check text-success"></i></td>
                            <?php else : ?>
                                <td class = "text-center"><i class = "fa fa-check text-danger"></i></td>
                            <?php endif ; ?>
    
                        </tr>
                    <?php endforeach ; ?>
                
                </tbody>
            </table>
        
        </div>
    
    <div>Total: <strong><?php echo count($users) ?></strong></div>

    


<?php $this->endSection() ?>