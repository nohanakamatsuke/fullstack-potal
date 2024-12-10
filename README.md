## 概要

フルスタック社員が使用可能な、 Web アプリケーション。

## 技術スタック

- PHP 8.3
- Laravel 11.x
- MySQL 8.0
- Docker

## 必要要件

- Docker Desktop
- Git
- VSCode（推奨）

## 環境構築手順

### 1. リポジトリのクローン

```bash
git clone https://github.com/nohanakamatsuke/fullstack-potal.git
```

### 2. 環境設定

```bash
# .envファイルの作成
cp .env.example .env
```

### 3. sail のインストール

```bash
composer require laravel/sail --dev
```

### 4. Docker イメージのビルドと起動

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

### 5. Docker イメージのビルドと起動

```bash
sail build
sail up -d
```

### 5. アプリケーションのセットアップ

```bash
# Composerパッケージのインストール
composer install
# ストレージディレクトリの権限設定
docker compose exec fullstack-portal chmod -R 777 storage bootstrap/cache
# アプリケーションキーの生成
php artisan key:generate
```

### 6. データベースのセットアップ

```bash
# マイグレーションの実行
docker-compose exec fullstack-potal php artisan migrate
# （オプション）シードデータの投入
docker-compose exec fullstack-potal php artisan db:seed
```

### 7. TailwindCSS のインストール

```bash
npm install -D tailwindcss
```

### 7. TailwindCSS のインストール

```bash
npm install -D tailwindcss
```

## 開発ガイドライン

### コーディング規約

#### 基本設定

- インデント: 2 スペース
- PHP コードスタイル: Laravel Pint
  - Laravel v9.3 以降の場合は Laravel Pint は標準搭載
  - デフォルトの設定で使用可能

### 設定ファイル

- .editorconfig（プロジェクトルートにすでに配置）

### コードチェック

```bash
# Dockerコンテナ内でコードスタイルをチェック（変更箇所を表示）
docker compose exec laravel.test ./vendor/bin/pint --test

# Dockerコンテナ内でコードをフォーマット
docker compose exec laravel.test ./vendor/bin/pint
```

# csvファイル出力をするために必要な手順

- Gitの"疑わしい所有権"の警告を解消
  `git config --global --add safe.directory /var/www/html`
  このコマンドを実行することで、Git の所有権警告が解消されます。

- composer.lock のJSONエラーを修正

- composer.lock を削除して再生成
  composer.lock を削除して、新たに生成します。以下の手順を実行してください。
  composer.lock を削除
  `rm composer.lock`
  依存関係を再インストール
  `./vendor/bin/sail composer install`
  これにより、composer.lock が再生成され、正しい状態に戻ります。

- 再インストール 修正後、以下を実行します。
  `./vendor/bin/sail composer install 3. maatwebsite/excel の再インストール`
  上記のエラーが解消したら、再度パッケージをインストールします。

`./vendor/bin/sail composer require maatwebsite/excel`
もし引き続きエラーが発生する場合、以下を試してください。

- キャッシュのクリア
  `./vendor/bin/sail composer clear-cache`
- 依存関係を無視
  `./vendor/bin/sail composer require maatwebsite/excel --ignore-platform-reqs`
