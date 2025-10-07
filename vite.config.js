import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
           input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/adminguru.css', 
                 'resources/css/dashboarsiswa.css', 
                  'resources/css/detail.css', 
                   'resources/css/gurumenu.css', 
                    'resources/css/login.css', 
                    'resources/css/orangtua.css', 
                    'resources/css/penilaian.css', 
                    'resources/css/siswa.css', 
                    'resources/css/tugas.css', 
            
            ],
        }),
    ],
});
