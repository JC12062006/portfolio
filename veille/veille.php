<?php
// --- CONFIGURATION DES FLUX ---
$configs = [
    'unreal_enginenews' => [
        'titre' => 'UnrealEngineNews RSS',
        'url'   => 'https://unrealenginenews.com/feed/',
        'icon'  => 'fa-solid fa-newspaper',
        'desc'  => 'Actualités Unreal Engine – flux fiable (site non officiel).'
    ],
    'unreal_youtube' => [
        'titre' => 'YouTube Unreal Engine',
        'url'   => 'https://www.youtube.com/feeds/videos.xml?channel_id=UCBobmJyzsJ6Ll7UbfhI4iwQ',
        'icon'  => 'fa-brands fa-youtube',
        'desc'  => 'Toutes les vidéos Unreal Engine.'
    ],
    'unreal_reddit' => [
        'titre' => 'Reddit Unreal Engine',
        'url'   => 'https://www.reddit.com/r/unrealengine/.rss',
        'icon'  => 'fa-brands fa-reddit',
        'desc'  => 'Posts de la communauté Unreal.'
    ],
    'unreal_tomlooman' => [
        'titre' => 'Tom Looman Blog',
        'url'   => 'https://tomlooman.com/feed/',
        'icon'  => 'fa-solid fa-code',
        'desc'  => 'Tutoriels et astuces Unreal Engine.'
    ],
    'unreal_80lv' => [
        'titre' => '80.lv Unreal Articles',
        'url'   => 'https://80.lv/articles/unreal-engine-5/rss',
        'icon'  => 'fa-solid fa-lightbulb',
        'desc'  => 'Articles Unreal Engine (80.lv).'
    ]
];

// --- CHOIX DE LA SOURCE ---
$sujet = isset($_GET['sujet']) && array_key_exists($_GET['sujet'], $configs)
    ? $_GET['sujet']
    : 'unreal_enginenews';

$currentConfig = $configs[$sujet];

// --- FONCTION DE RÉCUPÉRATION DES ARTICLES ---
function getRssItems($url, $limit = 12){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $content = curl_exec($ch);
    if(!$content) return [];

    curl_close($ch);

    $rss = @simplexml_load_string($content);
    if(!$rss) return [];

    $items = [];

    if(isset($rss->channel->item)){
        $feedItems = $rss->channel->item;
    } elseif(isset($rss->entry)) {
        $feedItems = $rss->entry;
    } else {
        return [];
    }

    foreach($feedItems as $item){
        if(count($items) >= $limit) break;

        $title = (string) $item->title;
        $desc = strip_tags((string)($item->description ?? $item->summary ?? $item->content ?? ''));
        if(strlen($desc) > 180) $desc = substr($desc, 0, 180) . '...';

        $link = '#';
        if(isset($item->link['href'])){
            $link = (string) $item->link['href'];
        } elseif($item->getName() == 'entry'){
            foreach($item->link as $l){
                $attr = $l->attributes();
                if(isset($attr['href'])){
                    $link = (string) $attr['href'];
                    break;
                }
            }
        }

        $dateStr = (string) ($item->pubDate ?? $item->updated ?? date('c'));
        $date = date('d/m/Y', strtotime($dateStr));

        $items[] = [
            'title' => $title,
            'link'  => $link,
            'date'  => $date,
            'desc'  => $desc
        ];
    }

    return $items;
}

// --- RÉCUPÉRATION DES ARTICLES ---
$articles = getRssItems($currentConfig['url'], 12);