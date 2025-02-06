


<section class="pb-4">
  <div class="bg-white border rounded-5">
    
    <section class="p-5 w-100" style="background-color: #f6f7ff; border-radius: .5rem .5rem 0 0;">
      <div class="row">
        <div class="col-12">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-5 mt-4"><?php echo $titre; ?></p>
                  <?= session()->getFlashdata('error') ?>
					<?php echo form_open('/compte/connecter'); ?>
					 <?= csrf_field() ?>
					
                    <strong><p style="color:#FF0000;"><?php echo $le_message; ?></p></strong>
                  

				    <div class="form-group">
				    	<div class="d-flex flex-row align-items-center mb-4">
                     		 <div class="form-outline flex-fill mb-0">
						        <label class="control-label col-sm-2" for="email"style="color:#0d6efd; ">Pseudo : </label>
						        <div class="col-sm-10">
						            <input type="text" class="form-control" id="email" placeholder="Entrez votre pseudo" name="pseudo">
						        </div>
						        <?= validation_show_error('pseudo') ?>
						        <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 68px;"></div><div class="form-notch-trailing"></div></div>
							</div>
						</div>
				    </div>

				    <div class="form-group">
				    	<div class="d-flex flex-row align-items-center mb-4">
                     		 <div class="form-outline flex-fill mb-0">
						        <label class="control-label col-sm-2" for="mdp" style="color:#0d6efd; ">Mot de passe : </label>
						        <div class="col-sm-10">
						            <input type="password" class="form-control" id="pwd" placeholder="Entrez votre mot de passe" name="mdp">
						        </div>
						        <?= validation_show_error('mdp') ?>
						        <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 68px;"></div><div class="form-notch-trailing"></div></div>
							</div>
						</div>
				    </div>


				    <div class="form-group">
				        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      		<button type="submit" class="btn btn-primary btn-lg" name="submit">Se connecter</button>
                    	</div>
				    </div>
                  </form>

                </div>
                <div class="col-md-10 col-lg-5 col-xl-6 d-flex align-items-center order-1 order-lg-2">

                  <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" alt="Sample image">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    
    
    
    
  </div>
</section>