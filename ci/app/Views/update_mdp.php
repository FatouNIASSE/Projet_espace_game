
<div class="container-fluid py-8 custom-container" style="width: 1000px;">
    <div class="card text-center" style="background-color: #e9ecefde;">
        <div class="card-body p-3">
            <div class="col-xl-13 col-sm-13 mb-xl-0 mb-4 mx-auto">
                <p class="text-center h1 fw-bold mb-5 mt-4"><?= $titre; ?></p>
                <?= session()->getFlashdata('error') ?>
                <?php echo form_open('/compte/modifier_mdp'); ?>
                <?= csrf_field() ?>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="nom" style="color:#0d6efd;">Nom :</label>
                    <div class="col-sm-10">
                        <input  type="text" name="nom" value="<?php echo  $adm->PRO_nom;?>" disabled>
                        <?= validation_show_error('nom') ?>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="prenom" style="color:#0d6efd;">Prénom :</label>
                    <div class="col-sm-10">
                        <input  type="text" name="prenom" value="<?php echo  $adm->PRO_prenom;?>" disabled>
                        <?= validation_show_error('prenom') ?>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="email" style="color:#0d6efd;">Pseudo :</label>
                    <div class="col-sm-10">
                        <input  type="text" name="id" value="<?php echo  $adm->CPT_login;?>" disabled>
                        <?= validation_show_error('pseudo') ?>
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
                        <button type="submit" class="btn btn-primary btn-lg" name="submit">Valider 👍</button>
                    </div>
                    <a href="<?php echo base_url();?>index.php/compte/afficher_profil" name="submit" role="button" class="btn btn-primary" type="submit">Annuler 👎</a>

                </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>