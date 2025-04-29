<?php
$date = isset($_POST["date"]) ? (new DateTime($_POST["date"]))->format('Y-m-d') : (new DateTime())->format('Y-m-d');
if (isset($_POST["city"])) {
  $city = $_POST["city"];
  $res = getJson("https://api.geoapify.com/v1/geocode/search?apiKey=7a853773c37044ea8d978a939c1cf809&text=$city");
  $res = $res["features"];
  if (count($res) > 0) {
    $city = $res[0]["properties"]["city"];
    $lon = $res[0]["properties"]["lon"];
    $lat = $res[0]["properties"]["lat"];
    $res = getJson("https://api.open-meteo.com/v1/forecast?latitude=$lat&longitude=$lon&start_date=$date&end_date=$date&daily=uv_index_max&hourly=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m");
  } else {
    $error = true;
    $res["reason"] = "Location not found";
  }
  if (!isset($error) && !isset($res["error"])) {
    $uv = $res["daily"]["uv_index_max"][0];
    $time = $res["hourly"]["time"];
    $temperature = $res["hourly"]["temperature_2m"];
    $humidity = $res["hourly"]["relative_humidity_2m"];
    $weather = $res["hourly"]["weather_code"];
    $wind = $res["hourly"]["wind_speed_10m"];
  } else {
    $error = true;
  }
}

function getJson($link)
{
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, $link);
  $res = curl_exec($curl);
  $json = json_decode($res, true);
  return $json;
}

function timeFormat($time)
{
  $time = new Datetime($time);
  return $time->format("H:i");
}

function deskripsiCuaca($kodeCuaca)
{
  $deskripsiCuaca = [
    0 => 'Langit cerah',
    1 => 'Cerah sebagian',
    2 => 'Berawan sebagian',
    3 => 'Berawan total',
    45 => 'Kabut',
    48 => 'Kabut rime',
    51 => 'Gerimis',
    53 => 'Gerimis sedang',
    55 => 'Gerimis tebal',
    56 => 'Gerimis beku',
    57 => 'Gerimis beku tebal',
    61 => 'Hujan ringan',
    63 => 'Hujan sedang',
    65 => 'Hujan deras',
    66 => 'Hujan beku ringan',
    67 => 'Hujan beku deras',
    71 => 'Salju ringan',
    73 => 'Salju sedang',
    75 => 'Salju deras',
    77 => 'Butiran salju',
    80 => 'Hujan deras',
    81 => 'Hujan sangat deras',
    82 => 'Hujan sangat sangat deras',
    85 => 'Salju lebat',
    86 => 'Salju lebat sekali',
    95 => 'Badai petir',
    96 => 'Badai petir dengan hujan es',
    99 => 'Badai petir dengan hujan es deras',
  ];

  // Mengembalikan deskripsi berdasarkan kode cuaca
  if (array_key_exists($kodeCuaca, $deskripsiCuaca)) {
    return $deskripsiCuaca[$kodeCuaca];
  } else {
    return 'Kode cuaca tidak dikenal';
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Dashboard</title>
  <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <style>
    .wrapper {
      width: 80vw;
      margin: 0 auto;
      padding: 20px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <form method="POST" action="/">
      <div class="mb-3">
        <label for="city" class="form-label">Kota</label>
        <input value='<?= $city ?? '' ?>' type="text" name="city" class="form-control" id="city" required />
      </div>
      <div class="mb-3">
        <label for="date" class="form-label">Tanggal</label>
        <input value='<?= $date ?? '' ?>' type="date" name="date" class="form-control" id="date" />
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div class="container-fluid">
      <div class="mt-5 mb-3 clearfix">
        <h2>
          Kondisi Cuaca di
          <?= $city ?? '' ?>
        </h2>
        <h5>Tingkat UV : <?= $uv ?? '-' ?></h5>
        <h5>Tanggal : <?= $date ?? '-' ?></h5>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Jam</th>
              <th>Temperature (C)</th>
              <th>Kelembapan</th>
              <th>Cuca</th>
              <th>Angin (kmh)</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($time) && count($time) > 0): ?>
              <?php for ($i = 0; $i < count($time); $i++): ?>
                <tr>
                  <td><?= timeFormat($time[$i]) ?></td>
                  <td><?= $temperature[$i] ?> °C</td>
                  <td><?= $humidity[$i] ?>%</td>
                  <td><?= deskripsiCuaca($weather[$i]) ?></td>
                  <td><?= $wind[$i] ?></td>
                </tr>
              <?php endfor ?>
            <?php endif ?>
          </tbody>
        </table>
        <?php if (isset($error)): ?>
          <h1><?= $res["reason"] ?></h1>
        <?php endif ?>
      </div>
    </div>
  </div>
</body>

</html>