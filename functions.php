<?
		
// funzione secondi a tempo
	function sec2hms ($sec, $padHours = false) 
		{
		    $hms = "";
		    $hours = intval(intval($sec) / 3600);
		    $hms .= ($padHours)
		    ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
		    : $hours. ':';
		    $minutes = intval(($sec / 60) % 60);
		    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
		    $seconds = intval($sec % 60);
		    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
		    return $hms;
		}

// funzione secondi a ms
	function sec2ms ($sec, $padHours = false) 
		{
		    $ms = "";
		    $ms .= ($padHours);
		    $minutes = intval(($sec / 60) % 60);
		    $ms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
		    $seconds = intval($sec % 60);
		    $ms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
		    return $ms;
		}
		

// funzione secondi a msp (con . invece di :) trasforma in minuti/km
	function sec2msp ($sec, $padHours = false) {
		    $ms = "";
		    $minutes = intval(($sec / 60) % 60);
		    $ms .= $minutes . '.';
		    $seconds = intval($sec % 60);
		    $ms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
		    return $ms;
	}
//funzione taglia (eliminazione valori estremi in min/km)
	function taglia ($v){
		if ($v < 2.50){
			return "2.50";
		}
		elseif ($v > 10){
			return "10";
		}
		else return $v;
	}
	
//funzione taglia (eliminazione valori estremi in m/s)
	function tagliams ($v){
		if ($v < 150){
			return "150";
		}
		elseif ($v > 990){
			return "990";
		}
		else return $v;
	}

//Funzione trova il +vicino 
function getClosest($search, $arr){
   $closest = null;
   foreach($arr as $item)
   {
      if($closest == null || abs($search - $closest) > abs($item - $search))
      {
         $closest = $item;
      }
   }
   return $closest;
}

//funzione distanza coordinate
function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000){
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $lonFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $lonTo = deg2rad($longitudeTo);
 
  $lonDelta = $lonTo - $lonFrom;
  $a = pow(cos($latTo) * sin($lonDelta), 2) +
    pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
  $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
 
  $angle = atan2(sqrt($a), $b);
  return $angle * $earthRadius;
}

function encrypt($toEncrypt)
{
    global $key;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    return base64_encode($iv . mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $toEncrypt, MCRYPT_MODE_CBC, $iv));
}

function decrypt($toDecrypt)
{
    global $key;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
    $toDecrypt = base64_decode($toDecrypt);
    return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, substr($toDecrypt, $iv_size), MCRYPT_MODE_CBC, substr($toDecrypt, 0, $iv_size)));
}


/************************************************
** Date DropDown
************************************************/

Function ShowFromDate($year_interval,$YearIntervalType) {
GLOBAL $day,$month,$year;

//DAY
echo "<select name=day>\n";
$i=1;
$CurrDay=date("d");
If(!IsSet($day)) $day=$CurrDay;
while ($i <= 31)
      {
       If(IsSet($day)) {
         If($day == $i || ($i == substr($day,1,1) && (substr($day,0,1) == 0))) {
                  echo"<option selected> $day\n";
                  $i++;
         }Else{
                If($i<10) {
                   echo "<option> 0$i\n";
                }Else {
                   echo "<option> $i\n";
                }
                $i++;
         }
       }Else {
              If($i == $CurrDay)
                If($i<10) {
                   echo "<option selected> 0$i\n";
                }Else {
                   echo"<option selected> $i\n";
                }
              Else {
                If($i<10) {
                   echo "<option> 0$i\n";
                }Else {
                   echo "<option> $i\n";
                }
              }
              $i++;
       }
      }
echo "</select>\n";

//MONTH
echo " / <select name=month>\n";
$i=1;
$CurrMonth=date("m");
while ($i <= 12)
     {
      If(IsSet($month)) {
         If($month == $i || ($i == substr($month,1,1) && (substr($month,0,1) == 0))) {
            echo"<option selected> $month\n";
            $i++;
         }Else{
            If($i<10) {
               echo "<option> 0$i\n";
            }Else {
               echo "<option> $i\n";
            }
            $i++;
         }
      }Else {
            If($i == $CurrMonth) {
              If($i<10) {
                 echo "<option selected> 0$i\n";
              }Else {
                 echo "<option selected> $i\n";
              }
            }Else {
              If($i<10){
                 echo "<option> 0$i\n";
              }Else {
                 echo "<option> $i\n";
              }
            }
            $i++;
      }
}
  echo "</select>\n";

//YEAR
  echo " / <select name=year>\n";
  $CurrYear=date("Y");
  If($YearIntervalType == "Past") {
      $i=$CurrYear-$year_interval+1;
      while ($i <= $CurrYear)
           {
            If($i == $year) {
               echo "<option selected> $i\n";
            }ElseIf ($i == $CurrYear && !IsSet($year)) {
               echo "<option selected> $i\n";
            }Else {
               echo "<option> $i\n";
            }
            $i++;
           }
       echo "</select>\n";
  }
  If($YearIntervalType == "Future") {
      $i=$CurrYear+$year_interval;
      while ($CurrYear < $i)
           {
            if ($year == $CurrYear) echo "<option selected> $CurrYear\n";
              else echo "<option> $CurrYear\n";
            $CurrYear++;
           }
       echo "</select>\n";
  }
  If($YearIntervalType == "Both") {
      $i=$CurrYear-$year_interval+1;
      while ($i < $CurrYear+$year_interval)
           {
            if ($i == $CurrYear) echo "<option selected> $i\n";
              else echo "<option> $i\n";
            $i++;
           }
       echo "</select>\n";
  }
}

//Usage Example :
//ShowFromDate(4,"Future");
/* DATE PICKER */
function date_picker($name, $startyear=NULL, $endyear=NULL)
{
    if($startyear==NULL) $startyear = date("Y")-14;
    if($endyear==NULL) $endyear=date("Y"); 

    $months=array('','Gennaio','Febbraio','Marzo','Aprile','Maggio',
    'Giugno','Luglio','Agosto', 'Settembre','Ottobre','Novembre','Dicembre');
   
    // Day dropdown
	$html="<select name=\"day\">";
    for($i=1;$i<=31;$i++){
       $html.="<option $selected value='$i'>$i</option>";
    }
    $html.="</select> ";
	
	// Month dropdown
	$html.="<select name=\"month\">";
    for($i=1;$i<=12;$i++){
       $html.="<option value='$i'>$months[$i]</option>";
    }
    $html.="</select> ";

    // Year dropdown
	 $html.="<select name=\"year\">";
    for($i=$startyear;$i<=$endyear;$i++){      
      $html.="<option value='$i'>$i</option>";
    }
    $html.="</select> ";

    return $html;
}
?>
  
<!--       funzione per chiamare il calendario   -->
  <script type="text/javascript">

   function showMonth(str, yr, userid)
   {
     if (str=="") {
      document.getElementById("calendar").innerHTML="";
      return;
     }
     if (window.XMLHttpRequest) {
       // code for IE7+, Firefox, Chrome, Opera, Safari
       xmlhttp=new XMLHttpRequest();
     }
     else {
       // code for IE6, IE5
       xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
     }

     xmlhttp.onreadystatechange=function()
     {
       if (xmlhttp.readyState==4 && xmlhttp.status==200)
       {
        document.getElementById("calendar").innerHTML=xmlhttp.responseText;
       }
     }
     xmlhttp.open("GET","calendar.php?userid=" + userid + "&m=" + str + "&y=" + yr, true);
     xmlhttp.send();
     return;
   }
    function showMonthbike(str, yr)
   {
     if (str=="") {
      document.getElementById("calendar").innerHTML="";
      return;
     }
     if (window.XMLHttpRequest) {
       // code for IE7+, Firefox, Chrome, Opera, Safari
       xmlhttp=new XMLHttpRequest();
     }
     else {
       // code for IE6, IE5
       xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
     }

     xmlhttp.onreadystatechange=function()
     {
       if (xmlhttp.readyState==4 && xmlhttp.status==200)
       {
        document.getElementById("calendar").innerHTML=xmlhttp.responseText;
       }
     }
     xmlhttp.open("GET","calendarbike.php?m="+str + "&y=" + yr,true);
     xmlhttp.send();
     return;
   }
    function showMonthswim(str, yr)
   {
     if (str=="") {
      document.getElementById("calendar").innerHTML="";
      return;
     }
     if (window.XMLHttpRequest) {
       // code for IE7+, Firefox, Chrome, Opera, Safari
       xmlhttp=new XMLHttpRequest();
     }
     else {
       // code for IE6, IE5
       xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
     }

     xmlhttp.onreadystatechange=function()
     {
       if (xmlhttp.readyState==4 && xmlhttp.status==200)
       {
        document.getElementById("calendar").innerHTML=xmlhttp.responseText;
       }
     }
     xmlhttp.open("GET","calendarswim.php?m="+str + "&y=" + yr,true);
     xmlhttp.send();
     return;
   }
//funzione controllo solo numeri

function isNumeric(elem, helperMsg){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		alert(helperMsg);
		elem.focus();
		return false;
	}
}
</script>



