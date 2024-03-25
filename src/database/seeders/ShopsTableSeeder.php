<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'area_id' => 13,
            'owner_id' => 1,
            'shop' => '仙人',
            'overview' => '料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。食材・味・価格、お客様の満足度を徹底的に追及したお店です。特別な日のお食事、ビジネス接待まで気軽に使用することができます。',
            'img' => 'sushi.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 27,
            'owner_id' => 2,
            'shop' => '牛助',
            'overview' => '焼肉業界で20年間経験を積み、肉を熟知したマスターによる実力派焼肉店。長年の実績とお付き合いをもとに、なかなか食べられない希少部位も仕入れております。また、ゆったりとくつろげる空間はお仕事終わりの一杯や女子会にぴったりです。',
            'img' => 'yakiniku.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 40,
            'owner_id' => 3,
            'shop' => '戦慄',
            'overview' => '気軽に立ち寄れる昔懐かしの大衆居酒屋です。キンキンに冷えたビールを、なんと199円で。鳥かわ煮込み串は販売総数100000本突破の名物料理です。仕事帰りに是非御来店ください。',
            'img' => 'izakaya.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 13,
            'owner_id' => 4,
            'shop' => 'ルーク',
            'overview' => '都心にひっそりとたたずむ、古民家を改築した落ち着いた空間です。イタリアで修業を重ねたシェフによるモダンなイタリア料理とソムリエセレクトによる厳選ワインとのペアリングが好評です。ゆっくりと上質な時間をお楽しみください。',
            'img' => 'italian.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 40,
            'owner_id' => 5,
            'shop' => '志摩屋',
            'overview' => 'ラーメン屋とは思えない店内にはカウンター席はもちろん、個室も用意してあります。ラーメンはこってり系・あっさり系ともに揃っています。その他豊富な一品料理やアルコールも用意しており、居酒屋としても利用できます。ぜひご来店をお待ちしております。',
            'img' => 'ramen.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 13,
            'owner_id' => 6,
            'shop' => '香',
            'overview' => '大小さまざまなお部屋をご用意してます。デートや接待、記念日や誕生日など特別な日にご利用ください。皆様のご来店をお待ちしております。',
            'img' => 'yakiniku.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 27,
            'owner_id' => 7,
            'shop' => 'JJ',
            'overview' => 'イタリア製ピザ窯芳ばしく焼き上げた極薄のミラノピッツァや厳選されたワインをお楽しみいただけます。女子会や男子会、記念日やお誕生日会にもオススメです。',
            'img' => 'italian.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 13,
            'owner_id' => 8,
            'shop' => 'らーめん極み',
            'overview' => '一杯、一杯心を込めて職人が作っております。味付けは少し濃いめです。 食べやすく最後の一滴まで美味しく飲めると好評です。',
            'img' => 'ramen.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 27,
            'owner_id' => 9,
            'shop' => '鳥雨',
            'overview' => '素材の旨味を存分に引き出す為に、塩焼を中心としたお店です。比内地鶏を中心に、厳選素材を職人が備長炭で豪快に焼き上げます。清潔な内装に包まれた大人の隠れ家で贅沢で優雅な時間をお過ごし下さい。',
            'img' => 'izakaya.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 13,
            'owner_id' => 10,
            'shop' => '築地色合',
            'overview' => '鮨好きの方の為の鮨屋として、迫力ある大きさの握りを1貫ずつ提供致します。',
            'img' => 'sushi.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 27,
            'owner_id' => 11,
            'shop' => '晴海',
            'overview' => '毎年チャンピオン牛を買い付け、仙台市長から表彰されるほどの上質な仕入れをする精肉店オーナーの本当に美味しい国産牛を食べてもらいたいという思いから誕生したお店です。',
            'img' => 'yakiniku.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 40,
            'owner_id' => 12,
            'shop' => '三子',
            'overview' => '最高級の美味しいお肉で日々の疲れを軽減していただければと贅沢にサーロインを盛り込んだ御膳をご用意しております。',
            'img' => 'yakiniku.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 13,
            'owner_id' => 13,
            'shop' => '八戒',
            'overview' => '当店自慢の鍋や焼き鳥などお好きなだけ堪能できる食べ放題プランをご用意しております。飲み放題は2時間と3時間がございます。',
            'img' => 'izakaya.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 27,
            'owner_id' => 14,
            'shop' => '福助',
            'overview' => 'ミシュラン掲載店で磨いた、寿司職人の旨さへのこだわりはもちろん、 食事をゆっくりと楽しんでいただける空間作りも意識し続けております。 接待や大切なお食事にはぜひご利用ください。',
            'img' => 'sushi.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 13,
            'owner_id' => 15,
            'shop' => 'ラー北',
            'overview' => 'お昼にはランチを求められるサラリーマン、夕方から夜にかけては、学生や会社帰りのサラリーマン、小上がり席もありファミリー層にも大人気です。',
            'img' => 'ramen.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 27,
            'owner_id' => 16,
            'shop' => '翔',
            'overview' => '博多出身の店主自ら厳選した新鮮な旬の素材を使ったコース料理をご提供します。一人一人のお客様に目が届くようにしております。',
            'img' => 'izakaya.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 13,
            'owner_id' => 17,
            'shop' => '経緯',
            'overview' => '職人が一つ一つ心を込めて丁寧に仕上げた、江戸前鮨ならではの味をお楽しみ頂けます。鮨に合った希少なお酒も数多くご用意しております。他にはない海鮮太巻き、当店自慢の蒸し鮑、是非ご賞味下さい。',
            'img' => 'sushi.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 13,
            'owner_id' => 18,
            'shop' => '漆',
            'overview' => '店内に一歩足を踏み入れると、肉の焼ける音と芳香が猛烈に食欲を掻き立ててくる。そんな漆で味わえるのは至極の焼き肉です。',
            'img' => 'yakiniku.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 40,
            'owner_id' => 19,
            'shop' => 'THE TOOL',
            'overview' => '非日常的な空間で日頃の疲れを癒し、ゆったりとした上質な時間を過ごせる大人の為のレストラン&バーです。',
            'img' => 'italian.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
        $param = [
            'area_id' => 27,
            'owner_id' => 20,
            'shop' => '木船',
            'overview' => '毎日店主自ら市場等に出向き、厳選した魚介類が、お鮨をはじめとした繊細な料理に仕立てられます。また、選りすぐりの種類豊富なドリンクもご用意しております。',
            'img' => 'sushi.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shops')->insert($param);
    }
}
