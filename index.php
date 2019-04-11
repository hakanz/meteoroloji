<!doctype html>
<html>
	<head>
	<meta charset="utf-8">
		<title>İstanbul ilçeleri ve çevresi için hava durumu</title>
		<style type="text/css">
			.ilce {
				float: left;
				height: auto;
				width: 230px;
				height: 90px;
				background-color: #333;
				margin: 2px;
				padding: 5px;
			}
			.baslik {
				font-family: Arial, Helvetica, sans-serif;
				line-height: 30px;
				color: #3C0;
				height: 30px;
				width: 100%;
				text-align: center;
				font-weight: bold;
			}
			.durum {
				font-size: 14px;
				color: #FFFFFF;
				width: 100%;
				font-weight: normal;
				font-family: Tahoma, Geneva, sans-serif;
			}
		</style>
	</head>
	<body>
	<?php
	$icerik = getir();
	if (!$icerik){
		exit("Hata: MGM'ye bağlanılamadı.");
	}
	$xml = simplexml_load_string($icerik);
	foreach ($xml->ilceler as $veri){
		$ilce = $veri->ilce;
		$sehir = $veri->Sehir;
		$periyot = $veri->Peryot;
		$durum = $veri->Durum;
		$maks = $veri->Mak;
		echo '
		<div class="ilce">
		<div class="baslik">'.$sehir.' / '.$ilce.' '.$maks.'&deg;</div>
		<div class="durum">'.$periyot.': '.$durum.'</div>
		</div>';
	}

	function getir() {
		$url = 'https://www.mgm.gov.tr/FTPDATA/bolgesel/istanbul/sonSOA.xml';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	?>
	</body>
</html>
