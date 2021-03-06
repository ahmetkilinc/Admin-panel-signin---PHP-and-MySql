<?php
	
session_start();

$url = 'http://ahmetkilinc.net/adminPanel/index.php';

if(!isset($_SESSION['adminkullanici']) && empty($_SESSION['adminkullanici'])){
	
	header("Location: $url");
}

$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
	
	die("Bağlantı sağlanamadı: " . $conn->connect_error);
}

$dateControl = (new \DateTime(date("Y")."-01-01"))->format("Y-m-d");
//echo $dateC . " hey there!";

$sql = "SELECT musteri_adi, musteri_firma, musteri_tel, musteri_eposta, teklif_fiyat, teklif_tarih, teklif_onay FROM musteri WHERE teklif_tarih >= '$dateControl' ORDER BY id DESC";

$result = $conn->query($sql);

$i = 0;

if($result->num_rows > 0){
	
	while($row = $result->fetch_assoc()){
		
		$musteriadlar[$i] = $row["musteri_adi"];
		$musterifirmalar[$i] = $row["musteri_firma"];
		$musteriteller[$i] = $row["musteri_tel"];
		$musteriepostalar[$i] = $row["musteri_eposta"];
		$tekliffiyatlar[$i] = $row["teklif_fiyat"];
		$tekliftarihler[$i] = $row["teklif_tarih"];
		$teklifOnaylar[$i] = $row["teklif_onay"];
		
		$i = $i + 1;
	}
}

$teklifSayisi = $i;

?>
<!doctype html>
<html>
	<header>
	<meta charset='UTF-8' name='viewport' content='width=device-width, initial-scale=1.0'>
		<style>
			
			.maincontent{
	
			  width: 960px;
			  background: white;
			  margin: 0 auto 15px auto;
			  border-radius: 0 0 7px 7px;
			  box-shadow: 0 1px 5px rgba(0, 0, 0, 0.6);
			  overflow: auto;
			  cursor: pointer;
			}
			
			button.button{

				background-color: #4CAD60;
				color: white;
				border: none;
			}
			
			button.buttonGonder{

				background-color: #4CAD60;
				color: white;
				padding: 14px 20px;
				margin: 8px 0;
				border: none;
				width: 100%;
			}
			
			th, td{
				
				border: 1px solid #dddddd;
				text-align: center;
				padding: 8px;
			}
			
			td.a{
				
				border: 1px solid #dddddd;
				text-align: center;
				padding: 8px;
			}
			
			td.b{
				
				border: 1px solid #dddddd;
				text-align: right;
				padding: 8px;
			}

			tr:nth-child(even){
				
				background-color: #dddddd;
			}
			
			table{
				
				font-family: arial, sans-serif;
				border: 1%;
				width: 100%;
				margin-top: 10%;
			}

			.buttonimg{
				
				margin-left: 90%;
				width: 5%;
				height: 5%;
			}
			
			h2{
				
				text-align: center;
			}
			
			.kullanici{
				
				width: 130%;
				border: 1px solid green;
				margin-right: 0px;
				text-align: center;
			}
			
			.btnPast{
				
				background-color: CornflowerBlue;
				width: 8%;
				height: 7%;
			}
				
		</style>
	</header>
	<body>
		<div class="buttonimg">
			<div style="float:left;" class="kullanici">
			<?php echo $_SESSION["adminkullanici"]; ?>
			</div>
			<div class="image">
				<div class="dropdown">
					<img style="width:130%; heigth:100%;" src="images/adminavatar.png">
				</div>
			</div>
				<button style="width: 130%; text-align:center; border-radius:50px;" onclick="funcAyarlar()" class="buttonD" type="button">Ayarlar</button>
				<button style="width: 130%; border-radius:50px;" class="button" type="button" onclick="func()">Çıkış</button>
		</div>
		
<div style="overflow:auto;" class='maincontent'>
<head>
<meta charset='UTF-8' name='viewport' content='width=device-width, initial-scale=1.0'>
</head>

	<button class="btnPast" onclick="goPast()"> <?php echo date("Y")-1; ?></button>
	<h2>Tüm Teklifler <?php echo date("Y");?></h2>
	<form method="post" action="tekliflerdetaylibilgi.php">
		<table>
		  <tr>
			<th>Müşteri Ad-Soyadı:</th>
			<th>Firma Adı:</th>
			<th>Müşteri Telefon:</th>
			<th>Müşteri E-Posta:</th>
			<th>Teklif Fiyatı:</th>
			<th>Teklif Tarihi:</th>
			<th>Teklif Onay:</th>
		  </tr>
		  <?php for($j = 0; $j < $teklifSayisi; $j++){ ?>
		  <tr>
			<td class="a"><?php echo $musteriadlar[$j]; ?></td>
			<td class="b"><?php echo $musterifirmalar[$j]; ?></td>
			<td class="a"><?php echo $musteriteller[$j]; ?></td>
			<td class="b"><?php echo $musteriepostalar[$j]; ?></td>
			<td class="a"><?php echo $tekliffiyatlar[$j]; ?></td>
			<td class="b"><?php echo $tekliftarihler[$j]; ?></td>
			<td class="a"><?php echo $teklifOnaylar[$j]; ?></td>
		  </tr>
		  <?php } ?>
		</table>
	</form>
	<button class="buttonGonder" onclick="funcGeri()">Geri Dön</button>
</div>	
	</body>
	<head>
		<script>
		
			function goPast(){
				
				window.location.replace('http://ahmetkilinc.net/adminPanel/tumTekliflerPast1.php');
			}
		
			function funcGeri(){
				
				window.location.replace('http://ahmetkilinc.net/adminPanel/teklifler.php');
			}
			
			function funcAyarlar(){
				
				window.location.replace('http://ahmetkilinc.net/adminPanel/settings.php');
			}
			
			function func(){

				window.location.replace('http://ahmetkilinc.net/adminPanel/cikis.php');
			}
		</script>
	</head>
</html>

<?php 

	$conn->close();
?>