<?php  
function connection(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ephcompta";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    return $conn;   
}
//-- GET variable --
$periode="";
$annee="";
$trimestre="";
$table="";
  if(isset($_GET['annee'])){ 
    $periode=($_GET['periode']);
    $annee=($_GET['annee']);
    $trimestre=($_GET['trimestre']);
    $table=($_GET['table']); 
     // Select code periode 
  } 
  function title(){
    $output = '';
    $conn = connection();
    if($GLOBALS['trimestre']==1){
    $output .='CALCUL DES COUTS / WILAYA DE JIJEL EPH  D`EL-MILIA / PERIODE '.$GLOBALS['trimestre'].'er TRIMESTRE '.$GLOBALS['annee']."";}
    else{$output .='CALCUL DES COUTS / WILAYA DE JIJEL EPH  D`EL-MILIA / PERIODE '.$GLOBALS['trimestre'].'ème TRIMESTRE '.$GLOBALS['annee']."";}
    return $output;
} 

//HTML-WEB

function services()
 {
    $output = '';      
    $conn = connection();
            $sql0 = "SELECT code_sce,nomSce FROM service where codeSection='2' order by ordre";
            $result0 = mysqli_query($conn, $sql0);
            while($row0 = mysqli_fetch_assoc($result0)) {
                $output .= '<td colspan="2">' . $row0["nomSce"]. '</td>';
            }
        $output .= '<th colspan="2" rowspan="1" style="text-align:center;font-size:12px;"> TOTAL </th>';            
        $output .= '</tr>';
    return $output;
}
function nbre_nbrerepas(){
    $output = '<tr  style="text-align:center;font-size:12px;">';      
    $conn = connection();
            $sql0 = "SELECT code_sce,nomSce FROM service where codeSection='2' order by ordre";
            $result0 = mysqli_query($conn, $sql0);
            while($row0 = mysqli_fetch_assoc($result0)) {
                $output .= '<td>Nbr EX.</td>
                        <td >Nbr B</td>';
            }
        $output .= '<td>Nbr EX.</td>
                    <td >Nbr B</td>';
        $output .= '</tr>';
    return $output;
}
function designB8(){
    $output = '';      
    $conn = connection();
    $sql1 = "SELECT code_designB8, nomDesignB8 FROM designB8 order by nomDesignB8 DESC";
    $result1 = mysqli_query($conn, $sql1);    
            while($row1 = mysqli_fetch_assoc($result1)) {
               $output .= '<tr style="text-align:center;font-size:12px;"> <td> ' . $row1["nomDesignB8"]. '</td>';
               $sql_code="SELECT codeB8 FROM designB8 where code_designB8=$row1[code_designB8]";               
               $result_code = mysqli_query($conn, $sql_code);
               $row_code = mysqli_fetch_assoc($result_code);                 
               $output .= '<td> ' . $row_code["codeB8"]. '</td>';
                    $sql0 = "SELECT code_sce,nomSce FROM service where codeSection='2' order by ordre";
                    $result0 = mysqli_query($conn, $sql0);
                    while($row0 = mysqli_fetch_assoc($result0)) {
                        $sql2 = "SELECT nbreB8 FROM designB8_sce_periode_data where  periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeSce = $row0[code_sce] and codeDesignB8=$row1[code_designB8]";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);  
                        $output .= '<td>' . $row2["nbreB8"]. '</td>
                                    <td>' . $row2["nbreB8"]*$row_code['codeB8']. '</td>';
                    }
            $sql6= "SELECT sum(nbreB8) as somnbre FROM designB8_sce_periode_data where  periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeDesignB8= $row1[code_designB8]";
            $result6 = mysqli_query($conn, $sql6);
            $row6 = mysqli_fetch_assoc($result6);
            $output .= '<td>'.$row6["somnbre"]. '</td>
                        <td>'.$row6["somnbre"]*$row_code['codeB8']. '</td>';
            $output .= '</tr>';
            
            }
    return $output;
}
function totalSce(){
    $output = '';      
    $conn = connection();
    $sumNbr_globale='0';
    $output .= '<tr  style="background-color: #BEBEBE;text-align:center;font-size:12px;"> <td  >TOTAL</td>';
        $output .= '<td >-</td>'; 
        $sql0 = "SELECT code_sce,nomSce FROM service where codeSection='2' order by ordre";
        $result0 = mysqli_query($conn, $sql0);
        while(($row0 = mysqli_fetch_assoc($result0))) {
            $sql4 = "SELECT sum(nbreB8) as somnbre FROM designB8_sce_periode_data 
                        where  periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and   codeSce= $row0[code_sce]";
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);

            $sumNbr='0';
            $sql1 = "SELECT code_designB8, nomDesignB8 FROM designB8 order by nomDesignB8 DESC";
            $result1 = mysqli_query($conn, $sql1);
            while($row1 = mysqli_fetch_assoc($result1)) {
                $sql_sumNbr = "SELECT nbreB8,codeB8 FROM designB8_sce_periode_data where  periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeSce = $row0[code_sce] and codeDesignB8=$row1[code_designB8]";
                $result_sumNbr = mysqli_query($conn, $sql_sumNbr);
                $row_sumNbr = mysqli_fetch_assoc($result_sumNbr);
                $sumNbr=$sumNbr+($row_sumNbr['nbreB8']*$row_sumNbr['codeB8']);
            }                

            $output .= '<td >' .$row4["somnbre"]. '</td>
                        <td >' .$sumNbr.'</td>';
            $sumNbr_globale=$sumNbr_globale+$sumNbr;
            }
        //Total
        $sql8 = "SELECT sum(nbreB8) as somnbre FROM designB8_sce_periode_data 
            where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']."";
        $result8 = mysqli_query($conn, $sql8);
        $row8 = mysqli_fetch_assoc($result8);
        $output .= '<td >' .$row8["somnbre"]. '</td>
                    <td >' .$sumNbr_globale. '</td>';
        $output .= '</tr>';
        return $output;        
}


//pdf 
function titleB8_pdf(){

    $output='</h3><br><br><br>                  
            <h3 style="text-align:center;text-transform: uppercase;">ACTIVITE DU LABORATOIRE</h3>
            <h3 style="text-align:right;text-transform: uppercase;">Tableau B8</h3>';
    return $output;
} 
function services_pdf(){
   $output = '';      
   $conn = connection();
           $sql0 = "SELECT code_sce,nomSce FROM service where codeSection='2' order by ordre";
           $result0 = mysqli_query($conn, $sql0);
           while($row0 = mysqli_fetch_assoc($result0)) {
               $output .= '<td colspan="2" style="text-align:center;font-size:8px;">' . $row0["nomSce"]. '</td>';
           }
       $output .= '<th colspan="2" rowspan="1" style="text-align:center;font-size:10px;"> TOTAL </th>';            
       $output .= '</tr>';
   return $output;
}
function nbre_nbrerepas_pdf(){
   $output = '<tr  style="text-align:center;font-size:8px;">';      
   $conn = connection();
           $sql0 = "SELECT code_sce,nomSce FROM service where codeSection='2' order by ordre";
           $result0 = mysqli_query($conn, $sql0);
           while($row0 = mysqli_fetch_assoc($result0)) {
               $output .= '<td>Nbr EX.</td>
                       <td >Nbr B</td>';
           }
       $output .= '<td>Nbr EX.</td>
                   <td >Nbr B</td>';
       $output .= '</tr>';
   return $output;
}
function designB8_pdf(){
   $output = '';      
   $conn = connection();
   $sql1 = "SELECT code_designB8, nomDesignB8 FROM designB8 order by nomDesignB8 DESC";
   $result1 = mysqli_query($conn, $sql1);    
           while($row1 = mysqli_fetch_assoc($result1)) {
              $output .= '<tr style="text-align:center;font-size:8px;"> <td> ' . $row1["nomDesignB8"]. '</td>';
              $sql_code="SELECT codeB8 FROM designB8 where code_designB8=$row1[code_designB8]";               
              $result_code = mysqli_query($conn, $sql_code);
              $row_code = mysqli_fetch_assoc($result_code);                 
              $output .= '<td> ' . $row_code["codeB8"]. '</td>';
                   $sql0 = "SELECT code_sce,nomSce FROM service where codeSection='2' order by ordre";
                   $result0 = mysqli_query($conn, $sql0);
                   while($row0 = mysqli_fetch_assoc($result0)) {
                       $sql2 = "SELECT nbreB8 FROM designB8_sce_periode_data where  periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeSce = $row0[code_sce] and codeDesignB8=$row1[code_designB8]";
                       $result2 = mysqli_query($conn, $sql2);
                       $row2 = mysqli_fetch_assoc($result2);  
                       $output .= '<td>' . $row2["nbreB8"]. '</td>
                                   <td>' . $row2["nbreB8"]*$row_code['codeB8']. '</td>';
                   }
           $sql6= "SELECT sum(nbreB8) as somnbre FROM designB8_sce_periode_data where  periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeDesignB8= $row1[code_designB8]";
           $result6 = mysqli_query($conn, $sql6);
           $row6 = mysqli_fetch_assoc($result6);
           $output .= '<td>'.$row6["somnbre"]. '</td>
                       <td>'.$row6["somnbre"]*$row_code['codeB8']. '</td>';
           $output .= '</tr>';
           
           }
   return $output;
}
function totalSce_pdf(){
   $output = '';      
   $conn = connection();
   $sumNbr_globale='0';
   $output .= '<tr  style="background-color: #BEBEBE;text-align:center;font-size:8px;"> <td>TOTAL</td>';
       $output .= '<td >-</td>'; 
       $sql0 = "SELECT code_sce,nomSce FROM service where codeSection='2' order by ordre";
       $result0 = mysqli_query($conn, $sql0);
       while(($row0 = mysqli_fetch_assoc($result0))) {
           $sql4 = "SELECT sum(nbreB8) as somnbre FROM designB8_sce_periode_data 
                       where  periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and   codeSce= $row0[code_sce]";
           $result4 = mysqli_query($conn, $sql4);
           $row4 = mysqli_fetch_assoc($result4);

           $sumNbr='0';
           $sql1 = "SELECT code_designB8, nomDesignB8 FROM designB8 order by nomDesignB8 DESC";
           $result1 = mysqli_query($conn, $sql1);
           while($row1 = mysqli_fetch_assoc($result1)) {
               $sql_sumNbr = "SELECT nbreB8,codeB8 FROM designB8_sce_periode_data where  periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeSce = $row0[code_sce] and codeDesignB8=$row1[code_designB8]";
               $result_sumNbr = mysqli_query($conn, $sql_sumNbr);
               $row_sumNbr = mysqli_fetch_assoc($result_sumNbr);
               $sumNbr=$sumNbr+($row_sumNbr['nbreB8']*$row_sumNbr['codeB8']);
           }                

           $output .= '<td>' .$row4["somnbre"]. '</td>
                       <td>' .$sumNbr.'</td>';
           $sumNbr_globale=$sumNbr_globale+$sumNbr;
           }
       //Total
       $sql8 = "SELECT sum(nbreB8) as somnbre FROM designB8_sce_periode_data 
           where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']."";
       $result8 = mysqli_query($conn, $sql8);
       $row8 = mysqli_fetch_assoc($result8);
       $output .= '<td >' .$row8["somnbre"]. '</td>
                   <td >' .$sumNbr_globale. '</td>';
       $output .= '</tr>';
       return $output;        
}


if(isset($_POST["generate_pdf"]))  {  
      require_once('../../tcpdf/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Generate HTML Table Data To PDF From MySQL Database Using TCPDF In PHP");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins('5', '15', '15');  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      //$obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 9);
      $obj_pdf->AddPage('L', 'A4');
      $content1 = '';
      $content1.='<h3 style="text-align: center;text-transform: uppercase;">';
      $content1.= title();
      $content1.= titleB8_pdf();
      $content1.='<p></p>';
      $content1.='<table border="1" cellspacing="0" cellpadding="3">
                  <tr>
                    <th rowspan="2" style="background-color: #BEBEBE;text-align:center;width:12%;font-size:9px;">Désignation</th>
                    <th colspan="1" rowspan="2" style="text-align:center;font-size:12px;">code</th>
                    ';   
      $content1.= services_pdf();
      $content1.=nbre_nbrerepas_pdf();
      $content1.= designB8_pdf();
     $content1.= totalSce_pdf();
      $content1.='</table>';
      $obj_pdf->writeHTML($content1);  
      $obj_pdf->Output('B8_Trimestriel_'.$GLOBALS['trimestre'].'_'.$GLOBALS['annee'].'.pdf', 'I'); 
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
    <head>  
           <title>Rapport | CHARGES |<?php echo" ".$periode." | ".$trimestre."";?></title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <style>
        h4{
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
        }
        h5{
            font-weight: bold;
            margin-left:5%;
            background-color:  #BEBEBE; 
            width:15%;
        }
        
        table, td, th {    
            border: 2px solid #ddd;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        th, td {
            padding: 3px;
        }
        #head{
        background-color: #BEBEBE;
        }
        #total{
        background-color: #F2F2F2;
        }
        .input{
            margin-left:90%;  
        }

    </style>          
    </head>  
    <body>  
                <br> 
                <?php $conn= connection();
                    //Title
                        $title=title();
                        echo"<h4>" .$title."</h4></br>";
                ?>
                <br>
                    <h5 style="margin-left:78%;">ACTIVITE DU LABORATOIRE </h5>
                    <h5 style="margin-left:78%;">TABLEAU B8 </h5>
                <table>
                <tr style="text-align:center;font-size:12px;">
                <th colspan="1" rowspan="2" style="background-color: #BEBEBE;text-align:center;font-size:14px;padding-left:70px;padding-right:70px;">Désignation</th>
                <th colspan="1" rowspan="2" style="text-align:center;font-size:12px;">code</th>
                
                <?php
                    // Affichage de services 
                        $services= services();
                        echo "".$services."";
                    //Affichage nbreEX && nbr B  row 
                        $nbre_nbrerepas= nbre_nbrerepas();
                        echo "".$nbre_nbrerepas."";
                    //Affichage des designB8- val_nbrerepas&Montant
                        $designB8= designB8();
                        echo "".$designB8."";
                    //Affichage des Total Src 
                        $totalSce=totalSce();
                        echo"" .$totalSce. "";
                   
                        
                ?>
                </table><br>
                <div class='row'>
                    <div class='col-sm-1'></div>
                    <div class='col-sm-5'>
                        <a href="http://localhost/compta_eph/genererRapportsPDF/rapportsAct/rapport_act_<?php echo"".$periode."_".$table.".php?table=".$table."&annee=".$annee."&periode=".$periode."&trimestre=".$trimestre."";?>" class="btn btn-primary btn-sm" data-toggle="button" aria-pressed="false" autocomplete="off">
                            <span class='fa fa-sync-alt'></span> Rafraîchir
                        </a> 
                    </div>
                    <div class='col-sm-2'>
                        <a href="../../gestionTables/activitees/insertion_act.php?table=<?php echo"".$table."";?>_act" class="btn btn-success" data-toggle="button" aria-pressed="false" autocomplete="off" target='_blank'>
                            <span class='fa fa-plus-circle'></span> Insérer un nouvel enregistrement 
                        </a>  
                    </div> 
                    <div class='col-sm-2'>
                        <a href="../../gestionTables/activitees/maj_act.php?table=<?php echo"".$table."";?>_act" class="btn btn-info" data-toggle="button" aria-pressed="false" autocomplete="off" target='_blank'>
                            <span class='fa fa-edit'></span> Modifier le tableau 
                        </a>
                    </div> 
                    <div class='col-sm-1'>
                        <form method="post">  
                            <input type="hidden" name="generate_pdf" class="btn btn-success input" value="Générer PDF" />
                            <button type="submit" class="btn btn-warning" data-toggle="button" aria-pressed="false" autocomplete="off">
                                <span class='fa fa-file-pdf'></span>  Générer le PDF
                            </button>  
                        </form> 
                    </div>
                </div>
    </body>
    <script src='../../js/all.js'></script> 

</html>         
                                
