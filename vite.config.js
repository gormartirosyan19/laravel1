import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                'resources/css/welcome.css',
                'resources/css/allPosts.css',
                'resources/css/createPost.css',
                'resources/css/edit-profile.css',
                'resources/css/editPost.css',
                'resources/css/footer.css',
                'resources/css/forget.css',
                'resources/css/header.css',
                'resources/css/login.css',
                'resources/css/newPassword.css',
                'resources/css/profile.css',
                'resources/css/register.css',
                'resources/css/settings.css',
                'resources/css/verifyForm.css',
                'resources/css/postDetails.css',
                'resources/js/app.js'],
            refresh: [
                ...refreshPaths,
                'app/Filament/**',
                'app/Forms/Components/**',
                'app/Livewire/**',
                'app/Infolists/Components/**',
                'app/Providers/Filament/**',
                'app/Tables/Columns/**',
            ],
        }),
    ],
})
