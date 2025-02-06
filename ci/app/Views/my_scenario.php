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
                if (!empty($msc)) {
                ?>
                    <div class="text-center">
                        <h3 style="background-color: #f2f2f2; color: #f10633e3; margin-top: 20px;"><?php echo $titre.' '. $msc[0]['SCE_intituler']; ?> </h3>
                        <h5 style="background-color: #f2f2f2; color: #2306f1e3; margin-top: 20px;"><?php echo 'le code : '. $msc[0]['SCE_code']; ?></h5>
                       </br>
                        
                    </div>

                   
                        
                                       <?php
                                    foreach ($msc as $sc) {
                                    ?>
                                         <div class="card" style="background-color: #fff; margin-top: 30px">
                                         <?php if($sc['ETP_id'] == 0) { 
                                                echo "<h3>Aucune étape pour ce scénarioe</h3>";
                                                } else{ ?>
                                            <h3 style="text-align: center  ; "><?php echo $sc['ETP_intituler']; ?> </h3>
                                            <p><h6 style="text-align: center;"> Question : </h6><?php echo $sc['ETP_description']; ?></p>
                                            <p><h6 style="text-align: center;">Reponse : </h6><?php echo $sc['ETP_reponse']; ?></p>
                                            <p><h6 style="text-align: center;">ordre : </h6><?php echo $sc['ETP_ordre']; ?></p>
                                            <?php } ?>
                                          </div>  
                                     <?php
                                    }
                                    ?>    
                               
                        
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
