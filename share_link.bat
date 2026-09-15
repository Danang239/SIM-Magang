@echo off
title SIP Biogen - Public URL (Cloudflare Tunnel)
color 0A
cls
echo =====================================================================
echo          MEMBUAT URL PUBLIK TESTING (CLOUDFLARE TUNNEL)              
echo =====================================================================
echo.
echo Pastikan 'php artisan serve' tetap aktif di terminal lain.
echo.
echo Sedang menyiapkan URL publik Cloudflare (CSS, JS, & Gambar 100%% Aktif)...
echo ---------------------------------------------------------------------
echo.
"C:\Program Files (x86)\cloudflared\cloudflared.exe" tunnel --url http://localhost:8000
pause
