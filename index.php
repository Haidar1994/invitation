<?php
require 'config.php';
require 'phpqrcode/qrlib.php';

// Mendapatkan NIS dari query string
$nis = isset($_GET['nis']) ? $_GET['nis'] : '';

// Mengambil data siswa dari database berdasarkan NIS
$sql = "SELECT * FROM siswa WHERE nis = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nis);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $nama = $row['nama'];

  // Membuat QR code
  $qrCodeDir = 'qr_codes/';
  $qrCodeFile = $qrCodeDir . "qr_$nis.png";
  QRcode::png($nis, $qrCodeFile, QR_ECLEVEL_L, 10);
} else {
  $qrCodeFile = "qr_codes/default.png"; // Gambar default
  $nama = " ";
}

$stmt->close();
$conn->close();

?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Haflah Musyahadah</title>
  <link rel="shortcut icon" href="img/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="styles.css" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

  <!-- countdown -->
  <link rel="stylesheet" href="countdown/simplyCountdown.theme.default.css" />
  <script src="countdown/simplyCountdown.min.js"></script>
</head>

<body>
  <!-- Overlay Section -->
  <div id="overlay">
    <div class="content">
      <img id="event-title" src="img/logo.png" alt="Haflah Musyahadah" />
      <p id="invitation-text">
        Kepada Yth. <br />
        Bapak/Ibu/Saudara/i <br />
        Dari Ananda :
      </p>
      <p id="student-name"><?php echo $nama ?></p>
      <button id="open-invitation"><i class="fa-solid fa-book-open"></i>BUKA UNDANGAN</button>
      <audio id="invitation-audio" src="music/song.mp3"></audio>
    </div>
  </div>

  <!-- Main Content Section -->

  <div id="main-contain">
    <div class="nav-menu">
      <nav>
        <ul>
          <li>
            <a href="#home"><i class="fa-solid fa-house"></i></a>
          </li>
          <li>
            <a href="#detail"><i class="fa-solid fa-calendar"></i></a>
          </li>
          <li>
            <a href="#location"><i class="fa-solid fa-location-dot"></i></a>
          </li>
          <li>
            <a href="#qr-code"><i class="fa-solid fa-qrcode"></i></a>
          </li>
          <li>
            <a id="#toggle-audio"><i class="fa-solid fa-music"></i></a>
          </li>

        </ul>
      </nav>
    </div>
    <section id="home" class="home-section">
      <img src="img/logo_text.png" alt="" class="text-logo" />
      <div class="ornament">
        <img src="img/ornament.png" alt="" class="right-ornament" data-aos="fade-left" />
        <img src="img/ornament.png" alt="" class="bottom-ornament" data-aos="fade-right" />
      </div>

    </section>
    <section id="detail" class="detail-section">
      <div class="content">
        <p class="greeting">Assalamu'alaikum Wr. Wb.</p>
        <p class="text">Dengan ridho dan rahmat Allah SWT, kami mengharap dengan hormat kehadiran Bapak/Ibu/Saudara/i dalam acara :</p>
        <h2 class="event-text">HAFLAH MUSYAHADA</h2>
        <p class="name-foundation">YAYASAN ALKHAIRIYAH SURABAYA</p>
        <p class="text">yang akan di selenggarakan pada :</p>
        <h2 class="date">
          SABTU <br />
          <span> 08 JUNI 2024 </span>
        </h2>
        <div class="clock">
          <i class="fa-solid fa-clock"></i>
          <h3>PUKUL 07.00 WIB</h3>
        </div>
        <div class="simply-countdown"></div>
        <button id="save-date">Save the Date</button>
      </div>
    </section>
    <section id="location" class="location-section">
      <div class="content">
        <h1>LOCATION</h1>
        <p>Jl. Sultan Iskandar Muda No. 36, Surabaya</p>
        <iframe class="maps" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.451287452214!2d112.72663207434029!3d-7.257680293693312!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f93962be15fb%3A0xb1c6a1a6d5e8ad5f!2sJl.%20Sultan%20Iskandar%20Muda%20No.36%2C%20Ujung%2C%20Kec.%20Semampir%2C%20Kota%20SBY%2C%20Jawa%20Timur%2060149!5e0!3m2!1sid!2sid!4v1686893342348!5m2!1sid!2sid" width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        <div class="nb">
          <p>CATATAN</p>
          <ul>
            <li></i>Undangan Untuk 2 Orang</li>
            <li></i>Tidak diperkenankan Membawa Anak Kecil</li>
          </ul>
        </div>
      </div>

    </section>
    <section id="qr-code">
      <div class="content">
        <h1 style="text-transform: uppercase">Check-in dengan QR Code</h1>
        <img id="qrCode" src="<?php echo htmlspecialchars($qrCodeFile); ?>" alt="QR Code" style="width: 180px;" />
        <div class="student-name-qrcode">
          <h3>Nama Siswa :</h3>
          <p class="student-name"><?php echo htmlspecialchars($nama); ?></p>
        </div>
        <p>Silahkan pindai QR Code ini untuk melakukan Check-in.</p>
        <button class="qr-download" onclick="downloadQRCode()">Download QR Code</button>
        <div class="salam">
          <p class="greeting">Wassalamu'alaikum Wr. Wb.</p>
        </div>
      </div>
    </section>
  </div>

  <!-- Scripts -->
  <script src="script.js"></script>
  <script src="https://kit.fontawesome.com/b404bb4861.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    simplyCountdown(".simply-countdown", {
      year: 2024, // required
      month: 6, // required
      day: 8, // required
      hours: 7, // Default is 0 [0-23] integer
      words: {
        //words displayed into the countdown
        days: {
          singular: "HARI",
          plural: "HARI"
        },
        hours: {
          singular: "JAM",
          plural: "JAM"
        },
        minutes: {
          singular: "MENIT",
          plural: "MENIT"
        },
        seconds: {
          singular: "DETIK",
          plural: "DETIK"
        },
      },
      plural: true, //use plurals
      inline: false, //set to true to get an inline basic countdown like : 24 days, 4 hours, 2 minutes, 5 seconds
      inlineClass: "simply-countdown-inline", //inline css span class in case of inline = true
      // in case of inline set to false
      enableUtc: false,
      onEnd: function() {
        // your code
        return;
      },
      refresh: 1000, //default refresh every 1s
      sectionClass: "simply-section", //section css class
      amountClass: "simply-amount", // amount css class
      wordClass: "simply-word", // word css class
      zeroPad: false,
      countUp: false, // enable count up if set to true
    });
  </script>

  <script>
    function downloadQRCode() {
      const qrCodeImg = document.getElementById("qrCode");
      const qrCodeUrl = qrCodeImg.src;
      const link = document.createElement("a");
      link.href = qrCodeUrl;
      link.download = "QR_Code_Checkin.png";
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  </script>

  <script>
    // Function to clear all cookies
    function clearCookies() {
      const cookies = document.cookie.split("; ");
      for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i];
        const eqPos = cookie.indexOf("=");
        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
      }
    }

    // Function to clear cache by reloading the page with no cache headers
    function clearCache() {
      window.location.reload(true); // Force reload ignoring cache
    }

    // Function to clear both cookies and cache every 5 seconds
    function clearCookiesAndCache() {
      clearCookies();
      clearCache();
    }

    // Set interval to clear cookies and cache every 5 seconds
    setInterval(clearCookiesAndCache, 600000);
  </script>

  <!-- music script -->




</body>

</html>