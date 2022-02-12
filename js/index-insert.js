
// Datepicker Mois 
$.fn.datepicker.dates['mois'] = {
    days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
    daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
    daysMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
    months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Nouvembre", "Décembre"],
    monthsShort: ["Jan.", "Fév", "Mar", "Avr", "Mai", "Jun", "Jul", "Aou", "Sep", "Oct", "Nov", "Déc"],
    today: "Today",
    clear: "Clear",
    format: "mm/dd/yyyy",
    titleFormat: "mm yyyy",
    weekStart: 0,
    setStartDate:"01-2010"
    };
    $('#date-mois-picker').datepicker({
    format: "mm yyyy",
    minViewMode: 1,
    autoclose: true,    
    language: "mois",
    forceParse: false,
    }).on('changeDate', function(){
        var date = $("#date-mois-picker").data("datepicker").getDate();
        document.getElementById("date-text-annee").value =date.getFullYear();
        document.getElementById("date-text-mois-sem").value =date.getMonth()+1;
});

    
// Datepicker Semestres 

var showQuartersDatepicker = function(event) {
          event.preventDefault();
          $(".datepicker-months .month").each(function(index, element) {
            if (index > 3) {
              $(element).hide()
            } else {
              $(element).addClass('quarters');
            }
          });
        }
$.fn.datepicker.dates['semestr'] = {
days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
daysMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
months: ["T1", "T2", "T3", "T4", "", "", "", "", "", "", "", ""],
monthsShort: ["T1", "T2", "T3", "T4", "", "", "", "", "", "", "", ""],
today: "Today",
clear: "Clear",
format: "mm/dd/yyyy",
titleFormat: "mm yyyy",
beforeShowMonth: 'quarters',
weekStart: 0
};

$('#date-sem-picker').datepicker({
format: "mm yyyy",
minViewMode: 1,
autoclose: true,
language: "semestr",
forceParse: false
}).on("show keyup", showQuartersDatepicker
).on('changeDate', function(){
var date = $("#date-sem-picker").data("datepicker").getDate();
document.getElementById("date-text-annee").value =date.getFullYear();
document.getElementById("date-text-mois-sem").value =date.getMonth()+1;	
});

/********* date picker annee  */
$.fn.datepicker.dates['annee'] = {
    days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
    daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
    daysMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
    months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Nouvembre", "Décembre"],
    monthsShort: ["Jan.", "Fév", "Mar", "Avr", "Mai", "Jun", "Jul", "Aou", "Sep", "Oct", "Nov", "Déc"],
    today: "Today",
    clear: "Clear",
    format: "yyyy",
    titleFormat: "yyyy",
    weekStart: 0,
    setStartDate:"2010"
    };
    $('#date-annee-picker').datepicker({
    format: "yyyy",
    minViewMode: 1,
    autoclose: true,    
    language: "annee",
    viewMode: "years", 
    minViewMode: "years",
    forceParse: false,
    }).on('changeDate', function(){
        var date = $("#date-annee-picker").data("datepicker").getDate();
        document.getElementById("date-text-annee").value =date.getFullYear();
});
/************************************************************************************************ */

// Debut et fin 
$('#date-mois-picker').datepicker('setStartDate', "01-2010");
$('#date-sem-picker').datepicker('setStartDate', "01-2010");
$('#date-annee-picker').datepicker('setStartDate', "2010");
var endDate= new Date();
    endDate= "01-"+(endDate.getFullYear()+1);
var endDateAnnee= new Date();
    endDateAnnee= ""+(endDateAnnee.getFullYear());
$('#date-mois-picker').datepicker('setEndDate',endDate);
$('#date-sem-picker').datepicker('setEndDate',endDate);
$('#date-annee-picker').datepicker('setEndDate',endDateAnnee);



// hide and show 
function showDiv(elem){
if(elem.value == "Trimestriel"){
     document.getElementById("div-mois").style.display = "none";
     document.getElementById("date-mois-picker").required = false;     
     document.getElementById("div-sem").style.display = "block";
     document.getElementById("date-sem-picker").required = true;     
}
else if(elem.value =="Mensuel"){
    document.getElementById("div-mois").style.display = "block";
    document.getElementById("date-mois-picker").required = true;         
    document.getElementById("div-sem").style.display = "none"; 
    document.getElementById("date-sem-picker").required = false;    
}

}