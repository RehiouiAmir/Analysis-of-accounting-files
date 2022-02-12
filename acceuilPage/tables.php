
<!-- Connextion php -->
<?php 
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ephcompta";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  ?>
  <!-- Selection tt les tables-->
  <?php 
  /* Charges */
  $sql_c = "SHOW TABLES FROM $dbname  WHERE Tables_in_$dbname LIKE '%_Chg'";
  $result_c = mysqli_query($conn, $sql_c);

  /*Activite */
  $sql_a = "SHOW TABLES FROM $dbname WHERE Tables_in_$dbname LIKE '%_Act'";
  $result_a = mysqli_query($conn, $sql_a);
?>

<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <title>Tables | Panneau Admin</title>
  
    <link rel="stylesheet" href="../css/normalize.min.css"></link>
    <link rel='stylesheet' href='../css/bootstrap.min.css'></link>
    <link rel='stylesheet' href='../css/animate.min.css'></link>
    

    <link rel="stylesheet" href="../css/style.css?version=2020"></link>

  
</head>

<body>

<body class="sidebar-is-reduced">
  <header class="l-header">
    <div class="l-header__inner clearfix">
      <div class="c-header-icon js-hamburger">
        <div class="hamburger-toggle"><span class="bar-top"></span><span class="bar-mid"></span><span class="bar-bot"></span></div>
      </div>
      <div class="c-search">
      <!-- Tilte de projet -->
      </div>
      <div class="header-icons-group">
        <div class="c-header-icon basket"><span class="c-badge c-badge--blue c-badge--header-icon animated swing">0</span><i class="fa fa-shopping-basket"></i></div>
        <div class="c-header-icon logout"><i class="fa fa-power-off"></i></div>
      </div>
    </div>
  </header>
  <div class="l-sidebar">
    <div class="logo">
      <div class="logo__txt">EPH</div>
    </div>
    <div class="l-sidebar__content">
      <nav class="c-menu js-menu">
        <ul class="u-list">
          <a href="../acceuil.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Acceuil">
            <div class="c-menu__item__inner"><i class="fa fa-home"></i>
              <div class="c-menu-item__title"><span>Acceuil</span></div>
            </div>
          </li>
          <a href="tables.php" style="text-decoration: none;"><li class="c-menu__item is-active" data-toggle="tooltip" title="Tables">
            <div class="c-menu__item__inner"><i class="fa fa-table"></i>
              <div class="c-menu-item__title"><span>Tables</span></div>
            </div>
          </li></a>
          <a href="rapports.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Rapports">
            <div class="c-menu__item__inner"><i class="fa fa-file-pdf"></i>
              <div class="c-menu-item__title"><span>Rapports</span></div>
            </div>
          </li></a>
          <a href="administration.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Administration ">
            <div class="c-menu__item__inner"><i class="fa fa-laptop"></i>
              <div class="c-menu-item__title"><span>Administration </span></div>
            </div>
          </li></a>
          <a href="Statistiques.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Statistiques">
            <div class="c-menu__item__inner"><i class="far fa-chart-bar"></i>
              <div class="c-menu-item__title"><span>Statistiques</span></div>
            </div>
          </li></a>
          <a href="parametres.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Paramètres">
            <div class="c-menu__item__inner"><i class="fa fa-cogs"></i>
              <div class="c-menu-item__title"><span>Paramètres</span></div>
            </div>
          </li></a>
        </ul>
      </nav>
    </div>
  </div>
</body>
<main class="l-main">
  <div class="content-wrapper content-wrapper--with-bg">
    <h1 class="page-title">Gestion des Tables</h1>
    <div class="page-content row css-table" >
      <div class="col-sm-4">
     
        <table class="table">

          <thead class="table__header">
            <tr class="table__row">
              <th class="table__cell u-text-center" colspan=5>CHARGES</th>
            </tr>
          </thead>

          <tbody>
          <?php
              while($row_c = mysqli_fetch_row($result_c)){
                $table= str_replace('_chg','',$row_c[0]);
                      echo "
                        <tr class='table__row'>
                          <td class='table__account table__cell'>
                            <p href='' class='table__account-content table__link '><span class='table__account-name'>".$table."</span>
                            </p>
                          </td>";
                          if($table!='a4'){echo"<form action='../gestionTables/charges/insertion_chg.php' method='get'>";}
                          else {echo"<form action='../gestionTables/charges/insertion_chg_coutRepas.php' method='get'>";}
                      echo"
                          <input type='hidden' value='".$row_c[0]."' name='table'>
                          <td class='table__transfer table__cell u-text-center'><input type='submit' value='Insertion' class='btn-tables'></td>
                          </form>
                          <form action='../gestionTables/charges/maj_chg.php' method='get'>
                          <input type='hidden' value='".$row_c[0]."' name='table'>
                          <td class='table__transfer table__cell'><input type='submit' value='Mise à jour' class='btn-tables'></td>
                          </form>    
                        </tr>              
                    ";
          }
          ?>
          </tbody>
      
          <tfoot>
            <tr class="table__row table__row--last">
            <td class="table__cell" align="center"></td>
            </tr>
          </tfoot>

        </table>
      </div>
      <div class="col-sm-4">
        <table class="table">

          <thead class="table__header">
            <tr class="table__row">
              <th class="table__cell u-text-center" colspan=5>ACTIVITES</th>
            </tr>
          </thead>
      
          <tbody>
          <?php
            while($row_a = mysqli_fetch_row($result_a)){
              $table= str_replace('_act','',$row_a[0]);              
            echo "
            <tr class='table__row'>
              <td class='table__account table__cell'>
                <p href='' class='table__account-content table__link '><span class='table__account-name'>".$table."</span>
                </p>
                </td>
                <form action='../gestionTables/activitees/insertion_act.php' method='get'>
                <input type='hidden' value='".$row_a[0]."' name='table'>
                <td class='table__transfer table__cell u-text-center'><input type='submit' value='Insertion' class='btn-tables'></td>
                </form>
                <form action='../gestionTables/activitees/maj_act.php' method='get'>
                <input type='hidden' value='".$row_a[0]."' name='table'>
                <td class='table__transfer table__cell'><input type='submit' value='Mise à jour' class='btn-tables'></td>
                </form>    
              </tr>              
          ";}
          ?>
            </tbody>
      
          <tfoot>
            <tr class="table__row table__row--last">
            <td class="table__cell" align="center"></td>
            </tr>
          </tfoot>

        </table>
      </div>
      <div class="col-sm-4">
          <table class="table">
              
                        <thead class="table__header">
                          <tr class="table__row">
                            <th class="table__cell u-text-center" colspan=5>REPARTITION</th>
                          </tr>
                        </thead>
                    
                        <tbody>
                            <tr class="table__row">
                              <td class="table__account table__cell">
                                <p href="#" class="table__account-content table__link "><span class="table__account-name">C1</span>
                                </p>
                              </td>
                              <td class="table__transfer table__cell u-text-center"><a class="btn-tables" href="">Mise à jour</a></td>
                              <td class="table__transfer table__cell u-text-center"><a class="btn-tables" href="">Insertion</a></td>
                            </tr>
                          </tbody>
                    
                        <tfoot>
                          <tr class="table__row table__row--last">
                          <td class="table__cell" align="center"></td>
                          </tr>
                        </tfoot>
              
                      </table>
      </div>
    </div>
  </div>
</main>
<script src='../js/jquery.min.js'></script>
<script src='../js/all.js'></script> 
<script src='../js/bootstrap.min.js'></script>

    <script  src="../js/index.js"></script>




</body>

</html>
