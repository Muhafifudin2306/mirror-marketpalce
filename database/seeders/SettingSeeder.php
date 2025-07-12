<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'type' => 'kebijakan-privasi',
                'content' => '<p class="MsoNormal"><b><span lang="EN-ID">Kebijakan
Privasi<o:p></o:p></span></b></p><p class="MsoNormal"><b><span lang="EN-ID">Terakhir
diperbarui:</span></b><span lang="EN-ID"> 6 Juli
2025<o:p></o:p></span></p><p class="MsoNormal"><span lang="EN-ID">Kebijakan
Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan
melindungi informasi pribadi Anda saat menggunakan layanan kami melalui situs
web <b>Sinau Print</b>.<o:p></o:p></span></p><p class="MsoNormal"><span lang="EN-ID">Dengan
mengakses dan menggunakan layanan ini, Anda menyetujui praktik pengumpulan dan
penggunaan data sesuai dengan Kebijakan Privasi ini.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">1.
Interpretasi dan Definisi<o:p></o:p></span></b></p><p class="MsoNormal"><b><span lang="EN-ID">Interpretasi<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Istilah-istilah
dengan huruf kapital memiliki makna yang ditetapkan di bawah ini. Definisi
berlaku baik dalam bentuk tunggal maupun jamak.<o:p></o:p></span></p><p class="MsoNormal"><b><span lang="EN-ID">Definisi<o:p></o:p></span></b></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><b><span lang="EN-ID">Akun</span></b><span lang="EN-ID">: Akun unik yang dibuat oleh
     Anda untuk mengakses layanan kami.<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Afiliasi</span></b><span lang="EN-ID">: Entitas yang mengendalikan,
     dikendalikan oleh, atau berada di bawah kendali yang sama dengan
     Perusahaan.<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Perusahaan / Kami</span></b><span lang="EN-ID">: <b>Sinau Print</b>, beralamat
     di Jalan Jatibarang Timur 16 No.184, Kedungpane, Kec. Mijen, Kota
     Semarang, Jawa Tengah.<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Perangkat</span></b><span lang="EN-ID">: Alat seperti komputer,
     ponsel, atau tablet yang digunakan untuk mengakses layanan kami.<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Data Pribadi</span></b><span lang="EN-ID">: Informasi tentang individu
     yang dapat diidentifikasi, baik langsung maupun tidak langsung.<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Layanan</span></b><span lang="EN-ID">: Website Sinau Print, yang
     dapat diakses melalui </span><span lang="IN"><a href="https://sinauprint.com/" target="_new"><span lang="EN-ID">https://sinauprint.com/</span></a></span><span lang="EN-ID">.<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Pengguna / Anda</span></b><span lang="EN-ID">: Individu atau badan hukum
     yang mengakses layanan.<o:p></o:p></span></li>
</ul><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">2. Data
Pribadi yang Kami Kumpulkan<o:p></o:p></span></b></p><p class="MsoNormal"><b><span lang="EN-ID">a. Data
Identitas<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Saat
mendaftar dan menggunakan layanan kami, kami dapat mengumpulkan data pribadi
berikut:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><span lang="EN-ID">Nama lengkap<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Alamat lengkap (termasuk
     provinsi, kota, kecamatan, kelurahan, dan kode pos)<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Nomor telepon<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Alamat email<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Informasi akun (username &amp;
     password)<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Riwayat transaksi dan
     penggunaan<o:p></o:p></span></li>
</ul><p class="MsoNormal"><b><span lang="EN-ID">b. Data
Penggunaan (Usage Data)<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Kami juga
mengumpulkan data otomatis seperti:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><span lang="EN-ID">Alamat IP perangkat<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Jenis browser dan versi<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Waktu kunjungan, halaman yang
     diakses, durasi akses<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Informasi perangkat (sistem
     operasi, jenis perangkat, resolusi layar, dll)<o:p></o:p></span></li>
</ul><p class="MsoNormal"><b><span lang="EN-ID">c.
Cookies dan Teknologi Pelacak<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Kami
menggunakan <b>cookies</b> dan <b>web beacons</b> untuk meningkatkan pengalaman
Anda. Cookies dapat berupa:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><b><span lang="EN-ID">Essential cookies</span></b><span lang="EN-ID"> – diperlukan untuk login dan
     keamanan akun<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Preference cookies</span></b><span lang="EN-ID"> – menyimpan pengaturan bahasa
     dan preferensi Anda<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Analytics cookies</span></b><span lang="EN-ID"> – menganalisis perilaku
     pengguna untuk pengembangan layanan<o:p></o:p></span></li>
</ul><p class="MsoNormal"><span lang="EN-ID">Anda dapat
mengatur browser Anda untuk menolak cookies. Namun, beberapa fitur mungkin
tidak dapat berfungsi tanpa cookies.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">3.
Penggunaan Data Pribadi Anda<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Kami
menggunakan data Anda untuk:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><span lang="EN-ID">Memproses pendaftaran dan login
     akun<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Menyediakan layanan pembelian
     dan pengiriman<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Menghubungi Anda terkait status
     pesanan, pembaruan sistem, dan notifikasi penting<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Mengirim penawaran, promosi,
     atau informasi yang relevan (jika Anda tidak menonaktifkan fitur ini)<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Menganalisis perilaku pengguna
     untuk peningkatan layanan<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Memenuhi kewajiban hukum dan
     audit<o:p></o:p></span></li>
</ul><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">4. Dasar
Hukum Pemrosesan Data<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Kami
memproses data pribadi Anda berdasarkan:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><span lang="EN-ID">Persetujuan yang Anda berikan
     saat mendaftar<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Perjanjian atau transaksi yang
     Anda lakukan dengan kami<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Kewajiban hukum (misalnya untuk
     pelaporan pajak atau penanganan sengketa)<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Kepentingan sah kami dalam
     meningkatkan dan melindungi layanan<o:p></o:p></span></li>
</ul><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">5. Penyimpanan
dan Keamanan Data<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Kami
menyimpan data pribadi Anda selama:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><span lang="EN-ID">Akun Anda masih aktif<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Diperlukan untuk memenuhi
     tujuan pemrosesan<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Diperlukan oleh hukum atau
     audit (contoh: selama 5 tahun setelah transaksi)<o:p></o:p></span></li>
</ul><p class="MsoNormal"><span lang="EN-ID">Kami
menggunakan enkripsi, firewall, dan metode keamanan lainnya untuk menjaga data
Anda tetap aman. Namun, tidak ada metode yang 100% aman.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">6. Hak
Anda sebagai Pengguna<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Berdasarkan
hukum Indonesia, Anda memiliki hak untuk:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><span lang="EN-ID">Mengakses data pribadi Anda<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Memperbaiki atau memperbarui
     data Anda<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Menarik persetujuan atau
     menghapus data pribadi Anda (dengan konsekuensi akses layanan dapat
     dihentikan)<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Menyampaikan keluhan atas
     pelanggaran privasi<o:p></o:p></span></li>
</ul><p class="MsoNormal"><span lang="EN-ID">Permintaan
dapat diajukan melalui email kami dan akan kami tanggapi dalam waktu paling
lambat 7 hari kerja.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">7.
Pengungkapan kepada Pihak Ketiga<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Kami <b>tidak
menjual atau menyewakan</b> data pribadi Anda. Namun, data dapat dibagikan
kepada:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><b><span lang="EN-ID">Penyedia layanan pihak ketiga</span></b><span lang="EN-ID"> (misalnya: jasa pengiriman,
     payment gateway)<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Otoritas hukum</span></b><span lang="EN-ID"> jika diwajibkan untuk
     kepentingan hukum atau penyelidikan<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Reorganisasi bisnis</span></b><span lang="EN-ID">, jika perusahaan mengalami
     merger, akuisisi, atau restrukturisasi<o:p></o:p></span></li>
</ul><p class="MsoNormal"><span lang="EN-ID">Kami
memastikan pihak ketiga mematuhi standar perlindungan data yang kami tetapkan.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">8.
Transfer Data Internasional<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Data Anda
dapat diproses di luar Indonesia (misalnya oleh server cloud global). Kami
memastikan data tetap terlindungi sesuai dengan hukum yang berlaku, termasuk
menerapkan perlindungan kontraktual dan teknis.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">9.
Perlindungan Anak<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Layanan
kami <b>tidak ditujukan untuk anak-anak di bawah usia 13 tahun</b>. Kami tidak
sengaja mengumpulkan data dari anak-anak tanpa izin orang tua. Jika Anda adalah
orang tua dan mengetahui anak Anda telah memberikan data tanpa izin, segera
hubungi kami.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">10.
Tautan ke Situs Lain<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Website
kami dapat mengandung tautan ke situs pihak ketiga. Kami tidak bertanggung
jawab atas konten atau kebijakan privasi situs eksternal tersebut. Harap
periksa terlebih dahulu kebijakan mereka sebelum memberikan informasi pribadi.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">11.
Perubahan Kebijakan Privasi<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Kami dapat
memperbarui Kebijakan Privasi ini sewaktu-waktu. Anda akan diberitahu melalui
email atau notifikasi di situs kami. Tanggal pembaruan akan ditampilkan di
bagian atas dokumen.<o:p></o:p></span></p><p class="MsoNormal"><span lang="EN-ID">Disarankan
untuk meninjau kebijakan ini secara berkala. Penggunaan layanan setelah
perubahan berarti Anda menyetujui versi terbaru.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">12.
Hubungi Kami<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Jika Anda
memiliki pertanyaan tentang Kebijakan Privasi ini, Anda dapat menghubungi kami:<o:p></o:p></span></p><p class="MsoNormal"><span lang="EN-ID" style="font-family:&quot;Segoe UI Emoji&quot;,sans-serif;
mso-bidi-font-family:&quot;Segoe UI Emoji&quot;;mso-ansi-language:EN-ID">📧</span><span lang="EN-ID"> Email: sinauprint@gmail.com<br>
</span><span lang="EN-ID" style="font-family:&quot;Segoe UI Emoji&quot;,sans-serif;
mso-bidi-font-family:&quot;Segoe UI Emoji&quot;;mso-ansi-language:EN-ID">📱</span><span lang="EN-ID"> WhatsApp: 0819 5276 4747<o:p></o:p></span></p><p>



























































































































</p><p class="MsoNormal"><span lang="IN">&nbsp;</span></p>',
            ],
            [
                'type' => 'syarat-ketentuan',
                'content' => '<p class="MsoNormal"><b><span lang="EN-ID">Syarat
dan Ketentuan Penggunaan<o:p></o:p></span></b></p><p class="MsoNormal"><b><span lang="EN-ID">Tanggal
terakhir diperbarui:</span></b><span lang="EN-ID">
6 Juli 2025<o:p></o:p></span></p><p class="MsoNormal"><span lang="EN-ID">Harap baca
Syarat dan Ketentuan ini dengan saksama sebelum menggunakan layanan kami di
website Sinau Print.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">1.
Interpretasi dan Definisi<o:p></o:p></span></b></p><p class="MsoNormal"><b><span lang="EN-ID">Interpretasi<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Kata-kata
yang huruf awalnya ditulis dengan huruf kapital memiliki makna tertentu sesuai
dengan definisi berikut ini. Definisi berikut berlaku baik dalam bentuk tunggal
maupun jamak.<o:p></o:p></span></p><p class="MsoNormal"><b><span lang="EN-ID">Definisi<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Dalam
konteks Syarat dan Ketentuan ini:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><b><span lang="EN-ID">Afiliasi</span></b><span lang="EN-ID"> berarti entitas yang
     mengendalikan, dikendalikan oleh, atau berada di bawah kendali yang sama
     dengan suatu pihak.<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Negara</span></b><span lang="EN-ID"> mengacu pada: Indonesia<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Perusahaan</span></b><span lang="EN-ID"> (disebut sebagai "Sinau
     Print", "Kami", "Kita", atau "Milik
     Kami" dalam perjanjian ini) mengacu pada PT Sinau Print Indonesia,
     beralamat di <b>Jalan Jatibarang Timur 16 No.184, Kedungpane, Kec. Mijen,
     Kota Semarang, Jawa Tengah</b>.<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Perangkat</span></b><span lang="EN-ID"> berarti alat apapun yang dapat
     mengakses Layanan seperti komputer, ponsel, atau tablet digital.<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Layanan</span></b><span lang="EN-ID"> mengacu pada website Sinau
     Print (</span><span lang="IN"><a href="https://sinauprint.com/" target="_new"><span lang="EN-ID">https://sinauprint.com/</span></a></span><span lang="EN-ID">).<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Syarat dan Ketentuan</span></b><span lang="EN-ID"> berarti perjanjian ini yang
     merupakan kesepakatan penuh antara Anda dan Sinau Print.<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Layanan Media Sosial Pihak
     Ketiga</span></b><span lang="EN-ID"> berarti
     layanan atau konten (termasuk data, informasi, produk, atau layanan) yang
     disediakan oleh pihak ketiga.<o:p></o:p></span></li>
 <li class="MsoNormal"><b><span lang="EN-ID">Pengguna / Anda</span></b><span lang="EN-ID"> berarti individu atau badan
     hukum yang mengakses atau menggunakan layanan ini.<o:p></o:p></span></li>
</ul><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">2.
Persetujuan<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Dengan
mengakses dan menggunakan Layanan, Anda menyatakan telah membaca, memahami, dan
menyetujui seluruh isi Syarat dan Ketentuan ini. Jika Anda tidak menyetujui
sebagian atau seluruhnya, Anda tidak diperkenankan menggunakan Layanan.<o:p></o:p></span></p><p class="MsoNormal"><span lang="EN-ID">Pengguna
harus berusia minimal 18 tahun untuk menggunakan layanan ini. Pengguna di bawah
usia tersebut tidak diizinkan untuk membuat akun atau melakukan transaksi.<o:p></o:p></span></p><p class="MsoNormal"><span lang="EN-ID">Penggunaan
layanan ini juga tunduk pada <b>Kebijakan Privasi</b> kami, yang menjelaskan
bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda.
Harap baca Kebijakan Privasi kami dengan seksama.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">3.
Pendaftaran Akun<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Untuk
melakukan pembelian, Anda wajib membuat akun dengan mengisi data berikut secara
akurat:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><span lang="EN-ID">Nama lengkap<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Nomor telepon aktif<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Email pengguna<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Alamat lengkap termasuk <b>kode
     pos</b><o:p></o:p></span></li>
</ul><p class="MsoNormal"><span lang="EN-ID">Anda bertanggung
jawab atas keamanan akun dan kata sandi Anda. Kami tidak bertanggung jawab atas
segala kerugian yang timbul akibat penyalahgunaan akun oleh pihak ketiga.<o:p></o:p></span></p><p class="MsoNormal"><span lang="EN-ID">Kami berhak
untuk menonaktifkan, membekukan, atau menghapus akun yang melanggar Syarat dan
Ketentuan ini tanpa pemberitahuan sebelumnya.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">4.
Ketentuan Produk dan Transaksi<o:p></o:p></span></b></p><p class="MsoNormal"><b><span lang="EN-ID">4.1
Informasi Produk<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Sinau Print
menyediakan platform marketplace yang mempertemukan penjual dan pembeli produk
percetakan maupun barang-barang terkait. Semua informasi produk (gambar, harga,
spesifikasi) diunggah oleh penjual dan dapat diubah oleh kami jika diperlukan.<o:p></o:p></span></p><p class="MsoNormal"><b><span lang="EN-ID">4.2
Pemesanan dan Pembayaran<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Pemesanan
hanya dapat dilakukan oleh pengguna yang telah mendaftar. Pembayaran harus
dilakukan melalui metode pembayaran yang disediakan. Pesanan akan diproses
setelah pembayaran dikonfirmasi.<o:p></o:p></span></p><p class="MsoNormal"><b><span lang="EN-ID">4.3
Pengiriman<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Barang
dikirim ke alamat yang telah diinput pengguna. Biaya dan estimasi pengiriman
akan ditampilkan sebelum checkout. Kami tidak bertanggung jawab atas
keterlambatan atau kehilangan akibat kesalahan kurir.<o:p></o:p></span></p><p class="MsoNormal"><b><span lang="EN-ID">4.4
Retur dan Komplain<o:p></o:p></span></b></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><span lang="EN-ID">Produk dapat diretur <b>jika
     terdapat cacat produksi atau kesalahan cetak</b>.<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Retur harus diajukan dalam
     waktu maksimal <b>2×24 jam</b> setelah barang diterima, disertai bukti
     berupa foto/video.<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Permintaan retur untuk produk
     kustom/cetak tidak dapat dilakukan jika sudah dalam proses produksi.<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Penyelesaian retur dapat
     berupa: pencetakan ulang, pengembalian dana sebagian, atau diskon sesuai
     kesepakatan.<o:p></o:p></span></li>
</ul><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">5. Hak
Kekayaan Intelektual<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Seluruh
konten dalam website Sinau Print termasuk teks, gambar, logo, video, desain
produk, dan kode sumber adalah milik kami atau pihak ketiga yang memberi
lisensi. Anda tidak diperkenankan menggunakan, menggandakan, mengubah, atau
menyebarkan konten tersebut tanpa izin tertulis dari kami.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">6.
Tautan ke Situs Pihak Ketiga<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Website
kami dapat berisi tautan ke situs lain. Kami tidak memiliki kontrol atas isi,
kebijakan privasi, atau praktik situs pihak ketiga tersebut dan tidak
bertanggung jawab atas kerusakan atau kerugian yang mungkin timbul akibat akses
ke situs tersebut.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">7.
Penghentian Layanan<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Kami berhak
menangguhkan atau menghentikan akses Anda ke Layanan kapan saja, tanpa
pemberitahuan sebelumnya, jika ditemukan pelanggaran terhadap Syarat dan
Ketentuan ini.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">8.
Batasan Tanggung Jawab<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Kami tidak
bertanggung jawab atas kerugian tidak langsung seperti:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><span lang="EN-ID">Kehilangan data<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Kehilangan keuntungan<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Gangguan bisnis<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Cedera pribadi<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID">Kerusakan akibat penggunaan
     perangkat lunak pihak ketiga atau virus dari situs kami<o:p></o:p></span></li>
</ul><p class="MsoNormal"><span lang="EN-ID">Total tanggung
jawab kami (jika ada) dibatasi sebesar jumlah yang telah Anda bayarkan melalui
layanan atau maksimum <b>Rp 500.000</b> (setara 30,88 USD), sesuai dengan kurs
ditetapkan per tanggal 6 Juli 2025 dan tidak dapat diubah sebagaimana dengan
perkembangan kurs yang ada kedepannya.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">9.
Penafian “SEBAGAIMANA ADANYA”<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Layanan
disediakan <b>“SEBAGAIMANA ADANYA” dan “SEBAGAIMANA TERSEDIA”</b>, tanpa
jaminan apapun. Kami tidak menjamin bahwa layanan akan selalu bebas dari
kesalahan, aman, tidak terputus, atau memenuhi harapan Anda.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">10.
Hukum yang Berlaku<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Syarat dan
Ketentuan ini tunduk pada hukum Negara Republik Indonesia tanpa memperhatikan
konflik aturan hukumnya.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">11.
Penyelesaian Sengketa<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Jika
terjadi sengketa, Anda setuju untuk menyelesaikannya secara musyawarah terlebih
dahulu dengan menghubungi kami. Jika tidak terselesaikan, maka diselesaikan
melalui Pengadilan Negeri Semarang.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">12.
Perubahan Syarat dan Ketentuan<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Kami dapat
memperbarui Syarat dan Ketentuan ini sewaktu-waktu. Perubahan besar akan
diinformasikan paling lambat 30 hari sebelum berlaku. Penggunaan Layanan
setelah perubahan dianggap sebagai bentuk persetujuan Anda.<o:p></o:p></span></p><div class="MsoNormal" align="center" style="text-align:center"><span lang="EN-ID">

<hr size="2" width="100%" align="center">

</span></div><p class="MsoNormal"><b><span lang="EN-ID">13.
Kontak Kami<o:p></o:p></span></b></p><p class="MsoNormal"><span lang="EN-ID">Jika Anda
memiliki pertanyaan tentang Syarat dan Ketentuan ini, silakan hubungi kami:<o:p></o:p></span></p><ul style="margin-top:0in" type="disc">
 <li class="MsoNormal"><span lang="EN-ID" style="font-family:&quot;Segoe UI Emoji&quot;,sans-serif;mso-bidi-font-family:
     &quot;Segoe UI Emoji&quot;;mso-ansi-language:EN-ID">📧</span><span lang="EN-ID"> Email: sinauprint@gmail.com<o:p></o:p></span></li>
 <li class="MsoNormal"><span lang="EN-ID" style="font-family:&quot;Segoe UI Emoji&quot;,sans-serif;mso-bidi-font-family:
     &quot;Segoe UI Emoji&quot;;mso-ansi-language:EN-ID">📱</span><span lang="EN-ID"> WhatsApp: 0819 5276 4747<o:p></o:p></span></li>
</ul><p>

























































































































</p><p class="MsoNormal"><span lang="IN">&nbsp;</span></p>',
            ],
        ]);
    }
}
