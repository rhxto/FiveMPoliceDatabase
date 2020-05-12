<?php session_start();
  require_once 'funs.php';

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    if (empty($data)) {
      die(json_encode(["status"=>"failure", "reason"=>"Nessun dato inviato."]));
    }

    return $data;
  }

  function loginCheck() {
    if (isset($_SESSION["user_uuid"]) && $_SESSION["user_uuid"] != "-1") {
      return true;
    } else {
      error_log("API contattata senza permesso. User UUID: " . $_SESSION["user_uuid"] . " IP: " . $_SERVER["REMOTE_ADDR"]);
      return false;
    }
  }



  if ($_SERVER["REQUEST_METHOD"] == "POST" && loginCheck()) {
    $citizen_id = test_input($_POST["id"]);
    $wanted = test_input($_POST["wanted"]);

    echo json_encode(setCitizenStatus($citizen_id, ($wanted === "true" ? 2 : 1)));
  } else {
    echo json_encode(["status"=>"failure", "reason"=>"Richiesta invalida."]);
  }
 ?>
