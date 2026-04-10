<p align="center"><a href="https://github.com/killukeren/bac-lab" target="_blank"><img src="https://akmweb.youngjoygame.com/web/gms/image/24c43180662d27aa5b62106b596fa4f7.webp" width="400" alt="BAC LAB Logo" style="border-radius: 20px;"></a></p>

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/Version-1.0.0--beta-blue" alt="Version"></a>
<a href="#"><img src="https://img.shields.io/badge/Laravel-11.x-red" alt="Laravel Version"></a>
<a href="#"><img src="https://img.shields.io/badge/Security-Research-blueviolet" alt="Security Research"></a>
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
</p>

#About BAC-LAB
BAC-LAB adalah platform strategi chat khusus squad Mobile Legends yang dibangun dengan Laravel. Berbeda dengan aplikasi chat biasa, proyek ini dirancang sebagai Laboratorium Keamanan Web untuk mendemonstrasikan celah Broken Access Control (BAC) dan Insecure Direct Object Reference (IDOR).

#BAC-LAB menyediakan fitur:

Expressive Routing: Menggunakan UUID untuk navigasi profil yang dinamis.

Strategize & Chat: Interface modern untuk diskusi draft pick dan analisis meta.

Vulnerable Architecture: Didesain sengaja dengan celah keamanan pada logika otorisasi untuk tujuan riset.

Tailwind-Powered UI: Tampilan futuristik dengan tema gelap (dark mode) ala game kompetitif.

Learning Security with BAC-LAB
BAC-LAB memiliki dokumentasi internal sederhana untuk membantu researcher pemula memahami bagaimana celah keamanan muncul:

Cara Kerja Broken Access Control.

Mengidentifikasi IDOR pada API Endpoints.

Implementasi UUID vs Integer IDs.

Project Setup
Struktur BAC-LAB mengikuti konvensi Laravel standar, membuatnya mudah dipasang untuk keperluan demo atau pengujian:

Bash
# Clone the lab
git clone https://github.com/killukeren/bac-lab.git

# Install dependencies
composer install && npm install

# Setup environment & database
php artisan migrate --seed
Security Vulnerabilities
Jika kamu menemukan celah keamanan yang tidak sengaja dibuat (di luar celah edukasi BAC yang sudah ada), silakan buka Issue atau hubungi maintainer di repo ini. Semua riset keamanan sangat dihargai untuk pengembangan lab ini lebih lanjut.

Contributing
Terima kasih telah tertarik untuk berkontribusi pada pengembangan BAC-LAB! Kamu bisa membantu dengan menambahkan fitur chat baru, memperbaiki UI, atau menambahkan skenario celah keamanan baru.

License
BAC-LAB adalah software open-source yang dilisensikan di bawah MIT license.
