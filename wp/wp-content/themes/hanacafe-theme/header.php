<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-[#F5F2E8] text-stone-800 font-[\'Noto_Sans_JP\'] antialiased'); ?>>
    <header class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-['Montserrat'] font-bold tracking-widest text-[#2E4D07]">
                <a href="<?php echo esc_url(home_url('/')); ?>">HanaCAFE nappa69</a>
            </h1>
            <nav class="hidden md:block">
                <ul class="flex gap-8 text-sm font-medium text-gray-700">
                    <li><a href="#about" class="hover:text-[#2E4D07] transition-colors">ABOUT</a></li>
                    <li><a href="#menu" class="hover:text-[#2E4D07] transition-colors">MENU</a></li>
                    <li><a href="#access" class="hover:text-[#2E4D07] transition-colors">ACCESS</a></li>
                    <li><a href="#news" class="hover:text-[#2E4D07] transition-colors">NEWS</a></li>
                </ul>
            </nav>
            <a href="#seats" class="bg-[#2E4D07] text-white px-6 py-2 rounded-full text-sm font-bold hover:bg-opacity-90 transition-all">
                お席の確認
            </a>
        </div>
    </header>