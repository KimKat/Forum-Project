<?php
/* The MIT License (MIT)

Copyright © 2013 KimKat of IT Consulting (Assistance)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. */

${'self'}=$_SERVER['PHP_SELF'];
${'password'}=$_GET['password'];
${'hash'}=$_GET['hash-type'];
${'advm'}=$_GET['advanced'];
${'ppassword'}=$_POST['p-password'];
${'phash'}=$_POST['p-hash-type'];
${'psubmit'}=$_POST['p-submit'];
${'pdata'}='';

if (strlen($password)==0 || empty($password)) {
	$password="Password Security";
}
if (strlen($hash)==0 || empty($hash)) {
	$hash="tiger192,4";
} else {
	foreach(hash_algos()as$k) {
			$h=strtolower($hash);
			if(in_array($h,hash_algos(),true)) {
			$hash=$hash;
		} else {
			$hash="*Invalid hash-type!*";
		}
	}
}
if (isset($psubmit)) {
	if (strlen($ppassword)!=0 || !empty($ppassword)) {
		if (strlen($phash)!=0 || !empty($phash)) {
			$pdata="<div>Hashed result of input (<i id=\"hash\">".encrypt($ppassword,$phash)."</i>) using algorithm (<i id=\"calgo\">$phash</i>).</div>";
		}
	} else {
		$pdata="<div><h5 id=\"ni\">No input!</h5></div>";
	}
}

function encrypt($password,$hash) {
	$j=hash($hash,$password);
	if($j) {
		return $j;
	} else {
		return "*Error!*";
	}
}

echo <<< p
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Password Security.">
		<title>Forum - DB - Password Security</title>
		<link rel="shortcut icon" type="image/x-icon" href="../../forum/favicon/favicon.ico">
		<style type="text/css">
			html, body {
				background-color: rgb(0,0,0);
				color: rgb(190,190,190);
				font-family: 'Tahoma','Verdana','Arial';
				font-size: 0.9em;
				margin: 1.0em 1.0em;
			}
			p:hover {
				color: rgba(222,222,222,0.9);
			}
			b:hover {
				color: rgba(240,240,90,0.9);
			}
			b#name:hover {
				color: rgba(222,222,72,0.9);
			}
			#hash {
				color: rgb(102,255,102);
			}
			#calgo {
				color: rgb(255,150,75);
			}
			#salgo {
				color: rgb(148,148,244);
				font-weight: bold;
			}
			#ni {
				color: rgb(255,90,90);
			}
			#name {
				color: rgb(244,52,255);
			}
		</style>
	</head>
	<body>
p;
if (isset($password) || isset($hash)) {
	if (isset($advm) && is_numeric($advm) && $advm==1) {
		echo "\r\t\t<p>Hashed result of input (<i id=\"hash\">".encrypt($password,$hash)."</i>) using algorithm (<i id=\"calgo\">$hash</i>).</p>\r";
	}
}
if (isset($advm) && is_numeric($advm) && $advm==1) {
	foreach(hash_algos()as$v) {
		if (strcasecmp($hash,trim($v))==0) {
			/* $hash=strtolower($hash); */
			$v=str_replace(strtolower($hash),"<b id=\"name\">$hash</b> (<i id=\"salgo\">Selected Algorithm</i>)",$v);
		}
		$s="\t\t<small><b>".$v."</b></small><br>\r";
		$v=str_replace("<b><b","<b",$s);
		$s=str_replace(")</b>",")",$v);
		echo($s);
	}
}
echo <<< p

		<div>
			<form action="$self" method="POST" name="encrypt_ppassword">
				<p>Password: <input type="text" name="p-password"></p>
				<select size="1" name="p-hash-type">
p;
foreach(hash_algos()as$v) {
	if ($v) {
		echo "\r\t\t\t\t\t<option value=\"$v\">$v</option>";
	}
}
echo <<< p

				</select>
				<input type="submit" value="Encrypt" name="p-submit">
			</form>
			{$pdata}
		</div>
		<script type="text/javascript" language="JavaScript">
			var e_pp=document.forms.encrypt_ppassword,e_pp_c=e_pp.children[1],e_pp_c_18=e_pp_c.children[18];
			e_pp_c_18.setAttribute("selected","");
		</script>
	</body>
</html>
p;

?>
