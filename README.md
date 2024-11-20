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
docker-compose build
docker-compose up -d
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

## 開発ガイドライン

### コーディング規約

#### 基本設定

- インデント: 2 スペース
- PHP コードスタイル: Laravel Pint
  - Laravel v9.3 以降の場合は Laravel Pint は標準搭載
  - デフォルトの設定で使用可能

### 必要な設定ファイル

- .editorconfig（プロジェクトルートに配置）

```bash
root = true

[*]
charset = utf-8
end_of_line = lf
indent_size = 2
indent_style = space
insert_final_newline = true
trim_trailing_whitespace = true

[*.{php,blade.php}]
indent_size = 2
```

### コードチェック

```bash
# Dockerコンテナ内でコードスタイルをチェック（変更箇所を表示）
docker compose exec laravel.test ./vendor/bin/pint --test

# Dockerコンテナ内でコードをフォーマット
docker compose exec laravel.test ./vendor/bin/pint
```
