<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetDailyNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily-news:get';
    protected $timeout = 120;


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To retrieve daily news / articles from different api endpoints.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        try {
        $newsApiData = Http::get('https://newsapi.org/v2/everything?q=apple&from=2023-11-26&to=2023-11-26&sortBy=popularity&apiKey=92c16ed8ccf2448aa22803e50fd8d436')->json();
        $guardianApiData = Http::get('https://content.guardianapis.com/search?api-key=a5b9f218-32f4-4ff5-b1f4-567aefe95cf9&page-size=100')->json();
        $nyTimesApiData = Http::get('https://api.nytimes.com/svc/topstories/v2/world.json?api-key=RaltUaheh9n8SDkAtAdQMNOPnC4ST7LC')->json();

        // dd($newsApiData, $guardianApiData, $nyTimesApiData);

        if(!empty($newsApiData['articles']) && $newsApiData['status'] == 'ok') {
            foreach($newsApiData['articles'] as $article) {
                Article::create([
                    'end_point' => 'News Api',
                    'source' => json_encode($article['source']) ?? null,
                    'author' => $article['author'] ?? null,
                    'title' => $article['title'] ?? null,
                    'description' => $article['description'] ?? null,
                    'type' => 'article',
                    'url' => $article['url'] ?? null,
                    'images' => json_encode($article['urlToImage']) ?? null,
                    'published_at' => $article['publishedAt'] ?? null,
                    'category'  => $article['sectionName'] ?? null,
                    'content'   => $article['content'] ?? null,
                ]);
            }
        }

        echo('News Api Done!');

        if(!empty($guardianApiData['response']['results']) && $guardianApiData['response']['status'] == 'ok') {
            foreach($guardianApiData['response']['results'] as $article) {

                Article::create([
                    'end_point' => 'Guardian Api',
                    'source' => json_encode($article['id']) ?? null,
                    'author' => $article['author'] ?? null,
                    'title' => $article['webTitle'] ?? null,
                    'description' => $article['description'] ?? null,
                    'type' => $article['type'] ?? null,
                    'url' => $article['webUrl'] ?? null,
                    // 'images' => json_encode($article['urlToImage']) ?? null,
                    'published_at' => $article['webPublicationDate'] ?? null,
                    'category'  => $article['sectionName'] ?? null,
                    'content'   => $article['content'] ?? null,
                ]);
            }
        }

        echo('Guardian Api Done!');

         if(!empty($nyTimesApiData['results']) && $nyTimesApiData['status'] == 'OK') {
                foreach($nyTimesApiData['results'] as $article) {
                    Article::create([
                        'end_point' => 'NewYork Times Api',
                        // 'source' => json_encode($article['id']) ?? null,
                        'author' => $article['byline'] ?? null,
                        'title' => $article['title'] ?? null,
                        'description' => $article['abstract'] ?? null,
                        'type' => $article['type'] ?? null,
                        'url' => $article['url'] ?? null,
                        'images' => json_encode($article['multimedia']) ?? null,
                        'published_at' => $article['published_date'] ?? null,
                        'category'  => $article['item_type'] ?? null,
                        'content'   => $article['content'] ?? null,
                    ]);
                }
            }
            echo('NewYork Times Api Done!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
