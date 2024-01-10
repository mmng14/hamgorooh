<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $home_page = $database->home_page()
        ->where("status = ?", 1)
        ->order("id desc")
        ->fetch();


    $home_subjects = $database->home_subjects()
        ->select("*")
        ->where("status = ?", 1)
        ->order("id");

    $subject_list = $database->subject()
        ->select("*")
        ->where("status = ?", 1)
        ->where("top_menu = ?", 1)
        ->order("ordering");


    $share_link = $HOST_NAME;
    $page_url = $share_link;
    $page_title = "بانک اطلاعات عمومی - همگروه";
    $page_keywords = "اخبار,فال حافظ,فال انبیاء,فال چوب,فال عطسه,دکوراسیون,خبر,مقاله,اس ام اس,اس ام اس عاشقانه,فال روز تولد,مدل مانتو,مدل لباس,فال,اس ام اس جدایی,اس ام اس جدید,نماز,فال قهوه,پیامک,پیام های عاشقانه,اس ام اس سرکاری,تقویت مو,ریزش مو,مطالب خنده دار,عکسهای خنده دار,جوک,اختراعات,داروهای گیاهی,عید,فال روزانه,فال امروز,کف بینی,طالع بینی,قیمت ارز,نرخ ارز,قیمت سکه,قیمت طلا,تزئین سفره,سفره آرایی,اس ام اس منت کشی,لطیفه های خنده دار,جوک خنده دار,آموزش آشپزی,مدل لباس بچه,خواص مواد غذایی,روانشناسی کودک,روان شناسی,خانه داری,آرایش صورت,مدل آرایش,معما,چیستان,انواع غذا,دانستنیهای جنسی,زناشویی,شعر کودکانه,ازدواج,تیتر روزنامه ها,دانستنیهای ازدواج,بیماری,گالری عکس,عکس بازیگران,بیوگرافی بازیگران,داستان,خرید اینترنتی,فروشگاه اینترنتی,تعبیرخواب,سرگرمی,گردشگری,آموزش کامپیوتر,اینترنت,ورزش,دین و مذهب,اخبار سیاسی,خبر ورزشی,مقاله علمی,مدل مو,تغذیه";
    $page_description = "همگروه - بانک اطلاعاتی شامل اخبار،سرگرمی،روانشناسی،زناشویی،فال و طالع بینی،دکوراسیون،آشپزی،گردشگری،داستان،ورزش،کودکان،مدل لباس،آگهی،احکام،گالری عکس،قیمت ارز،روابط زناشویی،مدل آرایش،دارو های گیاهی،دانستنی ها،بیوگرافی بازیگران،دانستنیهای جنسی،دین و مذهب،سلامت و بهداشت،آرایش و زیبایی،آموزش کامپیوتر و اینترنت";
    $page_og_image = "{$HOST_NAME}resources/images/favicon.jpg";
    $page_og_title = "بانک اطلاعات عمومی - همگروه";
    $page_og_sitename = $HOST_NAME;


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";

    //Check cookie if exist
    $cookie_name = "hamgorooh";
    if (isset($_COOKIE[$cookie_name])) {

        #region check_cookie

        $user_name_encrypted = $_COOKIE[$cookie_name];
        $user_name = decrypt_data($user_name_encrypted);
        $user_result = $database->users()
            ->where("username = ?", $user_name)
            ->where("status = ?", 1)
            ->fetch();

        if ($user_result) // if found something
        {

            $_SESSION['user_id'] = $user_result['id'];
            $_SESSION['user_name'] = $user_result['username'];
            $_SESSION['full_name'] = $user_result['name'] . " " . $user_result['family'];
            $_SESSION['user_email'] = $user_result['email'];
            $_SESSION['user_photo'] = $user_result['photo'];
            $_SESSION['reg_date'] = $user_result['reg_date'];
            $_SESSION['user_type'] = $user_result['type']; // 1 = admin / 2 = subject admin / 3 = group admin / 4 = power user / 5 = user

            $user_subjects = $database->user_subjects()
                ->select("*")
                ->where("status = ?", 1)
                ->where("user_id = ?", $user_result['id'])
                ->order("subject_name asc");


            $userSubjectsViewModel = [];

            $subject_rows = $database->subject()
                ->select("id,name,photo")
                ->where("status=?", 1);


            if (isset($user_subjects)) {

                foreach ($user_subjects as $user_subject) {

                    $subject_name = "نام موضوع";
                    foreach ($subject_rows as $subject_row) {
                        if ($subject_row["id"] == $user_subject["subject_id"]) {
                            $subject_name = $subject_row["name"];
                            $subject_photo = $subject_row["photo"];
                        }
                    }


                    $userSubjectsViewModel[] = [
                        "id" =>  $user_subjects['id'],
                        "subject_id" =>  $user_subject['subject_id'],
                        "subject_name" =>  $subject_name,
                        "subject_photo" =>  $subject_photo,
                        "user_id" =>  $user_subject['user_id'],
                        "role" =>  $user_subject['role'],
                        "user_rights" =>  $user_subject['user_rights'],
                        // "register_date" =>  $user_subject['register_date'],
                        "accept_date" =>  $user_subject['accept_date'],
                        "status" =>  $user_subject['status']
                    ];
                }
            }


            $_SESSION["user_subjects"] = $userSubjectsViewModel;

            $user_groups = $database->user_groups()
                ->select("*")
                ->where("status = ?", 1)
                ->where("user_id = ?", $user_result['id'])
                ->order("group_id asc");

            $user_groups_arr = iteratorToArray($user_groups);
            $_SESSION["user_groups"] = $user_groups_arr;

            $user_type_name = "";
            if ($user_result['type'] == 1) {
                $user_type_name = "مدیر سایت";
            }
            if ($user_result['type'] == 2) {
                $user_type_name = "مدیر گروه اصلی";
            }
            if ($user_result['type'] == 3) {
                $user_type_name = "مدیر گروه";
            }
            if ($user_result['type'] == 4) {
                $user_type_name = "کابر ويژه";
            }
            if ($user_result['type'] == 5) {
                $user_type_name = "کاربر سایت";
            }
            $_SESSION['user_type_name'] = $user_type_name;
            //Redirect To Home Page

            $redirect = "";
            #region redirect_home
            //admin home
            if ($_SESSION['user_type'] == "1") {
                $redirect = "{$HOST_NAME}admin/index"; /* Redirect browser */
            }

            //admin subject
            if ($_SESSION['user_type'] == "2") {
                $redirect = "{$HOST_NAME}group_admin/index"; /* Redirect browser */
            }

            //group admin
            if ($_SESSION['user_type'] == "3") {
                $redirect = "{$HOST_NAME}users/index"; /* Redirect browser */
            }

            //group user
            if ($_SESSION['user_type'] == "4" || $_SESSION['user_type'] == "5") {
                $redirect =  "{$HOST_NAME}users/index"; /* Redirect browser */
            }
   
            #endregion redirect_home

        }else{
            //Clear cookie
            unset($_COOKIE['hamgorooh']); 
            setcookie ("hamgorooh", null, time() - 3600);
        }

        #endregion check_cookie
    }

    if (isset($_SESSION['user_id'])) {
        $show_register_form = false;
    } else {
        $show_register_form = true;
    }

    $page_content = $ROOT_DIR . "app/home/views/index.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_home.php";
}
