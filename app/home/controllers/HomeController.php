<?php
//require_once "core/utility_controller.php";


//Get Sub category list for combo box
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["GET_SUBCATEGORY_LIST_CODE"]) {

    $categoryId = mysql_escape_mimic($_POST['categoryId']);
    $category = $database->category()
        ->select("*")
        ->where("id = ?", $categoryId)
        ->where("status = ?", 1)
        ->fetch();


    if ($category) // if found something
    {

        $subject = $database->subject()
            ->select("*")
            ->where("id = ?", $category["subject_id"])
            ->where("status = ?", 1)
            ->fetch();

        $subcategories = $database->sub_category()
            ->select("*")
            ->where("category_id = ?", $categoryId)
            ->where("status = ?", 1)
            ->order("name asc");

        $html =  "<option value='0'>انتخاب همه زیر گروهها</option>";
        if ($subcategories) {
            foreach ($subcategories as $subcategory) {
                $html .= "<option value=\"{$subcategory["id"]}\">{$subcategory["name"]}</option>";
            }
        }

        $category_name =  $category["name"];
        $category_url = $category["url_name"];
        $subject_name = $subject["name"];
        $subject_url = $subject["url_name"];



        $login_msg =  "عملیات با موفقیت انجام شد";
        echo json_encode(
            array(
                "message" => $login_msg,
                "html" => $html,
                "status" => "1",
            )
        );
    } else {
        $login_msg =  "داد ها نا معتبر می باشند";
        echo json_encode(
            array(
                "message" => $login_msg,
                "redirect" => "",
                "status" => "-1",
            )
        );
    }
}

//Redirect page to selected filters
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["FILTER_DATA_CODE"]) {
    try {
        
        if(isset($_POST['categoryId'])){
            $categoryId = mysql_escape_mimic($_POST['categoryId']);
        }

        if(isset($_POST["subCategoryId"])){
            $subCategoryId = mysql_escape_mimic($_POST['subCategoryId']);
        }

        if (isset($_POST['searchQuery'])) {
            $searchQuery = mysql_escape_mimic($_POST['searchQuery']);
        }

        $homeSubjectBaseURL = mysql_escape_mimic($_POST['homeSubjectBaseURL']);

        $redirect = $homeSubjectBaseURL;

        if (isset($subCategoryId) && $subCategoryId != "undefined" && $subCategoryId != "" && $subCategoryId != "0") {

            $subCategory = $database->sub_category()
                ->select("*")
                ->where("id = ?", $subCategoryId)
                ->where("status = ?", 1)
                ->fetch();

            $main_cat_id = $subCategory["category_id"];
            $main_subj_id = $subCategory["subject_id"];
            $subj_id_length = strlen($main_subj_id);
            $cat_id_length = strlen($main_cat_id);

            $subcategory_url = $HOST_NAME;
            $subcategory_url .= "subcategory/{$subj_id_length}{$main_subj_id}{$cat_id_length}{$main_cat_id}";
            $subcategory_url .= strlen($subCategory["id"]) . $subCategory["id"] . "/" . $subCategory["url_name"];
            $redirect = $subcategory_url;
        } else if (isset($categoryId) && $categoryId != "" && $categoryId != "0") {
            $category = $database->category()
                ->select("*")
                ->where("id = ?", $categoryId)
                ->where("status = ?", 1)
                ->fetch();

            $main_cat_id = $category["id"];
            $main_subj_id = $category["subject_id"];
            $subj_id_length = strlen($main_subj_id);
            $cat_id_length = strlen($main_cat_id);

            $redirect =  $HOST_NAME . "category/{$subj_id_length}{$main_subj_id}{$cat_id_length}{$main_cat_id}/{$category['url_name']}";
        }

        if (isset($searchQuery) && $searchQuery != "") {
            $redirect = $redirect . "/p1/" . $searchQuery;
        }

        $msg = "";
        $status = "1";

        echo json_encode(
            array(
                "message" => $msg,
                "redirect" => $redirect,
                "status" => $status,
            )
        );
    } catch (Exception $ex) {
        echo json_encode(
            array(

                "result" => "0",
                "redirect" => "",
                "message" => $ex->getMessage(),
                "status" => "0",
            )
        );
    }
}
