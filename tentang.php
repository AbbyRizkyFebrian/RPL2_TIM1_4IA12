<?php
include 'config/koneksi.php';
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - CV. Rizky Cipta Al-Fazza</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="maincss.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* --- STYLE GLOBAL TENTANG KAMI --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fcfcfc;
            color: #333;
        }

        .container-tentang {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* --- VISI & MISI --- */
        .visi-misi-section {
            margin-bottom: 60px;
        }

        .visi-box, .misi-box {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            border-left: 5px solid #2E3B55; /* Aksen Biru */
        }

        .visi-box h2, .misi-box h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-weight: 800;
        }

        .misi-box {
            text-align: right; /* Sesuai screenshot Misi rata kanan */
            border-left: none;
            border-right: 5px solid #2E3B55;
        }

        /* --- SEJARAH PERUSAHAAN --- */
        .sejarah-section {
            margin-bottom: 60px;
        }
        .sejarah-section h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 30px;
            text-transform: uppercase;
            font-weight: 800;
        }
        .sejarah-text {
            text-align: justify;
            line-height: 1.8;
            font-size: 1rem;
            color: #444;
        }
        .sejarah-text p {
            margin-bottom: 20px;
        }

        /* --- STRUKTUR ORGANISASI (CSS CHART) --- */
        .struktur-section {
            text-align: center;
            margin-bottom: 80px;
        }
        .struktur-section h2 {
            font-size: 2rem;
            margin-bottom: 40px;
            text-transform: uppercase;
            font-weight: 800;
        }

        /* Tree Layout */
        .org-tree {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .org-box {
            background-color: #e0e0e0; /* Warna abu-abu sesuai screenshot */
            padding: 15px 20px;
            width: 250px;
            border-radius: 0; /* Kotak tajam sesuai screenshot */
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .jabatan {
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }
        .nama {
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Garis Panah (Arrow) */
        .arrow-down {
            width: 2px;
            height: 30px;
            background-color: #333;
            margin: 0 auto;
        }

        /* Level Cabang (ADM & Logistik) */
        .org-row {
            display: flex;
            gap: 50px; /* Jarak antar kotak cabang */
            position: relative;
        }
        
        /* Garis Cabang */
        .branch-line {
            width: 300px; /* Lebar garis horizontal */
            height: 2px;
            background-color: #333;
            margin-bottom: -22px; /* Geser ke atas agar pas dengan panah */
        }
        
        /* Diagonal Lines (Variasi untuk visualisasi cabang) */
        .diagonal-connector {
             display: flex;
             justify-content: center;
             width: 100%;
             height: 20px;
        }
        .d-line-l { border-right: 2px solid #333; width: 50%; transform: skewX(45deg); transform-origin: bottom right; }
        .d-line-r { border-left: 2px solid #333; width: 50%; transform: skewX(-45deg); transform-origin: bottom left; }


        /* CHATBOT CSS (Include ulang agar muncul di halaman ini juga) */
        .chatbot-toggler { position: fixed; bottom: 30px; right: 35px; outline: none; border: none; height: 60px; width: 60px; display: flex; cursor: pointer; align-items: center; justify-content: center; border-radius: 50%; background: #2E3B55; transition: all 0.2s ease; box-shadow: 0 0 15px rgba(0,0,0,0.2); z-index: 9999; }
        .chatbot-toggler span { color: #fff; position: absolute; }
        .show-chatbot .chatbot-toggler span:first-child, .chatbot-toggler span:last-child { opacity: 0; }
        .show-chatbot .chatbot-toggler span:last-child { opacity: 1; }
        .chatbot { position: fixed; right: 35px; bottom: 100px; width: 350px; background: #fff; border-radius: 15px; overflow: hidden; opacity: 0; pointer-events: none; transform: scale(0.5); transform-origin: bottom right; box-shadow: 0 0 20px rgba(0,0,0,0.1); transition: all 0.1s ease; z-index: 9999; }
        body.show-chatbot .chatbot { opacity: 1; pointer-events: auto; transform: scale(1); }
        .chatbot header { background: #2E3B55; padding: 16px 0; position: relative; text-align: center; color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .chatbot header span { position: absolute; right: 15px; top: 50%; cursor: pointer; transform: translateY(-50%); display: block; }
        .chatbox { overflow-y: auto; height: 350px; padding: 20px 20px 70px; list-style: none; }
        .chatbox .chat { display: flex; list-style: none; margin-bottom: 15px; }
        .chatbox .incoming span { width: 32px; height: 32px; color: #fff; align-self: flex-end; background: #2E3B55; text-align: center; line-height: 32px; border-radius: 4px; margin: 0 10px 7px 0; display: block; }
        .chatbox .incoming p, .chatbox .outgoing p { padding: 12px 16px; border-radius: 10px; max-width: 75%; font-size: 0.95rem; margin: 0;}
        .chatbox .incoming p { background: #f2f2f2; color: #000; border-bottom-left-radius: 0; }
        .chatbox .outgoing { justify-content: flex-end; margin: 20px 0; }
        .chatbox .outgoing p { background: #2E3B55; color: #fff; border-bottom-right-radius: 0; }
        .chat-input { position: absolute; bottom: 0; width: 100%; background: #fff; padding: 3px 20px; border-top: 1px solid #ddd; display: flex; gap: 5px; }
        .chat-input textarea { height: 55px; width: 100%; border: none; outline: none; resize: none; padding: 15px 15px 15px 0; font-size: 0.95rem; }
        .chat-input span { align-self: flex-end; color: #2E3B55; cursor: pointer; height: 55px; display: flex; align-items: center; visibility: hidden; font-size: 1.35rem; }
        .chat-input textarea:valid ~ span { visibility: visible; }
    </style>
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
                <li><a href="index.php#kontak">Kontak</a></li>
                <li><a href="admin/login.php">Pencatatan</a></li>
            </ul>
        </nav>
    </header>

    <main class="container-tentang">
        
        <section class="visi-misi-section">
            <div class="visi-box">
                <h2>Visi</h2>
                <p>Menjadi perusahaan yang andal dalam bidang konstruksi dan pengadaan barang dengan mengedepankan integritas dan komitmen tinggi untuk memberikan hasil terbaik.</p>
            </div>
            
            <div class="misi-box">
                <h2>Misi</h2>
                <p>Menciptakan suasana kerja yang profitable dan penuh integritas bersama sumber daya manusia yang kompeten untuk memberikan hasil yang diimpikan.</p>
            </div>
        </section>

        <section class="sejarah-section">
            <h2>Sejarah Perusahaan</h2>
            <div class="sejarah-text">
                <p>
                    CV Rizky Cipta Al Fazza adalah sebuah perusahaan yang bergerak di bidang konstruksi dan pengadaan barang yang berlokasi di Kota Tangerang Selatan. Berdiri sejak 2021, kami menjajaki dunia konstruksi dan pengadaan barang dengan menjadi rekanan pada berbagai instansi pemerintahan di DKI Jakarta. Kami menamai perusahaan ini "Al Fazza" yang diambil dari bahasa Arab dan bermakna "Berkembang", sehingga kami menjunjung tinggi inovasi dan keterbaruan dalam berbagai aspek yang ada di perusahaan kami.
                </p>
                <p>
                    Perusahaan kami menawarkan jasa konstruksi yang spesifik pada konstruksi bangunan, baik berupa pembangunan rumah, gedung, atau bangunan lainnya. Kami juga menawarkan jasa pengadaan barang berupa furniture yang dapat di-custom, furniture jadi, barang kebutuhan rumah tangga, dan berbagai barang lainnya. Seluruh pekerjaan dikerjakan oleh tenaga profesional untuk menjamin kualitas hasil pekerjaan.
                </p>
                <p>
                    Kami berkomitmen untuk memberikan hasil terbaik di setiap pekerjaan yang kami kerjakan. Tentunya dengan memegang teguh prinsip "memanusiakan manusia" kepada seluruh tenaga yang terlibat, kami yakin hasil akan maksimal dengan lingkungan kerja yang baik. Memilih kami sebagai rekanan bisnis Anda adalah sebuah keputusan yang tepat untuk mendapatkan hasil yang diharapkan dengan harga terbaik.
                </p>
            </div>
        </section>

        <section class="struktur-section">
            <h2>Struktur Organisasi</h2>
            
            <div class="org-tree">
                
                <div class="org-box">
                    <span class="jabatan">Komisaris</span>
                    <span class="nama">Dwi Purwata</span>
                </div>
                <div class="arrow-down"></div>

                <div class="org-box">
                    <span class="jabatan">Direktur</span>
                    <span class="nama">Aditya Rizky Ramadhan, S.T.</span>
                </div>
                <div class="arrow-down"></div>

                <div style="border-top: 2px solid #333; width: 300px; height: 10px;"></div> 

                <div class="org-row">
                    <div style="display:flex; flex-direction:column; align-items:center;">
                        <div style="height:10px; border-left:2px solid #333; margin-top:-20px;"></div> <div class="org-box">
                            <span class="jabatan">ADM</span>
                            <span class="nama">Eka Saputri, S.T.<br>Teguh Wijaya, S.T.</span>
                        </div>
                        <div class="arrow-down"></div>
                    </div>

                    <div style="display:flex; flex-direction:column; align-items:center;">
                         <div style="height:10px; border-left:2px solid #333; margin-top:-20px;"></div> <div class="org-box">
                            <span class="jabatan">Logistik Lapangan</span>
                            <span class="nama">Tian<br>Syahalampriadi</span>
                        </div>
                        <div class="arrow-down"></div>
                    </div>
                </div>

                <div style="border-bottom: 2px solid #333; width: 300px; height: 15px; margin-top: -15px;"></div>
                <div class="arrow-down" style="margin-top:0;"></div>

                <div class="org-box">
                    <span class="jabatan">Mandor/Pekerja</span>
                </div>

            </div>
        </section>

    </main>

    <footer style="text-align: center; padding: 20px; background: #eee; font-size: 0.8rem; color: #666;">
        <p>&copy; 2025 CV. Rizky Cipta Al-Fazza. All Rights Reserved. | Privacy Policy | Terms of Service</p>
    </footer>

    <button class="chatbot-toggler">
        <span class="material-symbols-outlined">mode_comment</span>
        <span class="material-symbols-outlined">close</span>
    </button>
    <div class="chatbot">
        <header>
            <h2>CS Maju Jaya</h2>
            <span class="close-btn material-symbols-outlined">close</span>
        </header>
        <ul class="chatbox">
            <li class="chat incoming">
                <span class="material-symbols-outlined">smart_toy</span>
                <p>Halo! 👋 Ada yang bisa saya bantu terkait profil perusahaan kami?</p>
            </li>
        </ul>
        <div class="chat-input">
            <textarea placeholder="Ketik pesan..." spellcheck="false" required></textarea>
            <span id="send-btn" class="material-symbols-outlined">send</span>
        </div>
    </div>

    <script>
        const chatbotToggler = document.querySelector(".chatbot-toggler");
        const closeBtn = document.querySelector(".close-btn");
        const chatbox = document.querySelector(".chatbox");
        const chatInput = document.querySelector(".chat-input textarea");
        const sendChatBtn = document.querySelector(".chat-input span");
        let userMessage = null; 

        const createChatLi = (message, className) => {
            const chatLi = document.createElement("li");
            chatLi.classList.add("chat", className);
            let chatContent = className === "outgoing" ? `<p></p>` : `<span class="material-symbols-outlined">smart_toy</span><p></p>`;
            chatLi.innerHTML = chatContent;
            chatLi.querySelector("p").textContent = message;
            return chatLi; 
        }

        const generateResponse = async (chatElement) => {
            const messageElement = chatElement.querySelector("p");
            try {
                const response = await fetch("http://127.0.0.1:5000/chat", {
                    method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify({ message: userMessage })
                });
                const data = await response.json();
                let formattedReply = data.reply.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>').replace(/\n/g, '<br>');
                messageElement.innerHTML = formattedReply;
            } catch (error) {
                messageElement.textContent = "Maaf, server sedang offline.";
                messageElement.style.color = "red";
            }
            chatbox.scrollTo(0, chatbox.scrollHeight);
        }

        const handleChat = () => {
            userMessage = chatInput.value.trim(); 
            if(!userMessage) return;
            chatInput.value = "";
            chatbox.appendChild(createChatLi(userMessage, "outgoing"));
            chatbox.scrollTo(0, chatbox.scrollHeight);
            setTimeout(() => {
                const incomingChatLi = createChatLi("Sedang mengetik...", "incoming");
                chatbox.appendChild(incomingChatLi);
                chatbox.scrollTo(0, chatbox.scrollHeight);
                generateResponse(incomingChatLi);
            }, 600);
        }

        sendChatBtn.addEventListener("click", handleChat);
        closeBtn.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
        chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));
        chatInput.addEventListener("keydown", (e) => {
            if(e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
                e.preventDefault();
                handleChat();
            }
        });
    </script>
</body>
</html>