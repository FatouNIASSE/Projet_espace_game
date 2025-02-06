<?php
$session=session();
if ($_SESSION['role'] != 'A') {
    header("Location: " . base_url() . "index.php/compte/connecter");
    exit(); // Assurez-vous de terminer le script après la redirection
} else{
?>
<!-- ======= table des compte ======= -->
<div class="container-fluid py-8 custom-container" style="width: 1000px;">
    <div class="card text-center" style="background-color: #e9ecefde;">
        <div class="card-body p-3">
            <div class="col-xl-13 col-sm-13 mb-xl-0 mb-4 mx-auto" >

        <?php 
        if (! empty($logins) && is_array($logins)) {
        ?>
        <div class="text-center">
            <h1 style="background-color: #f2f2f2; color : #242326e3; margin-top: 20px;"><?php echo $titre; ?></h1>
            <br>
            <a href="<?php echo base_url() . "index.php/compte/creer"; ?>">
                <button type="submit" class="btn btn-primary mb-2">Ajouter un nouveau compte</button>
            </a>
            <br>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" style="background-color: #fff; margin-top: 30px">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center; padding: 10px; background-color: #333; color: #ecc56a;">Nom</th>
                        <th style="text-align: center; padding: 10px; background-color: #333; color: #ecc56a;">Prenom</th>
                        <th style="text-align: center; padding: 10px; background-color: #333; color: #ecc56a;">Role</th>
                        <th style="text-align: center; padding: 10px; background-color: #333; color: #ecc56a;">Validite</th>
                        <th style="text-align: center; padding: 10px; background-color: #333; color: #ecc56a;">Login</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($logins as $pseudos){
                    ?>
                    <tr>
                        <td style="text-align: center; padding: 10px;"><?php echo $pseudos["PRO_nom"]; ?></td>
                        <td style="text-align: center; padding: 10px;"><?php echo $pseudos["PRO_prenom"]; ?></td>
                        <td style="text-align: center; padding: 10px;"><?php echo $pseudos["PRO_role"]; ?></td>
                        <td style="text-align: center; padding: 10px;"><?php echo $pseudos["PRO_validite"]; ?></td>
                        <td style="text-align: center; padding: 10px;"><?php echo $pseudos["CPT_login"]; ?></td>
                        <td>
                        <a href="#"><i class="fas fa-toggle-on" style=" color: #16ba32;"></i>/<i class="fas fa-toggle-off" style=" color: #db2914;"></i></a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        } else {
            echo "<br />";
            echo("<h3>Aucun compte pour le moment</h3>");
        }
        ?>
   

   </div>
   </div>
   </div>
   </div> 
</section><!-- End table des compte-->
<?php } ?>