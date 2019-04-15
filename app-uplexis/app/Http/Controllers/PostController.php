<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\Post;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class PostController extends Controller
{
    private $urlGet = 'https://www.uplexis.com.br/blog';

    public function getAndSalvePostUrl(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'wordToSearch' => 'required',
        ],['required' => 'Digite uma palavra']);

        if ($validator->fails()) {
            return redirect('home')
                ->withErrors($validator)
                ->withInput();
        }


        $wordToSearch = $data['wordToSearch'];


        $html = $this->getHtmlCurlPost($wordToSearch);

        $arrayPosts = $this->createArrayPostsWitHtml($html);

        $result = [];

        foreach ($arrayPosts as $post){

            $result[] = $this->updateOrCreatePost($post);
        }

        if(count($result) > 0){
            return redirect()->route('home')
                ->with('success', 'Posts encontrados');
        }
        return redirect()->route('home')
            ->withErrors(['getPostError' => 'Nenhum post encontrado']);
    }

    private function getHtmlCurlPost($wordToSearch) {

        return Curl::to($this->urlGet)
            ->withData( array( 's' => urlencode($wordToSearch) ) )
            ->get();
    }

    private function createArrayPostsWitHtml($html) {

        $domHtml = new \DOMDocument; // '\' usada para o Laravel reconhecer a classe nativa
        libxml_use_internal_errors(true); //Para que o DOMDocument reconheça tags do hrml 5
        $htmlUTF8 = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8"); //converte textos para UTF8
        $domHtml->loadHTML($htmlUTF8);
        $divs = $domHtml->getElementsByTagName('div');

        $arrayPosts = [];

        foreach ($divs as $div){

            $class = explode(' ', $div->getAttribute('class'));

            if(!in_array('post', $class)){
                continue;
            }

            $divsPost = $div->getElementsByTagName('div');
            $aPost = $div->getElementsByTagName('a');

            $title = '';
            $link = '';

            foreach ($divsPost as $divPost){

                $classTitle = explode(' ', $divPost->getAttribute('class'));

                if(!in_array('title', $classTitle)) {
                    continue;
                }

                $title = trim($divPost->textContent);

            }

            if(isset($aPost[0])){
                $link = $aPost[0]->getAttribute('href');
            }

            if($title === '' || $link === '') {
                continue;
            }

            $arrayPosts[] = ['title' => $title, 'url' => $link];
        }

        return $arrayPosts;
    }

    private function updateOrCreatePost($post){

        $result = Post::updateOrCreate(
            ['url' => $post['url']],
            $post
        );

        return $result;
    }

    public function deletePost($id){

        $post = Post::find($id);
        if(!$post){
            return redirect()->route('home')
                ->withErrors(['deleteNotFound' =>'Error ao excluir - post não encontrado ']);
        }
        $result = $post->delete();

        if($result) {
            return redirect()->route('home')
                ->with('success', 'Post excluído');
        }

        return redirect()->route('home')
            ->withErrors(['deleteError' => 'Error ao excluir post']);
    }
}
