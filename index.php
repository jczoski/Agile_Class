<?php
$title = "Home";
include "includes/header.php";
?>

<div class="title_image">
        <img class="headerimagestyle" src="http://s-media-cache-ak0.pinimg.com/originals/cc/de/95/ccde95f5bec2cb5fba040d738cb407c1.jpg" width="700" height="400"
             align="middle" alt="Index_image"/>

        <h1 class="site_title">Destiny LiveStream <br/> and Forum</h1>
</div>
<?php



$forum_table = <<<FORUM_TABLE

    <table class="table-style">
    
        <th colspan="5"><h2>Forum Main Categories</h2></th>
        <tr><td></td><td><h4><a href="post_list.php?forum_type=Introductions">Introduce Yourself</a></h4>New to the community? Introduce yourself!</td><td>$introduce_posts topics<br/>$introduce_replies replies</td><td></td></tr>
        <tr><td></td><td><h4><a href="post_list.php?forum_type=General Discussion">General Discussion</a></h4>Anything goes!</td><td>$general_posts topics<br/>$general_replies replies</td><td></td></tr>
        <tr><td></td><td><h4><a href="post_list.php?forum_type=Feed Discussion">Feed Discussion</a></h4>Discussion related to any particular livestream in the site's history.</td><td>$livestream_posts topics<br/>$livestream_replies replies</td><td></td></tr>
        <tr><td></td><td><h4><a href="post_list.php?forum_type=Game Tips">Game Tips</a></h4>Discuss tips and strategies for Destiny.</td><td>$game_tips_posts topics<br/>$game_tips_replies replies</td><td></td></tr>
                
    </table>

FORUM_TABLE;

echo $forum_table;
?>
  <div class="center_this">
  <div id="stream_box">
    <?php
    require_once('EmbedYoutubeLiveStreaming.php');

    $CHANNELID = 'UCMHQalVZ-WOE7T5nitxxQCw';
    $APIKEY = 'AIzaSyBJGoqtDQC3I0Zjn3H8x2G4-kSVr5JjP0Q';
    $YouTubeLive = new EmbedYoutubeLiveStreaming($CHANNELID, $APIKEY);

    if (!$YouTubeLive->isLive) {
      echo "There is no live streaming right now! Response is (Decoded to object):<br><br>";
      echo "<pre><code>";
      var_dump($YouTubeLive->objectResponse);
      // print_r($YouTubeLive->arrayResponse);
      echo "</code></pre>";
    } else {
      echo <<<EOT
      There is a live streaming currently! You can see below!<br>
    <br>
    Title is: {$YouTubeLive->live_video_title}<br>
    <br>
    Description is: {$YouTubeLive->live_video_description}<br>
    <br>
    Video ID is: {$YouTubeLive->live_video_id}<br><br>
    Thumbs are: {$YouTubeLive->live_video_thumb_default}, {$YouTubeLive->live_video_thumb_medium}, {$YouTubeLive->live_video_thumb_high} <br><br>
    Published at: {$YouTubeLive->live_video_published_at}<br><br>
    Channel Title: {$YouTubeLive->channel_title}<br><br>

EOT;

      // $YouTubeLive->setEmbedSizeByWidth(200);
      // $YouTubeLive->setEmbedSizeByHeight(200);
      // $YouTubeLive->embed_autoplay = false;

      echo $YouTubeLive->embedCode();
    }
    ?>
  </div>
  </div>

<?php
include "includes/footer.php";
?>