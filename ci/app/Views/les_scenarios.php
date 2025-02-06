<!-- ======= Galerie des Scénarios ======= -->
<section id="scenarios" class="scenarios" >
    <div class="container">
        <?php 
        if (!empty($sce) ) {
        ?>
        <h1 style="text-align: center; background-color: #f2f2f2; color : #f40b0b; "><?php echo $titre;?></h1>
        </br>
        <marquee>
            <h1><span class="" style="color: rgb(239, 69, 64);"> ATTENTION(Message aux participants) : RÉPONDRE EN MAJUSCULES</span></h1>
        </marquee>
        <div class="row">
            <?php
            foreach ($sce as $scenario) {
            ?>
             <!-- Gallery item -->
             <div class="col-lg-6 col-md-6 d-flex align-items-stretch mb-5" style="margin-top: 40px;">
                    <div class="rounded shadow-sm" style="background-color: #f2e4e4;">
                        <img src="<?php echo base_url() . "images_scenario/" . $scenario['SCE_image']; ?>" alt="" class="img-fluid card-img-top">
                        <div class="p-4">
                            <h5 class="text-dark"><?php echo $scenario['SCE_intituler']; ?></h5>
                            <p class="small text-muted mb-0">
                                Niveau de Difficulté :
                                <span><a href="<?php echo base_url() . "index.php/scenario/afficher_etapes/" . $scenario['SCE_code'] . "/1"; ?>" class="facile" style="color: green;">Facile</a></span></br>
                                Niveau de Difficulté :
                                <span><a href="<?php echo base_url() . "index.php/scenario/afficher_etapes/" . $scenario['SCE_code'] . "/2"; ?>" class="moyen" style="color: orange;">Moyen</a></span></br>
                                Niveau de Difficulté :
                                <span><a href="<?php echo base_url() . "index.php/scenario/afficher_etapes/" . $scenario['SCE_code'] . "/3"; ?>" class="difficile" style="color: red;">Difficile</a></span>
                            </p>
                            <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-5 py-2 mt-4" style="background-color: #f2f2f2;">
                                <p class="small mb-0" ><span class="font-weight-bold">Auteur : <?php echo $scenario['Auteur']; ?></span></p>
                            </div>
                        </div>
                    </div>
            </div>

            <?php
            }
            ?>
        </div>
        <?php
        } else {
             echo "<br />"; ?>
            <strong><h1 style="color:#FF0000;"><?php echo "Aucun scénario disponible pour le moment." ?></h1></strong> <?php
        }
        ?>
    </div>
</section><!-- End Galerie des Scénarios -->

