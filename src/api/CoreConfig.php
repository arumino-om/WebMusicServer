<?php
// --- コア設定ファイル ---
// wmsを動作させるのに必要な最小限の設定を行います。
// 権限等の設定は、admin権限を持つユーザーでログインし、api経由またはwebクライアント経由で行えます。(このファイルでは設定できません)

// データベースにアクセスするための設定
$_wmsGlobal["database"]["dsn"] = "mysql:host=localhost; dbname=web_music_server; charset=utf8";
$_wmsGlobal["database"]["user"] = "root";
$_wmsGlobal["database"]["password"] = "";

// 音声ファイルと認識する拡張子
$_wmsGlobal["core"]["audio-extensions"] = [
    "mp3", "ogg", "wav"
];