# COACHTECHフリマ（フリマアプリ）

本アプリケーションは、ユーザー間で商品の売買ができるC2Cクローンスクールアプリです。
Laravel（Fortify）をベースに、厳格なメール認証セキュリティ、初期データとユーザー投稿データの画像表示互換システム、Stripeによる決済機能を組み込み、実商用を意識した堅牢なシステムとして構築しました。

---

## 主な実装機能（詳細）

実商用アプリとしての利便性とUX（ユーザー体験）を追求し、以下の機能を実装・最適化しました。

### 1. 認証・ユーザー管理機能（メール認証・ログイン・ログアウト）
安全なユーザー環境を提供するため、基本的な「ログイン・ログアウト」機能に加え、「会員登録時のメール認証」を導入しました。新規登録時に認証メールを送信し、有効なメールアドレスであるかを検証することで、不正なアカウント登録やスパム行為を未然に防ぐ堅牢なセキュリティを構築しています。

**【開発環境での検証】**　実装にあたっては、ローカル開発環境でメールの送受信をシミュレートできるテストツール「Mailpit」を導入して検証を行いました。 実際にアカウント名「test」、メールアドレス「test@example.com」、パスワード「password」という具体的なテスト用のデータを作成し、新規登録フォームから送信するテストを繰り返しました。Mailhogの受信トレイに届いた認証メールから、リンクをクリックして無事にアカウントが有効化され、ログイン画面から再度ログインができるかまで、一連のユーザー動線が完璧に動くことを自分の目で確認しながら実装しました。

### 2. 共通ヘッダー検索機能（ブランド名部分一致拡張）
ヘッダーに配置された検索窓から、全画面共通で瞬時に商品を絞り込める機能を実装しました。単なる商品名の一致だけでなく「エンターキー連動によるスムーズな検索実行」や、「ブランド名の部分一致」にも対応させることで、ユーザーが探している商品へストレスなく、直感的にたどり着ける検索ロジックを構築しています。

**【開発環境での検証】**　検証時はテストアカウントを使い、ユーザーが検索窓をどう触るかを想定して様々なパターンを試しました。検索ワードを入力して「Enterキー」を押すだけでスムーズに検索が実行されるかを確認したほか、具体的に「腕時計」や「Rolex」といった単語を入れて、商品名だけでなくブランド名の一部からでも正しく商品がヒットして一覧が絞り込まれるかをテストしました。また、あえてデータベースに「存在しない商品の名前」を入力して検索を実行し、画面が崩れたりエラーになったりせず、正しく「該当する商品がありません」といった適切な表示に切り替わるかまで細かく動かしてテストしました。

### 3. 商品出品機能（画像アップロード対応）
手軽に私物を販売できる「商品の出品機能」を実装しました。商品の名称や価格、説明文、カテゴリ、状態の選択に加え、商品の魅力を視覚的に伝えるための「画像アップロード」に対応しています。

**【開発環境での検証】**　検証用のテストアカウント（アカウント名：test）を使用し、出品機能のあらゆるケースを網羅するテストを繰り返しました。実際に複数の画像ファイルをアップロードしてマイページや一覧画面での表示互換性を検証したほか、未入力や誤入力があった際に「何が足りないのか」がひと目で伝わるよう、フォーム最上部に具体的なエラーメッセージ（「商品名を入力してください」など）が一括でリスト表示される独自のバリデーション挙動も徹底的にテストし、操作性の高い出品動線を作り込みました。

### 4. 決済機能（Stripeクレジットカード / コンビニ決済）
多様な決済ニーズに対応するため、決済インフラ「Stripe API」を導入。安全かつ迅速な「クレジットカード決済」に加え、実用性の高い「コンビニ決済」の双方を選択できるハイブリッドな決済動線を構築しました。購入完了後は、自動的にデータベースを更新して対象商品を即座に「SOLD（売り切れ）」状態へ切り替える堅牢なトランザクション処理を行っています。

**【開発環境での検証】**　実装後はテストアカウント（アカウント名：test）を使い、Stripeのテスト環境で実際の決済が正しく走るかを色々と試しました。具体的には、「HDD」を選択してコンビニ払いでの決済手続きをテストしたほか、「マイク」を購入する際にはStripeのテスト用クレジットカード（番号：4111-1111-1111-1111、CVC：123）を入力し、エラーを起こさず即座に決済が完了することを確認しました。購入した直後に商品一覧画面へ戻り、対象の商品が自動的に「SOLD」の表示に切り替わるかまで、一連の購入動線が完璧に連動して動くかを徹底的にテストしました。

### 5. 配送先住所の個別変更機能
商品の購入手続き画面において、基本プロフィールに登録された住所とは別に、お届け先（郵便番号・住所・建物名）をその場で個別自由に変更できる機能を実装しました。住所変更後はスムーズに元の購入確認画面へとスマートにリダイレクトされ、ユーザーの購入意欲を削がない手戻りのないスムーズな購入動線を実現しています。

**【開発環境での検証】**　実装後はテストアカウント（アカウント名：test）を使い、お届け先をその場で書き換えるテストを色々と試しました。具体的には、郵便番号に「000-0000」、住所に「どこかの府どっかの市ななし町」、建物名に「ホワイトマンション」というテスト用のデータを入力して変更ボタンを実行。エラーを起こさずにデータが更新され、元の購入確認画面へスマートにリダイレクトされるか、また、画面に戻った際に今変更したお届け先住所が正しく反映されているかまで、一連の画面遷移とデータ連携の挙動を徹底的に動かして確認しました。

### 6. 商品お気に入り登録 ＆ マイページ機能（3タブ完全切り替え連動）
気になる商品を保存できる「お気に入り登録機能」と、それらを一元管理できるマイページを実装しました。ユーザーが自身の活動履歴をひと目で把握できるよう、マイページ内には「出品した商品」「購入した商品」「お気に入りした商品」の3つの切り替えタブを配置。コントローラーとフロントエンド（Bladeビュー）を完璧に連動させ、各タブに応じた正しい商品リストを正確に出力・表示させています。また、プロフィール画像と商品画像の双方が、エラーを起こさずにクッキリ表示される堅牢なフロントエンド処理を実装しました。

**【開発環境での検証】**　実装後はテストアカウント（アカウント名：test）を使い、実際のユーザーの動きを想定して色々なパターンを試しました。具体的には、一覧画面から「腕時計」や「メイクセット」を選んで実際にお気に入り（いいね）登録を行い、マイページを開いて「お気に入りした商品」タブにその2つの商品が画像付きで正しく表示されるかを確認しました。さらに、「出品した商品」や「購入した商品」のタブもポチポチと切り替えながら、それぞれのデータが混ざることなく正確に連動して表示が切り替わるかを徹底的にテストしました。

---

##  開発環境のセットアップ（Docker / Laravel Sail）

> 💡 **環境構築時の重要な注意点**
> `docker-compose up` を実行する前に、まずローカル環境で一度 `composer install` を行うか、環境変数（`.env`）を作成しておく必要があります。これを怠ると、Dockerビルド時に `vendor/laravel/sail/runtimes/...` のファイルが見つからずエラー（ビルド失敗）の原因となります。

### 1. 依存パッケージの初期インストール
まず、Dockerを起動するために必要な `vendor` ディレクトリを一時的なコンテナを使って生成、またはローカル環境でインストールします。

```bash
# 1. 登録リポジトリのクローン
git clone https://github.com
cd coachtech-furima

# 2. 初期パッケージのインストール（Sail起動に必要な vendor フォルダを生成）
docker run --rm \
    -u "(id -u):(id -g)" \
    -v "\$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

### 2. 環境変数（.env）の設定
コンテナの権限不一致エラーやDB接続エラーを防ぐため、Docker起動前に必ず環境変数を設定してください。

```bash
cp .env.example .env
```

`.env` を開き、以下の項目を設定・確認します。

#### 🔹 権限・ユーザー設定（重要）
Linux/macOS環境でのファイル書き込み権限の衝突を防ぐため、ファイルの末尾等に以下を追記してください。（Windows+WSL2環境でも推奨）
```ini
WWWGROUP=1000
WWWUSER=1000
```

#### 🔹 データベース接続設定
```ini
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=testing
DB_USERNAME=sail
DB_PASSWORD=password
```

#### 🔹 メール認証用（MailHog）設定
認証メールを受信確認するために、メール送信先を開発環境内の MailHog に指定します。
```ini
MAIL_MAILER=smtp
MAIL_HOST=mysql      # 💡 Docker環境に合わせて指定してください（環境によっては「mailhog」の場合もあります）
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@example.com"
MAIL_FROM_NAME="\${APP_NAME}"
```
※その他、Stripeの各種APIキー（`STRIPE_KEY`、`STRIPE_SECRET`）の設定も合わせて行ってください。

### 3. Dockerコンテナの起動
環境変数の準備ができたら、コンテナを構築・起動します。

```bash
# 起動（バックグラウンド）
docker-compose up -d --build

# フロントエンドパッケージのインストールとビルド
docker-compose exec laravel.test npm install
docker-compose exec laravel.test npm run dev
```

### 4. アプリケーションの初期化
起動したコンテナ内で、キー生成、データベースの構築、および画像表示に必要なシンボリックリンクの作成を行います。

```bash
# アプリケーションキーの生成
docker-compose exec laravel.test php artisan key:generate

# マイグレーション＆シーダー実行（初期データの投入）
docker-compose exec laravel.test php artisan migrate:fresh --seed

# 💡 画像表示用のシンボリックリンク作成（必須）
# 出品された商品画像やプロフィール画像をブラウザから視認可能にするために実行します
docker-compose exec laravel.test php artisan storage:link
```

---

## 🛠️ 各種機能の動作確認手順

### 1. メール認証機能の確認
1. **ユーザー登録画面**（ http://localhost/register ）から新規会員登録を行います。
2. 登録ボタンを押すと、**メール認証確認画面**（ http://localhost/email/verify ）へ自動で遷移します。
3. 開発用メールボックス（ **MailHog**: http://localhost:8025/ ）を開きます。
4. `Verify Email Address` という件名のメールが届いているので、メール内の認証リンクをクリックします。
5. 認証が完了し、初回ログイン処理（※仕様に基づく画面への遷移）が行われます。

> 💡 **【検証時の注意点】Laravel側のバリデーションメッセージを確認する方法**
> メールアドレス入力時、ブラウザ標準のバリデーションが先に動作してしまい、Laravel側でカスタマイズしたエラーメッセージが表示されない場合があります。
> Laravel側の挙動を純粋にテスト・確認したい場合は、該当する `form` タグに `novalidate` 属性を一時的に付与してブラウザのバリデーションを無効化してください。
> 例: `<form action="/register" method="POST" novalidate>`

### 2. 初回ログイン時の挙動について
* 現在、会員登録直後の初回ログイン時は商品一覧画面に遷移する設定となっています。
* 仕様に沿って、今後は**「プロフィール設定画面（ `/mypage/profile` ）」へ遷移**し、ユーザー情報（コメントや購入に必要な情報）をスムーズに登録できるよう、リダイレクト処理の実装および改修を予定しています。

---

##  開発環境URL一覧
* **トップページ（商品一覧）** : http://localhost/
* **ユーザー登録** : http://localhost/register
* **メール認証確認** : http://localhost/email/verify （認証未完了時のガード画面）
* **Mailhog（開発用メールボックス）** : http://localhost:8025/
* **phpMyAdmin（DB管理ツール）** : http://localhost:8080/

###  phpMyAdmin ログイン情報
開発環境のデータベースをGUIで視認・管理できるよう、以下の認証情報で接続可能です。

- **サーバ (Server)**: `mysql`
- **ユーザー名 (Username)**: `sail`
- **パスワード (Password)**: `password`

---

##  テスト用アカウント（動作確認用シーダー実装）

アプリケーションの各種機能（出品・コメント・購入・お気に入り）をスムーズにテストできるよう、目的別に役割を分けた3つのテスト用アカウントをシーダー（`UserSeeder`）によって初期自動生成しています。パスワードは共通で `password` を設定していますが、シーダーの配列を書き換えるだけで個別パスワードへの変更も容易な拡張性の高い設計にしています。

### アカウント一覧と役割



| アカウント名 | メールアドレス | パスワード | 主な運用・テスト目的 |
| :--- | :--- | :--- | :--- |
| **Admin1** | `mi.su.da.kei@gmail.com` | `password` | **メインテスト用（出品者）**<br>ダミー商品の出品データと紐づいており、出品した商品の管理や、購入希望者からの質問（コメント）に回答する「出品者視点」の検証に使用します。 |
| **Admin2** | `suzumiya.kei@gmail.com` | `password` | **一般ユーザー用（購入希望者A / コメント投稿）**<br>Admin1が出品した商品に対して、お気に入り登録や購入前の質問コメントを投稿し、通知や画面連動を検証する「一般購入者視点」のテストに使用します。 |
| **Admin3** | `kaldenisq@gmail.com` | `password` | **第3のユーザー用（購入者B / Stripe決済検証）**<br>コメントの複数人でのやり取りの検証や、Stripe決済を用いた「別ユーザーによる商品の買い占め・SOLD OUT状態」の遷移をリアルに再現・検証するために運用します。 |

---

##  初期投入データ（商品一覧シーダー仕様）

`ItemSeeder` を実行した際、データベースに自動投入される全10件の初期商品データです。すべてのアカウントは **Admin1** の出品物として完璧に紐づけられており、データの整合性を担保しています。



| 商品名 | 価格 (円) | ブランド名 | 商品説明 | コンディション |
| :--- | :--- | :--- | :--- | :--- |
| **腕時計** | 15,000 | Rolax | スタイリッシュなデザインのメンズ腕時計 | 良好 |
| **HDD** | 5,000 | 西芝 | 高速で信頼性の高いハードディスク | 目立った傷や汚れなし |
| **玉ねぎ3束** | 300 | なし | 新鮮な玉ねぎ3束のセット | やや傷や汚れあり |
| **革靴** | 4,000 | (空欄) | クラシックなデザインの革靴 | 状態が悪い |
| **ノートPC** | 45,000 | (空欄) | 高性能なノートパソコン | 良好 |
| **マイク** | 8,000 | なし | 高音質のレコーディング用マイク | 目立った傷や汚れなし |
| **ショルダーバッグ** | 3,500 | (空欄) | おしゃれなショルダーバッグ | やや傷や汚れあり |
| **タンブラー** | 500 | なし | 使いやすいタンブラー | 状態が悪い |
| **コーヒーミル** | 4,000 | Starbacks | 手動のコーヒーミル | 良好 |
| **メイクセット** | 2,500 | (空欄) | 便利なメイクアップセット | 目立った傷や汚れなし |

---

## 🛠️ 使用技術（実行環境）
* **PHP** : 8.x
* **Laravel** : 11.x（Fortify / Blade）
* **MySQL** : 8.0.x
* **フロントエンド** : JavaScript / Tailwind CSS
* **インフラ・外部サービス** :
  - Docker / Laravel Sail
  - Stripe API (決済連携)

※初期データの商品画像には、インターネット上の公開画像URLをデータベースに保持して表示させています。

---

##  データベース設計（ER図）

Markdownのコードブロック（```mermaid）によってGitHub上で自動的に描画される最新のER図です。

```mermaid
erDiagram
    users ||--o{ items : "出品する (user_id)"
    users ||--o{ comments : "コメントする (user_id)"
    users ||--o{ purchases : "購入する (user_id)"
    users ||--o| profiles : "プロフィールを持つ (user_id)"
    
    categories ||--o{ items : "カテゴリに属する (category_id)"
    conditions ||--o{ items : "状態を持つ (condition)"
    
    items ||--o{ comments : "コメントされる (item_id)"
    items ||--o{ purchases : "購入される (item_id)"

    users {
        unsigned_bigint id PK
        varchar_255 name
        varchar_255 email UK
        timestamp email_verified_at
        varchar_255 password
        varchar_100 remember_token
        timestamp created_at
        timestamp updated_at
    }

    profiles {
        unsigned_bigint id PK
        unsigned_bigint user_id FK "users(id)"
        varchar_255 postal_code
        varchar_255 address
        varchar_255 building
        varchar_255 image_url
        timestamp created_at
        timestamp updated_at
    }

    items {
        unsigned_bigint id PK
        unsigned_bigint user_id FK "users(id)"
        unsigned_bigint category_id FK "categories(id)"
        unsigned_bigint condition FK "conditions(id)"
        varchar_255 name
        integer price
        varchar_255 brand
        text description
        varchar_255 image_path
        boolean is_sold
        unsigned_bigint buyer_id FK "users(id)"
        timestamp created_at
        timestamp updated_at
    }

    categories {
        unsigned_bigint id PK
        varchar_255 name
        timestamp created_at
        timestamp updated_at
    }

    conditions {
        unsigned_bigint id PK
        varchar_255 condition
        timestamp created_at
        timestamp updated_at
    }

    comments {
        unsigned_bigint id PK
        unsigned_bigint user_id FK "users(id)"
        unsigned_bigint item_id FK "items(id)"
        text body 
        timestamp created_at
        timestamp updated_at
    }

    purchases {
        unsigned_bigint id PK
        unsigned_bigint user_id FK "users(id)"
        unsigned_bigint item_id FK "items(id)"
        varchar_255 payment_method
        varchar_255 shipping_postal_code
        varchar_255 shipping_address
        varchar_255 shipping_building
        timestamp created_at
        timestamp updated_at
    }

```

---

##  画面一覧とルーティング（URLパス）
スクール指定URLに基づき、実装コード（`web.php`）と完全に同期しています。



| 画面名 | パス | アクセス制限 | 備考 |
| :--- | :--- | :--- | :--- |
| トップページ | `/` | なし | 商品一覧、外部URL画像自動判別表示 |
| 会員登録 | `/register` | ゲストのみ | 登録後、自動で `/email/verify` へ遷移 |
| メール認証確認 | `/email/verify` | 認証前ユーザー | 認証未完了時のガード画面 |
| 商品詳細 | `/item/{id}` | なし | お気に入り状態の表示制御 |
| マイページ | `/mypage` | ログイン（認証済） | 「お気に入り」含む3タブ切り替え |
| 購入確認 | `/shipping/{id}` | ログイン（認証済） | Stripe決済連携 |

---

##  データベース定義書（全7テーブル）

実際のマイグレーションファイルおよび実装環境と100%同期したエクセルレイアウト再現版の仕様です。

<details>
<summary> タップして全7テーブルの定義書を開く</summary>

###  1. usersテーブル


| カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY |
| :--- | :--- | :---: | :---: | :---: | :--- |
| id | unsigned bigint | 〇 | | 〇 | |
| name | varchar(255) | | | 〇 | |
| email | varchar(255) | | 〇 | 〇 | |
| email_verified_at | timestamp | | | | |
| password | varchar(255) | | | 〇 | |
| remember_token | varchar(100) | | | | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

###  2. profilesテーブル


| カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY |
| :--- | :--- | :---: | :---: | :---: | :--- |
| id | unsigned bigint | 〇 | | 〇 | |
| user_id | unsigned bigint | | | 〇 | users(id) |
| postal_code | varchar(255) | | | | |
| address | varchar(255) | | | | |
| building | varchar(255) | | | | |
| image_url | varchar(255) | | | | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

###  3. itemsテーブル


| カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY |
| :--- | :--- | :---: | :---: | :---: | :--- |
| id | unsigned bigint | 〇 | | 〇 | |
| user_id | unsigned bigint | | | 〇 | users(id) |
| condition | unsigned bigint | | | 〇 | conditions(id) |
| name | varchar(255) | | | 〇 | |
| price | integer | | | 〇 | |
| brand | varchar(255) | | | | |
| description | text | | | 〇 | |
| image_path | varchar(255) | | | 〇 | |
| is_sold | boolean | | | 〇 | |
| buyer_id | unsigned bigint | | | | users(id) |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

###  4. categoriesテーブル


| カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY |
| :--- | :--- | :---: | :---: | :---: | :--- |
| id | unsigned bigint | 〇 | | 〇 | |
| name | varchar(255) | | | 〇 | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

###  5. conditionsテーブル


| カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY |
| :--- | :--- | :---: | :---: | :---: | :--- |
| id | unsigned bigint | 〇 | | 〇 | |
| condition | varchar(255) | | | 〇 | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

###  6. commentsテーブル


| カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY |
| :--- | :--- | :---: | :---: | :---: | :--- |
| id | unsigned bigint | 〇 | | 〇 | |
| user_id | unsigned bigint | | | 〇 | users(id) |
| item_id | unsigned bigint | | | 〇 | items(id) |
| body | text | | | 〇 | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

###  7. purchasesテーブル


| カラム名 | 型 | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY |
| :--- | :--- | :---: | :---: | :---: | :--- |
| id | unsigned bigint | 〇 | | 〇 | |
| user_id | unsigned bigint | | | 〇 | users(id) |
| item_id | unsigned bigint | | | 〇 | items(id) |
| payment_method | varchar(255) | | | 〇 | |
| shipping_postal_code | varchar(255) | | | 〇 | |
| shipping_address | varchar(255) | | | 〇 | |
| shipping_building | varchar(255) | | | | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

</details>


---

##  仕様の変更・独自カスタマイズ点

スクール指定の基本仕様や初期設計にとどまらず、実際のフリマアプリとしての操作性やユーザーの利便性を第一に考え、私自身の意見・提案をもとに以下の仕様変更と機能拡張を自発的に行いました。

### 1. コメント機能の仕様改善（出品者返信の許可）
* **背景と自論**: 元の仕様案では「出品者自身は自分の商品にコメントできない」という制限になっていました。しかし、これでは購入希望者から質問が届いた際に出品者が回答や挨拶などの「返信」を行えず、C2Cアプリとして最も重要な取引コミュニケーションが成立しないと考えました。
* **改善アプローチ**: 出品者であっても自商品に対してコメント（返信）を投稿できるよう、バリデーションとポリシーの条件分岐を独自に改修し、円滑なフリマ取引動線を実現しました。

### 2. お気に入り（いいね）機能の表示ロジック変更
* **背景と自論**: 「お気に入り登録した商品はおすすめタブ（一覧）から消えて、お気に入りページへ移動する」という初期仕様でしたが、これではユーザーが「あれ？さっきいいねした商品が一覧から消えた？」と混乱し、認知しづらい使いにくさがあると感じました。
* **改善点**: ユーザーが一覧画面でも状況を把握し続けられるよう、お気に入り登録後もおすすめタブに残し、ひと目で判別できるハートマークを点灯させる仕様へ強化しました。さらに、マイページ側に「お気に入りした商品」タブを新設してスムーズなUI連動を行いました。

### 3. 購入完了後の画面遷移の最適化
* **背景と自論**: 元の設計には「購入完了後の完了（サンクス）ページ」への明快な動線が存在せず、決済完了後のユーザーの次のアクションが不透明な状態でした。
* **改善点**: 取引の安心感と次のステップ（発送待ち確認など）への誘導を高めるため、決済完了後は自動的にデータベースを更新（SOLD状態へ変更）しつつ、専用の完了画面へスムーズに誘導する形へ動線を最適化しました。

### 4. バリデーションエラー表示の統一（最上部一括表示への最適化）

* **背景と自論**: 初期の基本仕様では、エラーメッセージを画面のどこに表示するかが決まっていませんでした。よくあるWebサイトやアプリだと、エラーは各入力欄の下に出ることが多いですが、それではエラーが複数あるときに画面を下にスクロールしないとすべてを確認できず、少し見づらいと感じました。そこで、上部に一括でまとめた方がすっきりして見やすいのではないかと考えました。また、普段よく見る形とは違う「上部まとめスタイル」のデザインを、自分の手で実際に試して作ってみたいという興味もあり、この形に挑戦しました。
* **改善点**: ログイン画面と会員登録画面のどちらも、エラーが発生した際は「フォームの最上部に赤いボックスでまとめてリスト表示する」という形に場所を統一しました。ただ場所を上に持ってくるだけでなく、Laravelの仕様で表示が消えがちだった「確認用パスワードの不一致エラー」もバックエンドのルールを調整して、しっかり最上部に他のエラーと一緒に並んで表示されるように作り込みました。パッと見て何が間違っているかがすぐに把握できる、お気に入りの画面レイアウトに仕上げることができました。

