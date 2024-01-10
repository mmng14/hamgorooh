<?php
//routing of url parameters

//region Admin
if ($params[0] == "admin") {

    if (isset($params[1])) {
        $page_name = $params[1];
        if ($page_name == "index") {
            ob_start();
            include_once 'app/admin/controllers/IndexController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "new") {
            ob_start();
            include_once 'app/admin/controllers/NewController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "about") {
            ob_start();
            include_once 'app/admin/controllers/AboutController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "ads") {
            ob_start();
            include_once 'app/admin/controllers/AdsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "ads_request") {
            $url_user_id = 0;
            ob_start();
            include_once 'app/admin/controllers/AdsRequestController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
        if ($page_name == "reportage_request") {
            $url_user_id = 0;
            ob_start();
            include_once 'app/admin/controllers/ReportageRequestController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
        if ($page_name == "slider") {
            ob_start();
            include_once 'app/admin/controllers/SliderController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "gallery") {
            ob_start();
            include_once 'app/admin/controllers/GalleryController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }

        if ($page_name == "ads_subjects") {
            $url_ads_id = 0;
            if (isset($params[2])) {
                $url_ads_id = $params[2];
            }
            ob_start();
            include_once 'app/admin/controllers/AdsSubjectsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "reportage") {
            ob_start();
            include_once 'app/admin/controllers/ReportageController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "reportage_subjects") {
            $url_reportage_id = 0;
            if (isset($params[2])) {
                $url_reportage_id = $params[2];
            }
            ob_start();
            include_once 'app/admin/controllers/ReportageSubjectsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "users") {
            ob_start();
            include_once 'app/admin/controllers/UsersController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "user_admin") {
            ob_start();
            include_once 'app/admin/controllers/UserAdminController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "user_subjects") {
            $url_user_id = 0;
            if (isset($params[2])) {
                $url_user_id = $params[2];
            }
            ob_start();
            include_once 'app/admin/controllers/UserSubjectsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }

        if ($page_name == "user_groups") {
            $url_user_id = 0;
            if (isset($params[2])) {
                $url_user_id = $params[2];
            }
            ob_start();
            include_once 'app/admin/controllers/UserGroupsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "user_chat") {
            $url_user_id = 0;
            if (isset($params[2])) {
                $url_user_id = $params[2];
            }
            ob_start();
            include_once 'app/admin/controllers/UserChatsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "user_info") {
            $url_user_id = 0;
            if (isset($params[2])) {
                $url_user_id = $params[2];
            }
            ob_start();
            include_once 'app/admin/controllers/UserInfoController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }

        if ($page_name == "managers") {
            ob_start();
            include_once 'app/admin/controllers/ManagersController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }

        if ($page_name == "teammates") {
            $url_user_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            ob_start();
            include_once 'app/admin/controllers/TeammatesController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "messages") {
            ob_start();
            include_once 'app/admin/controllers/MessagesController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "subjects") {
            ob_start();
            include_once 'app/admin/controllers/SubjectsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "subject_category") {
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            ob_start();
            include_once 'app/admin/controllers/SubjectCategoryController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        
        if ($page_name == "sub_category") {
            $url_category_id = 0;
            if (isset($params[2])) {
                $url_category_id = $params[2];
            }
            ob_start();
            include_once 'app/admin/controllers/SubCategoryController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "subject_resources") {
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            ob_start();
            include_once 'app/admin/controllers/SubjectResourcesController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "post_management") {
            ob_start();
            include_once 'app/admin/controllers/PostManagementController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "comment_management") {
            ob_start();
            include_once 'app/admin/controllers/CommentManagementController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "comments") {
            $url_subject_id = 0;
            $url_category_id = 0;
            $url_post_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_category_id = $params[3];
            }
            if (isset($params[4])) {
                $url_post_id = $params[4];
            }
            ob_start();
            include_once 'app/admin/controllers/CommentsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "request_management") {
            ob_start();
            include_once 'app/admin/controllers/RequestManagementController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }
        if ($page_name == "robot_management") {
            ob_start();
            include_once 'app/admin/controllers/RobotManagementController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }

        if ($page_name == "crawler-sources") {
            ob_start();
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_page_number = $params[3];
            }
            include_once 'app/admin/controllers/CrawlerSourcesController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }

        if ($page_name == "crawler-items") {
            ob_start();
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_source_id = $params[3];
            }
            if (isset($params[4])) {
                $url_page_number = $params[4];
            }
            include_once 'app/admin/controllers/CrawlerItemsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }

        if ($page_name == "posts") {
            $url_cat_id = 0;
            if (isset($params[2])) {
                $url_cat_id = $params[2];
            }
            if (isset($params[3])) {
                $url_page_number = $params[3];
            }
            ob_start();
            include_once 'app/admin/controllers/PostController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "post_add") {
            $url_cat_id = 0;
            if (isset($params[2])) {
                $url_cat_id = $params[2];
            }
            if (isset($params[3])) {
                $url_post_id = $params[3];
            }
            if (isset($params[4])) {
                $url_page_number = $params[4];
            }
            ob_start();
            include_once 'app/admin/controllers/PostAddController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "post-attachments") {
            ob_start();

            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_category_id = $params[3];
            }
            if (isset($params[4])) {
                $url_post_id = $params[4];
            }
            include_once 'app/admin/controllers/PostAttachmentsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "statistics") {
            ob_start();
            include_once 'app/admin/controllers/StatisticsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "monthly_visit") {
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            ob_start();
            include_once 'app/admin/controllers/MonthlyVisitsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "contact_info") {
            ob_start();
            include_once 'app/admin/controllers/ContactInfoController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "authors") {
            ob_start();
            include_once 'app/admin/controllers/AuthorsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo sanitize_output($adminContent);
            exit;
        }
        if ($page_name == "resources") {
            ob_start();
            include_once 'app/admin/controllers/ResourcesController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "resources-attachments") {
            ob_start();

            if (isset($params[2])) {
                $url_resource_id = $params[2];
            }
            include_once 'app/admin/controllers/ResourcesAttachmentsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "test") {
            ob_start();
            include_once 'app/admin/controllers/TestController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
    }
}
//endregion Admin

//region GroupAdmin
if ($params[0] == "group_admin") {
    if (isset($params[1])) {
        $page_name = $params[1];
        if ($page_name == "index") {
            ob_start();
            include_once 'app/group_admin/controllers/IndexController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }
        if ($page_name == "post_management") {
            ob_start();
            include_once 'app/group_admin/controllers/PostManagementController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }
        if ($page_name == "request_management") {
            ob_start();
            include_once 'app/group_admin/controllers/RequestManagementController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }
        if ($page_name == "comment_management") {
            ob_start();
            include_once 'app/group_admin/controllers/CommentManagementController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "comments") {
            $url_subject_id = 0;
            $url_category_id = 0;
            $url_post_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_category_id = $params[3];
            }
            if (isset($params[4])) {
                $url_post_id = $params[4];
            }
            ob_start();
            include_once 'app/group_admin/controllers/CommentsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "user_comments") {
            ob_start();
            include_once 'app/group_admin/controllers/UserCommentsController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }
        if ($page_name == "user_posts") {
            ob_start();
            include_once 'app/group_admin/controllers/UserPostsController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }
        if ($page_name == "show_post") {
            if (isset($params[2]) && isset($params[3]) && is_numeric($params[2])) {
                $post_code = $params[2];

                ob_start();
                include_once 'app/group_admin/controllers/ShowPostController.php';
                $postContent = ob_get_contents();
                ob_end_clean();
                echo minifyHtml($postContent);
            }
            exit;
        }


        if ($page_name == "posts") {
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_page_number = $params[3];
            }
            ob_start();
            include_once 'app/group_admin/controllers/PostController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }

        if ($page_name == "post_add") {
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_post_id = $params[3];
            }
            if (isset($params[4])) {
                $url_page_number = $params[4];
            }
            ob_start();
            include_once 'app/group_admin/controllers/PostAddController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }

        if ($page_name == "post-attachments") {
            ob_start();

            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_category_id = $params[3];
            }
            if (isset($params[4])) {
                $url_post_id = $params[4];
            }
            include_once 'app/group_admin/controllers/PostAttachmentsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }
        if ($page_name == "user_management") {
            $url_cat_id = 0;
            if (isset($params[2])) {
                $url_cat_id = $params[2];
            }

            ob_start();
            include_once 'app/group_admin/controllers/UserManagementController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }

        // if ($page_name == "resources") {
        //     ob_start();
        //     $url_subject_id = 0;
        //     if (isset($params[2])) {
        //         $url_subject_id = $params[2];
        //     }
        //     if (isset($params[3])) {
        //         $url_page_number = $params[3];
        //     }
        //     include_once 'app/group_admin/controllers/ResourcesController.php';
        //     $adminContent = ob_get_contents();
        //     ob_end_clean();
        //     echo $adminContent;
        //     exit;
        // }

        // if ($page_name == "resources-attachments") {
        //     ob_start();

        //     if (isset($params[2])) {
        //         $url_resource_id = $params[2];
        //     }
        //     include_once 'app/group_admin/controllers/ResourcesAttachmentsController.php';
        //     $adminContent = ob_get_contents();
        //     ob_end_clean();
        //     echo $adminContent;
        //     exit;
        // }

        if ($page_name == "subject_resources") {
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            ob_start();
            include_once 'app/group_admin/controllers/SubjectResourcesController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }


        if ($page_name == "crawler-sources") {
            ob_start();
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_page_number = $params[3];
            }
            include_once 'app/group_admin/controllers/CrawlerSourcesController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }

        if ($page_name == "crawler-items") {
            ob_start();
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_source_id = $params[3];
            }
            if (isset($params[4])) {
                $url_page_number = $params[4];
            }
            include_once 'app/group_admin/controllers/CrawlerItemsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }

        if ($page_name == "reportage") {
            ob_start();
            include_once 'app/group_admin/controllers/ReportageController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }

        if ($page_name == "reportage_subjects") {
            $url_reportage_id = 0;
            if (isset($params[2])) {
                $url_reportage_id = $params[2];
            }
            ob_start();
            include_once 'app/group_admin/controllers/ReportageSubjectsController.php';
            $adminContent = ob_get_contents();
            ob_end_clean();
            echo $adminContent;
            exit;
        }

        if ($page_name == "subjects") {
            ob_start();
            include_once 'app/group_admin/controllers/SubjectsController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo  $content;
            exit;
        }

        if ($page_name == "statistics") {
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            ob_start();
            include_once 'app/group_admin/controllers/StatisticsController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo  $content;
            exit;
        }
    }
}
//endregion GroupAdmin

//region Users
if ($params[0] == "users") {
    if (isset($params[1])) {
        $page_name = $params[1];

        if ($page_name == "index") {
            ob_start();
            include_once 'app/users/controllers/IndexController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
        if ($page_name == "signout") {
            ob_start();
            include_once 'app/users/controllers/SignOutController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
        if ($page_name == "teammates") {
            $url_user_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            ob_start();
            include_once 'app/users/controllers/TeammatesController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
        if ($page_name == "profile") {
            ob_start();
            include_once 'app/users/controllers/ProfileController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }

        if ($page_name == "ads_request") {
            $url_user_id = 0;
            ob_start();
            include_once 'app/users/controllers/AdsRequestController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
        if ($page_name == "reportage_request") {
            $url_user_id = 0;
            ob_start();
            include_once 'app/users/controllers/ReportageRequestController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
        if ($page_name == "payment") {
            if (isset($params[2])) {
                $url_payment_type = $params[2];
            }
            if (isset($params[3])) {
                $url_request_id = $params[3];
            }

            ob_start();
            include_once 'app/users/controllers/PaymentController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
        if ($page_name == "groups") {
            $url_user_id = 0;
            ob_start();
            include_once 'app/users/controllers/GroupsController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
        if ($page_name == "user_groups") {
            $url_user_id = 0;
            ob_start();
            include_once 'app/users/controllers/UserGroupsController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
        if ($page_name == "post_management") {
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            ob_start();
            include_once 'app/users/controllers/PostManagementController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
        // if ($page_name == "posts") {
        //     $url_cat_id = 0;
        //     if (isset($params[2])) {
        //         $url_cat_id = $params[2];
        //     }
        //     if (isset($params[3])) {
        //         $url_page_number = $params[3];
        //     }
        //     ob_start();
        //     include_once 'app/users/controllers/PostController.php';
        //     $content = ob_get_contents();
        //     ob_end_clean();
        //     echo $content;
        //     exit;
        // }

        // if ($page_name == "post_add") {
        //     $url_cat_id = 0;
        //     if (isset($params[2])) {
        //         $url_cat_id = $params[2];
        //     }
        //     if (isset($params[3])) {
        //         $url_post_id = $params[3];
        //     }
        //     if (isset($params[4])) {
        //         $url_page_number = $params[4];
        //     }
        //     ob_start();
        //     include_once 'app/users/controllers/PostAddController.php';
        //     $content = ob_get_contents();
        //     ob_end_clean();
        //     echo $content;
        //     exit;
        // }

        if ($page_name == "posts") {
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_page_number = $params[3];
            }
            ob_start();
            include_once 'app/users/controllers/PostController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }

        if ($page_name == "post_add") {
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_post_id = $params[3];
            }
            if (isset($params[4])) {
                $url_page_number = $params[4];
            }
            ob_start();
            include_once 'app/users/controllers/PostAddController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }

        if ($page_name == "group_messages") {
            $url_subject_id = 0;
            if (isset($params[2])) {
                $url_subject_id = $params[2];
            }
            if (isset($params[3])) {
                $url_page_number = $params[3];
            }
            ob_start();
            include_once 'app/users/controllers/GroupMessagesController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }

        if ($page_name == "user_messages") {
            if (isset($params[2])) {
                $url_page_number = $params[3];
            }
            ob_start();
            include_once 'app/users/controllers/UserMessagesController.php';
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            exit;
        }


        if ($page_name == "notifications") {
            if (isset($params[2])) {
                $url_page_number = $params[3];
            }
            ob_start();
            include_once 'app/users/controllers/NotificationsController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }


        if ($page_name == "404") {
            $url_wrong_name = "";
            if (isset($params[2])) {
                $url_wrong_name = $params[2];
            }
            ob_start();
            include_once 'app/users/controllers/Error404Controller.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }

        //region wrong_url
        $url_wrong_name = "";
        if (isset($params[2])) {
            $url_wrong_name = $params[2];
        }
        ob_start();
        include_once 'app/users/controllers/Error404Controller.php';
        $pageContent = ob_get_contents();
        ob_end_clean();
        echo $pageContent;
        exit;
        //endregion wrong_url

    }
}
//endregion Users

//region shared
if ($params[0] == "shared") {

    if (isset($params[1])) {
        $page_name = $params[1];

        if ($page_name == "opcode") {
            ob_start();
            include_once 'app/shared/controllers/OpcodeController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
    }
    if (isset($params[1])) {
        $page_name = $params[1];
        if ($page_name == "groups") {
            ob_start();
            include_once 'app/shared/controllers/GroupsController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
    }
    if (isset($params[1])) {
        $page_name = $params[1];

        if ($page_name == "visit") {
            ob_start();
            include_once 'app/shared/controllers/VisitController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
    }

    if (isset($params[1])) {
        $page_name = $params[1];

        if ($page_name == "rate") {
            ob_start();
            include_once 'app/shared/controllers/RateController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
    }

    if (isset($params[1])) {
        $page_name = $params[1];

        if ($page_name == "comment") {
            ob_start();
            include_once 'app/shared/controllers/CommentController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
    }

    if (isset($params[1])) {
        $page_name = $params[1];

        if ($page_name == "notifications") {
            ob_start();
            include_once 'app/shared/controllers/NotificationsController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
    }
}

//endregion

//region Home
if ($params[0] == "post") {
    if (isset($params[1]) && isset($params[2]) && is_numeric($params[1])) {
        $post_code = $params[1];

        ob_start();
        include_once 'app/home/controllers/PostController.php';
        $postContent = ob_get_contents();
        ob_end_clean();
        echo minifyHtml($postContent);
    }
    exit;
}

if ($params[0] == "news") {
    if (isset($params[1]) && isset($params[2]) && is_numeric($params[1])) {
        $news_code = $params[1];
        ob_start();
        include_once 'app/home/controllers/NewsController.php';
        $newsContent = ob_get_contents();
        ob_end_clean();
        echo minifyHtml($newsContent);
    }
    exit;
}

if ($params[0] == "iframe") {
    if (isset($params[1]) && isset($params[2]) && is_numeric($params[1])) {
        $post_code = $params[1];

        ob_start();
        include_once 'app/home/controllers/IFrameController.php';
        $postContent = ob_get_contents();
        ob_end_clean();
        echo minifyHtml($postContent);
    }
    exit;
}


if ($params[0] == "subjects") {

    if (isset($params[1])) {
        $subject_page = $params[1];
    }

    ob_start();
    include_once 'app/home/controllers/SubjectsController.php';
    $pageContent = ob_get_contents();
    ob_end_clean();
    echo minifyHtml($pageContent);
    exit;
}

if ($params[0] == "subject") {
    if (isset($params[1]) && isset($params[2]) && is_numeric($params[1])) {
        $subject_code = $params[1];
        if (isset($params[3])) {
            $subject_page = $params[3];
        }
        if (isset($params[4])) {
            $searchQuery = $params[4];
        }
        ob_start();
        include_once 'app/home/controllers/SubjectController.php';
        $pageContent = ob_get_contents();
        ob_end_clean();
        echo minifyHtml($pageContent);
        exit;
    }
    exit;
}

if ($params[0] == "resources") {
    if (isset($params[1]) && isset($params[2]) && is_numeric($params[1])) {
        $subject_code = $params[1];

        if (isset($params[3])) {
            $resource_page = $params[3];
        }

        if (isset($params[4])) {
            $searchQuery = $params[4];
        }

        ob_start();
        include_once 'app/home/controllers/ResourcesController.php';
        $pageContent = ob_get_contents();
        ob_end_clean();
        echo minifyHtml($pageContent);
        exit;
    }
    exit;
}

if ($params[0] == "resource") {
    if (isset($params[1]) && isset($params[2]) && is_numeric($params[1])) {
        $resource_code = $params[1];
        ob_start();
        include_once 'app/home/controllers/ResourceController.php';
        $pageContent = ob_get_contents();
        ob_end_clean();
        echo minifyHtml($pageContent);
        exit;
    }
    exit;
}

if ($params[0] == "category") {
    if (isset($params[1]) && isset($params[2]) && is_numeric($params[1])) {
        $category_code = $params[1];
        if (isset($params[3])) {
            $category_page = $params[3];
        }
        if (isset($params[4])) {
            $searchQuery = $params[4];
        }
        ob_start();
        include_once 'app/home/controllers/CategoryController.php';
        $pageContent = ob_get_contents();
        ob_end_clean();
        echo minifyHtml($pageContent);
        exit;
    }
}

if ($params[0] == "subcategory") {
    $subcategory_code = $params[1];
    if (isset($params[3])) {
        $subcategory_page = $params[3];
    }
    if (isset($params[4])) {
        $searchQuery = $params[4];
    }
    ob_start();
    include_once 'app/home/controllers/SubCategoryController.php';
    $pageContent = ob_get_contents();
    ob_end_clean();
    echo minifyHtml($pageContent);
    exit;
}

if ($params[0] == "contact") {

    ob_start();
    include_once 'app/home/controllers/ContactController.php';
    $pageContent = ob_get_contents();
    ob_end_clean();
    echo minifyHtml($pageContent);
    exit;
}

if ($params[0] == "about") {

    ob_start();
    include_once 'app/home/controllers/AboutController.php';
    $pageContent = ob_get_contents();
    ob_end_clean();
    echo minifyHtml($pageContent);
    exit;
}

if ($params[0] == "help") {

    ob_start();
    include_once 'app/home/controllers/HelpController.php';
    $pageContent = ob_get_contents();
    ob_end_clean();
    echo minifyHtml($pageContent);
    exit;
}

if ($params[0] == "signin") {

    ob_start();
    include_once 'app/home/controllers/SignInController.php';
    $pageContent = ob_get_contents();
    ob_end_clean();
    echo minifyHtml($pageContent);
    exit;
}

if ($params[0] == "signup") {
    include_once 'app/home/controllers/SignUpController.php';
    exit;
}

if ($params[0] == "recoverPassword") {
    include_once 'app/home/controllers/RecoverPasswordController.php';
    exit;
}

if ($params[0] == "ads") {

    ob_start();
    include_once 'app/home/controllers/AdsController.php';
    $pageContent = ob_get_contents();
    ob_end_clean();
    echo minifyHtml($pageContent);
    exit;
}

if ($params[0] == "help") {

    ob_start();
    include_once 'app/home/controllers/HelpController.php';
    $pageContent = ob_get_contents();
    ob_end_clean();
    echo minifyHtml($pageContent);
    exit;
}

if ($params[0] == "terms") {
    include_once 'app/home/controllers/TermsController.php';
    exit;
}

if ($params[0] == "gallery") {

    ob_start();
    include_once 'app/home/controllers/GalleryController.php';
    $pageContent = ob_get_contents();
    ob_end_clean();
    echo minifyHtml($pageContent);
    exit;
}

if ($params[0] == "user_activate") {
    $url_user_name = $params[1];
    if (isset($params[2])) {
        $url_verify_code = $params[2];
    }

    ob_start();
    include_once 'app/home/controllers/UserActivateController.php';
    $pageContent = ob_get_contents();
    ob_end_clean();
    echo minifyHtml($pageContent);
    exit;
}

if ($params[0] == "home") {

    ob_start();
    include_once 'app/home/controllers/HomeController.php';
    $pageContent = ob_get_contents();
    ob_end_clean();
    echo minifyHtml($pageContent);
    exit;
}
//endregion Home

//region SiteMap
if ($params[0] == "sitemap") {
    $subject_code = $params[1];
    $category_code = $params[2];
    $subcategory_code = 0;
    if (isset($params[3])) {
        $subcategory_code = $params[3];
    }
    //Return Sitemap XML Format
    include_once 'app/home/controllers/SitemapController.php';
    exit;
}

if ($params[0] == "rss") {
    $subject_code = $params[1];
    $category_code = $params[2];
    $subcategory_code = 0;
    if (isset($params[3])) {
        $subcategory_code = $params[3];
    }
    //Return RSS Format
    //Return Sitemap XML Format
    include_once 'app/home/controllers/RssController.php';
    exit;
}
//endregion SiteMap

//region services
if ($params[0] == "api") {

    if (isset($params[1])) {
        $page_name = $params[1];

        if ($page_name == "post") {
            ob_start();
            include_once 'api/PostApiController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }

        if ($page_name == "auth") {
            ob_start();
            include_once 'api/AuthApiController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }

        if ($page_name == "subjects") {
            ob_start();
            include_once 'api/SubjectsApiController.php';
            $pageContent = ob_get_contents();
            ob_end_clean();
            echo $pageContent;
            exit;
        }
    }
}
//endregion services
