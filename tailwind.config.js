import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                biogen: {
                    dark: '#0B5E3C',     // Hijau Tua (Sidebar, branding)
                    medium: '#2F9A32',   // Hijau (Warna sekunder, button)
                    light: '#6BBF59',    // Hijau Muda (Warna aksen, hover)
                    bg: '#F5F6F8',       // Background internal
                },
                status: {
                    disetujui: '#2F9A32',          // Hijau
                    menunggu: '#EAB308',           // Kuning
                    ditolak: '#EF4444',            // Merah
                    selesai: '#3B82F6',            // Biru
                    terjadwal: '#8B5CF6',          // Ungu
                    magang: '#06B6D4',             // Biru Muda
                    dibatalkan: '#6B7280',         // Abu-abu
                }
            }
        },
    },

    plugins: [forms],
};
