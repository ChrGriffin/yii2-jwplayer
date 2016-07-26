Yii2 JWPlayer
-------------

JWPlayer is my favorite video player, so I was kind of bummed that there wasn't
any real extension/widget created yet. I did find one, however it was out-dated
and didn't work very well. The player was out of date, it didn't have any error
handling, and didn't have any global config options. You had to specify your
license key every single time you use the widget.

**JWPlayer Version:** 7.4.4

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/)

* Add

```json
"wadeshuler/yii2-jwplayer" : "*"
```

to the `require` section of your application's `composer.json` file and run `composer update`

* Create a free account at [https://www.jwplayer.com](https://www.jwplayer.com)

Then go to "Tools" on the left side bar under the "Players" menu. Your license key
is the **JW Player 7 (Self-Hosted)** option.

* Add `jwplayer` to your app's config. The following are the min requirements to get running:

```
'components' => [
    'jwplayer' => [
        'class' => 'wadeshuler\jwplayer\JWConfig',
        'key' => '',  // <-- Your Key Here!!
    ]
]
```

* Add the widget to your view where you want to embed a video.

```
use wadeshuler\jwplayer\JWPlayer;

<?= JWPlayer::widget([
    'playerOptions' => [
        'file' => '/path/to/video.mp4'
    ]
]) ?>
```

Refer to the [JWPlayer Config Guide](https://developer.jwplayer.com/jw-player/docs/developer-guide/customization/configuration-reference/) for guidance. Pass your JWPlayer setup config to `playerOptions` as an Array.

`htmlOptions` - HTML options for the player placeholder tag `<div id="w0"></div>`

`playerOptions` - JW Player setup options `jwplayer("w0").setup($playerOptions)`

You can add HTML tags to the JWPlayer placeholder `<div id="w0"></div>`, such as giving it a
class via `htmlOptions`. You can pass any valid JW Player setup config to the player via `playerOptions`.

**Global** - To define a global option, define `htmlOptions` and/or `playerOptions` in your application's config.

**Local** - To only affect the individual player and leave others on your site in tact, define `htmlOptions` and/or `playerOptions` in the widget itself.

-----

## Example 1

Lets add a class to the JW Player placeholder tag. By adding a class, we could put a border around our video.

```
<?= JWPlayer::widget([
    'htmlOptions' => [
        'class' => 'myVideoPlayer',
    ],
    'playerOptions' => [
        'file' => '/path/to/video.mp4',
    ],
]) ?>
```

The above will add the class `myVideoPlayer` to this video ONLY. If you want to add this class globally, to all your videos, add `htmlOptions` to your config instead.

```
'components' => [
    'jwplayer' => [
        'class' => 'wadeshuler\jwplayer\JWConfig',
        'key' => 'ABC123==',  // <-- Your Key Here!!
        'htmlOptions' => [
            'class' => 'myVideoPlayer',
        ],
    ]
]
```

Any local (widget) defined setting **will override** global settings. If you defined a class globally in your config, and also define one locally (widget), the locally defined option will be used.

## Example 2

Lets make every video auto start

```
'components' => [
    'jwplayer' => [
        'class' => 'wadeshuler\jwplayer\JWConfig',
        'key' => 'ABC123==',  // <-- Your Key Here!!
        'playerOptions' => [
            'autostart' => true,
        ],
    ]
]
```

## Example 3

Playlist, including images:

```
<?= JWPlayer::widget([
    'playerOptions' => [
        'playlist' => [
            [
                'file' => '/path/to/video1.mp4',
                'image' => '/path/to/image1.png',
                'title' => 'Video 1',
                'mediaid' => 'ddra573'
            ],
            [
                'file' => '/path/to/video2.mp4',
                'image' => '/path/to/image2.png',
                'title' => 'Video 2',
                'mediaid' => 'ddrx3v2'
            ],
        ],
    ],
]) ?>
```

## Example 4

Sharing on Facebook and Twitter

```
<?= JWPlayer::widget([
    'playerOptions' => [
        'file' => '/path/to/video.mp4',
        'sharing' => [
            'sites' => ['facebook', 'twitter'],
        ],
    ],
]) ?>
```

## Example 5

Video with specific width and height, autostart, and our own class:

```
<?= JWPlayer::widget([
    'htmlOptions' => [
        'class' => 'myVideoPlayer',
    ],
    'playerOptions' => [
        'file' => '/path/to/video.mp4',
        'autostart' => true,
        'width' => '600px',
        'height' => '300px',
    ],
]) ?>
```

## Example 6

Change the skin globally

```
'components' => [
    'jwplayer' => [
        'class' => 'wadeshuler\jwplayer\JWConfig',
        'key' => 'ABC123==',  // <-- Your Key Here!!
        'playerOptions' => [
            'skin' => 'vapor',
        ],
    ]
]
```
