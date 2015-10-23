px2-dec
=========

px2-dec は、Pickles 2 に DEC 拡張機能を追加します。


## Usage - 使い方

### 1. Pickles2 をセットアップ

### 2. composer.json に追記

```
{
    "require": {
        "tomk79/px2-dec": "dev-master"
    }
}
```

### 3. composer を更新

```
$ composer update
```

### 4. px-files/config.php に追加

`$conf->funcs->processor->html` にAPI設定を追加します。

- `tomk79\pickles2\dec\main::trim_dec()` は、埋め込まれたDECを削除します。
- `tomk79\pickles2\dec\main::add_auto_dec()` は、URIパラメータ showDEC をつけると自動的にDECを表示するスクリプトを追加します。
- `tomk79\pickles2\dec\main::exec()` は、`$px->is_publishtool()` の値を参照し、自動的に振り分け処理を行います。

それぞれ、必要な機能を選択して設定してください。

```php
<?php

$conf->funcs->processor->html = [
    // DEC変換処理の実行
    //   Pickles2の状態を参照し、自動的に処理を振り分けます。
    //   パブリッシュする場合、DECコメントを削除します。
    //   プレビューの場合、DECライブラリを埋め込み、
    //   URIパラメータからDECの表示・非表示を切り替えられるようにします。
    'tomk79\pickles2\dec\main::exec()' ,

    // DECを削除する
    'tomk79\pickles2\dec\main::trim_dec()' ,

    // 自動DEC表示機能を追加する
    'tomk79\pickles2\dec\main::add_auto_dec()' ,
];
```

DECモジュールを利用する場合、`$conf->plugins->px2dt->paths_module_template` に `./vendor/tomk79/px2-dec/modules/` を追加。

```php
<?php
// config for Pickles2 Desktop Tool.
@$conf->plugins->px2dt->paths_module_template["DEC"] = "./vendor/tomk79/px2-dec/modules/";
```


## 開発者向け情報 - for Developer

### テスト - Test

```
$ cd {$documentRoot}
$ composer test
```
