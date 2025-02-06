  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container d-flex flex-column align-items-center justify-content-center" ">
      <h1>👉 LE MONDE DES GENIES 🧞‍♀️</h1>
      <h2>Explorez un univers envoutant peuplé de génies et de merveilles 🥳</h2>
      <a href="<?php echo base_url();?>index.php/scenario/afficher_galerie" class="btn-get-started scrollto">JOUER</a>
      <img src="<?php echo base_url();?>bootstrap/assets/img/hero-img.png" class="img-fluid hero-img" alt=""  width="400 px">
    </div>

  </section><!-- End Hero -->

 
  <!-- ======= table des actualite ======= -->
  <div class="container">
        <?php 
        if ($actu != NULL) {
        ?>
        <h1 style="text-align: center; background-color: #f2f2f2; color : #f40b0b; margin-top: 20px "><?php echo $titre;?></h1>
        <div class="table-responsive">
            <table class="table table-bordered" style="background-color: #f40b0b; margin-top: 30px">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center; padding: 10px; background-color: #333; color: #ecc56a;">Intitule</th>
                        <th style="text-align: center; padding: 10px; background-color: #333; color: #ecc56a;">News</th>
                        <th style="text-align: center; padding: 10px; background-color: #333; color: #ecc56a;">Date</th>
                        <th style="text-align: center; padding: 10px; background-color: #333; color: #ecc56a;">Auteurs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($actu as $login) {
                    ?>
                    <tr>
                        <td style="text-align: center; padding: 10px;"><?php echo $login["ACT_intitule"]; ?></td>
                        <td style="text-align: center; padding: 10px;"><?php echo $login["ACT_description"]; ?></td>
                        <td style="text-align: center; padding: 10px;"><?php echo $login["ACT_date"]; ?></td>
                        <td style="text-align: center; padding: 10px;"><?php echo $login["Auteur"]; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        } else {
            echo "<br />"; ?>
            <strong><h1 style="color:#FF0000;"><?php echo "Aucune Actualite pour le moment" ?></h1></strong> <?php
        }
        ?>
    </div>

    
</section><!-- End table des actualite-->
