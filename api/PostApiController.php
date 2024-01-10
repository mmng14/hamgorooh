<?php
//require_once "includes/utility_services.php";

if (isset($_POST["security_code"]) && $_POST["security_code"] == "V3cwS0lIc05DaUFnSUNKdWRXMWlaWElpT2lJNU1ERTROVGcyTnpBd0lpd2dJQTBLSUNBZ0ltMWxjM05oWjJVaU9pSXgyTFBaaE5pbjJZVWlMQTBLSUNBZ0luTmxibVJsY2lJNklqVXdNREE1TURBeUlnMEtJSDBzRFFvZ2V3MEtJQ0FnSW01MWJXSmxjaUk2SWprd01UZzFPRFkzTURBaUxDQWdEUW9nSUNBaWJXVnpjMkZuWlNJNklqTFlzOW1FMktmWmhTSXNEUW9nSUNBaWMyVnVaR1Z5SWpvaU5UQXdNRGt3TURJaURRb2dmU3dOQ2lCN0RRb2dJQ0FpYm5WdFltVnlJam9pT1RBeE9EVTROamN3TUNJc0lDQU5DaUFnSUNKdFpYTnpZV2RsSWpvaU05aXoyWVRZcDltRklpd05DaUFnSUNKelpXNWtaWElpT2lJMU1EQXdPVEF3TWlJTkNpQjlEUXBk") {

    $post_data = $database->post()
        ->where("robot_status = ?", 0)
        ->order("id asc")
        ->fetch();

   
    //Return And Update Robot Status
    if ($post_data) {
        $dump=var_export(iteratorToArray($post_data), true);
        echo $dump;
        $edit_row = $database->post[$post_data["id"]];
        $property = array("robot_status" => 1);
        $affected = $edit_row->update($property);
    }


}