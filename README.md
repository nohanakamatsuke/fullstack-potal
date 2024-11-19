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
git clone []
cd [fullstack-potal]
```

### 2. 環境設定

```bash
# .envファイルの作成
cp .env.example .env
# Composerパッケージのインストール
composer install
# アプリケーションキーの生成
php artisan key:generate
```

### 3. Docker の起動

```bash
docker-compose up -d
```

### 4. データベースのセットアップ

```bash
# マイグレーションの実行
docker-compose exec laravel.test php artisan migrate
# （オプション）シードデータの投入
docker-compose exec laravel.test php artisan db:seed
```

## 開発ガイドライン

### コーディング規約

- インデント: 2 スペース
- PHP コードスタイル: Laravel Pint 準拠
- Blade テンプレート: Laravel Blade Formatter 準拠

### VSCode 推奨設定

以下の拡張機能をインストールしてください：

- Laravel Pint
- Laravel Blade Formatter

### フォーマッター設定

プロジェクトルートに以下のファイルが配置されています：

- `.editorconfig`: エディタ設定
- `pint.json`: PHP 用フォーマッター設定

### コードチェック

```bash
# コードスタイルチェック
composer lint
# コードフォーマット
composer format
```
