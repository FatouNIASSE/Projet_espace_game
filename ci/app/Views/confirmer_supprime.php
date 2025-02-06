</br></br></br>
<div class="container-fluid py-8 custom-container" style="width: 1000px;">
    <div class="card text-center" style="background-color: #e9ecefde;">
        <div class="card-body p-3">
                            <?php session()->getFlashdata('error') ?>
                            <?php echo form_open('/scenario/confirmer_supprimer/'.$code); ?>
                            <?php csrf_field() ?>
                            <label for="reponse">confirmer la suppression</label>
                            
                    
                            <input type="submit" name="submit" value="Confirmer">
                            <?php validation_show_error('reponse') ?>
                            </form>
        </div>
    </div>
</div>
</br></br></br>

<?php
header("refresh:5;url=" . base_url() . "index.php/scenario/afficher_galerie");
?>