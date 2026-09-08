# Aturan Keamanan Database

1. **JANGAN PERNAH** mereset atau menghapus isi database (seperti menjalankan `migrate:fresh`, `db:wipe`, dsb.) ketika terjadi error.
2. Ketika terjadi bug atau error, perbaiki langsung logika kode programnya (Controller, Model, View, Request, Service, dll.) tanpa menyentuh atau menghapus data yang sudah ada di database.
3. Selalu pertahankan dan jaga integritas seluruh data pengajuan, akun, master data, dan relasi di database.
