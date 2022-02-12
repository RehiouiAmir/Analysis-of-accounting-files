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
    //variable
    $ajouterCout=false;
    $nvCoutRepas=false;
    $updatcoutRepas=false;
    $suivant=false;
    $ajouter=false;
    $ligne_insert=false;
    $ligne_update=false;
    $nbr_ligne_insert=0;
    $nbr_ligne_update=0;
    //Get le nom de table 
    $table=($_GET['table']);
    $table_DATA= $table."_data";
    $table_name=str_replace('_chg','',$table); 
    // select col+ pour a1 et a4 
    if($table_name=='a1' or $table_name=='a4'){
      $sql_get_col="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table'";
      $result_get_col=mysqli_query($conn, $sql_get_col);
      $i=0;
      while ($row_get_col=mysqli_fetch_assoc($result_get_col) and $i!=3) {$i=$i+1;}
      $col=$row_get_col['COLUMN_NAME']; 
    }    
    // Get variable Periode et Designation 
      if(isset($_GET['periode']))  {
          $periode=($_GET['periode']);
          $mois_sem=($_GET['mois_sem']);
          $annee=($_GET['annee']);
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
      if(isset($_GET['design']))  {
        if($table_name=='a4'){
          $coutRepas=($_GET['coutRepas']);
          $coutRepas_aff = number_format($coutRepas, 2, ',', ' ');}
        $design=($_GET['design']);
        $suivant=true;        
      }        
      //GET variable + calculer le coup d'une repas + insert cout repas  
      if(isset($_GET['mtA4Globale']) and isset($_GET['nbreRepasGlobale']) ){
          $ajouterCout=true;
          $code_periode=($_GET['code_periode']);
          $mtA4Globale=($_GET['mtA4Globale']);
          $nbreRepasGlobale=($_GET['nbreRepasGlobale']);
          if($nbreRepasGlobale==0){$coutRepas_aff=0.00;$coutRepas=0.00;}
          else{
          $coutRepas=$mtA4Globale/$nbreRepasGlobale;
          $coutRepas_aff = number_format($coutRepas, 2, ',', ' ');}

          $sql_exist_cout="SELECT COUNT(*) AS verif_exist_cout FROM  coutdesigna4 where codePeriode=".$code_periode." ;";
          $result_exist_cout= mysqli_query($conn, $sql_exist_cout);
          $row_exist_cout=mysqli_fetch_assoc($result_exist_cout);
            if($row_exist_cout['verif_exist_cout'] ==0){
              $sql_ajouter_cout="INSERT INTO coutdesigna4  VALUES ('NULL','".$code_periode."', '".$nbreRepasGlobale."', '".$mtA4Globale."')";
              $result_ajouter_cout= mysqli_query($conn, $sql_ajouter_cout);
              $nvCoutRepas=true;
              }else{
                $sql_egal_cout="SELECT * FROM coutdesigna4 where codePeriode=".$code_periode." ";
                $result_egal_cout= mysqli_query($conn, $sql_egal_cout);
                $row_egal_cout=mysqli_fetch_assoc($result_egal_cout);
                  if($row_egal_cout['mtA4Globale']!=$mtA4Globale or $row_egal_cout['nbreRepasGlobale']!=$nbreRepasGlobale){
                    $sql_mod_cout="UPDATE coutdesigna4 SET  mtA4Globale='".$mtA4Globale."', nbreRepasGlobale='".$nbreRepasGlobale."' 
                      where codePeriode=".$code_periode." ;";
                    $result_mod_cout= mysqli_query($conn, $sql_mod_cout);
                    $updatcoutRepas=true;
                  }
                }
            
          }
                
      // Get variable pour l'ajout
      if(isset($_GET['codePeriode'])){
          $codePeriode=($_GET['codePeriode']);
          $codeDesign=($_GET['codeDesign']);
          if($table_name!='a9'){
            for ($i = 0; $i <= 19; $i++) {
              $codeSce[$i]=($_GET['codeSce'.$i.'']);
              $valMt[$i]=($_GET['valMt'.$i.'']);
              if($table_name=='a1' or $table_name=='a4'){$val_Ef_Rp[$i]=($_GET['val_Ef_Rp'.$i.'']);}
            }
          }else{
            $valMt[0]=($_GET['valMt']);
          }
        $ajouter=true;
      } 
      
            
?>
<!-- Request d'affichage SUIVANT-->
<?php
  //Affichages des désignation
  if($table_name!='a9'){
    $sql_design="SELECT code_design".$table_name." AS codeDesign ,nomDesign".$table_name." AS nomDesign 
                        FROM design".$table_name." order by nomDesign".$table_name."";
    }else{
    $sql_design="SELECT code_budget,titre,chapitre,article FROM budget order by titre";                      
  }
  $result_design= mysqli_query($conn, $sql_design);
  if($suivant==true){
  // nom designation
          if($table_name!='a9'){    
          $sql_design_nom="SELECT nomDesign".$table_name." AS nomDesign FROM design".$table_name." where code_design".$table_name."=".$design." ";    
          }else{
            $sql_design_nom="SELECT titre,chapitre,article FROM budget where code_budget=".$design."";               
          }
          $result_design_nom= mysqli_query($conn, $sql_design_nom);
          $row_design_nom= mysqli_fetch_assoc($result_design_nom);
  // affichage des services et les champs saisie
  $sql_sce="SELECT code_sce,nomSce,ordre,codeSection FROM service  order by codeSection ASC,ordre ASC ;";
  $result_sce=mysqli_query($conn, $sql_sce);
  }
  if($suivant==true){
    // Select code periode 
      if($periode=='Mensuel'){
        $sql_periode="SELECT code_periode FROM periode where typePeriode='".$periode."' and nomPeriode='".$mois_sem."' and anneePeriode='".$annee." ';";
      } else { $sql_periode="SELECT code_periode FROM periode where typePeriode='".$periode."' and numPeriode='".$mois_sem."' and anneePeriode='".$annee." ';";}
      $result_periode= mysqli_query($conn, $sql_periode);
      $row_periode= mysqli_fetch_assoc($result_periode);
      if($table_name=='a1' or $table_name=='a4'){
        //affichag de mt et eff/nbr repas  s'il existe  A1 et A4 
      $sql_val_mt="SELECT codeSce,".$col.",mt".$table_name." FROM ".$table." 
        where codePeriode=".$row_periode['code_periode']." and codeDesign".$table_name."=".$design." ;";
      }else if ($table_name=='a9'){
        //affichag de mt s'il existe A9 
        $sql_val_mt="SELECT mt".$table_name." FROM ".$table." 
            where codePeriode=".$row_periode['code_periode']." and codeBudget=".$design." ;";
      }else{
        //affichag de mt s'il existe  A5 A7 A8 
        $sql_val_mt="SELECT codeSce,mt".$table_name." FROM ".$table." 
        where codePeriode=".$row_periode['code_periode']." and codeDesign".$table_name."=".$design." ;";}
      }

?>
<!-- Request  Ajouter-->
<?php
  // insert into Table tous les tables de charge sauf A4
  if($ajouter==true and $table_name!='a4'){
    if($table_name!='a9'){$n=19;}else{$n=0;}
    for ($i = 0; $i <= $n; $i++) {
      if($valMt[$i]!=0){
        // test d'exisatnce 
        if($table_name!='a9'){
        $sql_exist="SELECT COUNT(*) AS verif_exist FROM ".$table." 
                    where codeSce=".$codeSce[$i]." and codePeriode=".$codePeriode." and codeDesign".$table_name."=".$codeDesign." ;";
        }else{
          $sql_exist="SELECT COUNT(*) AS verif_exist FROM ".$table." 
              where codePeriode=".$codePeriode." and codeBudget=".$codeDesign." ;"; 
        }
        $result_exist= mysqli_query($conn, $sql_exist);
        $row_exist=mysqli_fetch_assoc($result_exist);
        if($row_exist['verif_exist']==0){
          //a1
          if($table_name=='a1'){          
            $sql_ajouter="INSERT INTO ".$table." VALUES ('".$codeSce[$i]."', '".$codePeriode."','".$codeDesign."','".$val_Ef_Rp[$i]."','".$valMt[$i]."')";}
          // a9
          else if($table_name=='a9'){$sql_ajouter="INSERT INTO ".$table." VALUES ('".$codePeriode."','".$codeDesign."','".$valMt[$i]."')";}
          //  a5 a7 a8
          else{$sql_ajouter="INSERT INTO ".$table." VALUES ('".$codeSce[$i]."', '".$codePeriode."','".$codeDesign."','".$valMt[$i]."')";}
          $result_ajouter= mysqli_query($conn, $sql_ajouter);
          $ligne_insert=true;
          $nbr_ligne_insert=$nbr_ligne_insert+1;
        }else{
          //a4 et a1
          if($table_name=='a1'){
             $sql_egal="SELECT ".$col.", mt".$table_name." FROM ".$table." 
            where codeSce=".$codeSce[$i]." and codePeriode=".$codePeriode." and codeDesign".$table_name."=".$codeDesign." ;";}
          //  a9
          else if($table_name=='a9'){$sql_egal="SELECT mt".$table_name." FROM ".$table." 
            where codePeriode=".$codePeriode." and codeBudget=".$codeDesign." ;";}
          else{$sql_egal="SELECT mt".$table_name." FROM ".$table." 
            where codeSce=".$codeSce[$i]." and codePeriode=".$codePeriode." and codeDesign".$table_name."=".$codeDesign." ;";}         
          $result_egal= mysqli_query($conn, $sql_egal);
          $row_egal=mysqli_fetch_assoc($result_egal);
          if($table_name=='a1' or $table_name=='a4'){
            if ($row_egal['mt'.$table_name.'']!= $valMt[$i] or $row_egal[''.$col.'']!= $val_Ef_Rp[$i]){
              $sql_mod="UPDATE ".$table." SET ".$col."='".$val_Ef_Rp[$i]."' ,mt".$table_name."='".$valMt[$i]."' 
              where  codeSce=".$codeSce[$i]." and codePeriode=".$codePeriode." and codeDesign".$table_name."=".$codeDesign." ;";
              $result_mod= mysqli_query($conn, $sql_mod);
              $ligne_update=true;
              $nbr_ligne_update=$nbr_ligne_update+1;
            }
          }
          else{  
            if ($row_egal['mt'.$table_name.'']!= $valMt[$i]){
              if($table_name=='a9'){
              $sql_mod="UPDATE ".$table." SET  mt".$table_name."='".$valMt[$i]."' 
              where codePeriode=".$codePeriode." and codeBudget=".$codeDesign." ;";}
              else{$sql_mod="UPDATE ".$table." SET  mt".$table_name."='".$valMt[$i]."' 
                where  codeSce=".$codeSce[$i]." and codePeriode=".$codePeriode." and codeDesign".$table_name."=".$codeDesign." ;";}
              $result_mod= mysqli_query($conn, $sql_mod);
              $ligne_update=true;
              $nbr_ligne_update=$nbr_ligne_update+1;
            }
          }
        }
      }
  }

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
                }else if ($nvCoutRepas==true){
                  echo "<div class='alert-sup alert-success' role='alert' >
                  <strong>Succès!</strong> <br>
                    Le Coût de repas a été inséré avec succès!<br>
                  </div>";
                }else if ($updatcoutRepas==true){
                  echo "<div class='alert-sup alert-success' role='alert' >
                  <strong>Succès!</strong> <br>
                    Le Coût de repas a été modifiée avec succès!<br>
                  </div>";
                }

              ?>
          <div class="table_content">
            <?php 
                echo "<h2>L'insertion de données dans la table  [ ".$table_name." ]</h2>";
                if ($table_name=='a4' and $suivant==true){ echo"<form autocomplete='off' action='insertion_chg_coutRepas.php'>";
                }else{echo"<form autocomplete='off' action='insertion_chg.php'>";}
              ?>

            <div class="contentform">
                
                <div class="leftcontact">
                    <h1>Période</h1>

                    <?php if($suivant==false and $ajouterCout==false){
                        echo"
                            <select class='form-control' onchange='showDiv(this)' name='periode'>
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
                                
                            </div>";
                        }else if($suivant==true or $ajouterCout==true) {
                            echo "<label class='label-periode-titre'>Type : </label>
                                    <span class='span-periode'>".$periode."</span><br>";
                            if ($periode =='Mensuel'){echo"<label class='label-periode-titre'>Mois : </label>
                                    <span class='span-periode'>".$mois_sem."</span><br>";}
                            else{echo"<label class='label-periode-titre'>Trimestre : </label>
                                    <span class='span-periode'>".$mois_sem."</span><br>";}
                             echo"<label class='label-periode-titre'>Année : </label>
                                    <span class='span-periode'>".$annee."</span><br>";
                               echo"<input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                    <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                    <input type='hidden' id='date-text-mois-sem' value='".$mois_sem."' name='mois_sem'>";
                            }
                    ?>
                    <br><br>
                    <?php if($suivant==true and $table_name!='a9'){
                            echo "<h1>Services</h1>";
                                  $i=0;
                            while($row_sce = mysqli_fetch_assoc($result_sce)){
                                echo"<label class='label-service'>".$row_sce['codeSection']."-".$row_sce['ordre']." ".$row_sce['nomSce']."</label>
                                <hr class='line-label' >
                                <input type='hidden' value='".$row_sce['code_sce']."' name='codeSce".$i."'>
                                ";
                                $i=$i+1;
                            }
                        }
                    ?>
                </div>

            <div class="rightcontact">	
                    <?php 
                        if($suivant==false ){
                            if($table_name!='a9'){
                              echo"<h1>Désignation</h1>                            
                                  <select class='form-control' name='design'>";
                            }else{
                              echo"<h1>Budget</h1>                            
                                    <select class='form-control' name='design'> ";
                            }
                                    while ($row_design= mysqli_fetch_assoc($result_design)){
                                        if($table_name!='a9'){
                                              echo "<option value='".$row_design['codeDesign']."'>".$row_design['nomDesign']."</option>";                                             
                                        }else{echo "<option value='".$row_design['code_budget']."'>".$row_design['titre']." | ".$row_design['chapitre']." | ".$row_design['article']."</option>";}
                                    }
                            echo"</select>";
                            if($ajouterCout==true){
                              echo"<br><h1>Coût du repas</h1>
                                <label class='label-calcule-coutRepas'>".$coutRepas_aff." DZD</label>";
                            }
                        }else{
                          if($table_name!='a9' and $table_name!='a4'){echo"<h1>Désignation</h1>
                                                    <div class='label-design'><label >".$row_design_nom['nomDesign']."</label></div>";
                                                    
                          }else if($table_name=='a4'){
                            echo"
                                  <h1>Désignation</h1>
                                  <label class='label-a4'>".$row_design_nom['nomDesign']." </label>
                                  <h1>Coût du repas</h1>
                                  <label class='label-a4'>".$coutRepas_aff." DZD</label>";
                          }
                          else if ($table_name='a9'){echo"<h1>Budget</h1>                            
                            <label class='label-periode-titre'>Titre : </label>
                            <span class='span-periode'>".$row_design_nom['titre']."</span><br>
                            <label class='label-periode-titre'>Chapitre : </label>
                            <span class='span-periode'>".$row_design_nom['chapitre']."</span><br>
                            <label class='label-periode-titre'>Article : </label>
                            <span class='span-periode'>".$row_design_nom['article']."</span><br><br><br>";}
                        }
                    ?>
                    <?php
                          // Table a5 a7 a8
                        if($suivant==true){ 
                           if($table_name!='a1' and $table_name!='a4' and $table_name!='a9'){
                                $i=0;
                                $result_sce=mysqli_query($conn, $sql_sce);
                                echo "<h1>Champs saisie [Montant] </h1>";
                                while($row_sce = mysqli_fetch_assoc($result_sce)){
                                  $echo="<div class='input-group input-group-sm'  style='width:60%;'>
                                          <input type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                            value='0' name='valMt".$i."'>
                                          <span class='input-group-addon'><span>DZD</span></span>
                                      </div>
                                      <hr class='line-input' >";
                                 $result_val_mt= mysqli_query($conn, $sql_val_mt);                                  
                                  while($row_val_mt=mysqli_fetch_assoc($result_val_mt)){                                    
                                    if($row_val_mt['codeSce']==$row_sce['code_sce']){                      
                                      $echo="<div class='input-group input-group-sm'  style='width:60%;'>
                                              <input type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                                  value='".$row_val_mt['mt'.$table_name.'']."' name='valMt".$i."'>
                                                  <span class='input-group-addon'><span>DZD</span></span>
                                            </div>
                                            <hr class='line-input'>
                                            ";
                                    }
                                  }
                                    echo"".$echo."";
                                    $i=$i+1;
                                }
                                // table a1
                            }else if($table_name=='a1'){
                              $i=0;
                                echo "<h1>Champs saisie [Effectif] [Montant] </h1>";
                                    $result_sce=mysqli_query($conn, $sql_sce);                                    
                                    while($row_sce = mysqli_fetch_assoc($result_sce)){
                                        $echo="
                                        <div class='row'>
                                          <div class='col-sm-5 input-group-sm'>
                                            <input  type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                            value='0' name='val_Ef_Rp".$i."'>
                                          </div>
                                          <div class='col-sm-5 input-group input-group-sm'>
                                            <input  type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                              value='0' name='valMt".$i."'>
                                              <span class='input-group-addon'><span>DZD</span></span>                                          
                                          </div>
                                        </div>
                                        <hr class='line-2input' >";
                                        $result_val_mt= mysqli_query($conn, $sql_val_mt);                                  
                                        while($row_val_mt=mysqli_fetch_assoc($result_val_mt)){                                    
                                          if($row_val_mt['codeSce']==$row_sce['code_sce']){
                                            $echo="
                                            <div class='row'>
                                              <div class='col-sm-5 input-group-sm'>
                                                <input  type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                                value='".$row_val_mt[''.$col.'']."' name='val_Ef_Rp".$i."'>
                                              </div>
                                              <div class='col-sm-5 input-group input-group-sm'>
                                                <input  type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                                  value='".$row_val_mt['mt'.$table_name.'']."' name='valMt".$i."'>
                                                  <span class='input-group-addon'><span>DZD</span></span>                                          
                                              </div>
                                            </div>
                                            <hr class='line-2input' >";
                                          }
                                        }                                     
                                        echo"".$echo."";
                                        $i=$i+1;
                                    }
                                  }
                                    //a4
                                    else if($table_name=='a4'){
                                      $i=0;
                                        echo "<h1>Champs saisie [Nombre de repas] [Montant] </h1>"; 
                                            $result_sce=mysqli_query($conn, $sql_sce);                                    
                                            while($row_sce = mysqli_fetch_assoc($result_sce)){
                                                $echo="
                                                <div class='row'>
                                                  <div class='col-sm-5 input-group-sm'>
                                                    <input  type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                                    value='0' name='val_Ef_Rp".$i."'>
                                                  </div>
                                                  <div class='col-sm-5 input-group input-group-sm'>
                                                    
                                                    <input  type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                                      value='0'  disabled>
                                                      <span class='input-group-addon'><span>DZD</span></span>                                          
                                                  </div>
                                                </div>
                                                <hr class='line-2input' >";
                                                $result_val_mt= mysqli_query($conn, $sql_val_mt);                                  
                                                while($row_val_mt=mysqli_fetch_assoc($result_val_mt)){                                    
                                                  if($row_val_mt['codeSce']==$row_sce['code_sce']){
                                                    $echo="
                                                    <div class='row'>
                                                      <div class='col-sm-5 input-group-sm'>
                                                        <input  type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                                        value='".$row_val_mt[''.$col.'']."' name='val_Ef_Rp".$i."'>
                                                      </div>
                                                      <div class='col-sm-5 input-group input-group-sm'>
                                                        <input  type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                                          value='".$row_val_mt['mt'.$table_name.'']."' disabled>
                                                          <span class='input-group-addon'><span>DZD</span></span>                                          
                                                      </div>
                                                    </div>
                                                    <hr class='line-2input' >";
                                                  }
                                                }                                     
                                                echo"".$echo."";
                                                $i=$i+1;
                                            }
                                    // table a9
                            }else if($table_name=='a9'){
                              echo "<h1>Champs saisie [Montant] </h1>";
                              $echo="<div class='input-group input-group-sm'  style='width:60%;'>
                                     <input type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                          value='0' name='valMt'>
                                      <span class='input-group-addon'><span>DZD</span></span>
                                    </div>";
                              $result_val_mt= mysqli_query($conn, $sql_val_mt);
                              while($row_val_mt=mysqli_fetch_assoc($result_val_mt) and $row_val_mt['mt'.$table_name.'']!=0){                                                                      
                                $echo="<div class='input-group input-group-sm'  style='width:60%;'>
                                        <input type='number' class='form-control' aria-label='Small' aria-describedby='inputGroup-sizing-sm'
                                            value='".$row_val_mt['mt'.$table_name.'']."' name='valMt'>
                                        <span class='input-group-addon'><span>DZD</span></span>
                                      </div>";
                              }
                              echo"".$echo."";
                            }
                          }

                    ?>
                        
                    </div>
                    </div>
                          <input type="hidden" value=<?php echo "'".$table."'"?> name="table">
                    <?php if ($suivant==false and $ajouterCout==false){
                        echo "
                              <input type='hidden' id='date-text-annee' value='' name='annee'>
                              <input type='hidden' id='date-text-mois-sem' value='' name='mois_sem'>
                          <button type='submit' class='bouton-suivant'>Suivant</button>";
                        }else if($suivant==false and $ajouterCout==true){
                              echo"<input type='hidden' value='".$coutRepas."' name='coutRepas'>                              
                              <button type='submit' class='bouton-suivant'>Suivant</button>";                  
                        }else if($suivant==true){
                            if($table_name=='a4'){echo"<input type='hidden' value='".$coutRepas."' name='coutRepas'>";}
                            echo "                              
                                  <input type='hidden' value='".$design."' name='codeDesign'>
                                  <input type='hidden' value='".$row_periode['code_periode']."' name='codePeriode'>
                            <button type='submit' class='bouton-ajouter'>Ajouter</button>"; 
                        }
                    ?>
                    
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
