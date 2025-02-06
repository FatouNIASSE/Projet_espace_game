
<div class="container-fluid py-8 custom-container" style="width: 1000px;">
    <div class="card text-center" style="background-color: #e9ecefde;">
        <div class="card-body p-3">

			<div class="card border-primary mx-auto text-center mt-5 d-flex flex-column align-items-center" style="max-width: 80rem;">
			    <div class="card-body text-secondary">
			        <br>
			        <h4 class="card-title" style="color: #f40b0b;">Bravo ! Formulaire rempli, le compte suivant a été ajouté :</h4>

			        <h5>Le pseudo :<?php echo $le_compte; ?></h5>
			        <h5><?php echo $le_message ?> <?php echo $le_total; ?></h5>
			    </div>
			</div>
		</div>
	</div>
</div>

<?php
header("refresh:5;url=" . base_url() . "index.php/compte/lister");
?>

</body>
</html>
