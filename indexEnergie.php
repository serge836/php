<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Prototype encryption</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script>
function submitForm()
{
 document.frm.submit();
}
</script>
	</head>
	<body onload="submitForm()">

        <form name="frm" id="frm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
			<?php						
					$key="Swaweqetu7rathAnas8et4semaswaWru";
					$iv=substr($key,strlen($key)-16);
					$web_directory=$_GET["web_directory"];
					$FrmReceipt = crypt_value($key,$iv,1);			
					$FrmFirstName = urlencode(crypt_value($key,$iv,urldecode(Traitement($_GET["FrmFirstName"],'0'))));
					$FrmLastName = urlencode(crypt_value($key,$iv,urldecode(Traitement($_GET["FrmLastName"],'0'))));
					$FrmAddress=urlencode(crypt_value($key,$iv,urldecode(TraitementAddress($_GET["FrmAddress"],'Adresse'))));
					$FrmEmail=urlencode(crypt_value($key,$iv,format_EMAIL($_GET["FrmEmail"])));
					$FpsUID96 = urlencode(crypt_value($key,$iv,$_GET["FpsUID96"]));
					$FrmActUID479 = urlencode(crypt_value($key,$iv,$_GET["FrmActUID479"]));
					$FrmCity = urlencode(crypt_value($key,$iv,str_replace("\'","'",TraitementAddress($_GET["FrmCity"],'Ville'))));
					$FrmPostalCode=urlencode(crypt_value($key,$iv,format_CP($_GET["FrmPostalCode"])));
					$FrmHome=urlencode(crypt_value($key,$iv,format_phone($_GET["FrmHome"])));
					$FrmComment = urlencode(crypt_value($key,$iv,$_GET["FrmComment"]));	
					$FrmCountry = urlencode(crypt_value($key,$iv,"Canada"));
					$url="https://www.jedonneenligne.org/$web_directory/index.php?PersonnalKey=1&FrmComment=$FrmComment&FrmActUID479=$FrmActUID479&FrmFirstName=$FrmFirstName&FrmLastName=$FrmLastName&FrmAddress=$FrmAddress&FrmUID=19&FrmCity=$FrmCity&FrmPostalCode=$FrmPostalCode&FrmHome=$FrmHome&FrmEmail=$FrmEmail&FrmEmailConfirmation=$FrmEmail&FpsUID96=$FpsUID96&FrmCountry=$FrmCountry";
					echo "VEUILLEZ PATIENTER...";
					
					echo "veuillez patienter...";	
					?>	
					<?php
					
					
function format_phone($phone)
{
	$formatted = "(".substr($phone,0,3).") ".substr($phone,3,3)."-".substr($phone,6);
    return $formatted;
}

function format_CP($CP)
{
	if ((trim($_GET["VADRE"]) == 'N' && trim($_GET["QUNIT"]) == '1'))
	{
		$formatted = $CP;
	}
	else
	{
		$formatted = substr($CP,0,3)." ".substr($CP,3,3);
    }
    return $formatted;
}

function format_EMAIL($Courriel)
{
	if ($Courriel == '')
	{
		$formatted = 'sylvie_st-cyr_energie@ssss.gouv.qc.ca';
	}
	else
	{
		$formatted = $Courriel;
	}
    return $formatted;
}
				
function Traitement($str,$test)
{
	$rtn = name_title_case($str);										
	$rtn = trim($rtn);
	return $rtn;
}
						
function TraitementAddress($str, $type)
{	

			$str = trim($str,"\t");
			$str = trim($str,"\t.");
			$str = trim($str,"\n");
			$str = trim($str,"\s");
			$str = trim($str,"\r");
			$str = ltrim($str, ",");
			$str = preg_replace('/\s+/', ' ',$str);
			
			$str = str_replace(",  ","",$str);
			$str = str_replace("\t","",$str);
			$str = str_replace("\r","",$str);
			$str = str_replace("\n","",$str);
			$str = str_replace(",    ","",$str);
			$str = str_replace("- ","-",$str);
			$str = str_replace(" De L'é"," de l'É",$str);
			$str = str_replace("e rue","e Rue", $str);
			

	// si c'est une acquisition, on doit corriger l'adresse
	// si c'est un QUnit = 2 ou Qunit = 3 ou VADRE = Y, on corrige l'adresse
	// si VADRE = N l'adresse ne doit pas être corrigé.
	If (trim($_GET["STRA4"]) == 'ACQUI')
	{
		
		$hostname = trim('172.17.1.1');
		$username = trim('appuser');
		$password = trim('appU53r');
		$database = trim('db_fondations');
		$rtn = $str;
		
		$link = mysql_connect("$hostname", "$username", "$password");
		if (!$link)
		{
			echo "<p>Could not connect to the server '" . $hostname . "'</p>\n";
			echo mysql_error();
		}
	
		if ($database) 
		{
			$dbcheck = mysql_select_db("$database");
			if (!$dbcheck) 
			{
				echo mysql_error();
			}
			else
			{			
				$sql = "select Ancien, Nouveau from fondationscorrection where Libelle = '$type'";
				$result = mysql_query($sql);
				if (mysql_num_rows($result) > 0) 
				{				
					while ($row = mysql_fetch_row($result)) 
					{
						$rtn = str_replace($row[0],$row[1],$rtn);
						if ($type == 'Ville')
							{
							$rtn = name_title_case($rtn);										
							$rtn = trim($rtn);
							}
						else	
						{
							$rtn = name_title_case($rtn);										
							$rtn = trim($rtn);
							$rtn = name_title_case($rtn);										
							$rtn = trim($rtn);
							$rtn = str_replace("Rue","rue",$rtn);
							$rtn = str_replace("Boulevard","boulevard",$rtn);
							$rtn = str_replace(" De La "," de la ",$rtn);
							$rtn = str_replace(" De L' "," de l' ",$rtn);
							$rtn = str_replace(" De L'é"," de l'É",$rtn);
							$rtn = str_replace(" Du "," du ",$rtn);
							$rtn = str_replace(" Des "," des ",$rtn);
							$rtn = str_replace("- ","-",$rtn);
							$rtn = str_replace("e rue","e Rue", $rtn);
							
						}
													
					}				
				} 
			}
		}
	}
	else
	{
		if ((trim($_GET["VADRE"]) == 'N' && trim($_GET["QUNIT"]) == '1'))
		{
			$rtn = $str;
		}
	else
		{
		
			$hostname = trim('172.17.1.1');
			$username = trim('appuser');
			$password = trim('appU53r');
			$database = trim('db_fondations');
			$rtn = $str;

			$link = mysql_connect("$hostname", "$username", "$password");
			if (!$link)
			{
				echo "<p>Could not connect to the server '" . $hostname . "'</p>\n";
				echo mysql_error();
			}
	
			if ($database) 
			{
				$dbcheck = mysql_select_db("$database");
				if (!$dbcheck) 
				{
					echo mysql_error();
				}
				else
				{			
					$sql = "select Ancien, Nouveau from fondationscorrection where Libelle = '$type'";
					$result = mysql_query($sql);
					if (mysql_num_rows($result) > 0) 
					{				
						while ($row = mysql_fetch_row($result)) 
						{
							$rtn = str_replace($row[0],$row[1],$rtn);
							if ($type == 'Ville')
							{
							$rtn = name_title_case($rtn);										
							$rtn = trim($rtn);
							$rtn = str_replace("- ","-",$rtn);
							}
							else
							{
								
							$rtn = name_title_case($rtn);										
							$rtn = trim($rtn);
							$rtn = str_replace("Rue","rue",$rtn);
							$rtn = str_replace(" Avenue "," avenue ",$rtn);
							$rtn = str_replace("Boulevard","boulevard",$rtn);
							$rtn = str_replace(" De La "," de la ",$rtn);
							$rtn = str_replace(" De L' "," de l' ",$rtn);
							$rtn = str_replace(" De L'é"," de l'É",$rtn);
							$rtn = str_replace(" Du "," du ",$rtn);
							$rtn = str_replace(" Des "," des ",$rtn);
							$rtn = str_replace("- ","-",$rtn);
							$rtn = str_replace("e rue","e Rue", $rtn);
							
							
							
							}
									
						}				
					} 
				}
			}
		}
	}
	return $rtn;
}
	
function name_title_case($str)
{
  // name parts that should be lowercase in most cases
  $ok_to_be_lower = array('rue1','des1');
  // name parts that should be lower even if at the beginning of a name
  $always_lower   = array('des');

  // Create an array from the parts of the string passed in
  $parts = explode(" ", mb_strtolower($str, 'UTF-8'));

  foreach ($parts as $part)
  {
    (in_array($part, $ok_to_be_lower)) ? $rules[$part] = 'nocaps' : $rules[$part] = 'caps';
  }

  // Determine the first part in the string
  reset($rules);
  $first_part = key($rules);

  // Loop through and cap-or-dont-cap
  foreach ($rules as $part => $rule)
  {
    if ($rule == 'caps')
    {
      // ucfirst() words and also takes into account apostrophes and hyphens like this:
      // O'brien -> O'Brien || mary-kaye -> Mary-Kaye
      $part = str_replace('- ','-',ucwords(str_replace('-','- ', $part)));
      $c13n[] = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', $part)));
    }
    else if ($part == $first_part && !in_array($part, $always_lower))
    {
      // If the first part of the string is ok_to_be_lower, cap it anyway
      $c13n[] = ucfirst($part);
    }
    else
    {
      $c13n[] = $part;
    }
  }

  $titleized = implode(' ', $c13n);

  return trim($titleized);
}
						?>
					
					<script type="text/javascript">
						 window.location='<?php echo $url;?>';
					</script>		
				
			</p>
			
        </form>
	</body>
</html>
<?php
function crypt_value($key,$iv,$value){

	return base64_encode(mcrypt_cbc(MCRYPT_RIJNDAEL_128,$key,$value,MCRYPT_ENCRYPT,$iv));
}
?>