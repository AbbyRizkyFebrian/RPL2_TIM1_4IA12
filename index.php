<?php
include __DIR__ . '/config/koneksi.php';

$gambar = [];

$q = mysqli_query($koneksi, "SELECT posisi, nama_file FROM beranda_gambar");
while ($row = mysqli_fetch_assoc($q)) {
    $gambar[$row['posisi']] = $row['nama_file'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV. Rizky Cipta Al-Fazza - Company Profile</title>
    <link rel="stylesheet" href="maincss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="assets/images/pppl_icon.png" alt="Logo CV. Rizky Cipta Al-Fazza">
            <span>CV. Rizky Cipta Al-Fazza</span>
        </div>
        <nav class="nav-links">
            <ul>
                <li><a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : ''; ?>">Beranda</a></li>
                <li><a href="tentang.php" class="<?= ($current_page == 'tentang.php') ? 'active' : ''; ?>">Tentang Kami</a></li>
                <li><a href="#kontak">Kontak</a></li>
                <li><a href="admin/login.php">Pencatatan</a></li>
             </ul>
        </nav>
    </header>

    <button class="chatbot-toggler">
    <span class="material-symbols-outlined">mode_comment</span>
    <span class="material-symbols-outlined">close</span>
    </button>

  <div class="chatbot">
    <header>
      <h2>CS Maju Jaya</h2>
      <span class="close-btn material-symbols-outlined">close</span>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    </header>
    
    <ul class="chatbox">
      <li class="chat incoming">
        <span class="material-symbols-outlined">smart_toy</span>
        <p>Halo! 👋 Ada yang bisa saya bantu terkait renovasi atau bangun rumah?</p>
      </li>
    </ul>

    <div class="chat-input">
      <textarea placeholder="Ketik pesan..." spellcheck="false" required></textarea>
      <span id="send-btn" class="material-symbols-outlined">send</span>
    </div>
  </div>

    <main>
        <section class="hero" style="background: url('assets/beranda/<?= $gambar['hero'] ?? 'default.jpg'; ?>') no-repeat center/cover;">
            <div class="hero-content">
                <h1>Membangun Masa Depan,<br>Mewujudkan Impian</h1>
            </div>
        </section>

        <section class="about-section">
            <div class="about-logo">
                <img src="assets/images/pppl_icon.png" alt="Logo Besar">
            </div>
            <div class="about-text">
                <h2>CV Rizky Cipta Al-Fazza</h2>
                <p>
                    Sebuah perusahaan yang bergerak di bidang konstruksi dan pengadaan barang yang berlokasi di Kota Tangerang Selatan. Berdiri sejak 2021, kami menjajaki dunia konstruksi dan pengadaan barang dengan menjadi rekanan pada berbagai instansi pemerintahan di DKI Jakarta. Kami menamai perusahaan ini "Al Fazza" yang diambil dari bahasa Arab dan bermakna "Berkembang", sehingga kami menjunjung tinggi inovasi dan keterbaruan dalam berbagai aspek yang ada di perusahaan kami.
                </p>
                <a href="assets/legalitas/legalitas_rca.pdf" class="btn-legalitas">Legalitas Perusahaan</a>
            </div>
        </section>

        <section class="services">
            <h2>LAYANAN KAMI</h2>
            <div class="grid-container grid-4-cols">
                <figure class="grid-item">
                    <img src="assets/beranda/<?= $gambar['layanan1']; ?>">
                    <figcaption>
                        <h3>Proyek Renovasi Gedung</h3>
                        <p>Lokasi: Jakarta Selatan</p>
                    </figcaption>
                </figure>
                <figure class="grid-item">
                    <img src="assets/beranda/<?= $gambar['layanan2']; ?>">
                    <figcaption>
                        <h3>Pembangunan Ruko</h3>
                        <p>Lokasi: Depok, Jawa Barat</p>
                    </figcaption>
                </figure>
                <figure class="grid-item">
                    <img src="assets/beranda/<?= $gambar['layanan3']; ?>">
                    <figcaption>
                        <h3>Interior Kantor</h3>
                        <p>Lokasi: Sudirman, Jakarta</p>
                    </figcaption>
                </figure>
                <figure class="grid-item">
                    <img src="assets/beranda/<?= $gambar['layanan4']; ?>">
                    <figcaption>
                        <h3>Pabrik Industri</h3>
                        <p>Lokasi: Cikarang</p>
                    </figcaption>
                </figure>
            </div>
        </section>

        <section class="portfolio">
            <h2>PORTOFOLIO TERBARU</h2>
            <div class="grid-container grid-2-cols">
                <figure class="grid-item">
                    <img src="assets/beranda/<?= $gambar['portofolio1']; ?>" alt="Portofolio 1">
                    
                    <figcaption>
                        <h3>Pembangunan Mall</h3>
                        <p>Lokasi: Surabaya</p>
                    </figcaption>
                </figure>
                <figure class="grid-item">
                    <img src="assets/beranda/<?= $gambar['portofolio2']; ?>" alt="Portofolio 2">
                    <figcaption>
                        <h3>Cluster Perumahan</h3>
                        <p>Lokasi: Tangerang</p>
                    </figcaption>
                </figure>
            </div>
        </section>
    </main>
    <section id="kontak" class="contact-section">
        <div class="contact-info">
            <h2>Contact Us</h2>
            <p>We'd love to hear from you! Fill out the form below related to our construction services.</p>
        </div>
        
        <div class="contact-form">
            <form action="#">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea placeholder="Your message"></textarea>
                </div>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </section>

    <section class="map-section">
        <h2>Alamat Kantor</h2>
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.5578620559363!2d106.76094599999999!3d-6.3216563!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69efb7d874172b%3A0x9cc10a0165aa7158!2sJl.%20Lestari%20VII%20No.161%2C%20Pisangan%2C%20Kec.%20Ciputat%20Tim.%2C%20Kota%20Tangerang%20Selatan%2C%20Banten%2015419!5e0!3m2!1sid!2sid!4v1768053658049!5m2!1sid!2sid" 
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 CV. Rizky Cipta Al-Fazza. All Rights Reserved.</p>
    </footer>
    <script>
    const chatbotToggler = document.querySelector(".chatbot-toggler");
    const closeBtn = document.querySelector(".close-btn");
    const chatbox = document.querySelector(".chatbox");
    const chatInput = document.querySelector(".chat-input textarea");
    const sendChatBtn = document.querySelector(".chat-input span");

    let userMessage = null; // Menyimpan pesan user

    const createChatLi = (message, className) => {
      // Membuat elemen <li> chat bubble baru
      const chatLi = document.createElement("li");
      chatLi.classList.add("chat", className);
      
      let chatContent = className === "outgoing" 
        ? `<p></p>` 
        : `<span class="material-symbols-outlined">smart_toy</span><p></p>`;
      
      chatLi.innerHTML = chatContent;
      chatLi.querySelector("p").textContent = message;
      return chatLi; 
    }

    const generateResponse = async (chatElement) => {
        const messageElement = chatElement.querySelector("p");

        try {
            // Mengirim request ke Backend Python
            const response = await fetch("http://127.0.0.1:5000/chat", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ message: userMessage })
            });
            const data = await response.json();

            // Format teks (Bold dan Newline)
            let formattedReply = data.reply.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
            formattedReply = formattedReply.replace(/\n/g, '<br>');

            messageElement.innerHTML = formattedReply;

        } catch (error) {
            messageElement.textContent = "Maaf, server sedang offline. Pastikan backend Python berjalan.";
            messageElement.style.color = "red";
        }
        
        chatbox.scrollTo(0, chatbox.scrollHeight);
    }

    const handleChat = () => {
      userMessage = chatInput.value.trim(); 
      if(!userMessage) return;

      // 1. Tampilkan pesan User
      chatInput.value = "";
      chatbox.appendChild(createChatLi(userMessage, "outgoing"));
      chatbox.scrollTo(0, chatbox.scrollHeight);

      // 2. Tampilkan status "Sedang mengetik..."
      setTimeout(() => {
        const incomingChatLi = createChatLi("Sedang mengetik...", "incoming");
        chatbox.appendChild(incomingChatLi);
        chatbox.scrollTo(0, chatbox.scrollHeight);
        
        // 3. Panggil API Python
        generateResponse(incomingChatLi);
      }, 600);
    }

    // Event Listeners
    sendChatBtn.addEventListener("click", handleChat);
    closeBtn.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
    chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));
    
    // Kirim dengan Enter
    chatInput.addEventListener("keydown", (e) => {
        if(e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
            e.preventDefault();
            handleChat();
        }
    });
    </script>
</body>
</html>