<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/23
 * Time: 14:30
 */

namespace App\View;


use Common\User;
use pQuery\DomNode;

class Render
{
    static function nav(){
        $dom = \pQuery::parseFile( __DIR__.'\\indexPage.tpl');
        $nav = \pQuery::parseFile(__DIR__.'\\component\\nav.tpl');
        $nav->query('#signed')->remove();
        $div = $nav->select('#Nav');
        $js  = $nav->select('#NavScript');
        $dom->query('.body')->append($div);
        $dom->query('.body')->append($js);
        return $dom;
    }
    static function signedNav(User $user){
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
        return  $dom;
    }
    static function jum(DomNode $dom){
        $jum = \pQuery::parseFile(__DIR__.'\\component\\mainJum.tpl');
        $jumb= $jum->select('.jumbotron');
        $dom->query('.body')->append($jumb);
        return $dom;
    }
    static function userProfile(DomNode $dom,$data){
        $upf = \pQuery::parseFile(__DIR__.'\\component\\userProfile.tpl');
        $char = strtoupper(substr($data['username'],0,1));
        $upf->query('#userCircle')->text($char);
        $upf->query('#userName')->text($data['username']);
        $upf->query('#email')->text($data['email']);
        $upf->query('#moreInfo')->text($data['moreinfo']);
        $upfi= $upf->select('#userProfile');
        $dom->query('.body')->append($upfi);
        return $dom;
    }


    static function index(DomNode $dom){
        echo $dom->html();
    }
}