<?php namespace App\Http\Controllers;

use App\Post;
use App\Template;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\XmlFeed;

use Illuminate\Http\Request;

class LineController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->data['tmp_template'] = Template::where('template','=','post')->first();
		$this->data['posts'] = Post::where('template_id','=',$this->data['tmp_template']->id)
									->with('parent')
									->with('template')
									->translatedIn()
									->orderBy('id','DESC')
									->paginate(15);
		$xml = new XmlFeed();
		foreach($this->data['posts'] as $t){
			$xml->addArticle($t);
		}

		return response($xml->FeedXml())
					->header('Content-Type', 'application/xml');
	}
}
