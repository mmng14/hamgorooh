<?php
include "includes/config.php";
include "includes/NotORM.php";
include_once 'libraries/phpfunction.php';
include_once 'libraries/jdf.php';
include_once 'libraries/smily.php';
include_once 'libraries/sanitize_title.php';

try
{

    $dsn = "mysql:dbname=$DB_NAME;host=$DB_SERVER;charset=utf8";
    $GLOBALS["db_pdo"] = new PDO($dsn, "$DB_USER", "$DB_PASS");

    function db()
    {
        return new NotORM($GLOBALS["db_pdo"]);
    }

    $main_page = db()->main_page()
      ->where("status = ?",1)
      ->order("id desc")
      ->fetch();


    $main_subjects =  db()->main_subject()
        ->select("*")
        ->where("status = ?",1)
        ->order("id");

    $share_link = $HOST_NAME;
    $page_url = $share_link;
    $page_title="بانک اطلاعات عمومی - همگروه";
    $page_keywords="اخبار,فال حافظ,فال انبیاء,فال چوب,فال عطسه,دکوراسیون,خبر,مقاله,اس ام اس,اس ام اس عاشقانه,فال روز تولد,مدل مانتو,مدل لباس,فال,اس ام اس جدایی,اس ام اس جدید,نماز,فال قهوه,پیامک,پیام های عاشقانه,اس ام اس سرکاری,تقویت مو,ریزش مو,مطالب خنده دار,عکسهای خنده دار,جوک,اختراعات,داروهای گیاهی,عید,فال روزانه,فال امروز,کف بینی,طالع بینی,قیمت ارز,نرخ ارز,قیمت سکه,قیمت طلا,تزئین سفره,سفره آرایی,اس ام اس منت کشی,لطیفه های خنده دار,جوک خنده دار,آموزش آشپزی,مدل لباس بچه,خواص مواد غذایی,روانشناسی کودک,روان شناسی,خانه داری,آرایش صورت,مدل آرایش,معما,چیستان,انواع غذا,دانستنیهای جنسی,زناشویی,شعر کودکانه,ازدواج,تیتر روزنامه ها,دانستنیهای ازدواج,بیماری,گالری عکس,عکس بازیگران,بیوگرافی بازیگران,داستان,خرید اینترنتی,فروشگاه اینترنتی,تعبیرخواب,سرگرمی,گردشگری,آموزش کامپیوتر,اینترنت,ورزش,دین و مذهب,اخبار سیاسی,خبر ورزشی,مقاله علمی,مدل مو,تغذیه";
    $page_description="همگروه - بانک اطلاعاتی شامل اخبار،سرگرمی،روانشناسی،زناشویی،فال و طالع بینی،دکوراسیون،آشپزی،گردشگری،داستان،ورزش،کودکان،مدل لباس،آگهی،احکام،گالری عکس،قیمت ارز،روابط زناشویی،مدل آرایش،دارو های گیاهی،دانستنی ها،بیوگرافی بازیگران،دانستنیهای جنسی،دین و مذهب،سلامت و بهداشت،آرایش و زیبایی،آموزش کامپیوتر و اینترنت";
    $page_og_image="{$HOST_NAME}resources/shared/images/favicon.jpg";
    $page_og_title="بانک اطلاعات عمومی - همگروه";
    $page_og_sitename=$HOST_NAME;
}
catch(Exception $e)
{
    echo "<div style='margin: 50px auto;text-align:center'>";
    echo "<img src='"  . $HOST_NAME . "resources/shared/images/broken.jpg' />";
    echo "</div>";
    exit;
}
?>
<?php include_once 'views/shared/home_header.php';  ?>
<div class="container">
    <section id="mainContent">
        <div class="content_top">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm6">
                    <div class="latest_slider">
                        <?php echo $main_page["slider"]; ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm6">
                    <div class="content_top_right">
                        <ul class="featured_nav wow fadeInDown">

                            <?php echo $main_page["top_posts"]; ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>



        <div class="content_middle">


            <div class="col-lg-12 col-md-12">


                <?php  if($main_subjects):   ?>
                <?php  foreach($main_subjects as $main_subject): ?>

                <div class="col-lg-6 col-md-6">
                    <div class="content_bottom_left">
                        <div class="single_category wow fadeInDown">
                            <h2><span class="bold_line"><span></span></span><span class="solid_line"></span><a class="title_text" href="<?php echo $HOST_NAME . "subject/". strlen($main_subject["subject_id"]) . $main_subject["subject_id"] . "/" . $main_subject["url_link"]    ?>"><?php echo $main_subject["subject_title"]; ?></a> </h2>
                            <?php echo htmlspecialchars_decode($main_subject["content"]); ?>
                        </div>
                    </div>
                </div>

                <?php endforeach ; ?>
                <?php endif; ?>

            </div>
        </div>

    </section>
</div>
<?php include_once 'shared/views/home_footer.php';  ?>
