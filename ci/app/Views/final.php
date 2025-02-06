</br></br></br>
<div class="container-fluid py-8 custom-container" style="width: 1000px;">
    <div class="card text-center" style="background-color: #e9ecefde;">
        <div class="card-body p-3">
            <div class="col-xl-13 col-sm-13 mb-xl-0 mb-4 mx-auto">
                <p class="text-center h1 fw-bold mb-5 mt-4"><?= $titre; ?></p>
                <?= session()->getFlashdata('error') ?>
                <?php echo form_open_multipart('/scenario/finaliser/'.$lecode.'/'.$chaine.'/'.$niveau); ?>
                <?= csrf_field() ?>

                <div class="form-group row mb-4">
                    <label class="col-sm-2 col-form-label" for="mail" style="color:#0d6efd;">votre-email :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="mail" placeholder="Entrez votre email" name="mail">
                        <?= validation_show_error('mail') ?>
                    </div>
                </div>


                <div class="form-group">
                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                        <button type="submit" class="btn btn-primary btn-lg" name="submit">Enrigistrer</button>
                    </div>


                </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
</br></br></br>
