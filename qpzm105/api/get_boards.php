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

if($_GET['id'] <> ""){
    $query_board = sprintf("SELECT * FROM iwinestand_board WHERE id = %s", GetSQLValueString($_GET['id'], "int")); 

}else{
    $query_board = "SELECT * FROM iwinestand_board "; 

}
$boards = mysql_query($query_board, $iwine) or die(mysql_errno());
$total_boards = mysql_num_rows($boards);
$data['total_boards'] = $total_boards;


if($total_boards == 0){
    $code = 151;
    if ($_GET['id']<>""){
        $status = sprintf("board id = %s not exist.", $_GET['id']);
    }else{
        $status = "no boards in database";
    }

}else{
    while($each_board=mysql_fetch_assoc($boards)){
        //get all board joiner
        $query_joiner = sprintf("SELECT member_id FROM iwinestand_joiner where board_id = %s ORDER BY member_id", GetSQLValueString($each_board['id'], "int"));
        // $each_board['joiner_sql'] = $query_joiner;
        $joiner = mysql_query($query_joiner, $iwine) or die(mysql_error());
        $totalRows_joiner = mysql_num_rows($joiner);
        $each_board['joiner_total'] = $totalRows_joiner;

        $join_list = array();

        while($each_row = mysql_fetch_assoc($joiner)){
          array_push($join_list, $each_row['member_id']);
          
        };

        $each_board['member_list'] = $join_list;
        $data['data'][] = $each_board;
        $code = 100;
        $status = 'success';

    };
}

$data['code'] = $code;
$data['status'] = $status;
mysql_free_result($boards);
mysql_free_result($joiner);

print json_encode($data);
?>
