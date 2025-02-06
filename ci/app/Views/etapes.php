<!-- ======= les etapes ======= -->
<?php if (empty($err)){ ?>              
    <p class="no-data">L'information recherchée n'existe pas !</p>
<?php } else{

        if (!empty($etp)) {
        ?>

            <div class="card  border-primary mx-auto text-center mt-5 d-flex flex-column align-items-center" style="max-width: 80rem;">
               
                    
                        <div class="card-header"><h3 style="color: #b31717; font-weight: bold;"><?php echo "$etp->ETP_intituler"; ?></h3></div>
                        <div class="card-body text-secondary">
                            </br>
                            <h5 class="card-title"><?php echo "$etp->ETP_description"; ?></h5>
                            </br>
                            <?php if (!empty("$etp->IDE_description")): ?>
                                <div style="margin-top: 20px; font-style: italic;">
                                    <p><a href="<?php echo "$etp->IDE_lien"; ?>"><strong>Indice:</strong> <?php echo "$etp->IDE_description"; ?><a href="<?php echo "$etp->IDE_lien"; ?>">🔍 </a></p>
                                </div>
                            <?php endif; ?>
                            </br></br>
                            <?php session()->getFlashdata('error') ?>
                            <?php echo form_open('/scenario/afficher_etapes/'.$lecode_sc.'/'.$niveau); ?>
                            <?php csrf_field() ?>
                            <label for="reponse">Votre réponse : </label>
                            <input type="input" name="reponse">
                            
                            
                            
                           
                            <input type="submit" name="submit" value="Valider">
                            <?php validation_show_error('reponse') ?>
                            </form>
                            </br></br></br></br>
                            <p class="mt-auto text-center"><strong>Etape:</strong> <?php echo "$etp->ETP_ordre"; ?></p>
                        </div>
                    
               
            </div>




        <?php
        } else {
            echo "<p>Aucun etapes disponible pour le moment.</p>";
                }
    }
  ?><!-- End les etapes -->