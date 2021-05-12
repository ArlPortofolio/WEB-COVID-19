<?php

function http_request($url){
    // persiapkan curl
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);
    
    // set user agent    
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    // mengembalikan hasil curl
    return $output;
}

$profile = http_request("https://api.kawalcorona.com/indonesia/provinsi/");
$dataIndonesia = http_request("https://api.kawalcorona.com/indonesia/"); 
$antarNegara = http_request("https://api.kawalcorona.com/"); 

// ubah string JSON menjadi array
$profile = json_decode($profile, TRUE);
$dataIndonesia = json_decode($dataIndonesia, TRUE);
$antarNegara = json_decode($antarNegara, TRUE);

$nilaia = $antarNegara[1]["attributes"]["Confirmed"];
$nilaib = $antarNegara[17]["attributes"]["Confirmed"];
$positif = $nilaia - $nilaib;

$nilaib = $antarNegara[1]["attributes"]["Recovered"];
$nilaic = $antarNegara[17]["attributes"]["Recovered"];
$sembuh = $nilaib - $nilaic;

$nilaic = $antarNegara[1]["attributes"]["Deaths"];
$nilaid = $antarNegara[17]["attributes"]["Deaths"];
$death = $nilaic - $nilaid;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-light bg-light" id="navbarCovid">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="img/starlup.png" alt="" width="100" height="45">
      <p id="dataTable"><em><b>DATA TABLE COVID-19</b></em></p>
    </a>
  </div>
</nav>
<!-- End Navbar -->
<!-- Data-1 -->
<section id="table-corona1">
      <table class="table">
        <thead>
          <h3>Data Covid-19 untuk provinsi <br> DKI Jakarta, Jawa Tengah, Jawa Timur</h3>
          <hr/>
          <tr>
            <th scope="col">Nama Kota</th>
            <th scope="col">FID</th>
            <th scope="col">Kode Provinsi</th>
            <th scope="col">Kasus Positif</th>
            <th scope="col">Kasus Meninggal</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row"><?php echo $profile[0]["attributes"]["Provinsi"] ?></th>
            <td><?php echo $profile[0]["attributes"]["FID"] ?></td>
            <td><?php echo $profile[0]["attributes"]["Kode_Provi"] ?></td>
            <td><?php echo $profile[0]["attributes"]["Kasus_Posi"] ?></td>
            <td><?php echo $profile[0]["attributes"]["Kasus_Meni"] ?></td>
          </tr>
          <tr>
            <th scope="row"><?php echo $profile[2]["attributes"]["Provinsi"] ?></th>
            <td><?php echo $profile[2]["attributes"]["FID"] ?></td>
            <td><?php echo $profile[2]["attributes"]["Kode_Provi"] ?></td>
            <td><?php echo $profile[2]["attributes"]["Kasus_Posi"] ?></td>
            <td><?php echo $profile[2]["attributes"]["Kasus_Meni"] ?></td>
          </tr>
          <tr>
            <th scope="row"><?php echo $profile[3]["attributes"]["Provinsi"] ?></th>
            <td><?php echo $profile[3]["attributes"]["FID"] ?></td>
            <td><?php echo $profile[3]["attributes"]["Kode_Provi"] ?></td>
            <td><?php echo $profile[3]["attributes"]["Kasus_Posi"] ?></td>
            <td><?php echo $profile[3]["attributes"]["Kasus_Meni"] ?></td>
          </tr>
        </tbody>
      </table>
    </section>

    <section id="table-corona2">
      <table class="table">
        <thead>
          <h3>Data summary (COVID-19) seluruh Indonesia</h3>
          <hr/>
          <tr>
            <th scope="col">Negara</th>
            <th scope="col">Kasus Positif</th>
            <th scope="col">Sembuh</th>
            <th scope="col">Meninggal</th>
            <th scope="col">Dirawat</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row"><?php echo $dataIndonesia[0]["name"] ?></th>
            <td><?php echo $dataIndonesia[0]["positif"] ?></td>
            <td><?php echo $dataIndonesia[0]["sembuh"] ?></td>
            <td><?php echo $dataIndonesia[0]["meninggal"] ?></td>
            <td><?php echo $dataIndonesia[0]["dirawat"] ?></td>
          </tr>
        </tbody>
      </table>
    </section>

    <section id="table-corona3">
      <table class="table">
        <thead>
          <h3>Data selisih perbandingan antara <br> Indonesia dan India</h3>
          <hr/>
          <tr>
            <th scope="col">Negara</th>
            <th scope="col">Positif</th>
            <th scope="col">Sembuh</th>
            <th scope="col">Meninggal</th>

          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row"><?php echo $antarNegara[17]["attributes"]["Country_Region"] ?></th>
            <td><?php echo $antarNegara[17]["attributes"]["Confirmed"] ?></td>
            <td><?php echo $antarNegara[17]["attributes"]["Recovered"] ?></td>
            <td><?php echo $antarNegara[17]["attributes"]["Deaths"] ?></td>
          </tr>
          <tr>
            <th scope="row"><?php echo $antarNegara[1]["attributes"]["Country_Region"] ?></th>
            <td><?php echo $antarNegara[1]["attributes"]["Confirmed"] ?></td>
            <td><?php echo $antarNegara[1]["attributes"]["Recovered"] ?></td>
            <td><?php echo $antarNegara[1]["attributes"]["Deaths"] ?></td>
          </tr>
          <tr id="jumlah">
            <th scope="row">Perbandingan <br> Selisih Antar Negara</th>
            <td><?php echo $positif ?></td>
            <td><?php echo $sembuh ?></td>
            <td><?php echo $death ?></td>
          </tr>
        </tbody>
      </table>
    </section>
<script>type="text/javascript" src="js/bootstrap.min.js"</script>
</body>
</html>