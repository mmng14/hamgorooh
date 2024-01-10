<?php


if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["check"]) && $_POST["check"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {

    try {
        page_access_check_ajax(array(1, 2, 3, 4, 5), $HOST_NAME);
        //csrf_validation_ajax($_POST["_csrf"]);
        //--------------------------- page -----------------------------
        //Get page number from Ajax POST
        if (isset($_POST["page"])) {
            $page_number = filter_var(mysql_escape_mimic($_POST["page"]), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
            if (!is_numeric($page_number)) {
                die('Invalid page number!');
            } //incase of invalid page number
        } else {
            $page_number = 1; //if there's no page number, set it to 1
        }
        //------------------------------------------------------------
        //-------------------------- perpage -------------------------
        if (isset($_POST['perpage'])) {
            $item_per_page = mysql_escape_mimic($_POST['perpage']);
        } else
            $item_per_page = 10;
        //---------------------------------------------------------------
        //-------------------------- order -------------------------------
        if (isset($_POST['order'])) {
            $orderBy = mysql_escape_mimic($_POST['order']);
            if ($orderBy == 1) $order = 'id DESC';
            else if ($orderBy == 2) $order = 'id ASC';
        } else {
            $orderBy = 2;
            $order = 'id DESC';
        }
        //-----------------------------------------------------------------
        $count = $database->subject()
            ->select(" count(id) as c")
            ->fetch();

        //------------
        $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
        //break records into pages

        $total_pages = ceil($get_total_rows / $item_per_page);

        if ($total_pages < $page_number)
            $page_number = 1;

        //get starting position to fetch the records
        $page_position = (($page_number - 1) * $item_per_page);


        $rows = $database->subject()
            ->select("*")
            ->order($order)
            ->limit($item_per_page, $page_position);

        $viewModel = null;

        if (isset($rows)) {

            foreach ($rows as $row) {


                $subject_site_link = "https://www.hamgorooh.com/";


                // image: "img/avatar54-sm.jpg",
                // name: "Marie Davidson",
                // message: "4 Friends in Common",
                // icon: "olymp-happy-face-icon",

                $viewModel[] = [
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "message" =>  $row['description'],
                    "link" => $subject_site_link,
                    "image" => $subject_site_link . $row['photo'],
                    "icon" => "olymp-badge-icon"
                ];
            }
        }


        $pagination = array(
            "item_per_page" => $item_per_page,
            "page_number" => $page_number,
            "total_rows" => $get_total_rows,
            "total_pages" => $total_pages,
        );


        $data = array();
        $data['list'] = $viewModel;
        $data['pagination'] = $pagination;
        echo json_encode($data);

        exit;
    } catch (Exception $e) {
        echo json_encode($e);
    }
}
