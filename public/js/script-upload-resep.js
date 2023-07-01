function previewImage(event) {
  var input = event.target;
  var preview = document.getElementById("preview");
  var fileInfo = document.getElementById("file-info");

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      preview.src = e.target.result;
      fileInfo.textContent = "File: " + input.files[0].name;
    };

    reader.readAsDataURL(input.files[0]);
  } else {
    preview.src = "{{asset('assets/upload-resep-img/upload.png')}}";
    fileInfo.textContent = "";
  }
}

function extractVideoId(url) {
  var regExp =
    /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=|\?v=)([^#&?]*).*/;
  var match = url.match(regExp);
  if (match && match[2].length === 11) {
    return match[2];
  } else {
    return null;
  }
}

function saveDataAndShowNextPage() {
  var namaResep = document.getElementById("nama_resep").value;
  var deskripsiResep = document.getElementById("deskripsi_resep").value;
  var waktuPenyajian = document.getElementById("waktu_penyajian").value;
  var porsi = document.getElementById("porsi").value;
  var videoYoutube = document.getElementById("video_youtube");
  var bahan = document.getElementById("bahan").value;
  var langkahMasak = document.getElementById("langkah_masak").value;

  var videoLink = videoYoutube.value;
  var videoId = extractVideoId(videoLink);

  var previewContainer = document.getElementById("video-preview-container");
  previewContainer.innerHTML = "";

  if (videoId) {
    var iframe = document.createElement("iframe");
    iframe.classList.add("video-preview");
    iframe.src = "https://www.youtube.com/embed/" + videoId;
    iframe.title = "YouTube Video";
    iframe.frameborder = "0";
    iframe.allow =
      "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share";
    iframe.allowfullscreen = true;
    previewContainer.appendChild(iframe);
  } else {
    previewContainer.innerHTML = "Link YouTube tidak valid.";
  }

  document.getElementById("preview1").src =
    document.getElementById("preview").src;
  document.getElementById("preview2").src =
    document.getElementById("preview").src;
  document.getElementById("output-nama-resep").textContent = namaResep;
  document.getElementById("output-deskripsi-resep").textContent = deskripsiResep;
  document.getElementById("output-waktu-penyajian").textContent ="Waktu Penyajian " + waktuPenyajian + " menit";
  document.getElementById("output-porsi").textContent = porsi + " porsi";
  
  document.getElementById("output-bahan").textContent = "Bahan-bahan: " + bahan;
  document.getElementById("output-langkah-masak").textContent ="Langkah-langkah Memasak: " + langkahMasak;

    var langkahInput = document.querySelector('#bahan').value; // Mengambil nilai dari textarea
    var langkahList = langkahInput.split('\n'); // Memisahkan langkah-langkah berdasarkan baris baru

     var hasilDiv = document.querySelector('#output-bahan');
        hasilDiv.innerHTML = ''; // Mengosongkan hasil sebelumnya

        for (var i = 0; i < langkahList.length; i++) {
            var langkah = langkahList[i].trim(); // Menghapus spasi di awal dan akhir langkah
            if (langkah !== '') {
            var langkahElem = document.createElement('p');
            langkahElem.textContent = (i + 1) + '. ' + langkah;
            hasilDiv.appendChild(langkahElem);
            }
        }
    
    var caraKerjaInput = document.querySelector('#langkah_masak').value; // Mengambil nilai dari textarea langkah cara kerja
    var caraKerjaList = caraKerjaInput.split('\n'); // Memisahkan langkah-langkah cara kerja berdasarkan baris baru
    
    var hasilCaraKerjaDiv = document.querySelector('#output-langkah-masak');
    hasilCaraKerjaDiv.innerHTML = ''; // Mengosongkan dan menambahkan judul Langkah Cara Kerja
    
    for (var j = 0; j < caraKerjaList.length; j++) {
      var caraKerja = caraKerjaList[j].trim(); // Menghapus spasi di awal dan akhir langkah cara kerja
      if (caraKerja !== '') {
        var caraKerjaElem = document.createElement('p');
        caraKerjaElem.textContent = (j + 1) + '. ' + caraKerja;
        hasilCaraKerjaDiv.appendChild(caraKerjaElem);
      }
    }

  showNextPage();
}

function showPreviousPage() {
  var currentPage = document.querySelector(".active");
  var previousPage = currentPage.previousElementSibling;

  if (previousPage) {
    currentPage.classList.remove("active");
    previousPage.classList.add("active");
  }
}

function showNextPage() {
  var currentPage = document.querySelector(".active");
  var nextPage = currentPage.nextElementSibling;

  if (nextPage) {
    currentPage.classList.remove("active");
    nextPage.classList.add("active");

    // Jika berpindah ke halaman 3, tampilkan tombol "Upload"
    if (nextPage.id === "page3") {
      document.getElementById("upload-button").style.display = "block";
    }
  }
}

function uploadData() {
  // Kode untuk meng-upload data ke server
  alert("Data telah diupload ke server.");
}

var nextButton = document.getElementById("nextButton");

// Periksa apakah halaman saat ini adalah halaman 3
if (currentPage === 3) {
  // Gantilah 'currentPage' dengan variabel atau logika yang sesuai
  nextButton.innerHTML = "Simpan"; // Ubah teks tombol menjadi 'Simpan'
}
