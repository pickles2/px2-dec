px2-dec
=========

px2-dec は、Pickles 2 に DEC 拡張機能を追加します。


## Usage - 使い方

### 1. Pickles2 をセットアップ

### 2. composer.json に追記

```
{
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/tomk79/px2-dec.git"
        }
    ],
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

`$conf->funcs->processor->html` に `tomk79\pickles2\dec\main::exec` を追加。

```
$conf->funcs->processor->html = [
    // DECコメントを削除する
    'tomk79\pickles2\dec\main::exec' ,
];
```

`$conf->plugins->px2dt->paths_module_template` に `./vendor/tomk79/px2-dec/modules/` を追加。

```
// config for Pickles2 Desktop Tool.
@$conf->plugins->px2dt->paths_module_template["DEC"] = "./vendor/tomk79/px2-dec/modules/";
```


## 開発者向け情報 - for Developer

### テスト - Test

```
$ cd {$documentRoot}
$ ./vendor/phpunit/phpunit/phpunit px2DecTest "./tests/px2DecTest.php"
```

