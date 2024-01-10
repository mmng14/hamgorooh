<?php
//require_once "core/utility_controller.php";

$HOME_PAGE_ID = 2;
//$msg = update("home_page", "menu='{$menus}',slider='{$slider}',top_posts='{$top_posts}',popular_posts='{$popular_posts}',recent_posts='{$recent_posts}',ads1='{$ads1}',ads2='{$ads2}',ads3='{$ads3}',ads4='{$ads4}',subject_contents='$subject_contents',galleries='$gallery_contents'", "id=2");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    $active_menu = "index";

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
    $page_content = $ROOT_DIR . "app/admin/views/index.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}


//*************************************************************************************
//**********************************   Update Homepage Ads  ***************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == "V32pXXww826AR34HLHLKcbvcg") {
    
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    date_default_timezone_set('Asia/Tehran');
    $today_date = convertPersianToEng(jdate('Y/m/d'));
    $today_date_num = (int) str_replace("/", "", $today_date);

    $result = $database->ads()
        ->select("*")
        ->where("status=?", 1)
        ->where("start_date_num <= ?", $today_date_num)
        ->where("end_date_num >= ?", $today_date_num);

    $ads1 = "";
    $ads2 = "";
    $ads3 = "";
    $ads4 = "";

    foreach ($result as $ads) {


        if ($ads["type"] == 1) {
            $ads1 = "<a  target=\"_blank\" href=\"{$ads["link_address"]}\"><img class=\"img-responsive\" src=\"{$HOST_NAME}{$ads["photo"]}\" alt=\"\"></a>";
        }

        if ($ads["type"] == 2) {
            $ads2 = "<a target=\"_blank\" href=\"{$ads["link_address"]}\"><img class=\"img-responsive\" src=\"{$HOST_NAME}{$ads["photo"]}\" alt=\"\"  ></a>";
        }

        if ($ads["type"] == 3) {
            $ads3 = "<a  target=\"_blank\" href=\"{$ads["link_address"]}\"><img class=\"img-responsive\" src=\"{$HOST_NAME}{$ads["photo"]}\" alt=\"\"></a>";
        }

        if ($ads["type"] == 4) {
            $ads4 = "<a  target=\"_blank\" href=\"{$ads["link_address"]}\"><img class=\"img-responsive\" src=\"{$HOST_NAME}{$ads["photo"]}\" alt=\"\"></a>";
        }
    }

    if ($HOME_PAGE_ID != "") {
        $update_row = $database->home_page[$HOME_PAGE_ID];
        $property = array("id" => $HOME_PAGE_ID, "ads1" => $ads1, "ads2" => $ads2, "ads3" => $ads3, "ads4" => $ads4);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//**********************************   Update Homepage Subjects  ***************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == "V32pXXw4545PItCBfkhkUIOP") {
    //TODO  later
    echo json_encode(
        array(
            "state" => '1',
        )
    );
}

//*************************************************************************************
//**********************************   Update Homepage   ***************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == "V32pX45BQkjKLJHgyw826ARYkhkhkUIOP") {
    //TODO  later
    echo json_encode(
        array(
            "state" => '1',
        )
    );
}


//*************************************************************************************
//**********************************   Update Homepage With Slider  ***************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == "V3CveOPas34GXXww826ARYkhkhkUIOP") {
    //TODO  later
    echo json_encode(
        array(
            "state" => '1',
        )
    );
}
