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
$typeRapport="";
$periode="";
$annee="";
  if(isset($_GET['typeRapport'])){ 
    $typeRapport=($_GET['typeRapport']);
    $periode=($_GET['periode']);
    $annee=($_GET['annee']);
  } 
?>
<!-- Selection tt les tables-->
<?php 
  /* Charges */
  if($typeRapport=="Charges"){
    $sql_c = "SHOW TABLES FROM $dbname  WHERE Tables_in_$dbname LIKE '%_Chg'";
    $result_c = mysqli_query($conn, $sql_c);
  }
  else if($typeRapport=="Activites"){
    /*Activite */
    $sql_a = "SHOW TABLES FROM $dbname WHERE Tables_in_$dbname LIKE '%_Act'";
    $result_a = mysqli_query($conn, $sql_a);
  }
?>

<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <title>Rapports PDF | Panneau Admin</title>
  
    <lin rel="stylesheet" href="../css/normalize.min.css"></link>
    <link rel='stylesheet' href='../css/bootstrap.min.css'></link>
    <link rel='stylesheet' href='../css/animate.min.css'></link>
    <link rel='stylesheet' href='../css/bootstrap-datepicker.css'>
  
    <link rel="stylesheet" href="../css/style-insert.css?version=2000">
    <link rel="stylesheet" href="../css/style.css?version=10000"></link>

  
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
            <a href="../acceuilPage/tables.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Tables">
              <div class="c-menu__item__inner"><i class="fa fa-table"></i>
                <div class="c-menu-item__title"><span>Tables</span></div>
              </div>
            </li></a>
            <a href="../acceuilPage/rapports.php" style="text-decoration: none;"><li class="c-menu__item is-active" data-toggle="tooltip" title="Rapports">
              <div class="c-menu__item__inner"><i class="fa fa-file-pdf"></i>
                <div class="c-menu-item__title"><span>Rapports</span></div>
              </div>
            </li></a>
            <a href="../acceuilPage/administration.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Administration ">
              <div class="c-menu__item__inner"><i class="fa fa-laptop"></i>
                <div class="c-menu-item__title"><span>Administration </span></div>
              </div>
            </li></a>
            <a href="../acceuilPage/statistiques.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Statistiques">
              <div class="c-menu__item__inner"><i class="far fa-chart-bar"></i>
                <div class="c-menu-item__title"><span>Statistiques</span></div>
              </div>
            </li></a>
            <a href="../acceuilPage/parametres.php" style="text-decoration: none;"><li class="c-menu__item has-submenu" data-toggle="tooltip" title="Paramètres">
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
      <h1 class="page-title">Générer les Rapports PDF</h1>
        <div class="page-content row" >

          <?php 
              
              echo"<h2>Rapports des ".$typeRapport." | ".$periode." | ".$annee."</h2>
              <div class='row'>";
              if($typeRapport=="Charges"){
                while($row_c = mysqli_fetch_row($result_c)){
                      $table= str_replace('_chg','',$row_c[0]);
                    echo "
                    <div class='col-sm-4 div-pere'>
                      <div class='div-fils'>
                        <div class='table_content'>
                          <table id= 'table-id'>
                            <thead>
                              <tr>
                                <th style='text-transform:uppercase;' scope='row' colspan='3' class='rounded-company'>".$table."</th>
                              </tr>
                            </thead>";
                      if($periode=="Mensuel"){
                        echo"
                            <tbody>
                              <tr>
                                <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Janvier' name='mois'>
                                <td>01</td>
                                <td>Janvier</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>                                 
                              </tr>
                              <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Fevrier' name='mois'>
                                <td>02</td>
                                <td>Février</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Mars' name='mois'>
                                <td>03</td>
                                <td>Mars</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Avril' name='mois'>
                                <td>04</td>
                                <td>Avril</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Mai' name='mois'>
                                <td>05</td>
                                <td>Mai</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Juin' name='mois'>
                                <td>06</td>
                                <td>Juin</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Juillet' name='mois'>
                                <td>07</td>
                                <td>Juillet</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Aout' name='mois'>
                                <td>08</td>
                                <td>Août</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Septembre' name='mois'>
                                <td>09</td>
                                <td>Septembre</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Octobre' name='mois'>
                                <td>10</td>
                                <td>Octobre</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Novembre' name='mois'>
                                <td>11</td>
                                <td>Novembre</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Decembre' name='mois'>
                                <td>12</td>
                                <td>Décembre</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                            </tbody>
                    ";
                  }else if ($periode=="Trimestriel"){
                          echo"
                            <tbody>
                            <tr>
                                <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                <input type='hidden' id='date-text-annee' value='1' name='trimestre'>
                              <td>1er</td>
                              <td>Trimestre</td>
                              <td><button type='submit' class='btn btn-primary btn-sm'>
                                    <span class='fa fa-file-pdf'></span>  Consulter
                                  </button>
                              </td>
                              </form>                                 
                            </tr>
                            <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                <input type='hidden' id='date-text-annee' value='2' name='trimestre'>
                              <td>2e</td>
                              <td>Trimestre</td>
                              <td><button type='submit' class='btn btn-primary btn-sm'>
                                    <span class='fa fa-file-pdf'></span>  Consulter
                                  </button>
                              </td>
                              </form>     
                            </tr>
                            <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                <input type='hidden' id='date-text-annee' value='3' name='trimestre'>
                              <td>3e</td>
                              <td>Trimestre</td>
                              <td><button type='submit' class='btn btn-primary btn-sm'>
                                    <span class='fa fa-file-pdf'></span>  Consulter
                                  </button>
                              </td>
                              </form>     
                            </tr>
                            <tr>
                                 <form action='rapportsChg/rapport_chg_".$periode."_".$table.".php' method=GET target='_blank' >
                                <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                <input type='hidden' id='date-text-annee' value='4' name='trimestre'>
                              <td>4e</td>
                              <td>Trimestre</td>
                              <td><button type='submit' class='btn btn-primary btn-sm'>
                                    <span class='fa fa-file-pdf'></span>  Consulter
                                  </button>
                              </td>
                              </form>     
                            </tr>
                          </tbody>
                            ";

                          }
                          echo"
                              </table>
                              </div>
                            </div>
                          </div>
                          ";
                  }
              }else if ($typeRapport=="Activites"){
                  while($row_a = mysqli_fetch_row($result_a)){
                    $table= str_replace('_act','',$row_a[0]);
                    echo "
                    <div class='col-sm-4 div-pere'>
                      <div class='div-fils'>
                        <div class='table_content'>
                          <table id= 'table-id'>
                            <thead>
                              <tr>
                                <th style='text-transform:uppercase;' scope='row' colspan='3' class='rounded-company'>".$table."</th>
                              </tr>
                            </thead>";
                            if($periode=="Mensuel"){
                              echo"
                            <tbody>
                              <tr>
                                <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Janvier' name='mois'>
                                <td>01</td>
                                <td>Janvier</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                               <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Fevrier' name='mois'>
                                <td>02</td>
                                <td>Février</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                               <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Mars' name='mois'>
                                <td>03</td>
                                <td>Mars</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                               <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Avril' name='mois'>
                                <td>04</td>
                                <td>Avril</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                               <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Mai' name='mois'>
                                <td>05</td>
                                <td>Mai</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                               <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Juin' name='mois'>
                                <td>06</td>
                                <td>Juin</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                               <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Juillet' name='mois'>
                                <td>07</td>
                                <td>Juillet</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                               <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Aout' name='mois'>
                                <td>08</td>
                                <td>Août</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                               <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Septembre' name='mois'>
                                <td>09</td>
                                <td>Septembre</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                               <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Octobre' name='mois'>
                                <td>10</td>
                                <td>Octobre</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                               <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Novembre' name='mois'>
                                <td>11</td>
                                <td>Novembre</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                              <tr>
                               <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                  <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                
                                  <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                  <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                  <input type='hidden' id='date-text-annee' value='Decembre' name='mois'>
                                <td>12</td>
                                <td>Décembre</td>
                                <td><button type='submit' class='btn btn-primary btn-sm'>
                                      <span class='fa fa-file-pdf'></span>  Consulter
                                    </button>
                                </td>
                                </form>     
                              </tr>
                            </tbody>";
                          }else if ($periode=="Trimestriel"){
                          echo"
                            <tbody>
                            <tr>
                                <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                                                
                                <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                <input type='hidden' id='date-text-annee' value='1' name='trimestre'>
                              <td>1er</td>
                              <td>Trimestre</td>
                              <td><button type='submit' class='btn btn-primary btn-sm'>
                                    <span class='fa fa-file-pdf'></span>  Consulter
                                  </button>
                              </td>
                              </form>                                 
                            </tr>
                            <tr>
                                <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                                                
                                <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                <input type='hidden' id='date-text-annee' value='2' name='trimestre'>
                              <td>2e</td>
                              <td>Trimestre</td>
                              <td><button type='submit' class='btn btn-primary btn-sm'>
                                    <span class='fa fa-file-pdf'></span>  Consulter
                                  </button>
                              </td>
                              </form>     
                            </tr>
                            <tr>
                                <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                                                
                                <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                <input type='hidden' id='date-text-annee' value='3' name='trimestre'>
                              <td>3e</td>
                              <td>Trimestre</td>
                              <td><button type='submit' class='btn btn-primary btn-sm'>
                                    <span class='fa fa-file-pdf'></span>  Consulter
                                  </button>
                              </td>
                              </form>     
                            </tr>
                            <tr>
                                <form action='rapportsAct/rapport_act_".$periode."_".$table.".php' method=GET target='_blank'>
                                <input type='hidden' id='date-text-annee' value='".$table."' name='table'>                                                                
                                <input type='hidden' id='date-text-annee' value='".$annee."' name='annee'>
                                <input type='hidden' id='date-text-annee' value='".$periode."' name='periode'>
                                <input type='hidden' id='date-text-annee' value='4' name='trimestre'>
                              <td>4e</td>
                              <td>Trimestre</td>
                              <td><button type='submit' class='btn btn-primary btn-sm'>
                                    <span class='fa fa-file-pdf'></span>  Consulter
                                  </button>
                              </td>
                              </form>     
                            </tr>
                          </tbody>
                            ";

                          }
                          echo"
                              </table>
                              </div>
                            </div>
                          </div>
                          ";
                  }
              }
          ?>
          </div>
        
      </div>
    </div>
  </main>
  <!-- script -->
  <script src='../js/jquery.min.js'></script>
  <script src='../js/all.js'></script> 
  <script src='../js/bootstrap.min.js'></script>
    <!-- Dat picker -->
    <script src='../js/bootstrap-datepicker.js'></script>
        
        <script  src="../js/index-table.js"></script>
        <script  src="../js/index-insert.js"></script>
        <script  src="../js/index.js"></script>
      
  </body>

</html>
