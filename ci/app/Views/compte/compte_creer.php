<?php
$session=session();
if ($_SESSION['role'] != 'A') {
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
                <?php echo form_open_multipart('/compte/creer'); ?>
                <?= csrf_field() ?>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="nom" style="color:#0d6efd;">Nom :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nom" placeholder="Entrez votre nom" name="nom">
                        <?= validation_show_error('nom') ?>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="prenom" style="color:#0d6efd;">Prénom :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="prenom" placeholder="Entrez votre prénom" name="prenom">
                        <?= validation_show_error('prenom') ?>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="role" style="color:#0d6efd;">Rôle :</label>
                    <div class="col-sm-10" style="background-color: #f6f7ff;">
                        <select class="form-control" id="role" name="role">
                            <option value="">Sélectionner un rôle</option>
                            <option value="Administrateur">Administrateur</option>
                            <option value="Organisateurs">Organisateurs</option>
                        </select>
                        <?= validation_show_error('role') ?>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="email" style="color:#0d6efd;">Pseudo :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" placeholder="Entrez votre pseudo" name="pseudo">
                        <?= validation_show_error('pseudo') ?>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="validite" style="color:#0d6efd;">Validite :</label>
                    <div class="col-sm-10" style="background-color: #f6f7ff;">
                        <select class="form-control" id="validite" name="validite">
                            <option value="">Sélectionner validite</option>
                            <option value="Activer">Activer</option>
                            <option value="Desactiver">Desactiver</option>
                        </select>
                        <?= validation_show_error('validite') ?>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="fichier" style="color:#0d6efd;">Image pour le profil :</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="fichier" name="fichier">
                        <?= validation_show_error('fichier') ?>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="mdp" style="color:#0d6efd;">Mot de passe :</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="pwd" placeholder="Entrez votre mot de passe" name="mdp">
                        <?= validation_show_error('mdp') ?>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="confirmer_mdp" style="color:#0d6efd;">Confirmation du mot de passe :</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="confirmer_mdp" placeholder="Confirmez votre mot de passe" name="confirmer_mdp">
                        <?= validation_show_error('confirmer_mdp') ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                        <button type="submit" class="btn btn-primary btn-lg" name="submit">Créer un nouveau compte</button>
                    </div>

                    <a href="<?php echo base_url();?>index.php/compte/lister" name="submit" role="button" class="btn btn-primary" type="submit">Annuler 👎</a>

                </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php } ?>