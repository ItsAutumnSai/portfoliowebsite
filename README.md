# Sultan Agung Portfolio Website
## Anggota:
### 1. Sultan Arya Iskandarsyah (3012310703)
### 2. Agung Setya Ariowirawan (3012310701)

## Deskripsi singkat
Adalah website portfolio menggunakan restful API, terdapat sisi visitor yang dapat berkomentar terhadap setiap portfolio, dan ada juga sisi admin yang dapat menambahkan, mengedit, atau menghapus portfolio.
## Dokumentasi Penggunaan
Visitor dapat registrasi atau login akun melalui tombol pojok kanan atas jika belum ada akun yang terkait. Visitor dapat berkomentar dalam setiap portfolio.
Admin mendapati panel khusus dengan route /admin. satu satunya admin adalah `{email: student@student.uisi.ac.id, password: admin123}` setelah masuk ke panel admin maka terdapat opsi menambahkan, mengedit, serta menghapus portfolio, gambar yang bisa di upload adalah jpeg,png,jpg,gif dengan maksimal resolusi 2048x2048 pixels.
## API Documentation
* GET `/api/portfolios` untuk mendapatkan semua portfolio
* GET `/api/portfolios/{id}` untuk mendapatkan portfolio dengan id yang diminta
* POST `/api/portfolios` untuk menambahkan portfolio dengan id yang diminta
* PUT `/api/portfolios/{id}` untuk mengedit portfolio dengan id yang diminta
** contoh: `{
  "title": "Judul Portfolio"}`
* DELETE `/api/portfolios/{id}` untuk menghapus portfolio dengan id yang diminta
* POST `/api/portfolios/{id}/contents` untuk menambahkan konten kepada id yang diminta
* DELETE `/api/contents/{id}` untuk menghapus konten dengan id _contents_
