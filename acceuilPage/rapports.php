
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

          <div class="table_content">

        <form  autocomplete='off' action="../genererRapportsPDF/genererRapports.php">

            <div class="contentform">
                
                <div class="leftcontact">
                    <h1>Période</h1>

                      <select class='form-control' name='periode'>
                              <option value='Mensuel'>Mensuel</option>
                              <option value ='Trimestriel'>Trimestriel</option>
                      </select><br>
                      <div>
                          <div class='input-group date'>
                                  <input required id='date-annee-picker' type='text' class='form-control'  placeholder='xxxx' minlength='4' maxlength='4'
                                      pattern='[0-9]{4}' title='XXXX' value=''/>
                                  <span class='input-group-addon'>
                                      <span class='fa fa-calendar-alt'></span>
                          </div>
                      </div>
                                 
                </div>

            <div class="rightcontact">	
                  <h1>Type Rapport</h1>                            
                    <select class='form-control' name='typeRapport'>
                      <option value='Charges'>Charges</option>
                      <option value='Activites'>Activités</option>                                            
                      <option value='Repartition'>Répartition</option>                                                                                        
                    </select>
            </div>
                <input type='hidden' id='date-text-annee' value='' name='annee'>
            <button type='submit' class='bouton-suivant'>Suivant</button>
                             
        </form>	           
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
