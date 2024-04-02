# 飲食店予約サービス
### 飲食店を確認、予約をすることができるサービス

## 作成目的
模擬案件を通して実践に近い開発経験を積むために作成

## アプリケーションURL
- 開発環境：http://localhost/
- 本番環境：http://18.182.80.119/
- phpMyAdmin：http://localhost:8080/
- MailHog：http://localhost:8025/

## テスト用アカウント
会員

        Email：test@test.com

        Pass ：123456789

管理者

        Email：admin@test.com

        Pass ：123456789

店舗代表者

        Email：owner@test.com

        Pass ：123456789

既存の店の店舗代表者アカウントにログインしたい場合はphpMyAdminを使用してメールアドレスを参照してください。Passは「123456789」です。

## テスト用クレジットカード番号
        4242 4242 4242 4242

支払い機能で使用できるテスト用のクレジットカード番号です
## 機能一覧
<table>
<tr>
<th>
<div style="text-align: center;">
トップ画面
</div>
</th>
<th>
<div style="text-align: center;">
店舗詳細画面
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/top.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E5%BA%97%E8%88%97%E8%A9%B3%E7%B4%B0.png">
</td>
</tr>
<tr>
<td>
ハートマークを押すことでお気に入りの登録・削除を行うこともできます。
</td>
<td>
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
予約通知機能
</div>
</th>
<th>
<div style="text-align: center;">
評価機能
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E4%BA%88%E7%B4%84%E3%83%A1%E3%83%BC%E3%83%AB%E9%80%9A%E7%9F%A5.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E8%A9%95%E4%BE%A1.png">
</td>
</tr>
<tr>
<td>
予約を行っていると、当日の朝に通知メールが登録アドレスに送信されます。付属されているQRコードを店舗に提示することで、簡単に予約の照合が行えます。
</td>
<td>
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
メニュー画面（未ログイン状態）
</div>
</th>
<th>
<div style="text-align: center;">
メニュー画面（ログイン状態）
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E3%83%A1%E3%83%8B%E3%83%A5%E3%83%BC%EF%BC%88%E6%9C%AA%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3%EF%BC%89.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E3%83%A1%E3%83%8B%E3%83%A5%E3%83%BC%EF%BC%88%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3%EF%BC%89.png">
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
会員登録機能
</div>
</th>
<th>
<div style="text-align: center;">
ログイン機能
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E4%BC%9A%E5%93%A1%E7%99%BB%E9%8C%B2.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3.png">
</td>
</tr>
<tr>
<td>
</td>
<td>
管理者と店舗代表者のログインもこちらで行えます。
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
確認用メール通知画面
</div>
</th>
<th>
<div style="text-align: center;">
確認用メール
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E7%A2%BA%E8%AA%8D%E7%94%A8%E3%83%A1%E3%83%BC%E3%83%AB%E9%80%9A%E7%9F%A5%E7%94%BB%E9%9D%A2.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E7%A2%BA%E8%AA%8D%E3%83%A1%E3%83%BC%E3%83%AB.png">
</td>
</tr>
</tr>
<tr>
<td>
会員登録後、こちらのページに遷移します。
</td>
<td>
MailHogからメールの確認ができます
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
マイページ
</div>
</th>
<th>
<div style="text-align: center;">
予約変更画面
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E3%83%9E%E3%82%A4%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E4%BA%88%E7%B4%84%E5%A4%89%E6%9B%B4.png">
</td>
</tr>
<tr>
<td>
予約の変更・削除ができ、対応している予約であれば事前支払いも可能となっています。今回は、テスト用アカウントの持つ予約を事前支払いに対応させています。
</td>
<td>
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
支払い機能
</div>
</th>
<th>
<div style="text-align: center;">
メニュー画面（管理者ログイン状態）
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E6%94%AF%E6%89%95%E3%81%84%E7%94%BB%E9%9D%A2.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E3%83%A1%E3%83%8B%E3%83%A5%E3%83%BC%EF%BC%88%E3%82%A2%E3%83%89%E3%83%9F%E3%83%B3%EF%BC%89.png">
</td>
</tr>
<tr>
<td>
テスト用のクレジットカードを使用できます。ほかの情報は適当で大丈夫です。
</td>
<td>
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
店舗代表者用アカウント作成機能
</div>
</th>
<th>
<div style="text-align: center;">
メール送信機能
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E3%82%AA%E3%83%BC%E3%83%8A%E3%83%BC%E7%99%BB%E9%8C%B2.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E3%83%A1%E3%83%BC%E3%83%AB%E9%80%81%E4%BF%A1.png">
</td>
</tr>
</tr>
<tr>
<td>
管理者であれば店舗代表者用のアカウントを作成することができます。
</td>
<td>
管理者はすべてのユーザーに対してメールを送信することができます。
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
メニュー画面（店舗代表者ログイン状態）
</div>
</th>
<th>
<div style="text-align: center;">
店舗作成機能
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E3%83%A1%E3%83%8B%E3%83%A5%E3%83%BC%EF%BC%88%E3%82%AA%E3%83%BC%E3%83%8A%E3%83%BC%EF%BC%89.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E5%BA%97%E8%88%97%E4%BD%9C%E6%88%90.png">
</td>
</tr>
<tr>
<td>
</td>
<td>
店舗代表者は、まだ店舗を作成していなければ新たに店舗を作成することができます。
</td>
</tr>
</table>

<table style='width:50%'>
<tr>
<th>
<div style="text-align: center;">
店舗更新機能
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/%E6%96%B0%E3%81%97%E3%81%84%E3%83%95%E3%82%A9%E3%83%AB%E3%83%80%E3%83%BC/%E5%BA%97%E8%88%97%E6%9B%B4%E6%96%B0.png">
</td>
</tr>
<tr>
<td>
既に店舗を作成している場合は、店舗の情報を更新することができます。また、現在の予約状況も確認できます。
</td>
</tr>
</table>

## 使用技術
<table>
<tr>
<td>
フロントエンド
</td>
<td>
HTML , CSS , JavaScript
</td>
</tr>
<tr>
<td>
バックエンド
</td>
<td>
PHP：8.2 ,
Laravel：10.45.1 ,
MySQL：8.0.36
</td>
</tr>
<tr>
<td>
インフラ
</td>
<td>
Docker (開発環境) ,
AWS
</td>
</tr>
<tr>
<td>
その他
</td>
<td>
Git , GitHub
</td>
</tr>
</table>

## テーブル設計
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/table1.png">
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/table2.png">
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/table3.png">

## ER図
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/reservation/reservation.drawio.png">

## 環境構築
### Dockerビルド
1.         git clone git@github.com:nakagawa1573/shops.git
2.         docker-compose up -d --build

＊MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせて docker-compose.ymlファイルを編集してください。

### Laravel環境構築
1.         docker-compose exec php bash
2.         composer install
3. .env.exampleファイルから.envを作成
4. .envを編集

        DB_CONNECTION=mysql
        DB_HOST=mysql
        DB_PORT=3306
        DB_DATABASE=laravel_db
        DB_USERNAME=laravel_user
        DB_PASSWORD=laravel_pass
   
        MAIL_MAILER=smtp
        MAIL_HOST=mailhog
        MAIL_PORT=1025
        MAIL_USERNAME=null
        MAIL_PASSWORD=null
        MAIL_ENCRYPTION=null
        MAIL_FROM_ADDRESS="test@test.com"
        MAIL_FROM_NAME="Rese"

        STRIPE_KEY=pk_test_51OwaF1Ej4thKGBpLnvdTzxna6urrkUm2AqtJLfvgpmwcnn9elUJORyof8iPnPtHQzs6aqgBuRaHLrG5V2KVxXSCl00umi16ofV

        STRIPE_SECRET=sk_test_51OwaF1Ej4thKGBpLFeajzbDVcZ0zt6FdKp8OLozLYyCqbyslLTN2pMYKW85yr9VgMIxJSQfl7C0FasgZLVYVyp2C00jdTkefhY
5.         php artisan key:generate
6. もしマイグレーションとシーディングがされていなければ、自分で実行してください


           php artisan migrate
           php artisan db:seed
8.         php artisan storage:link

## 本番環境
AWSを利用して構築
<table>
<tr>
<td>
バックエンド
</td>
<td>
EC2（Amazon Linux2）
</td>
</tr>
<tr>
<td>
データベース
</td>
<td>
RDS（MySQL）
</td>
</tr>
<tr>
<td>
ストレージ
</td>
<td>
S3
</td>
</tr>
</table>
