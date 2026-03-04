<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-green': '#2E4D07',
                        'nappa-orange': '#F29159',
                    }
                }
            }
        }
    </script>
    <style>
        /* スクロールアニメーション */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1.2s ease-out;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* 🌟 ここから追加：WP管理バー表示時のヘッダー位置調整 🌟 */
        body.admin-bar header {
            top: 32px;
            /* PCサイズの管理バーの高さ */
        }

        @media screen and (max-width: 782px) {
            body.admin-bar header {
                top: 46px;
                /* スマホサイズの管理バーの高さ */
            }
        }
    </style>
</head>

<body <?php body_class('bg-[#F5F2E8] text-stone-800 font-[\'Noto_Sans_JP\'] antialiased'); ?>>
    <header class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-['Montserrat'] font-bold tracking-widest text-dark-green">
                <a href="<?php echo esc_url(home_url('/')); ?>">HanaCAFE nappa69</a>
            </h1>
            <nav class="hidden md:block">
                <ul class="flex gap-8 text-sm font-medium text-gray-700">
                    <li><a href="#about" class="hover:text-dark-green transition-colors">ABOUT</a></li>
                    <li><a href="#menu" class="hover:text-dark-green transition-colors">MENU</a></li>
                    <li><a href="#access" class="hover:text-dark-green transition-colors">ACCESS</a></li>
                    <li><a href="#news" class="hover:text-dark-green transition-colors">NEWS</a></li>
                </ul>
            </nav>
            <a href="#about" class="bg-dark-green text-white px-6 py-2 rounded-full text-sm font-bold hover:bg-opacity-90 transition-all shadow-sm">
                お席の確認
            </a>
        </div>
    </header>