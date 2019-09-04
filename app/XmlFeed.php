<?php namespace App;

use Uuid;
use XMLWriter;
use App\Helpers\SystemHelper;

class XmlFeed {
    public $uuid;
    public $time;
    public $articles = [];

    private $articlesCount = 0;

    public function __construct() {
        $this->uuid = str_replace('-', '', Uuid::generate(4));
        $this->time = strval(time());
    }

    public function length() {
        return $this->articlesCount;
    }

    public function addArticle($article) {
        if(is_array($article)) {
            foreach ($article as $value) {
                $this->addSingleArticle($value);
            }
        } else {
            $this->addSingleArticle($article);
        }
    }

    public function FeedXml() {
        $xml = new XMLWriter('1.0', 'UTF-8');
		$xml->openMemory();
		$xml->setIndent(true);
    	$xml->startDocument();
		$xml->startElement('articles');
		$xml->writeElement('UUID', $this->uuid);
		$xml->writeElement('time', $this->printUnixTime($this->time));

        foreach ($this->articles as $value) {
            $createdAt = $value->created_at;
            $startYmdtUnix = $this->printUnixTime($createdAt->timestamp);
            $endYmdtUnix = $this->printUnixTime($createdAt->addDays(45)->timestamp);
            $publishTimeUnix = $startYmdtUnix;
            $publishTime = $this->printTime($createdAt);
            $updateTimeUnix = $this->printUnixTime($value->updated_at->timestamp);
            $updateTime = $this->printTime($value->updated_at);

            //$get_posts_menu = SystemHelper::getMenus($value->menus[0]->name);
            //$recommendArticles = $get_posts_menu->posts()->where('id', '<>', $value->id)->orderBy('id','desc')->take(3)->get();
            $recommendArticles = SystemHelper::getRecommendArticles($value);

            // Begin article
            $xml->startElement('article');
            $xml->writeElement('ID', $value->id);
            $xml->writeElement('nativeCountry', 'TH');
            $xml->writeElement('language', 'th');
            $xml->writeElement('startYmdtUnix', $startYmdtUnix);
            $xml->writeElement('endYmdtUnix', $endYmdtUnix);
            $xml->startElement('publishCountries');
            $xml->writeElement('country', 'TH');
            $xml->endElement();
            $xml->writeElement('title', $value->title);
            $xml->writeElement('category', $value->menus[0]->name);
            $xml->writeElement('publishTimeUnix', $publishTimeUnix);
            $xml->writeElement('publishTime', $publishTime);
            $xml->writeElement('updateTimeUnix', $updateTimeUnix);
            $xml->writeElement('updateTime', $updateTime);

            // Begin contents
            $xml->startElement('contents');
            if(isset(json_decode($value->main_images)->images[0]->path)){
                // Begin image
                $xml->startElement('image');
                $xml->writeElement('title', $value->title);
                $xml->writeElement('url', asset(json_decode($value->main_images)->images[0]->path));
                // End image
                $xml->endElement();
            }
            // Begin text
            $xml->startElement('text');
	    	$xml->startElement('content');
            $xml->writeCData(e($value->content));
	    	$xml->endElement();
            // End text
            $xml->endElement();
            // End contents
            $xml->endElement();
            // Begin recommendArticles
            $xml->startElement('recommendArticles');
            if(isset($recommendArticles)) {
                foreach($recommendArticles as $item) {
                    // Begin article
                    $xml->startElement('article');
                    $xml->writeElement('title', $item->slug);
                    $xml->writeElement('url', url($item->slug));
                    if(isset(json_decode($item->main_images)->images[0]->path)){
                        $xml->writeElement('thumbnail', asset(json_decode($item->main_images)->images[0]->path));
                    }
                    // End article
                    $xml->endElement();
                }
            }
            // End recommendArticles
            $xml->endElement();
            $xml->writeElement('sourceUrl', url($value->slug));
            // End article
            $xml->endElement();
        }

		$xml->endElement();
    	$xml->endDocument();
		$content = $xml->outputMemory();
    	$xml = null;
		return $content;
    }


    private function addSingleArticle($article) {
        $this->articles[$this->articlesCount] = $article;
        $this->articlesCount++;
    }

    private function printUnixTime($time) {
        return $time . "000";
    }

    private function printTime($carbon) {
        return str_pad($carbon->hour, 2, "0", STR_PAD_LEFT).':'.str_pad($carbon->minute, 2, "0", STR_PAD_LEFT);
    }
}