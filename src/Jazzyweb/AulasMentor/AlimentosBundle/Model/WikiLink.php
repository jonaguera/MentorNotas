<?php

namespace Jazzyweb\AulasMentor\AlimentosBundle\Model;

class WikiLink {

    public function __construct() {
        
    }

    private function getWikiLink($nombre) {
        $nombre = urlencode(str_replace(" ", "_", ucwords($nombre)));
        return "http://es.wikipedia.com/wiki/" . $nombre;
    }

    public function addWikiLink($alimentos) {
        $alimentos_wikilink = array();
        foreach ($alimentos as $alimento) {
            $wikilink=  $this->getWikiLink($alimento->getNombre());
            $alimentos_wikilink[$alimento->getNombre()] = $wikilink;
        }
        return $alimentos_wikilink;
    }

}