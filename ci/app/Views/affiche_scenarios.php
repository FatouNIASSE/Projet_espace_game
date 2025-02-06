<?php
$session = session();
if ($_SESSION['role'] != 'O') {
    header("Location: " . base_url() . "index.php/compte/connecter");
    exit(); // Assurez-vous de terminer le script après la redirection
} else {
?>
    <!-- ======= table des scenarios ======= -->
   <div class="container-fluid py-8 custom-container" style="width: 1300px;">
    <div class="card text-center" style="background-color: #e9ecefde;">
        <div class="card-body p-3">
            <div class="col-xl-13 col-sm-13 mb-xl-0 mb-4 mx-auto" >
                <?php
                if (!empty($sc)) {
                ?>
                    <div class="text-center">
                        <h1 style="background-color: #f2f2f2; color: #242326e3; margin-top: 20px;"><?php echo $titre; ?></h1>
                        <br>
                       
                        <a href="<?php echo base_url() . "index.php/scenario/creer"; ?>">
                            <button type="submit" class="btn btn-primary mb-2">Ajouter un nouveau scénario</button>
                        </a>
                         <br>
       
                    </div>

                    <div class="card" style="background-color: #fff; margin-top: 30px">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="margin-bottom: 0;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center; background-color: #333; color: #ecc56a;">Intitulé</th>
                                        <th style="text-align: center; background-color: #333; color: #ecc56a;">Code</th>
                                        <th style="text-align: center; background-color: #333; color: #ecc56a;">Description</th>
                                        <th style="text-align: center; background-color: #333; color: #ecc56a;">Auteur</th>
                                        <th style="text-align: center; background-color: #333; color: #ecc56a;">Nombre_etape</th>
                                        <th style="text-align: center; background-color: #333; color: #ecc56a;">Etats</th>
                                        <th style="text-align: center; background-color: #333; color: #ecc56a;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($sc as $scenario) {
                                    ?>
                                        <tr>
                                           <td style="text-align: center;">
                                            <?php echo $scenario['SCE_intituler']; ?></br>
                                         
                                            <!-- Affichage de l'image avec une taille maximale -->
                                            <img src="<?php echo base_url() . "images_scenario/" . $scenario['SCE_image']; ?>" style="max-width: 100px; max-height: 100px; alt="" "></br></br></br>
                                               <a href="<?php echo base_url() . "index.php/scenario/visualiser/" . $scenario['SCE_code']; ?>" style="margin-right: 10px;">
                                                    <i class="fas fa-eye" style="color: #0f69df;"></i>
                                                </a>
                                                <a href="#" style="margin-left: 10px;">
                                                    <i class="fas fa-copy" style="color: #5e6a81;"></i>
                                                </a></br>
                                                                                        
                                           
                                        </td>

                                            <td style="text-align: center;"><?php echo $scenario['SCE_code']; ?></td>
                                            <td style="text-align: center;">
                                            <?php 
                                            $description = $scenario['SCE_description'];
                                            $wrappedDescription = wordwrap($description, 15, "<br>", true);
                                            echo $wrappedDescription; 
                                            ?>
                                        </td>
                                            <td style="text-align: center;"><?php echo $scenario['Auteur']; ?></td>
                                            <td style="text-align: center;"><?php if($scenario['Totale_etape'] == 0) { 
                                                echo "<p>aucun etape</p>";
                                                } else{ echo $scenario['Totale_etape']; }?></td>
                                             <td style="text-align: center;"><?php echo $scenario['SCE_activite']; ?></td>
                                            <td>
                                                <?php if($scenario['CPT_login'] == $session->get('user')){ ?>
                                                <!-- Add your icons for actions here -->
                                                <a href="#"><i class="fas fa-edit" style=" color:  #5e6a81;"></i></a></br>
                                                <!-- Ajouter un formulaire pour la suppression -->
                                                <?php echo form_open('/scenario/supprimer/' . $scenario['SCE_code'], 'onsubmit="return confirm(\'Voulez-vous vraiment supprimer ce scénario ?\')"'); ?>
                                                    <input type="hidden" name="scenarioCode" value="<?php echo $scenario['SCE_code']; ?>">
                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                <?php echo form_close(); ?>

                                                <a href="#"><i class="fas fa-toggle-on" style=" color: #16ba32;"></i>/<i class="fas fa-toggle-off" style=" color: #db2914;"></i></a></br>
                                                <a href="#">RAZ <i class="fas fa-undo" style=" color: #5e6a81;"></i></a>
                                            <?php } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php
                } else {
                    echo "<p>Aucun scénario disponible pour le moment.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- End table des Scénarios -->
<?php } ?>
