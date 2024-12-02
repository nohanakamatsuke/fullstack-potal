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

### 4. エイリアスの設定

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

### 5. Docker イメージのビルドと起動

```bash
sail build
sail up -d
```

### 6. アプリケーションのセットアップ

```bash
# Composerパッケージのインストール
composer install
# ストレージディレクトリの権限設定
docker compose exec fullstack-portal chmod -R 777 storage bootstrap/cache
# アプリケーションキーの生成
php artisan key:generate
```

### 7. データベースのセットアップ

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

## 開発ガイドライン

### コーディング規約

#### 基本設定

- インデント: 2 スペース
