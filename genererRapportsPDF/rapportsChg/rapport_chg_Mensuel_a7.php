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
$mois="";
$table="";
  if(isset($_GET['annee'])){ 
    $periode=($_GET['periode']);
    $annee=($_GET['annee']);
    $mois=($_GET['mois']);
    $table=($_GET['table']);    
  } 
function title(){
    $output = '';
    $conn = connection();
    $output .='CALCUL DES COUTS / WILAYA DE JIJEL EPH  D`EL-MILIA / PERIODE '.$GLOBALS['mois'].' ANNEE '.$GLOBALS['annee']."";
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
            $nbrSce= $row5["nbrSce"];
            $output .= '<th colspan="'.$nbrSce.'" style="text-align:center;text-transform: uppercase;font-size:12px;"> Section ' .$row3["nomSection"]. '</th>';
        }
    $output .= '<th colspan="1" rowspan="2" style="text-align:center;font-size:12px;"> TOTAL </th>';
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
                $output .= '<td colspan="1" style="text-align:center;font-size:12px;">' . $row0["nomSce"]. '</td>';
            }
        }
        $output .= '</tr>';
    return $output;
}

function designA7(){
    $output = '';      
    $conn = connection();
    $sql3 = "SELECT code_section,nomSection FROM section  order by ordreSection";    
    $result3 = mysqli_query($conn, $sql3);
    $sql1 = "SELECT code_designA7, nomDesignA7 FROM designA7 order by nomDesignA7 DESC";
    $result1 = mysqli_query($conn, $sql1);    
    $result10= mysqli_query($conn, $sql1);
    $row10 = mysqli_fetch_assoc($result10);
            while($row1 = mysqli_fetch_assoc($result1)) {
            $row10 = mysqli_fetch_assoc($result10);
               $output .= '<tr style="text-align:center;font-size:12px;"> <td> ' . $row1["nomDesignA7"]. '</td>';
                while ($row3 = mysqli_fetch_assoc($result3)){
                    $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
                    $result0 = mysqli_query($conn, $sql0);
                    while($row0 = mysqli_fetch_assoc($result0)) {
                        $sql2 = "SELECT mtA7 FROM designA7_sce_periode_data where periode='".$GLOBALS['periode']."' and mois='".$GLOBALS['mois']."' and annee=".$GLOBALS['annee']." and  codeSce = $row0[code_sce] and codeDesignA7=$row1[code_designA7]";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);  
                        $output .= '<td>' . $row2["mtA7"]. '</td>';
                    }
            }
            $sql6= "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data where periode='".$GLOBALS['periode']."' and mois='".$GLOBALS['mois']."' and annee=".$GLOBALS['annee']." and  codeDesignA7= $row1[code_designA7]";
            $result6 = mysqli_query($conn, $sql6);
            $row6 = mysqli_fetch_assoc($result6);
            $output .= '<td>'.$row6["somMt"]. '</td>';
            $output .= '</tr>';
            
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
            $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and mois='".$GLOBALS['mois']."' and annee=".$GLOBALS['annee']." and   codeSce= $row0[code_sce]";
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);
            $output .= '<td >' .$row4["somMt"]. '</td>';
            }
            $i= $i+1;
        }
        //Total
        $sql8 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
            where periode='".$GLOBALS['periode']."' and mois='".$GLOBALS['mois']."' and annee=".$GLOBALS['annee']."";
        $result8 = mysqli_query($conn, $sql8);
        $row8 = mysqli_fetch_assoc($result8);
        $output .= '<td >' .$row8["somMt"]. '</td>';
        $output .= '</tr>';
        return $output;        
}

function totalSce_trim(){
    $output = '';      
    $conn = connection();
    $sql3 = "SELECT code_section,nomSection FROM section";    
    $result3 = mysqli_query($conn, $sql3);
    $output .= '<tr style="height:20px;"><td colspan=100></td></tr>
                <tr  style="background-color: #BEBEBE;text-align:center;font-size:12px;"> <td  >TOTAL</td>';
    $i = 0;
    while ($row3 = mysqli_fetch_assoc($result3)){
        $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
        $result0 = mysqli_query($conn, $sql0);
        while(($row0 = mysqli_fetch_assoc($result0)) and $i<4) {
            if ($GLOBALS['mois']=="Mars"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Mars' or mois='Fevrier' or mois='Janvier'); ";
            }else if ($GLOBALS['mois']=="Juin"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Juin' or mois='Mai' or mois='Avril'); ";
            }else if ($GLOBALS['mois']=="Septembre"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Septembre' or mois='Aout' or mois='Juillet'); ";
            }else if ($GLOBALS['mois']=="Decembre"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Decembre' or mois='Octobre' or mois='Novembre'); ";
            }
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);
            $output .= '<td >'  .$row4["somMt"]. '</td>';
            }
            $i= $i+1;
        }
        //Total
        if ($GLOBALS['mois']=="Mars"){            
            $sql8 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']."    
                    and ( mois='Mars' or mois='Fevrier' or mois='Janvier'); ";
        }else if ($GLOBALS['mois']=="Juin"){
            $sql8 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                    where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']."   
                        and ( mois='Juin' or mois='Mai' or mois='Avril'); ";
        }else if ($GLOBALS['mois']=="Septembre"){
            $sql8 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                    where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']."   
                        and ( mois='Septembre' or mois='Aout' or mois='Juillet'); ";
        }else if ($GLOBALS['mois']=="Decembre"){
            $sql8 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                    where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']."   
                        and ( mois='Decembre' or mois='Octobre' or mois='Novembre'); ";
        }
        $result8 = mysqli_query($conn, $sql8);
        $row8 = mysqli_fetch_assoc($result8);
        $output .= '<td >'.$row8["somMt"]. '</td>';
        $output .= '</tr>';
        return $output;        
}
//pdf 
function titleA7_pdf(){

    $output='</h3><br><br><br>                  
            <h3 style="text-align:center;text-transform: uppercase;">FOURNITURES DIVERSES</h3>';
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
            $nbrSce= $row5["nbrSce"];
            $output .= '<th colspan="'.$nbrSce.'" style="text-align:center;font-size:9px;text-transform: uppercase;"> SECTION ' .$row3["nomSection"]. '</th>';
    $row3 = mysqli_fetch_assoc($result3);
            $nbrSce= (int)($i-$row5["nbrSce"]);
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
                $output .= '<td colspan="1" style="text-align:center;font-size:8px;">' . $row0["nomSce"]. '</td>';
                $n=$n+1;
            }
        }
        $output .= '</tr>';
    return $output;
}
function designA7_pdf_p1(){
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
    $sql1 = "SELECT code_designA7, nomDesignA7 FROM designA7 order by nomDesignA7 DESC";
    $result1 = mysqli_query($conn, $sql1);    
    $result10= mysqli_query($conn, $sql1);
    $row10 = mysqli_fetch_assoc($result10);
            while($row1 = mysqli_fetch_assoc($result1)) {
               $row10 = mysqli_fetch_assoc($result10);
               $output .= '<tr style="font-size:7px;text-align:center;"> <td> ' . $row1["nomDesignA7"]. '</td>';
               $n='1';               
                while ($row3 = mysqli_fetch_assoc($result3)){
                    $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
                    $result0 = mysqli_query($conn, $sql0);
                    //$m=(int)($i/2);                       
                    while($row0 = mysqli_fetch_assoc($result0)and $n<=$i) {
                        $sql2 = "SELECT mtA7 FROM designA7_sce_periode_data where periode='".$GLOBALS['periode']."' and mois='".$GLOBALS['mois']."' and annee=".$GLOBALS['annee']." and  codeSce = $row0[code_sce] and codeDesignA7=$row1[code_designA7]";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);  
                        $output .= ' <td>'.$row2["mtA7"]. '</td>';
                                     $n=$n+1;                                                                
                    }
            }
            $output .= '</tr>';
            
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
            $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and mois='".$GLOBALS['mois']."' and annee=".$GLOBALS['annee']." and   codeSce= $row0[code_sce]";
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);
            $output .= '<td>'.$row4["somMt"]. '</td>';
            $n= $n+1;                        
            }
        }
        $output .= '</tr>';
        return $output;        
}
function totalSce_trim_pdf_p1(){
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
    $output .= '<tr style="height:20px;"><td colspan="100"></td></tr>
                <tr  style="background-color: #BEBEBE;text-align:center;font-size:8px;"> <td style="font-size:9px;" >TOTAL</td>';
    $n='1';                   
    while ($row3 = mysqli_fetch_assoc($result3)){
        $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
        $result0 = mysqli_query($conn, $sql0);
        while(($row0 = mysqli_fetch_assoc($result0)) and $n<=$i) {
            if ($GLOBALS['mois']=="Mars"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Mars' or mois='Fevrier' or mois='Janvier'); ";
            }else if ($GLOBALS['mois']=="Juin"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Juin' or mois='Mai' or mois='Avril'); ";
            }else if ($GLOBALS['mois']=="Septembre"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Septembre' or mois='Aout' or mois='Juillet'); ";
            }else if ($GLOBALS['mois']=="Decembre"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Decembre' or mois='Octobre' or mois='Novembre'); ";
            }
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);
            $output .= '<td>' .$row4["somMt"]. '</td>';
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
    $nbrSce= $i;  
            $output .= '<th colspan="'.$nbrSce.'" style="text-align:center;font-size:9px;text-transform: uppercase;"> SECTION ' .$row3["nomSection"]. '</th>';
            $output .= '<th colspan="1" rowspan="2" style="text-align:center;font-size:9px;text-transform: uppercase;"> TOTAL </th>';
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
        }
        while($row0 = mysqli_fetch_assoc($result0)) {
            $output .= '<td colspan="1" style="text-align:center;font-size:8px;">' . $row0["nomSce"]. '</td>';
            $n=$n+1;
        }
        $output .= '</tr>';
    return $output;
}    
function designA7_pdf_p2(){
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
    $sql1 = "SELECT code_designA7, nomDesignA7 FROM designA7 order by nomDesignA7 DESC";
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
            }
            while($row0 = mysqli_fetch_assoc($result0)) {
                $sql2 = "SELECT mtA7 FROM designA7_sce_periode_data where periode='".$GLOBALS['periode']."' and mois='".$GLOBALS['mois']."' and annee=".$GLOBALS['annee']." and  codeSce = $row0[code_sce] and codeDesignA7=$row1[code_designA7]";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);  
                $output .= ' <td>'. $row2["mtA7"]. '</td>';
                             $n=$n+1;                                                                
            }
                $sql6= "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                where periode='".$GLOBALS['periode']."' and mois='".$GLOBALS['mois']."' and annee=".$GLOBALS['annee']." and codeDesignA7= $row1[code_designA7]";
                $result6 = mysqli_query($conn, $sql6);
                $row6 = mysqli_fetch_assoc($result6);
                $output .= '<td>' .$row6["somMt"]. '</td>';
                $output .= '</tr>';
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
        }while(($row0 = mysqli_fetch_assoc($result0)) ) {
            $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and mois='".$GLOBALS['mois']."' and annee=".$GLOBALS['annee']." and  codeSce= $row0[code_sce]";
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);
            $output .= '<td>'.$row4["somMt"]. '</td>';
            $n= $n+1;                        
            }
        //Total
        $sql8 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data where periode='".$GLOBALS['periode']."' and mois='".$GLOBALS['mois']."' and annee=".$GLOBALS['annee']."";
        $result8 = mysqli_query($conn, $sql8);
        $row8 = mysqli_fetch_assoc($result8);
        $output .= '<td>'.$row8["somMt"]. '</td>';
        $output .= '</tr>';
        return $output;        
}
function totalSce_trim_pdf_p2(){
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
    $output .= '<tr style="height:20px;"><td colspan="100"></td></tr>
                <tr  style="background-color: #BEBEBE;text-align:center;font-size:8px;">';
    $n='1';                   
    while ($row3 = mysqli_fetch_assoc($result3)){
        $sql0 = "SELECT code_sce,nomSce FROM service where codeSection= $row3[code_section] order by ordre";
        $result0 = mysqli_query($conn, $sql0);
        while(($row0 = mysqli_fetch_assoc($result0)) and $n<$i) {
            $n= $n+1;                        
            }
        }while(($row0 = mysqli_fetch_assoc($result0))) {
            if ($GLOBALS['mois']=="Mars"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Mars' or mois='Fevrier' or mois='Janvier'); ";
            }else if ($GLOBALS['mois']=="Juin"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Juin' or mois='Mai' or mois='Avril'); ";
            }else if ($GLOBALS['mois']=="Septembre"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Septembre' or mois='Aout' or mois='Juillet'); ";
            }else if ($GLOBALS['mois']=="Decembre"){
                $sql4 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                        where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']." and codeSce= $row0[code_sce]   
                            and ( mois='Decembre' or mois='Octobre' or mois='Novembre'); ";
            }
            $result4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($result4);
            $output .= '<td>' .$row4["somMt"]. '</td>';
            $n= $n+1;                        
            }
        //Total
        if ($GLOBALS['mois']=="Mars"){            
            $sql8 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']."    
                    and ( mois='Mars' or mois='Fevrier' or mois='Janvier'); ";
        }else if ($GLOBALS['mois']=="Juin"){
            $sql8 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                    where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']."   
                        and ( mois='Juin' or mois='Mai' or mois='Avril'); ";
        }else if ($GLOBALS['mois']=="Septembre"){
            $sql8 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                    where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']."   
                        and ( mois='Septembre' or mois='Aout' or mois='Juillet'); ";
        }else if ($GLOBALS['mois']=="Decembre"){
            $sql8 = "SELECT sum(mtA7) as somMt FROM designA7_sce_periode_data 
                    where periode='".$GLOBALS['periode']."' and annee=".$GLOBALS['annee']."   
                        and ( mois='Decembre' or mois='Octobre' or mois='Novembre'); ";
        }       
        $result8 = mysqli_query($conn, $sql8);
        $row8 = mysqli_fetch_assoc($result8);
        $output .= '<td>'.$row8["somMt"]. '</td>';
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
      $content1.= titleA7_pdf();
      $content1.='<p></p>';
      $content1.='<table border="1" cellspacing="0" cellpadding="3">
                  <tr>
                    <th rowspan="2" style="background-color: #BEBEBE;text-align:center;width:12%;font-size:9px;">Désignation</th>';   
      $content1.= sections_pdf_p1();
      $content1.= services_pdf_p1();
      $content1.= designA7_pdf_p1();
      $content1.= totalSce_pdf_p1();
      if ($GLOBALS['mois']=="Mars" or $GLOBALS['mois']=="Juin" or $GLOBALS['mois']=="Septembre" or $GLOBALS['mois']=="Decembre"){
      $content1.= totalSce_trim_pdf_p1();}
      $content1.='</table>';
      $obj_pdf->writeHTML($content1);  
      $obj_pdf->AddPage('L', 'A4');
      $content2 ='';
      $content2.= '<p></p><p></p><h3 style="text-align:right;text-transform: uppercase;">Tableau A7</h3><p></p>';
      $content2.= '<table border="1" cellspacing="0" cellpadding="3">';
      $content2.= sections_pdf_p2();
      $content2.= services_pdf_p2();
      $content2.= designA7_pdf_p2();
      $content2.= totalSce_pdf_p2();
      if ($GLOBALS['mois']=="Mars" or $GLOBALS['mois']=="Juin" or $GLOBALS['mois']=="Septembre" or $GLOBALS['mois']=="Decembre"){
      $content2.= totalSce_trim_pdf_p2();}
      $content2.='</table>';      
      $obj_pdf->writeHTML($content2);  
      $obj_pdf->Output('A7_Mensuel_'.$GLOBALS['mois'].'_'.$GLOBALS['annee'].'.pdf', 'I'); 
    }  
 ?>  
 <!DOCTYPE html>  
 <html>  
    <head>  
           <title>Rapport | CHARGES |<?php echo" ".$periode." | ".$mois."";?></title>  
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
                    <h5 style="margin-left:78%;">FOURNITURES DIVERSES</h5>
                    <h5 style="margin-left:78%;">TABLEAU A7 </h5>
                <table>
                <tr>
                <th colspan="1" rowspan="2" style="background-color: #BEBEBE;text-align:center;font-size:14px;padding-left:70px;padding-right:70px;">Désignation</th>

                <?php
                    //Affichage des sections
                        $sections= sections();
                        echo "".$sections."";
             
                    // Affichage de services 
                        $services= services();
                        echo "".$services."";

                    //Affichage des designA7- val_nbrerepas&Montant
                        $designA7= designA7();
                        echo "".$designA7."";
                    //Affichage des Total Src 
                        $totalSce=totalSce();
                        echo"" .$totalSce. "";
                    // Affichage totale trimestre
                     if ($GLOBALS['mois']=="Mars" or $GLOBALS['mois']=="Juin" or $GLOBALS['mois']=="Septembre" or $GLOBALS['mois']=="Decembre"){
                        $totalSce_trim= totalSce_trim();
                        echo"" .$totalSce_trim. "";
                        }
                        
                ?>
                </table><br>
                <div class='row'>
                    <div class='col-sm-1'></div>
                    <div class='col-sm-5'>
                        <a href="http://localhost/compta_eph/genererRapportsPDF/rapportsChg/rapport_chg_<?php echo"".$periode."_".$table.".php?table=".$table."&annee=".$annee."&periode=".$periode."&mois=".$mois."";?>" class="btn btn-primary btn-sm" data-toggle="button" aria-pressed="false" autocomplete="off">
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
                                
