<h1>Video Errors Detected on <?php echo base_url(); ?>!</h1>

<p>The video errors could be any of the following:</p>

<ul>
    <li>The index still includes a legacy response that needs to be removed.</li>
    <li>The video file doesn't exist in the S3 bucket for this experience.</li>
    <li>The video file exists in the S3 bucket for this experience but it's named incorrectly.  Remember, file names are case sensitive in S3.</li>
    <li>Read permissions weren't set correctly on the video file in S3.</li>
    <li>The video hasn't propagated to CloudFront yet.  CloudFront caches not found errors.  Try invalidating the cache for this file in the <a href="https://console.aws.amazon.com/cloudfront/home">CloudFront Console</a> if none of the above work.</li>
    <li>Uknown CloudFront Error.</li>
</ul>

<h2>Video Errors:</h2>

<ul>
<?php foreach($missing_response_videos as $response => $videos): ?>
    <li style="font-weight:bold;"><?php echo $response; ?></li>

    <li style="list-style-type:none;">
        <ul>
            <?php foreach($videos as $video): ?>
                <li><?php echo $video; ?></li>
            <?php endforeach; ?>
        </ul>
    </li>
<?php endforeach;?>
</ul>