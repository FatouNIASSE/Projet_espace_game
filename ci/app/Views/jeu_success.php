</br></br></br>
<div class="container-fluid py-8 custom-container" style="width: 1000px;">
    <div class="card text-center" style="background-color: #e9ecefde;">
        <div class="card-body p-3">
            <div class="card border-success mx-auto text-center mt-5" style="max-width: 30rem;">
                <div class="card-header bg-success text-white">
                    <h3>Félicitations <?php echo $participant; ?> 🥇</h3>
                </div>
                <div class="card-body text-success">
                    <p class="card-text">Vous avez accompli avec succès toutes les étapes du scénario 👏</p>
                </div>
                
            </div>
        </div>
    </div>
</div>
</br></br></br>

<?php
header("refresh:5;url=" . base_url() . "index.php/scenario/afficher_galerie");
?>