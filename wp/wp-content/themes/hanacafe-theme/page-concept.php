<?php
/*
Template Name: コンセプトページ
*/
get_header(); ?>

<main class="pt-32 pb-24 bg-[#F5F2E8] min-h-screen">
    <div class="container mx-auto px-4 max-w-3xl reveal active">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-serif text-dark-green mb-4">CONCEPT</h1>
            <p class="text-sm tracking-widest text-stone-500">空間について</p>
        </div>

        <div class="bg-white p-8 md:p-14 rounded-2xl shadow-sm text-stone-700 leading-loose text-sm md:text-base">
            <p class="mb-6">花と植物、美味しいコーヒーとカフェごはん　大好きなものたちを詰め込んだ小さなカフェ、、、はじめました。</p>

            <p class="mb-6">手塗りの生成色の壁に木のぬくもりを感じる椅子とテーブル、お気に入りのソファーを一席どうぞ。<br>
                ひとりの時間を大切にしたいお客様の為に、カウンター席を多数ご用意しました。</p>

            <p class="mb-6">棚には不思議なかたちの多肉植物やサボテン達、店先では季節の花鉢が静かにお出迎えしています。</p>

            <p class="mb-6">全てのメニューを一つ一つ心を込めて手作りで、玄米や有機野菜、旬の地産野菜を中心にした、<br>
                <span class="font-bold text-dark-green text-lg mt-2 inline-block">「体に優しい心が嬉しいお料理」</span>
            </p>

            <p class="mb-6">毎朝焼くまるパン、そしてクッキーやケーキは国産小麦、バターで作ります。<br>
                自家製のジンジャーエールや果実酒などもございます。</p>

            <p>大好きなものたちを詰め込んだ隠れ家カフェ、<br>
                ゆっくりとした時間が流れる、そんなカフェ空間です。</p>
        </div>

        <div class="text-center mt-12">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block text-sm text-stone-500 hover:text-dark-green transition-colors underline underline-offset-4">
                トップページへ戻る
            </a>
        </div>
    </div>
</main>

<?php get_footer(); ?>