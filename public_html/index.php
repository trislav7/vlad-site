<?php
echo "<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Vlad Site - Layout Module</title>
    <link rel='stylesheet' href='/assets/client/layout/main.min.css'>
</head>
<body class='bg-gray-50'>
    <!-- Header -->
    <header class='layout-header'>
        <div class='layout-container'>
            <div class='flex justify-between items-center py-4'>
                <div class='text-xl font-bold text-gray-800'>
                    🏗️ Layout Module
                </div>
                <nav class='hidden md:flex space-x-6'>
                    <a href='#' class='text-gray-600 hover:text-blue-600'>Home</a>
                    <a href='#' class='text-gray-600 hover:text-blue-600'>About</a>
                    <a href='#' class='text-gray-600 hover:text-blue-600'>Services</a>
                    <a href='#' class='text-gray-600 hover:text-blue-600'>Contact</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class='layout-container py-8'>
        <div class='text-center mb-12'>
            <h1 class='text-4xl font-bold text-gray-800 mb-4'>
                Layout Module Test
            </h1>
            <p class='text-xl text-gray-600 max-w-2xl mx-auto'>
                Testing the new layout module with Tailwind CSS and custom components
            </p>
        </div>

        <!-- Color Tests -->
        <div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12'>
            <div class='layout-card text-center'>
                <h3 class='text-lg font-semibold mb-3'>Custom Colors</h3>
                <div class='space-y-2'>
                    <div class='h-16 bg-primary-red rounded flex items-center justify-center text-white'>
                        bg-primary-red
                    </div>
                    <div class='h-16 bg-primary-blue rounded flex items-center justify-center text-white'>
                        bg-primary-blue
                    </div>
                    <div class='h-16 bg-primary-green rounded flex items-center justify-center text-white'>
                        bg-primary-green
                    </div>
                </div>
            </div>

            <div class='layout-card text-center'>
                <h3 class='text-lg font-semibold mb-3'>Button Components</h3>
                <div class='space-y-3'>
                    <button class='btn-primary w-full'>
                        Primary Button
                    </button>
                    <button class='btn-secondary w-full'>
                        Secondary Button
                    </button>
                </div>
            </div>

            <div class='layout-card text-center'>
                <h3 class='text-lg font-semibold mb-3'>Default Tailwind</h3>
                <div class='space-y-2'>
                    <div class='h-16 bg-red-500 rounded flex items-center justify-center text-white'>
                        bg-red-500
                    </div>
                    <div class='h-16 bg-blue-500 rounded flex items-center justify-center text-white'>
                        bg-blue-500
                    </div>
                    <div class='h-16 bg-green-500 rounded flex items-center justify-center text-white'>
                        bg-green-500
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class='layout-hero rounded-2xl p-8 text-white text-center mb-12'>
            <h2 class='text-3xl font-bold mb-4'>Hero Section</h2>
            <p class='text-xl opacity-90 max-w-2xl mx-auto'>
                This uses the .layout-hero class with gradient background
            </p>
        </div>

        <!-- Admin Test Section -->
        <div class='layout-card'>
            <h2 class='text-2xl font-bold mb-4'>Admin Layout Test</h2>
            <div class='space-y-4'>
                <p>Testing admin layout classes (check browser console for logs):</p>
                <div class='flex space-x-4'>
                    <button class='btn-admin-primary'>
                        Admin Primary
                    </button>
                    <button class='btn-admin-secondary'>
                        Admin Secondary
                    </button>
                </div>
                <div class='h-20 admin-bg-primary rounded flex items-center justify-center text-white'>
                    admin-bg-primary
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class='layout-footer'>
        <div class='layout-container py-8 text-center'>
            <p>&copy; 2024 Vlad Site. Layout module demonstration.</p>
        </div>
    </footer>

    <script src='/assets/client/layout/app.min.js'></script>
    <script src='/assets/admin/layout/admin.min.js'></script>
</body>
</html>";
?>