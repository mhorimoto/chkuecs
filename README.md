# chkuecs

Check UECS node Life and Death Monitoring Program  
UECSノード死活監視プログラム

## このプログラムの目的

対象とするUECSノード全てでUECSプログラムが動作しているかを監視するプログラムです。
pingだけではプログラムが動作しているかわからないため、uecsrxdbが受信したパケットを元に死活を判定する。

## 必要条件

* uecsrxdbが動作する環境
* Mailが送信できる事
* PHPプログラムが動作すること

## プログラムのインストール方法

 1. sudo install chkuecs.php /usr/local/bin
 2. chkuecs.conf を編集する。
 3. sudo cp chkuecs.conf /usr/local/etc

## chkuecs.confの編集方法

    [M304 No.1]
    ip = "192.168.120.171"
    mailto = "sending@to.your.address"
    location = "M304 No.1"

|          |  意味              |
|----------|--------------------|
| [名称]   | ノード名称         |
| ip       | IPアドレス         |
| mailto   | メール送信先       |
| location | ノード設置場所など |

多分、日本語だとうまく行かないと思います。

## 実行方法

このプログラムは、起動するとセマフォファイルを確認して異常があればメールを送信し、
何もなければセマフォファイルを作成して終了します。
uecsrxdbプログラムがセマフォファイルを削除するか否かで正常か異常が判定されます。

UECSの電文は3倍ルールの寿命計算が一般的です。
そのため、1Mの電文でも3分に1回は届くと想定して、5分毎にこのプログラムを起動することにします。

この起動には crontab を用いることにします。

      `sudo crontab -e`

として

      `*/5 * * * * /usr/local/bin/chkuecs.php`

この行を追記します。

## 履歴

 *  v1.00: 1st release 2024/01/22

## 作者

堀本　正文 https://www.ys-lab.tech/ 

## LICENSE
 MITライセンスです。
