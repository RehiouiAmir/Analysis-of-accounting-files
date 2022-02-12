<!-- Connextion php -->
<?php 
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ephcompta";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
?>
<!-- Get le nom de table -->
<?php $table=($_GET['table']);
      $table_DATA= $table."_DATA";
      $sup=false;
      $mod=false;
    ?>
<!-- Request d'affichage -->
<?php 
  /* nbr des columns de table */
      $sql= "SELECT COUNT(*) AS nbr FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_DATA'";
      $result= mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      $nbrColum= $row["nbr"]-3;
  /* SELECT les nom des columns de table */
      $sql1= "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_DATA'";
  /* DELETE dATA from Table */
  if(isset($_GET['sup_col1']))  {
    $sup_col1=($_GET['sup_col1']);
    $sup_col2=($_GET['sup_col2']);
    $sup_col3=($_GET['sup_col3']);
    $i=0;
    $col= array(); 
    $result1= mysqli_query($conn, $sql1);
    while ( $i<$nbrColum and $row1 = mysqli_fetch_assoc($result1)){$i=$i+1;}
    $i=0;
    while ($row1 = mysqli_fetch_assoc($result1)){$col[$i]=$row1['COLUMN_NAME'];$i=$i+1;}
      if($table!='a9_chg'){
        $test_sql= "SELECT * FROM ".$table." where ".$col[0]."=".$sup_col1." AND ".$col[1]."=".$sup_col2." AND ".$col[2]."=". $sup_col3." ; ";
        $test_result= mysqli_query($conn, $test_sql);
        while ($test_row = mysqli_fetch_row($test_result)){
            $sup_sql = "DELETE FROM ".$table." where ".$col[0]."=".$sup_col1." AND ".$col[1]."=".$sup_col2." AND ".$col[2]."=". $sup_col3." ; "; 
            $sup_result = mysqli_query($conn, $sup_sql);
            $sup=true;
          }
      }
      // charge commune table deleted
      else{
        $test_sql= "SELECT * FROM ".$table." where ".$col[0]."=".$sup_col1." AND ".$col[1]."=".$sup_col2." ;";
        $test_result= mysqli_query($conn, $test_sql);
        while ($test_row = mysqli_fetch_row($test_result)){
            $sup_sql = "DELETE FROM ".$table." where ".$col[0]."=".$sup_col1." AND ".$col[1]."=".$sup_col2." ; "; 
            $sup_result = mysqli_query($conn, $sup_sql);
            $sup=true;
          }
      }
    } 
  // EDIT table 
    if(isset($_GET['mod_col1']))  {
      $mod_col1=($_GET['mod_col1']);
      $mod_col2=($_GET['mod_col2']);
      $mod_col3=($_GET['mod_col3']);
      $val_mod_col1=($_GET['val_mod_col1']);
      // select colum Montant
      $mt_sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table'";
      $mt_result=mysqli_query($conn, $mt_sql);
      while ($mt_row = mysqli_fetch_assoc($mt_result)){$mt_col=$mt_row['COLUMN_NAME'];}   
      $i=0;
      $col= array(); 
      $result1= mysqli_query($conn, $sql1);
      while ( $row1 = mysqli_fetch_assoc($result1) and $row1['COLUMN_NAME']!='Annee' ){$i=$i+1;}
      $i=0;
      while ($row1 = mysqli_fetch_assoc($result1)){$col[$i]=$row1['COLUMN_NAME'];$i=$i+1;} 
      // verification de modifation 
      if($table=='a1_chg' or $table=='a4_chg'){
        if($table=='a1_chg'){$mod_col='effectif';}else{$mod_col='nbrerepas';}
        $test_sql= "SELECT * FROM ".$table." where ".$col[2]."=".$mod_col1." AND ".$col[3]."=".$mod_col2." AND ".$col[4]."=". $mod_col3." ; "; 
        $test_result= mysqli_query($conn, $test_sql);
        $test_row = mysqli_fetch_assoc($test_result);
        if($table=='a1_chg'){          
        $val_mod_col2=($_GET['val_mod_col2']);}
        if($table=='a4_chg'){
          $sql_egal_cout="SELECT * FROM coutdesigna4 where codePeriode=".$mod_col3." ";
          $result_egal_cout= mysqli_query($conn, $sql_egal_cout);
          $row_egal_cout=mysqli_fetch_assoc($result_egal_cout);
          $val_mod_col2=($row_egal_cout['mtA4Globale']/$row_egal_cout['nbreRepasGlobale'])*$val_mod_col1;
        }
        if($test_row[$mod_col] != $val_mod_col1 or $test_row[$mt_col] != $val_mod_col2) {     
          $mod_sql = "UPDATE ".$table." SET ".$mod_col."='".$val_mod_col1."' ,".$mt_col."='".$val_mod_col2."' where ".$col[2]."=".$mod_col1." AND ".$col[3]."=".$mod_col2." AND ".$col[4]."=". $mod_col3." ; "; 
          $mod=true;
          $mod_result = mysqli_query($conn, $mod_sql);                
        }
      }else if($table=='a9_chg'){
        $test_sql= "SELECT * FROM ".$table." where ".$col[1]."=".$mod_col1." AND ".$col[2]."=".$mod_col2." ; "; 
        $test_result= mysqli_query($conn, $test_sql);
        $test_row = mysqli_fetch_assoc($test_result);
        if( $test_row[$mt_col] != $val_mod_col1) {             
          $mod_sql = "UPDATE ".$table." SET ".$mt_col."='".$val_mod_col1."' where ".$col[1]."=".$mod_col1." AND ".$col[2]."=".$mod_col2." ; ";
          $mod=true;
          $mod_result = mysqli_query($conn, $mod_sql);                
        }
      }else {
        $test_sql= "SELECT * FROM ".$table."  where ".$col[1]."=".$mod_col1." AND ".$col[2]."=".$mod_col2." AND ".$col[3]."=". $mod_col3." ;  "; 
        $test_result= mysqli_query($conn, $test_sql);
        $test_row = mysqli_fetch_assoc($test_result);
        if( $test_row[$mt_col] != $val_mod_col1) { 
          $mod_sql = "UPDATE ".$table." SET ".$mt_col."='".$val_mod_col1."' where ".$col[1]."=".$mod_col1." AND ".$col[2]."=".$mod_col2." AND ".$col[3]."=". $mod_col3." ; ";       
          $mod=true;
          $mod_result = mysqli_query($conn, $mod_sql);        
        }
      }
    }
  /* SELECT FRom TABLe */
      $sql2= "SELECT * FROM $table_DATA";
      $result2= mysqli_query($conn, $sql2);
?>
<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <title>Tables-MAJ | Panneau Admin</title>
  
    <lin rel="stylesheet" href="../../css/normalize.min.css"></link>
    <link rel='stylesheet' href='../../css/bootstrap.min.css'></link>
    <link rel='stylesheet' href='../../css/animate.min.css'></link>
    
    <link rel="stylesheet" href="../../css/style.css?version=100"></link>

  
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
            <a href="../../acceuil.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Acceuil">
              <div class="c-menu__item__inner"><i class="fa fa-home"></i>
                <div class="c-menu-item__title"><span>Acceuil</span></div>
              </div>
            </li>
            <a href="../../acceuilPage/tables.php" style="text-decoration: none;"><li class="c-menu__item is-active" data-toggle="tooltip" title="Tables">
              <div class="c-menu__item__inner"><i class="fa fa-table"></i>
                <div class="c-menu-item__title"><span>Tables</span></div>
              </div>
            </li></a>
            <a href="../../acceuilPage/rapports.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Rapports">
              <div class="c-menu__item__inner"><i class="fa fa-file-pdf"></i>
                <div class="c-menu-item__title"><span>Rapports</span></div>
              </div>
            </li></a>
            <a href="../../acceuilPage/administration.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Administration ">
              <div class="c-menu__item__inner"><i class="fa fa-laptop"></i>
                <div class="c-menu-item__title"><span>Administration </span></div>
              </div>
            </li></a>
            <a href="../../acceuilPage/statistiques.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Statistiques">
              <div class="c-menu__item__inner"><i class="far fa-chart-bar"></i>
                <div class="c-menu-item__title"><span>Statistiques</span></div>
              </div>
            </li></a>
            <a href="../../acceuilPage/parametres.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Paramètres">
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
            <?php
               // Alert de supression 
                if($sup==true){
                  echo "<div class='alert-sup alert-success' role='alert' >
                        <strong>Succès!</strong> <br>
                        La suppression a été effectuée avec succès!<br>
                        <img src='../../images/trash.png' alt='' title='' border='0' />
                        </div>";
                }
               // Alert de modification
               if($mod==true){
                echo "<div class='alert-sup alert-success' role='alert' >
                      <strong>Succès!</strong> <br>
                      La modification a été effectuée avec succès!<br>
                      <img src='../../images/user_edit.png' alt='' title='' border='0' />
                      </div>";
                }
              ?>
          <div class="table_content">
            <?php 
                $table_name= str_replace('_chg','',$table);
                echo "<h2>Mettre à jour la table [ ".$table_name." ]</h2>"
              ?>
            <div class=" demo">

              <table id= "table-id" class="datatable">
                <thead>
                  <tr>
                    <th scope="row" class="rounded-company"></th>
                    <!-- Affichage des columns de table -->
                    <?php
                        $result1= mysqli_query($conn, $sql1);                      
                        $i=0;
                        while ($row1 = mysqli_fetch_assoc($result1) and $i<$nbrColum){
                          echo "<th scope='row' class='rounded'>".$row1['COLUMN_NAME']."</th>";
                          $i=$i+1;
                        }
                      ?>
                      <th scope="col">Edit</th>
                      <th scope="col" class="rounded-q4">Delete</th>
                    </tr>

                </thead>
                <tbody>
                
                  <!-- Affichage des données de table -->
                  <?php
                      $mod=0;
                      $i=0;                                                                
                      while ($row2 = mysqli_fetch_row($result2)){
                        $result1= mysqli_query($conn, $sql1);
                        echo "<tr>
                              <td><input type='checkbox' name='' /></td>
                          ";
                          do {
                              $n=0;
                              while($n<$nbrColum){
                                $n=$n+1;
                              }
                            echo " 
                                <td class='cle_edit'>".$row2[$i]."
                                    <input type='hidden' class='1 hidden' value='".$row2[$n]."'>
                                    <input type='hidden' class='2 hidden' value='".$row2[$n+1]."'>
                                    <input type='hidden' class='3 hidden' value='".$row2[$n+2]."'>                                  
                                  </td>
                              ";
                                $i=$i+1;
                          } while ($row1 = mysqli_fetch_assoc($result1) and $row1['COLUMN_NAME']!='Annee');
                          while ($row1 = mysqli_fetch_assoc($result1) and $i<$nbrColum){
                            if($table_name=='a4' and $row1['COLUMN_NAME']=='Montant'){
                              $row2[$i]=number_format($row2[$i], 2, ',', ' ');
                              echo "
                              <td>".$row2[$i]."</td>
                                ";
                            }else{
                              echo "
                              <td class='edit'>".$row2[$i]."</td>
                                ";
                            }
                            
                            $i=$i+1;
                          }
                    ?>
                        <td>
                          <a id="bEdit"  style="text-decoration:none;" onclick="rowEdit(this);">
                            <img src="../../images/user_edit.png" alt="" title="" border="0"/>
                          </a>
                          <a  id="bAcep"  style="text-decoration:none;display:none;" onclick="rowAcep(this);">
                            <img src="../../images/confirm.png" alt="" title="" border="0"/>
                          </a><br>
                        <a id="bCanc"  style="display:none;" onclick="rowCancel(this);">
                            <img src="../../images/user_logout.png" alt="" title="" border="0"/>
                          </a>
                        </td>
                    <?php
                        echo "
                              <td>
                                <a class='ask' href='maj_chg.php?table=".$table."&sup_col1=".$row2[$i]."&sup_col2=".$row2[$i+1]."&sup_col3=".$row2[$i+2]."'>
                                  <img src='../../images/trash.png' alt='' title='' border='0' />
                                </a>
                              </td>
                          ";
                          $i=0;                                                
                      }
                    ?>
                    </tr>
                    
                  </tbody>
              </table>
              <input type="hidden" id="name_table" value="<?php echo"".$table."";?>">

              <a href="#" class="bt_red"><span class="bt_red_lft"></span><strong>Supprimer</strong><span class="bt_red_r"></span></a> 
              <a href="#" class="bt_blue"><span class="bt_blue_lft"></span><strong>Éditer</strong><span class="bt_blue_r"></span></a>
              <a href="<?php echo"insertion_chg.php?table=".$table."";?>" class="bt_green"><span class="bt_green_lft"></span><strong>Insérer</strong><span class="bt_green_r"></span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  <!-- script -->

  <script src='../../js/jquery.min.js'></script>
  <script src='../../js/all.js'></script> 
  <script src='../../js/bootstrap.min.js'></script>
  <!-- Table -->
      <script type="text/javascript">	$(document).ready(function() {
          $('.ask').jConfirmAction();
      });
  </script>
  <!-- edité Table -->
  <script src="../../js/index-mod-chg.js"></script>
    <script>
    $('table').SetEditable();
    </script>
<!--/.container.demo -->
<script src='../../js/jquery.dataTables.min.js'></script>

      <script src="../../js/index-table.js"></script>
      <script  src="../../js/index.js"></script>
      
  </body>

</html>
