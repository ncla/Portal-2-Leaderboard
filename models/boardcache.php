<?php
class BoardCache {
    public static function getBoard($boardName) {
        if(apc_exists($boardName)) {
            return apc_fetch($boardName);
        }
    }
    public static function setBoard($boardName, $board) {
        apc_store($boardName, $board);
    }
}