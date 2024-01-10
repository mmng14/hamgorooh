<?php 
//SEO
if(!isset($page_title)){$page_title="بانک اطلاعات عمومی - همگروه";}
if(!isset($page_keywords)){$page_keywords="اخبار,فال حافظ,فال انبیاء,فال چوب,فال عطسه,دکوراسیون,خبر,مقاله,اس ام اس,اس ام اس عاشقانه,فال روز تولد,مدل مانتو,مدل لباس,فال,اس ام اس جدایی,اس ام اس جدید,نماز,فال قهوه,پیامک,پیام های عاشقانه,اس ام اس سرکاری,تقویت مو,ریزش مو,مطالب خنده دار,عکسهای خنده دار,جوک,اختراعات,داروهای گیاهی,عید,فال روزانه,فال امروز,کف بینی,طالع بینی,قیمت ارز,نرخ ارز,قیمت سکه,قیمت طلا,تزئین سفره,سفره آرایی,اس ام اس منت کشی,لطیفه های خنده دار,جوک خنده دار,آموزش آشپزی,مدل لباس بچه,خواص مواد غذایی,روانشناسی کودک,روان شناسی,خانه داری,آرایش صورت,مدل آرایش,معما,چیستان,انواع غذا,دانستنیهای جنسی,زناشویی,شعر کودکانه,ازدواج,تیتر روزنامه ها,دانستنیهای ازدواج,بیماری,گالری عکس,عکس بازیگران,بیوگرافی بازیگران,داستان,خرید اینترنتی,فروشگاه اینترنتی,تعبیرخواب,سرگرمی,گردشگری,آموزش کامپیوتر,اینترنت,ورزش,دین و مذهب,اخبار سیاسی,خبر ورزشی,مقاله علمی,مدل مو,تغذیه";}
if(!isset($page_description)){$page_description="همگروه - بانک اطلاعاتی شامل اخبار،سرگرمی،روانشناسی،زناشویی،فال و طالع بینی،دکوراسیون،آشپزی،گردشگری،داستان،ورزش،کودکان،مدل لباس،آگهی،احکام،گالری عکس،قیمت ارز،روابط زناشویی،مدل آرایش،دارو های گیاهی،دانستنی ها،بیوگرافی بازیگران،دانستنیهای جنسی،دین و مذهب،سلامت و بهداشت،آرایش و زیبایی،آموزش کامپیوتر و اینترنت";}
if(!isset($page_url)){$page_url=$HOST_NAME;$share_link = $HOST_NAME;}

//----------
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title;  ?></title>
    <meta charset="utf-8">

    <meta name="language" content="fa_IR">
    <meta name="geo.region" content="IR" />
    <meta name="geo.placename" content="Babol" />
    <meta name="geo.position" content="32.427908;53.688046" />
    <meta name="ICBM" content="32.427908, 53.688046" />

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="keywords" content="<?php echo  $page_keywords;  ?>">
    <meta name="description"  content="<?php echo $page_description;  ?>">

    <link rel="canonical" href="<?php echo $page_url;  ?>">


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" type="text/css" href="<?php echo $HOST_NAME; ?>resources/assets/css/all.css">

    <style>
        .post-desc {
            direction: rtl;
            text-align: justify;
            font-family: iransans;
        }
    </style>


</head>
<body onload="iframe_resize();">
    <!-- For Google Analytics -->
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date(); a = s.createElement(o),
            m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-77540813-1', 'auto');
        ga('send', 'pageview');

    </script>
    <!-- For Alexa -->
    <a href="http://www.alexa.com/siteinfo/www.hamgorooh.com" style="display: none">
        <script type='text/javascript' src='http://xslt.alexa.com/site_stats/js/s/a?url=www.hamgorooh.com'></script>
    </a>
    <div id="desc" class="post-desc">
        <?php if(isset($post_content) && $post_content): ?>

        <p class="post-desc"><?php  echo htmlspecialchars_decode($post_content['content']);   ?></p>

        <?php  endif; ?>
    </div>
</body>
<script type="text/javascript">
    function iframe_resize() {
        var body = document.body,
        html = document.documentElement,
        height = Math.max(body.scrollHeight, body.offsetHeight,
        html.clientHeight, html.scrollHeight, html.offsetHeight);
        if (parent.postMessage) {
            parent.postMessage(height, "http://www.bazzarrooz.ir");
        }
    }
</script>
</html>


