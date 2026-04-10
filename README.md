<p align="center"><a href="https://github.com/killukeren/bac-lab" target="_blank"><img src="https://akmweb.youngjoygame.com/web/gms/image/24c43180662d27aa5b62106b596fa4f7.webp" width="400" alt="BAC LAB Logo" style="border-radius: 20px;"></a></p>
<!--Dari https://www.mobilelegends.com/-->

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/Version-1.0.0--beta-blue" alt="Version"></a>
<a href="#"><img src="https://img.shields.io/badge/Laravel-11.x-red" alt="Laravel Version"></a>
<a href="#"><img src="https://img.shields.io/badge/Security-Research-blueviolet" alt="Security Research"></a>
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
</p>

# About BAC-LAB (MLBB CHAT)
BAC-LAB adalah platform strategi chat khusus squad Mobile Legends yang dibangun dengan Laravel. Berbeda dengan aplikasi chat biasa, proyek ini dirancang sebagai Laboratorium Keamanan Web untuk mendemonstrasikan celah Broken Access Control (BAC) dan Insecure Direct Object Reference (IDOR).

# BAC-LAB menyediakan fitur:

- Expressive Routing
- Chat
- Edit Profile
- Role Management


# Project Setup
## Clone the lab
git clone https://github.com/killukeren/bac-lab.git

## Install dependencies
composer install && npm install

- edit pada bagian .env dengan
```

DB_CONNECTION=mysql
DB_HOST=127.0.0.1 >> ip db
DB_PORT=3306 -> port db
DB_DATABASE=bac_db -> nama db
DB_USERNAME=root -> pass db
DB_PASSWORD=
```
- deploy pake laragon/xampp (Apache/Nginx) 
- export file sql ke db
- gass exploit

Contributing
Terima kasih telah tertarik untuk berkontribusi pada pengembangan BAC-LAB! Kamu bisa membantu dengan menambahkan fitur chat baru, memperbaiki UI, atau menambahkan skenario celah keamanan baru.

License
BAC-LAB adalah software open-source yang dilisensikan di bawah MIT license.
