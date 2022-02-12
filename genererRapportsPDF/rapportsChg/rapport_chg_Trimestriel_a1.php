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
function sections(){
    $output = '';      
    $conn = connection();
    $sql3 = "SELECT code_section,nomSection FROM section order by ordreSection";
    $result3 = mysqli_query($conn, $sql3);
    while($row3 = mysqli_fetch_assoc($result3)) {
            $sql5="SELECT COUNT(code_sce) AS nbrSce FROM service  where codeSection= $row3[code_section]";
            $result5 = mysqli_query($conn, $sql5);
            $row5=mysqli_fetch_assoc($result5);
            $nbrSce= $row5["nbrSce"]*2;
            $output .= '<th colspan="'.$nbrSce.'" style="text-align:center;text-transform: uppercase;font-size:12px;"> Section ' .$row3["nomSection"]. '</th>';
        }
    $output .= '<th colspan="2" rowspan="2" style="text-align:center;font-size:12px;"> TOTAL </th>';
    $output .= '</tr>';   
    return $output;
}
function services()
 {
    $output = '<tr>';      
    $conn = connection();
    $sql3 = "SELECT code_section,nomSection FROM section order by ordreSection";
    $result3 = mysqli_query($conn, $sql3);
        while ($row3 = mysqli_fetch_assoc($result3)){
            $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
            $result0 = mysqli_query($conn, $sql0);
            while($row0 = mysqli_fetch_assoc($result0)) {
                $output .= '<td colspan="2" style="text-align:center;font-size:12px;">' . $row0["nomSce"]. '</td>';
            }
        }
        $output .= '</tr>';
    return $output;
}
function mt_effectif(){
    $output = '<tr  style="text-align:center;font-size:12px;">';      
    $conn = connection();
    $sql3 = "SELECT code_section,nomSection FROM section  order by ordreSection";
    $result3 = mysqli_query($conn, $sql3);
        while ($row3 = mysqli_fetch_assoc($result3)){
            $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
            $result0 = mysqli_query($conn, $sql0);
            while($row0 = mysqli_fetch_assoc($result0)) {
                $output .= '<td>Eff.</td>
                        <td >Montant</td>';
            }
        }
        $output .= '<td>Eff.</td>
        <td >Montant</td>';
        $output .= '</tr>';
    return $output;
}
function designA1(){
    $output = '';      
    $conn = connection();
    $sql3 = "SELECT code_section,nomSection FROM section  order by ordreSection";    
    $result3 = mysqli_query($conn, $sql3);
    $sql1 = "SELECT code_designA1, nomDesignA1, categorie FROM designA1 order by categorie DESC";
    $result1 = mysqli_query($conn, $sql1);    
    $result10= mysqli_query($conn, $sql1);
    $row10 = mysqli_fetch_assoc($result10);
            while($row1 = mysqli_fetch_assoc($result1)) {
            $row10 = mysqli_fetch_assoc($result10);
               $output .= '<tr style="text-align:center;font-size:12px;"> <td> ' . $row1["nomDesignA1"]. '</td>';
                while ($row3 = mysqli_fetch_assoc($result3)){
                    $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
                    $result0 = mysqli_query($conn, $sql0);
                    while($row0 = mysqli_fetch_assoc($result0)) {
                        $sql2 = "SELECT effectif, mtA1 FROM designA1_sce_periode_data where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeSce = $row0[code_sce] and codeDesignA1=$row1[code_designA1]";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);  
                        $output .= ' <td>' . $row2["effectif"]. '</td>
                            <td>' . $row2["mtA1"]. '</td>';
                    }
            }
            $sql6= "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeDesignA1= $row1[code_designA1]";
            $result6 = mysqli_query($conn, $sql6);
            $row6 = mysqli_fetch_assoc($result6);
            $output .= '<td>' .$row6["somEffectif"]. '</td>
                        <td>' .$row6["somMt"]. '</td>';
            $output .= '</tr>';
            if ( $row1['categorie'] != $row10 ['categorie']){
                $output .= '<tr style="background-color: #BEBEBE;text-align:center;font-size:12px;"> <td  > S/T '.$row1["categorie"].'</td>';
                // Affichage des services
                $result3 = mysqli_query($conn, $sql3);
                    while ($row3 = mysqli_fetch_assoc($result3)){
                        $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
                        $result0 = mysqli_query($conn, $sql0);
                        while($row0 = mysqli_fetch_assoc($result0)) {
                            $sql4 = "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data 
                                        where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce] and categorie= '".$row1["categorie"]."'";
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_assoc($result4);
                            $output .= '<td>' .$row4["somEffectif"]. '</td>
                                        <td>' .$row4["somMt"]. '</td>';
                            }
                        }
                    $sql7 = "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data 
                    where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and categorie= '".$row1["categorie"]."'";
                    $result7 = mysqli_query($conn, $sql7);
                    $row7 = mysqli_fetch_assoc($result7);
                    $output .= '<td>' .$row7["somEffectif"]. '</td>
                                <td>' .$row7["somMt"]. '</td>';
                    $output .= '</tr>';                                                        
                    }
                $result3 = mysqli_query($conn, $sql3);                           
            }
    return $output;
}
function totalSce(){
    $output = '';      
    $conn = connection();
    $sql3 = "SELECT code_section,nomSection FROM section";    
    $result3 = mysqli_query($conn, $sql3);
    $output .= '<tr  style="background-color: #BEBEBE;text-align:center;font-size:12px;"> <td  >TOTAL</td>';
    $i = 0;
    while ($row3 = mysqli_fetch_assoc($result3)){
        $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
        $result0 = mysqli_query($conn, $sql0);
        while(($row0 = mysqli_fetch_assoc($result0)) and $i<4) {
            $sql4 = "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and   codeSce= $row0[code_sce]";
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);
            $output .= '<td >' .$row4["somEffectif"]. '</td>
                        <td >' .$row4["somMt"]. '</td>';
            }
            $i= $i+1;
        }
        //Total
        $sql8 = "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data 
            where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']."";
        $result8 = mysqli_query($conn, $sql8);
        $row8 = mysqli_fetch_assoc($result8);
        $output .= '<td >' .$row8["somEffectif"]. '</td>
                <td >' .$row8["somMt"]. '</td>';
        $output .= '</tr>';
        return $output;        
}


//PDF-PAGE1
function sections_pdf_p1(){
    $output = '';      
    $conn = connection();
    $sql="SELECT COUNT(code_sce) as nbrSce FROM service";
    $result= mysqli_query($conn, $sql);
    $nbrSce=mysqli_fetch_assoc($result);
    //if ($nbrSce["nbrSce"]<=24){
        $i=(int)($nbrSce["nbrSce"]/2);
        /*$nbrpage='2';
    }else{
        $i=$nbrSce["nbrSce"]/3+1;
        //$nbrpage='3';
    }*/
    $sql3 = "SELECT code_section,nomSection FROM section order by ordreSection";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($result3);
           $sql5="SELECT COUNT(code_sce) AS nbrSce FROM service  where codeSection= $row3[code_section]";
            $result5 = mysqli_query($conn, $sql5);
            $row5=mysqli_fetch_assoc($result5);
            $nbrSce= $row5["nbrSce"]*2;
            $output .= '<th colspan="'.$nbrSce.'" style="text-align:center;font-size:9px;text-transform: uppercase;"> SECTION ' .$row3["nomSection"]. '</th>';
    $row3 = mysqli_fetch_assoc($result3);
            $nbrSce= (int)($i-$row5["nbrSce"])*2;
            $output .= '<th colspan="'.$nbrSce.'" style="text-align:center;font-size:9px;text-transform: uppercase;"> SECTION ' .$row3["nomSection"]. '</th>';
    $output .= '</tr>';   
    return $output;
}
function services_pdf_p1()
 {
    $output = '<tr>';      
    $conn = connection();
    //nbr des services 
    $sql="SELECT COUNT(code_sce) as nbrSce FROM service";
    $result= mysqli_query($conn, $sql);
    $nbrSce=mysqli_fetch_assoc($result);
    //if ($nbrSce["nbrSce"]<=24){
        $i=(int)($nbrSce["nbrSce"]/2);
        /*$nbrpage='2';
    }else{
        $i=$nbrSce["nbrSce"]/3+1;
        //$nbrpage='3';
    }*/
    $n='1';
    $sql3 = "SELECT code_section,nomSection FROM section";
    $result3 = mysqli_query($conn, $sql3);
        while ($row3 = mysqli_fetch_assoc($result3)){
            $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
            $result0 = mysqli_query($conn, $sql0);
            while($row0 = mysqli_fetch_assoc($result0) and $n<=$i) {
                $output .= '<td colspan="2" style="text-align:center;font-size:8px;">' . $row0["nomSce"]. '</td>';
                $n=$n+1;
            }
        }
        $output .= '</tr>';
    return $output;
}
function mt_effectif_pdf_p1(){
    $output = '<tr>';      
    $conn = connection();
    //nbr des services 
    $sql="SELECT COUNT(code_sce) as nbrSce FROM service";
    $result= mysqli_query($conn, $sql);
    $nbrSce=mysqli_fetch_assoc($result);
    //if ($nbrSce["nbrSce"]<=24){
        $i=(int)($nbrSce["nbrSce"]/2);
        /*$nbrpage='2';
    }else{
        $i=$nbrSce["nbrSce"]/3+1;
        //$nbrpage='3';
    }*/
    $n='1';
    $sql3 = "SELECT code_section,nomSection FROM section";
    $result3 = mysqli_query($conn, $sql3);
        while ($row3 = mysqli_fetch_assoc($result3)){
            $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
            $result0 = mysqli_query($conn, $sql0);
            while($row0 = mysqli_fetch_assoc($result0)and $n<=$i) {
                $output .= '<td style="text-align:center;font-size:7px;">Eff.</td>
                            <td  style="text-align:center;font-size:7px;">Montant</td>';
                $n=$n+1;                        
            }
        }
        $output .= '</tr>';
    return $output;
}
function designA1_pdf_p1(){
    $output = '';      
    $conn = connection();
    //nbr des services 
    $sql="SELECT COUNT(code_sce) as nbrSce FROM service";
    $result= mysqli_query($conn, $sql);
    $nbrSce=mysqli_fetch_assoc($result);
    //if ($nbrSce["nbrSce"]<=24){
        $i=(int)($nbrSce["nbrSce"]/2);
        /*$nbrpage='2';
    }else{
        $i=$nbrSce["nbrSce"]/3+1;
        //$nbrpage='3';
    }*/
    $sql3 = "SELECT code_section,nomSection FROM section";    
    $result3 = mysqli_query($conn, $sql3);
    $sql1 = "SELECT code_designA1, nomDesignA1, categorie FROM designA1 order by categorie DESC";
    $result1 = mysqli_query($conn, $sql1);    
    $result10= mysqli_query($conn, $sql1);
    $row10 = mysqli_fetch_assoc($result10);
            while($row1 = mysqli_fetch_assoc($result1)) {
               $row10 = mysqli_fetch_assoc($result10);
               $output .= '<tr style="font-size:7px;text-align:center;"> <td> ' . $row1["nomDesignA1"]. '</td>';
               $n='1';               
                while ($row3 = mysqli_fetch_assoc($result3)){
                    $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
                    $result0 = mysqli_query($conn, $sql0);
                    //$m=(int)($i/2);                       
                    while($row0 = mysqli_fetch_assoc($result0)and $n<=$i) {
                        $sql2 = "SELECT effectif, mtA1 FROM designA1_sce_periode_data where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeSce = $row0[code_sce] and codeDesignA1=$row1[code_designA1]";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);  
                        $output .= ' <td>' . $row2["effectif"]. '</td>
                                     <td>' . $row2["mtA1"]. '</td>';
                                     $n=$n+1;                                                                
                    }
            }
            $output .= '</tr>';
            if ( $row1['categorie'] != $row10 ['categorie']){
                $n='1';                
                $output .= '<tr> <td style="background-color: #BEBEBE;text-align:center;font-size:8px;" > S/T '.$row1["categorie"].'</td>';
                // Affichage des services
                $result3 = mysqli_query($conn, $sql3);
                    while ($row3 = mysqli_fetch_assoc($result3)){
                        $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
                        $result0 = mysqli_query($conn, $sql0);
                        while($row0 = mysqli_fetch_assoc($result0)and $n<=$i) {
                            $sql4 = "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data 
                                        where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and   codeSce= $row0[code_sce] and categorie= '".$row1["categorie"]."'";
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_assoc($result4);
                            $output .= '<td style="background-color: #BEBEBE;text-align:center;font-size:7px;">' .$row4["somEffectif"]. '</td>
                                        <td style="background-color: #BEBEBE;text-align:center;font-size:7px;">' .$row4["somMt"]. '</td>';
                            $n=$n+1;                                                                
                            }
                        }
                    $output .= '</tr>';                                                        
                    }
                $result3 = mysqli_query($conn, $sql3);                           
            }
    return $output;
}
function totalSce_pdf_p1(){
    $output = '';      
    $conn = connection();
    $sql="SELECT COUNT(code_sce) as nbrSce FROM service";
    $result= mysqli_query($conn, $sql);
    $nbrSce=mysqli_fetch_assoc($result);
    //if ($nbrSce["nbrSce"]<=24){
        $i=(int)($nbrSce["nbrSce"]/2);
        /*$nbrpage='2';
    }else{
        $i=$nbrSce["nbrSce"]/3+1;
        //$nbrpage='3';
    }*/
    $sql3 = "SELECT code_section,nomSection FROM section";    
    $result3 = mysqli_query($conn, $sql3);
    $output .= '<tr  style="background-color: #BEBEBE;text-align:center;font-size:8px;"> <td style="font-size:9px;" >TOTAL</td>';
    $n='1';                   
    while ($row3 = mysqli_fetch_assoc($result3)){
        $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
        $result0 = mysqli_query($conn, $sql0);
        while(($row0 = mysqli_fetch_assoc($result0)) and $n<=$i) {
            $sql4 = "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and   codeSce= $row0[code_sce]";
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);
            $output .= '<td>' .$row4["somEffectif"]. '</td>
                        <td>' .$row4["somMt"]. '</td>';
            $n= $n+1;                        
            }
        }
        $output .= '</tr>';
        return $output;        
}

//PDF-PAGE2
function sections_pdf_p2(){
    $output = '<tr>';      
    $conn = connection();
    $sql="SELECT COUNT(code_sce) as nbrSce FROM service";
    $result= mysqli_query($conn, $sql);
    $nbrSce=mysqli_fetch_assoc($result);
    //if ($nbrSce["nbrSce"]<=24){
        $i=$nbrSce["nbrSce"]-(int)($nbrSce["nbrSce"]/2);
        /*$nbrpage='2';
    }else{
        $i=$nbrSce["nbrSce"]/3+1;
        //$nbrpage='3';
    }*/
    $sql3 = "SELECT code_section,nomSection FROM section order by ordreSection";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($result3);
    $row3 = mysqli_fetch_assoc($result3);
    $nbrSce= $i*2;  
            $output .= '<th colspan="'.$nbrSce.'" style="text-align:center;font-size:9px;text-transform: uppercase;"> SECTION ' .$row3["nomSection"]. '</th>';
            $output .= '<th colspan="2" rowspan="2" style="text-align:center;font-size:9px;text-transform: uppercase;"> TOTAL </th>';
            $output .= '</tr>';   
    return $output;
}
function services_pdf_p2()
 {
    $output = '<tr>';      
    $conn = connection();
    //nbr des services 
    $sql="SELECT COUNT(code_sce) as nbrSce FROM service";
    $result= mysqli_query($conn, $sql);
    $nbrSce=mysqli_fetch_assoc($result);
    //if ($nbrSce["nbrSce"]<=24){
        $i=$nbrSce["nbrSce"]-(int)($nbrSce["nbrSce"]/2);
        /*$nbrpage='2';
    }else{
        $i=$nbrSce["nbrSce"]/3+1;
        //$nbrpage='3';
    }*/
    $n='1';
    $sql3 = "SELECT code_section,nomSection FROM section";
    $result3 = mysqli_query($conn, $sql3);
        while ($row3 = mysqli_fetch_assoc($result3)){
            $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
            $result0 = mysqli_query($conn, $sql0);
            while($row0 = mysqli_fetch_assoc($result0) and $n<$i) {
                $n=$n+1;
            }
        }while($row0 = mysqli_fetch_assoc($result0)) {
            $output .= '<td colspan="2" style="text-align:center;font-size:8px;">' . $row0["nomSce"]. '</td>';
            $n=$n+1;
        }
        $output .= '</tr>';
    return $output;
}
function mt_effectif_pdf_p2(){
    $output = '<tr>';      
    $conn = connection();
    //nbr des services 
    $sql="SELECT COUNT(code_sce) as nbrSce FROM service";
    $result= mysqli_query($conn, $sql);
    $nbrSce=mysqli_fetch_assoc($result);
    //if ($nbrSce["nbrSce"]<=24){
        $i=$nbrSce["nbrSce"]-(int)($nbrSce["nbrSce"]/2);
        /*$nbrpage='2';
    }else{
        $i=$nbrSce["nbrSce"]/3+1;
        //$nbrpage='3';
    }*/
    $n='1';
    $sql3 = "SELECT code_section,nomSection FROM section";
    $result3 = mysqli_query($conn, $sql3);
        while ($row3 = mysqli_fetch_assoc($result3)){
            $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
            $result0 = mysqli_query($conn, $sql0);
            while($row0 = mysqli_fetch_assoc($result0)and $n<$i) {
                $n=$n+1;                        
            }
        }while($row0 = mysqli_fetch_assoc($result0)) {
            $output .= '<td style="text-align:center;font-size:7px;">Eff.</td>
                        <td  style="text-align:center;font-size:7px;">Montant</td>';
            $n=$n+1;                        
        }
        $output .= '<td style="text-align:center;font-size:7px;">Eff.</td>
        <td  style="text-align:center;font-size:7px;">Montant</td>';
        $output .= '</tr>';
    return $output;
}
function designA1_pdf_p2(){
    $output = '';      
    $conn = connection();
    //nbr des services 
    $sql="SELECT COUNT(code_sce) as nbrSce FROM service";
    $result= mysqli_query($conn, $sql);
    $nbrSce=mysqli_fetch_assoc($result);
    //if ($nbrSce["nbrSce"]<=24){
        $i=$nbrSce["nbrSce"]-(int)($nbrSce["nbrSce"]/2);
        /*$nbrpage='2';
    }else{
        $i=$nbrSce["nbrSce"]/3+1;
        //$nbrpage='3';
    }*/
    $sql3 = "SELECT code_section,nomSection FROM section";    
    $result3 = mysqli_query($conn, $sql3);
    $sql1 = "SELECT code_designA1, nomDesignA1, categorie FROM designA1 order by categorie DESC";
    $result1 = mysqli_query($conn, $sql1);    
    $result10= mysqli_query($conn, $sql1);
    $row10 = mysqli_fetch_assoc($result10);
            while($row1 = mysqli_fetch_assoc($result1)) {
               $row10 = mysqli_fetch_assoc($result10);
               $output .= '<tr style="font-size:7px;text-align:center;font-size:7px;">';
               $n='1';               
                while ($row3 = mysqli_fetch_assoc($result3)){
                    $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
                    $result0 = mysqli_query($conn, $sql0);
                    //$m=(int)($i/2);                       
                    while($row0 = mysqli_fetch_assoc($result0)and $n<$i) {
                                     $n=$n+1;                                                                
                    }
            } while($row0 = mysqli_fetch_assoc($result0)) {
                $sql2 = "SELECT effectif, mtA1 FROM designA1_sce_periode_data where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeSce = $row0[code_sce] and codeDesignA1=$row1[code_designA1]";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);  
                $output .= ' <td>' . $row2["effectif"]. '</td>
                             <td>' . $row2["mtA1"]. '</td>';
                             $n=$n+1;                                                                
            }
                $sql6= "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data 
                where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and codeDesignA1= $row1[code_designA1]";
                $result6 = mysqli_query($conn, $sql6);
                $row6 = mysqli_fetch_assoc($result6);
                $output .= '<td>' .$row6["somEffectif"]. '</td>
                            <td>' .$row6["somMt"]. '</td>';
                $output .= '</tr>';
            if ( $row1['categorie'] != $row10 ['categorie']){
                $n='1';                
                $output .= '<tr style="background-color: #BEBEBE;text-align:center;font-size:7px;">';
                // Affichage des services
                $result3 = mysqli_query($conn, $sql3);
                    while ($row3 = mysqli_fetch_assoc($result3)){
                        $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
                        $result0 = mysqli_query($conn, $sql0);
                        while($row0 = mysqli_fetch_assoc($result0)and $n<$i) {
                            $n=$n+1;                                                                
                            }
                        }while($row0 = mysqli_fetch_assoc($result0)) {
                            $sql4 = "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data 
                                       where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeSce= $row0[code_sce] and categorie= '".$row1["categorie"]."'";
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_assoc($result4);
                            $output .= '<td>' .$row4["somEffectif"]. '</td>
                                        <td>' .$row4["somMt"]. '</td>';
                            $n=$n+1;                                                                
                            }
                        $sql7 = "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and    categorie= '".$row1["categorie"]."'";
                        $result7 = mysqli_query($conn, $sql7);
                        $row7 = mysqli_fetch_assoc($result7);
                        $output .= '<td>' .$row7["somEffectif"]. '</td>
                                    <td>' .$row7["somMt"]. '</td>';
                    $output .= '</tr>';  
                    }
                $result3 = mysqli_query($conn, $sql3);                           
            }
    return $output;
}
function totalSce_pdf_p2(){
    $output = '';      
    $conn = connection();
    $sql="SELECT COUNT(code_sce) as nbrSce FROM service";
    $result= mysqli_query($conn, $sql);
    $nbrSce=mysqli_fetch_assoc($result);
    //if ($nbrSce["nbrSce"]<=24){
        $i=$nbrSce["nbrSce"]-(int)($nbrSce["nbrSce"]/2);
        /*$nbrpage='2';
    }else{
        $i=$nbrSce["nbrSce"]/3+1;
        //$nbrpage='3';
    }*/
    $sql3 = "SELECT code_section,nomSection FROM section";    
    $result3 = mysqli_query($conn, $sql3);
    $output .= '<tr  style="background-color: #BEBEBE;text-align:center;font-size:8px;">';
    $n='1';                   
    while ($row3 = mysqli_fetch_assoc($result3)){
        $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
        $result0 = mysqli_query($conn, $sql0);
        while(($row0 = mysqli_fetch_assoc($result0)) and $n<$i) {
            $n= $n+1;                        
            }
        }while(($row0 = mysqli_fetch_assoc($result0))) {
            $sql4 = "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']." and  codeSce= $row0[code_sce]";
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);
            $output .= '<td>' .$row4["somEffectif"]. '</td>
                        <td>' .$row4["somMt"]. '</td>';
            $n= $n+1;                        
            }
        //Total
        $sql8 = "SELECT sum(effectif) as somEffectif ,sum(mtA1) as somMt FROM designA1_sce_periode_data where periode='".$GLOBALS['periode']."' and trimestre='".$GLOBALS['trimestre']."' and annee=".$GLOBALS['annee']."";
        $result8 = mysqli_query($conn, $sql8);
        $row8 = mysqli_fetch_assoc($result8);
        $output .= '<td>' .$row8["somEffectif"]. '</td>
                <td>' .$row8["somMt"]. '</td>';
        $output .= '</tr>';
        return $output;        
}

if(isset($_POST["generate_pdf"]))  
 {  
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
      $content1.= '</h3><br>
                    <h4 style="text-align:right;text-transform: uppercase;">EFFECTIF - MASSE SALARIALE</h4>';
      $content1.='<p></p>';
      $content1.='<table border="1" cellspacing="0" cellpadding="3">
                  <tr>
                    <th rowspan="3" style="background-color: #BEBEBE;text-align:center;width:8%;font-size:9px;">Désignation</th>';   
      $content1.= sections_pdf_p1();
      $content1.= services_pdf_p1();
      $content1.= mt_effectif_pdf_p1();
      $content1.= designA1_pdf_p1();
      $content1.= totalSce_pdf_p1();
      $content1.='</table>';
      $obj_pdf->writeHTML($content1);  
      $obj_pdf->AddPage('L', 'A4');
      $content2 ='';
      $content2.= '<p></p><p></p><h3 style="text-align:right;text-transform: uppercase;">Tableau A1</h3><p></p>';
      $content2.= '<table border="1" cellspacing="0" cellpadding="3">';
      $content2.= sections_pdf_p2();
      $content2.= services_pdf_p2();
      $content2.= mt_effectif_pdf_p2();
      $content2.= designA1_pdf_p2();
      $content2.= totalSce_pdf_p2();
      $content2.='</table>';      
      $obj_pdf->writeHTML($content2);  
      $obj_pdf->Output('A1_Trimestriel_'.$GLOBALS['trimestre'].'_'.$GLOBALS['annee'].'.pdf', 'I'); 
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
            margin-left:80%;
            background-color:  #BEBEBE; 
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
                        echo"<h4>" .$title."</h4>";?>
                <br>
                    <h5>EFFECTIF - MASSE SALARIALE</h5>
                    <h5>TABLEAU A1 </h5>
                <table>
                <tr>
                <th rowspan="3" style="background-color: #BEBEBE;text-align:center;font-size:12px;">Désignation</th>

                <?php
                    //Affichage des sections
                        $sections= sections();
                        echo "".$sections."";
             
                    // Affichage de services 
                        $services= services();
                        echo "".$services."";

                    //Affichage Effectif && Montant row 
                        $mt_effectif= mt_effectif();
                        echo "".$mt_effectif."";
                    //Affichage des designA1- val_effectif&Montant
                        $designA1= designA1();
                        echo "".$designA1."";
                    //Affichage des Total Src 
                        $totalSce=totalSce();
                        echo"" .$totalSce. "";    
                ?>
                </table><br>
                <div class='row'>
                    <div class='col-sm-1'></div>
                    <div class='col-sm-5'>
                        <a href="http://localhost/compta_eph/genererRapportsPDF/rapportsChg/rapport_chg_<?php echo"".$periode."_".$table.".php?table=".$table."&annee=".$annee."&periode=".$periode."&trimestre=".$trimestre."";?>" class="btn btn-primary btn-sm" data-toggle="button" aria-pressed="false" autocomplete="off">
                            <span class='fa fa-sync-alt'></span> Rafraîchir
                        </a> 
                    </div>
                    <div class='col-sm-2'>
                        <a href="../../gestionTables/charges/insertion_chg.php?table=<?php echo"".$table."";?>_chg" class="btn btn-success" data-toggle="button" aria-pressed="false" autocomplete="off" target='_blank'>
                            <span class='fa fa-plus-circle'></span> Insérer un nouvel enregistrement 
                        </a>  
                    </div> 
                    <div class='col-sm-2'>
                        <a href="../../gestionTables/charges/maj_chg.php?table=<?php echo"".$table."";?>_chg" class="btn btn-info" data-toggle="button" aria-pressed="false" autocomplete="off" target='_blank'>
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
                                
