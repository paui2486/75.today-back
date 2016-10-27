<?php header('content-type: application/json; charset=utf-8');

require_once('../../Connections/iwine.php');
mysql_select_db($database_iwine, $iwine);

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
      if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
      $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
      switch ($theType) {
        case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
        case "long":
        case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
        case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
        case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
        case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
      }
      return $theValue;
    }
}
$data = array();

if ($_POST['member_id']<> "" && $_POST['board_id']<> "") {
  
    $_today = date('Y-m-d H:i:s'); 
    
    //check member
    $query_check_member = sprintf("SELECT * FROM member WHERE m_id = %s", GetSQLValueString($_POST['member_id'], "int"));
    // $data['query_check_member'] =  $query_check_member;
    $check_member = mysql_query($query_check_member, $iwine) or die(mysql_error());
    $totalRows_check_member = mysql_num_rows($check_member);
    
    //check board
    $query_check_board = sprintf("SELECT * FROM iwinestand_board WHERE id = %s", GetSQLValueString($_POST['board_id'], "int"));
    // $data['query_check_board'] =  $query_check_board;
    $check_board = mysql_query($query_check_board, $iwine) or die(mysql_error());
    $totalRows_check_board = mysql_num_rows($check_board);
    $board_row = mysql_fetch_assoc($check_board);

    //check joiner 
    $query_check_joiner = sprintf("SELECT * FROM iwinestand_joiner WHERE member_id = %s AND board_id = %s", GetSQLValueString($_POST['member_id'], "int"),GetSQLValueString($_POST['board_id'], "int"));
    // $data['query_check_joiner'] =  $query_check_joiner;
    $check_joiner = mysql_query($query_check_joiner, $iwine) or die(mysql_error());
    $totalRows_check_joiner = mysql_num_rows($check_joiner);
    $row_check_joiner = mysql_fetch_assoc($check_joiner);

    // $now_timestamp = date_timestamp_get(date_create());
    if($totalRows_check_member == 1 && $totalRows_check_board == 1 && $totalRows_check_joiner == 1){
        $del_SQL = sprintf("DELETE FROM iwinestand_joiner WHERE id = %s", $row_check_joiner['id']);
        // $data['del_SQL'] =  $del_SQL;
        mysql_select_db($database_iwine, $iwine);
        $Result1 = mysql_query($del_SQL, $iwine) or die(mysql_error());
        
        //get all board joiner
        $query_joiner = sprintf("SELECT joiner.member_id FROM iwinestand_board as board join iwinestand_joiner as joiner on board.id = joiner.board_id where board.id = %s ORDER BY joiner.member_id", GetSQLValueString($_POST['board_id'], "int"));
        $joiner = mysql_query($query_joiner, $iwine) or die(mysql_error());
        $totalRows_joiner = mysql_num_rows($oiner);

        $join_list = array();
        while($eacg_row = mysql_fetch_assoc($joiner)){
          array_push($join_list, $eacg_row['member_id']);
        };

        $board_row['member_list'] = $join_list;
        $data['data'] = $board_row;

        $code = 100;
        $status = "success";

    }else if($totalRows_check_joiner > 0){
        $code = 199;
        $status = sprintf("member:%s has joined board: %s", $_POST['member_id'], $_POST['board_id']);
    }else{
        $code = 199;
        if($totalRows_check_member == 0 && $totalRows_check_board ==0){
            $status = sprintf("member id = %s  and board id = %s not exist.",$_POST['member_id'], $_POST['board_id']);
        }else if($totalRows_check_member == 0){
            $status = sprintf("member id = %s not exist.",$_POST['member_id']);
        }else if($totalRows_check_board == 0){
            $code = 151;
            $status = sprintf("board id = %s not exist.", $_POST['board_id']);
        }else{
            $status = sprintf("member id = %s is not in board members", $_POST['member_id']);
        }
        
    }
}else{
    $code = 199;
    if($_POST['board_id'] == ""){
        $status = "no post board data";
    }else if($_POST['member_id'] == ""){
        $status = "no post member data";
    }else{
        $status = "no post member and board data";
    }
    
}

$data['code'] = $code;
$data['status'] = $status;
mysql_free_result($check_member);
mysql_free_result($check_board);
mysql_free_result($check_joiner);
mysql_free_result($Result1);
mysql_free_result($joiner);

print json_encode($data);
?>
