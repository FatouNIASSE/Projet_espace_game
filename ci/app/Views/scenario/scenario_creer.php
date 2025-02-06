<?php
$session=session();
if ($_SESSION['role'] != 'O') {
    header("Location: " . base_url() . "index.php/compte/connecter");
    exit(); // Assurez-vous de terminer le script après la redirection
} else{
?>


   <div class="container-fluid py-8 custom-container" style="width: 1000px;">
    <div class="card text-center" style="background-color: #e9ecefde;">
        <div class="card-body p-3">
            <div class="col-xl-13 col-sm-13 mb-xl-0 mb-4 mx-auto">
                <p class="text-center h1 fw-bold mb-5 mt-4"><?= $titre; ?></p>
                <?= session()->getFlashdata('error') ?>
                <?php echo form_open_multipart('/scenario/creer'); ?>
                <?= csrf_field() ?>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="intituler" style="color:#0d6efd;">Intitule :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="intituler" placeholder="Entrez l'intitule du scénario" name="intituler">
                        <?= validation_show_error('intituler') ?>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="description" style="color:#0d6efd;">Description :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="description" placeholder="Entrez la descripion du scenario" name="description">
                        <?= validation_show_error('description') ?>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="validite" style="color:#0d6efd;">Validite :</label>
                    <div class="col-sm-10" style="background-color: #f6f7ff;">
                        <select class="form-control" id="validite" name="validite">
                            <option value="">Sélectionner validite</option>
                            <option value="Activer">Activer</option>
                            <option value="Cacher">Cacher</option>
                        </select>
                        <?= validation_show_error('validite') ?>
                    </div>
                </div>
               
                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="fichier" style="color:#0d6efd;">Image pour le scenario :</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="fichier" name="fichier">
                        <?= validation_show_error('fichier') ?>
                    </div>
                </div>

               

                <div class="form-group">
                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                        <button type="submit" class="btn btn-primary btn-lg" name="submit">Créer un nouveau scenario</button>
                    </div>

                    <a href="<?php echo base_url();?>index.php/scenario/afficher_scenario" name="submit" role="button" class="btn btn-primary" type="submit">Annuler 👎</a>

                </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php } ?>