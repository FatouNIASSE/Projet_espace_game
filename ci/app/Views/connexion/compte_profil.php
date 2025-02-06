<?php
$session=session();
if ($_SESSION['role'] != 'A' && $_SESSION['role'] != 'O') {
    header("Location: " . base_url() . "index.php/compte/connecter");
    exit(); // Assurez-vous de terminer le script après la redirection
} else{
?>

<div class="container-fluid py-8 custom-container" style="width: 1000px;">
    <div class="card text-center" style="background-color: #e9ecefde;">
        <div class="card-body p-3">
            <div class="col-xl-13 col-sm-13 mb-xl-0 mb-4 mx-auto" >
             
                   
                                    <h2 class="font-weight-bolder mt-5">Information Personnelles</h2>
                                    <?php 
                                    if ($adm != null) {
                                    ?>
                                    <div class="card" style="background-color: #fff;">
                                        <div class="card-body p-3">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Nom :</td>
                                                        <td><?php echo "$adm->PRO_nom"; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Prenom :</td>
                                                        <td><?php echo "$adm->PRO_prenom"; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pseudo :</td>
                                                        <td><?php echo "$adm->CPT_login"; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="row justify-content-center">
                                                <div class="col-md-4 mt-4"><a href="<?php echo base_url() . "index.php/compte/modifier_mdp"; ?>">
                                                    <button class="btn btn-primary">
                                                        <h2 class="text-sm mb-0 font-weight-bold" style="color: #ffffff;">Parametre <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer" aria-hidden="true"></i></h2>
                                                    </button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    } else {
                                        echo "<p>Aucune information enregistrée.</p>";
                                    }
                                    ?>
              
            </div>
        </div>
    </div>
</div>
<?php } ?>