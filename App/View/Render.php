<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/23
 * Time: 14:30
 */

namespace App\View;


use Common\User;

class Render
{
    static function index(){
        $dom = \pQuery::parseFile( __DIR__.'\\indexPage.tpl');
        $nav = \pQuery::parseFile(__DIR__.'\\component\\nav.tpl');
        $nav->query('#signed')->remove();
        $div = $nav->select('#Nav');
        $js  = $nav->select('#NavScript');
        $dom->query('.body')->append($div);
        $dom->query('.body')->append($js);

        echo $dom->html();
    }
    static function signedIndex(User $user){
        $dom = \pQuery::parseFile( __DIR__.'\\indexPage.tpl');
        $nav = \pQuery::parseFile(__DIR__.'\\component\\nav.tpl');
        $nav->query('#unSign')->remove();
        $char = strtoupper(substr($user->username,0,1));
        $nav->query('#navCircle')->text($char);
        $nav->query('#boldName')->text($user->username);
        $nav->query('#profHref')->attr('href',$user->username);
        $div = $nav->select('#Nav');
        $js  = $nav->select('#NavScript');
        $dom->query('.body')->append($div);
        $dom->query('.body')->append($js);

        echo $dom->html();
    }
}