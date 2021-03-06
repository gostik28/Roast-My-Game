<?php

use Illuminate\Database\Seeder;

class GameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('games')->delete();

        $games = array(
            ['id' => 1,
                'user_id' => 1,
                'title' => 'Test Game 1',
                'slug' => 'test-game-1',
                'genre' => 'action',
                'thumbnail' => 'test-game-1-thumb.jpg',
                'description' => 'This is a description. This is a description. This is a description. This is a description. This is a description. This is a description.',
                'likes' => 1,
                'views' => 1020,
                'link_platform_pc' => null,
                'link_platform_mac' => null,
                'link_platform_linux' => null,
                'link_platform_ios' => null,
                'link_platform_android' => null,
                'link_platform_unity' => null,
                'link_platform_other' => null,
                'link_social_greenlight' => 'http://greenlight.com',
                'link_social_kickstarter' => 'http://kickstarter.com',
                'link_social_website' => 'http://website.com',
                'link_social_twitter' => 'http://link-twitter.com',
                'link_social_youtube' => 'http://link-youtube.com',
                'link_social_google_plus' => 'http://link-gplus.com',
                'link_social_facebook' => 'http://link-facebook.com'

            ],
            [
                'id' => 2,
                'user_id' => 1,
                'title' => 'Test Game 2',
                'slug' => 'test-game-2',
                'genre' => 'shooter',
                'thumbnail' => 'test-game-2-thumb.jpg',
                'description' => 'This my description',
                'likes' => 2,
                'views' => 600000,
                'link_platform_pc' => 'http://existing-platform_pc-link.com',
                'link_platform_mac' => 'http://existing-platform_mac-link.com',
                'link_platform_linux' => 'http://existing-platform_linux-link.com',
                'link_platform_ios' => 'http://existing-platform_ios-link.com',
                'link_platform_android' => 'http://existing-platform_android-link.com',
                'link_platform_unity' => 'http://existing-platform_unity-link.com',
                'link_platform_other' => 'http://existing-platform_other-link.com',
                'link_social_greenlight' => 'http://greenlight.com',
                'link_social_kickstarter' => 'http://kickstarter.com',
                'link_social_website' => 'http://website.com',
                'link_social_twitter' => 'http://link-twitter.com',
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'title' => 'Test Game 3',
                'slug' => 'test-game-3',
                'genre' => 'strategy',
                'thumbnail' => 'test-game-3-thumb.jpg',
                'description' => 'This is a teeny tiny description',
                'likes' => 1,
                'views' => 764,
                'link_platform_pc' => 'https://clickr.app/download/test-game-3/platform_pc/test-game-3-platform_pc.zip',
                'link_platform_mac' => 'https://clickr.app/download/test-game-3/platform_mac/test-game-3-platform_mac.zip',
                'link_platform_linux' => 'https://clickr.app/download/test-game-3/platform_linux/test-game-3-platform_linux.zip',
                'link_platform_ios' => 'https://clickr.app/download/test-game-3/platform_ios/test-game-3-platform_ios.zip',
                'link_platform_android' => 'https://clickr.app/download/test-game-3/platform_android/test-game-3-platform_android.zip',
                'link_platform_unity' => 'https://clickr.app/download/test-game-3/platform_unity/test-game-3-platform_unity.zip',
                'link_platform_other' => 'https://clickr.app/download/test-game-3/platform_other/test-game-3-platform_other.zip',
                'link_social_greenlight' => null,
                'link_social_kickstarter' => null,
                'link_social_website' => null,
                'link_social_twitter' => null,
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'title' => 'Test Game 4',
                'slug' => 'test-game-4',
                'genre' => 'puzzle',
                'thumbnail' => 'test-game-4-thumb.jpg',
                'description' => 'This is a short description.',
                'likes' => 0,
                'views' => 887,
                'link_platform_pc' => 'https://clickr.app/download/test-game-3/platform_pc/test-game-3-platform_pc.zip',
                'link_platform_mac' => 'https://clickr.app/download/test-game-3/platform_mac/test-game-3-platform_mac.zip',
                'link_platform_linux' => 'https://clickr.app/download/test-game-3/platform_linux/test-game-3-platform_linux.zip',
                'link_platform_ios' => 'http://existing-ios-link.com',
                'link_platform_android' => 'http://existing-android-link.com',
                'link_platform_unity' => 'http://existing-unity-link.com',
                'link_platform_other' => 'http://existing-other-link.com',
                'link_social_greenlight' => null,
                'link_social_kickstarter' => null,
                'link_social_website' => null,
                'link_social_twitter' => null,
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ],
            [
                'id' => 5,
                'user_id' => 2,
                'title' => 'Test Game 5',
                'slug' => 'test-game-5',
                'genre' => 'strategy',
                'thumbnail' => 'test-game-5-thumb.jpg',
                'description' => 'This is a teeny tiny description',
                'likes' => 0,
                'views' => 764,
                'link_platform_pc' => null,
                'link_platform_mac' => null,
                'link_platform_linux' => null,
                'link_platform_ios' => null,
                'link_platform_android' => null,
                'link_platform_unity' => null,
                'link_platform_other' => null,
                'link_social_greenlight' => null,
                'link_social_kickstarter' => null,
                'link_social_website' => null,
                'link_social_twitter' => null,
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ],
            [
                'id' => 6,
                'user_id' => 3,
                'title' => 'Test Game 6',
                'slug' => 'test-game-6',
                'genre' => 'strategy',
                'thumbnail' => 'test-game-6-thumb.jpg',
                'description' => 'text<br /><br />pharagraph text<br /><br /><strong>bold text</strong><br /><br /><em>italics text</em><br /><br /><a href="http://google.com">link</a><br /><br />
                                <ul>
                                <li>bullet1</li>
                                <li>bullet2</li>
                                <li>bullet3</li>
                                </ul>
                                <br />
                                <ol>
                                <li>number1</li>
                                <li>number2</li>
                                <li>number3</li>
                                </ol>',
                'likes' => 0,
                'views' => 764,
                'link_platform_pc' => null,
                'link_platform_mac' => null,
                'link_platform_linux' => null,
                'link_platform_ios' => null,
                'link_platform_android' => null,
                'link_platform_unity' => null,
                'link_platform_other' => null,
                'link_social_greenlight' => null,
                'link_social_kickstarter' => null,
                'link_social_website' => null,
                'link_social_twitter' => null,
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ],
            [
                'id' => 7, //a minimal game
                'user_id' => 2,
                'title' => 'Test Game 7',
                'slug' => 'test-game-7',
                'genre' => 'strategy',
                'thumbnail' => 'test-game-7-thumb.jpg',
                'description' => '',
                'likes' => 0,
                'views' => 764,
                'link_platform_pc' => null,
                'link_platform_mac' => null,
                'link_platform_linux' => null,
                'link_platform_ios' => null,
                'link_platform_android' => null,
                'link_platform_unity' => null,
                'link_platform_other' => null,
                'link_social_greenlight' => null,
                'link_social_kickstarter' => null,
                'link_social_website' => null,
                'link_social_twitter' => null,
                'link_social_youtube' => null,
                'link_social_google_plus' => null,
                'link_social_facebook' => null
            ],
            [
            'id' => 8, //a minimal game with downloads
            'user_id' => 1,
            'title' => 'Test Game 8',
            'slug' => 'test-game-8',
            'genre' => 'strategy',
            'thumbnail' => 'test-game-8-thumb.jpg',
            'description' => 'This is a description. This is a description. This is a description. This is a description. This is a description. This is a description.',
            'likes' => 0,
            'views' => 123,
            'link_platform_pc' => 'https://clickr.app/download/test-game-3/platform_pc/test-game-3-platform_pc.zip',
            'link_platform_mac' => 'https://clickr.app/download/test-game-3/platform_mac/test-game-3-platform_mac.zip',
            'link_platform_linux' => 'https://clickr.app/download/test-game-3/platform_linux/test-game-3-platform_linux.zip',
            'link_platform_ios' => 'http://existing-ios-link.com',
            'link_platform_android' => 'http://existing-android-link.com',
            'link_platform_unity' => 'http://existing-unity-link.com',
            'link_platform_other' => 'http://existing-other-link.com',
            'link_social_greenlight' => 'http://greenlight.com',
            'link_social_kickstarter' => 'http://kickstarter.com',
            'link_social_website' => 'http://website.com',
            'link_social_twitter' => 'http://link-twitter.com',
            'link_social_youtube' => 'http://link-youtube.com',
            'link_social_google_plus' => 'http://link-gplus.com',
            'link_social_facebook' => 'http://link-facebook.com'
            ]
        );

        // Uncomment the below to run the seeder
        DB::table('games')->insert($games);
    }
}
