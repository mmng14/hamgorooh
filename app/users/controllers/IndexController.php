<?php
// require_once "includes/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    // $home_page = $database->home_page()
    //     ->where("status = ?", 1)
    //     ->order("id desc")
    //     ->fetch();


    // $home_subjects = $database->home_subjects()
    //     ->select("*")
    //     ->where("status = ?", 1)
    //     ->order("id");

    //Get UserId
    $current_user_id = $_SESSION["user_id"];

    $user_subjects = $database->user_subjects()
        ->select("*")
        ->where("status = ?", 1)
        ->where("role <> ?", 2)
        ->where("user_id = ?", $current_user_id)
        ->order("subject_name asc");

    $user_subject_list = array();

    if ($user_subjects) {
        foreach ($user_subjects as $user_subject_item) {
            $user_subject_list[] = $user_subject_item["subject_id"];
        }
    }

    $subject_list = $database->subject()
        ->select("*")
        ->where("status = ?", 1)
        ->where("id", $user_subject_list)
        ->order("ordering asc");

    $share_link = $HOST_NAME;
    $page_url = $share_link;
    $page_title = "بانک اطلاعات عمومی - همگروه";
    $page_keywords = "اخبار,فال حافظ,فال انبیاء,فال چوب,فال عطسه,دکوراسیون,خبر,مقاله,اس ام اس,اس ام اس عاشقانه,فال روز تولد,مدل مانتو,مدل لباس,فال,اس ام اس جدایی,اس ام اس جدید,نماز,فال قهوه,پیامک,پیام های عاشقانه,اس ام اس سرکاری,تقویت مو,ریزش مو,مطالب خنده دار,عکسهای خنده دار,جوک,اختراعات,داروهای گیاهی,عید,فال روزانه,فال امروز,کف بینی,طالع بینی,قیمت ارز,نرخ ارز,قیمت سکه,قیمت طلا,تزئین سفره,سفره آرایی,اس ام اس منت کشی,لطیفه های خنده دار,جوک خنده دار,آموزش آشپزی,مدل لباس بچه,خواص مواد غذایی,روانشناسی کودک,روان شناسی,خانه داری,آرایش صورت,مدل آرایش,معما,چیستان,انواع غذا,دانستنیهای جنسی,زناشویی,شعر کودکانه,ازدواج,تیتر روزنامه ها,دانستنیهای ازدواج,بیماری,گالری عکس,عکس بازیگران,بیوگرافی بازیگران,داستان,خرید اینترنتی,فروشگاه اینترنتی,تعبیرخواب,سرگرمی,گردشگری,آموزش کامپیوتر,اینترنت,ورزش,دین و مذهب,اخبار سیاسی,خبر ورزشی,مقاله علمی,مدل مو,تغذیه";
    $page_description = "همگروه - بانک اطلاعاتی شامل اخبار،سرگرمی،روانشناسی،زناشویی،فال و طالع بینی،دکوراسیون،آشپزی،گردشگری،داستان،ورزش،کودکان،مدل لباس،آگهی،احکام،گالری عکس،قیمت ارز،روابط زناشویی،مدل آرایش،دارو های گیاهی،دانستنی ها،بیوگرافی بازیگران،دانستنیهای جنسی،دین و مذهب،سلامت و بهداشت،آرایش و زیبایی،آموزش کامپیوتر و اینترنت";
    $page_og_image = "{$HOST_NAME}resources/shared/images/favicon.jpg";
    $page_og_title = "بانک اطلاعات عمومی - همگروه";
    $page_og_sitename = $HOST_NAME;


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/users/views/index.view.php";
    return include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}
