<?php
//session_start();
//ini_set("display_errors","ON");
//error_reporting(E_ALL);
require_once 'Mobile-Detect-master/Mobile_Detect.php';
    // Safety check.
    if (!class_exists('Mobile_Detect')) { return 'classic'; }
    $detect = new Mobile_Detect;

	if ($detect->isMobile()) {
//echo "This is Mobile";
    // Your code here.
    echo "<h3>Join us in WhatsApp for Offers, Coupons, Recharges</h3>";
	echo do_shortcode('[contact-form-7 id="3032" title="Mobile Number"]');
	echo "<br/><hr>";
	?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Deals with Coupons -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9985881453346589"
     data-ad-slot="3682457750"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br/><hr>
<span style="color: #ff0000; font-size: 14px;">Free Talktime Everyday. Earn upto Rs 250 for Installing EarnTalktime Android App. <a style="color: #000000;" title="mobile recharge app" href="http://5841202.earntalktime.com" target="_blank"><strong>Click Here to Download</a></strong></span>
<br/><hr>
<?php
}
else
{?>
<div id="banner-ad" style="width:600px; margin:0 auto; align:center;"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Deals Banner -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-9985881453346589"
     data-ad-slot="3803758554"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>
<?php }
?>

