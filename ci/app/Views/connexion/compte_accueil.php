<?php
$session=session();
if ($_SESSION['role'] != 'A' ) {
    header("Location: " . base_url() . "index.php/compte/connecter");
    exit(); // Assurez-vous de terminer le script après la redirection
} else{
?>

<div class="container-fluid py-8 custom-container" style="width: 1000px;">
    <div class="card text-center" style="background-color: #e9ecefde;">
        <div class="card-body p-3">

            <div class="col-xl-13 col-sm-13 mb-xl-0 mb-4 mx-auto">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row justify-content-center">
                            <div class="col-6"> <!-- Adjusted col-8 to col-6 -->
                                <div class="numbers">
                                    <img src="<?php echo base_url() . "images/" . "$adm->PRO_img"; ?>" style="max-width: 150px; max-height: 150px; alt="" "></br></br></br>
                                    <h2 class="font-weight-bolder">
                                        Espace d'administration
                                    </h2>
                                    <h6 class="font-weight-bolder" style="color:rgb(0, 176, 80)">
                                        Session ouverte ! </br><h4>Bienvenue
                                        <?php
                                        $session = session();
                                        echo $session->get('user');
                                        ?> !</h4>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php } ?>