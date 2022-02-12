<!-- Connextion php -->
<?php 
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ephcompta";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
?>
<!-- GET variable -->
<?php 
    // declaration variable 
    $ligne_insert=false;
    $ligne_update=false;
    $nbr_ligne_insert=0;
    $nbr_ligne_update=0;
    //Get le nom de table 
    $table=($_GET['table']);
    $table_DATA= $table."_data";
    $table_name=str_replace('_chg','',$table); 
    $suivant=false;
    if(isset($_GET['periode_cout']))  {
      $periode=($_GET['periode_cout']);
      $mois_sem=($_GET['mois_sem']);
      $annee=($_GET['annee']);
      $suivant=true;
      if ($periode=='Mensuel'){
          if($mois_sem==1){$mois_sem='Janvier';}
          else if($mois_sem==2){$mois_sem='Fevrier';}
          else if($mois_sem==3){$mois_sem='Mars';}
          else if($mois_sem==4){$mois_sem='Avril';}
          else if($mois_sem==5){$mois_sem='Mai';}
          else if($mois_sem==6){$mois_sem='Juin';}              
          else if($mois_sem==7){$mois_sem='Juillet';}
          else if($mois_sem==8){$mois_sem='Aout';}
          else if($mois_sem==9){$mois_sem='Septembre';}
          else if($mois_sem==10){$mois_sem='Octobre';}
          else if($mois_sem==11){$mois_sem='Novembre';}              
          else if($mois_sem==12){$mois_sem='Decembre';}
     }
  }
  // Get variable pour l'ajout et ajouter A4
  if(isset($_GET['codePeriode'])){
    $coutRepas=($_GET['coutRepas']);
    $codePeriode=($_GET['codePeriode']);
    $codeDesign=($_GET['codeDesign']);
      for ($i = 0; $i <= 19; $i++) {
        $codeSce[$i]=($_GET['codeSce'.$i.'']);
        $val_Ef_Rp[$i]=($_GET['val_Ef_Rp'.$i.'']);
      }
    // function insert
    $n=19;
    for ($i = 0; $i <= $n; $i++) {
      if($val_Ef_Rp[$i]!=0){ 
        $sql_exist="SELECT COUNT(*) AS verif_exist FROM ".$table." 
        where codeSce=".$codeSce[$i]." and codePeriode=".$codePeriode." and codeDesign".$table_name."=".$codeDesign." ;";
        $result_exist= mysqli_query($conn, $sql_exist);
        $row_exist=mysqli_fetch_assoc($result_exist);
        if($row_exist['verif_exist']==0){
            $mta4=$coutRepas*$val_Ef_Rp[$i];      
            $sql_ajouter="INSERT INTO ".$table." VALUES ('".$codeSce[$i]."', '".$codePeriode."','".$codeDesign."','".$val_Ef_Rp[$i]."','".$mta4."')";
            $result_ajouter= mysqli_query($conn, $sql_ajouter);
            $ligne_insert=true;
            $nbr_ligne_insert=$nbr_ligne_insert+1;           
        }else{
          $sql_egal="SELECT nbrerepas FROM ".$table." 
          where codeSce=".$codeSce[$i]." and codePeriode=".$codePeriode." and codeDesign".$table_name."=".$codeDesign." ;";
          $result_egal= mysqli_query($conn, $sql_egal);
          $row_egal=mysqli_fetch_assoc($result_egal);
          if ($row_egal['nbrerepas']!= $val_Ef_Rp[$i]){
            $mta4=$coutRepas*$val_Ef_Rp[$i];                  
            $sql_mod="UPDATE ".$table." SET nbrerepas='".$val_Ef_Rp[$i]."' ,mt".$table_name."='".$mta4."' 
            where  codeSce=".$codeSce[$i]." and codePeriode=".$codePeriode." and codeDesign".$table_name."=".$codeDesign." ;";
            $result_mod= mysqli_query($conn, $sql_mod);
            $ligne_update=true;
            $nbr_ligne_update=$nbr_ligne_update+1;
            }
        }
      }
    }
  } 
    
?>
<!-- Ajouté depense globale et nbr de repas globale -->
<?php
if($suivant==true){
  //select code periode 
  if($periode=='Mensuel'){
        $sql_periode="SELECT code_periode FROM periode where typePeriode='".$periode."' and nomPeriode='".$mois_sem."' and anneePeriode='".$annee." ';";
      } else { $sql_periode="SELECT code_periode FROM periode where typePeriode='".$periode."' and numPeriode='".$mois_sem."' and anneePeriode='".$annee." ';";}
      $result_periode= mysqli_query($conn, $sql_periode);
      $row_periode= mysqli_fetch_assoc($result_periode);
      //select 
      $sql_global="SELECT nbreRepasGlobale,mtA4Globale FROM coutdesigna4 where codePeriode=".$row_periode['code_periode'].";";
      $result_global= mysqli_query($conn, $sql_global);
      $row_global= mysqli_fetch_assoc($result_global);
  }

?>

<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <title>Tables-Insertion | Panneau Admin</title>
  
    <lin rel="stylesheet" href="../../css/normalize.min.css"></link>
    <link rel='stylesheet' href='../../css/bootstrap.min.css'></link>
    <link rel='stylesheet' href='../../css/animate.min.css'></link>
    <link rel='stylesheet' href='../../css/bootstrap-datepicker.css'>
  
    <link rel="stylesheet" href="../../css/style-insert.css?version=2000">
    <link rel="stylesheet" href="../../css/style.css?version=10000"></link>

  
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
        <div class="page-content row" >
          <?php
                // Alert de l'insertion ou l'update
                if($nbr_ligne_insert==1){$string_insert="Ligne a été insérée";}else{$string_insert="Lignes ont été insérées";}
                if($nbr_ligne_update==1){$string_update="Ligne a été modifiée";}else{$string_update="Lignes ont été modifiées";}
                if($ligne_insert==true and $ligne_update==true){
                    echo "<div class='alert-sup alert-success' role='alert' >
                    <strong>Succès!</strong> <br>
                    ".$nbr_ligne_insert." ".$string_insert." et ".$nbr_ligne_update." ".$string_update." avec succès!<br>
                    </div>";
                  } 
                  else if($ligne_insert==true){
                    echo "<div class='alert-sup alert-success' role='alert' >
                          <strong>Succès!</strong> <br>
                          ".$nbr_ligne_insert." ".$string_insert."  avec succès!<br>
                          </div>";
                  }else if ($ligne_update==true){
                    echo "<div class='alert-sup alert-success' role='alert' >
                    <strong>Succès!</strong> <br>
                    ".$nbr_ligne_update." ".$string_update." avec succès!<br>
                    </div>";
                  }
          ?>
          <div class="table_content">
            <?php 
                echo "<h2>L'insertion de données dans la table  [ ".$table_name." ]</h2>
                        <h2 style='font-size:16px;'>[ calcule Coût du repas ]</h2>";
              
                if($suivant==false){echo"<form autocomplete='off' action='insertion_chg_coutRepas.php'>";}
                else{echo"<form autocomplete='off' action='insertion_chg.php'>";}
            ?>
            <div class="contentform">
                
                <div class="leftcontact">
                    <h1>Période</h1>
                    <?php 
                        if($suivant==false){
                          echo"
                                <select class='form-control' onchange='showDiv(this)' name='periode_cout'>
                                <option value='Mensuel'>Mensuel</option>
                                <option value ='Trimestriel'>Trimestriel</option>
                        </select><br>
                        <div id='div-mois' >
                            <div class='input-group date'>
                                    <input required id='date-mois-picker' type='text' class='form-control'  placeholder='xx xxxx' minlength='7' maxlength='7'
                                        pattern='[0-9]{2}[\s]{1}[0-9]{4}' title='XX XXXX' value=''/>
                                    <span class='input-group-addon'>
                                        <span class='fa fa-calendar-alt'></span>
                            </div>
                        </div>
                        <div  id='div-sem' style='display:none' >
                            <div class='start-date'>
                                <div class='input-group date' >
                                        <input id='date-sem-picker' class='form-control' placeholder='xx xxxx' minlength='7' maxlength='7' 
                                            pattern='[0-9]{2}[\s]{1}[0-9]{4}' title='XX XXXX'/>
                                            <span class='input-group-addon'><span class='fa fa-calendar-alt'></span></span>
                                </div>
                            </div>
                            
                        </div>
                          ";
                        }else{
                                    echo "<label class='label-periode-titre'>Type : </label>
                                    <span class='span-periode'>".$periode."</span><br>";
                            if ($periode =='Mensuel'){echo"<label class='label-periode-titre'>Mois : </label>
                                    <span class='span-periode'>".$mois_sem."</span><br>";}
                            else{echo"<label class='label-periode-titre'>Trimestre : </label>
                                    <span class='span-periode'>".$mois_sem."</span><br>";}
                            echo"<label class='label-periode-titre'>Année : </label>
                                    <span class='span-periode'>".$annee."</span><br>";
                          }
                  ?>
                            
                </div>

            <div class="rightcontact">	
                        <?php 
                          if($suivant==true){
                            echo"
                                  <h1>Coût du repas</h1> 
                                  <div class='form-group'>
                                    <label class='label-coutRepas'>Dépense alimentaire globale du trimestre</label>
                                    <div style='margin-left:5%;' class='col-sm-8 input-group input-group-sm'>
                                      <input required type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                        value='".$row_global['mtA4Globale']."' name='mtA4Globale'>
                                        <span class='input-group-addon'><span>DZD</span></span>                                          
                                    </div>
                                  </div>
                                  <hr class='line-2input' >
                                  <div class='form-group'>
                                    <label class='label-coutRepas'>Nombre total de repas servis durant le trimestre</label>
                                    <div style='margin-left:5%;' class='col-sm-8 input-group input-group-sm'>
                                      <input  required type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                      value='".$row_global['nbreRepasGlobale']."' name='nbreRepasGlobale' >
                                    </div>
                                  </div> 
                            ";
                          }
                        ?>
                        
                    </div>
                    </div>
                          <input type="hidden" value=<?php echo "'".$table."'"?> name="table">
                          <?php 
                              if($suivant==false){
                                echo"
                                  <input type='hidden' id='date-text-annee' value='' name='annee'>
                                  <input type='hidden' id='date-text-mois-sem' value='' name='mois_sem'>
                                ";
                              } else{
                                echo"
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-mois-sem' value='".$mois_sem."' name='mois_sem'>
                                  <input type='hidden' id='date-text-mois-sem' value='".$row_periode['code_periode']."' name='code_periode'>                                  
                                ";
                              }   
                          ?>
                          <button type='submit' class='bouton-suivant'>Suivant</button>
            </form>	           
        </div>
      </div>
    </div>
  </main>
  <!-- script -->
  <script src='../../js/jquery.min.js'></script>
  <script src='../../js/all.js'></script> 
  <script src='../../js/bootstrap.min.js'></script>
    <!-- Dat picker -->
    <script src='../../js/bootstrap-datepicker.js'></script>
        
        <script  src="../../js/index-table.js"></script>
        <script  src="../../js/index-insert.js"></script>
        <script  src="../../js/index.js"></script>
      
  </body>

</html>
