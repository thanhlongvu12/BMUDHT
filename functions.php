<?php
function commentTree($post_id, $parentid = 0, $spacing = '', $user_tree_array = '')
{
  global $db;
  if (!is_array($user_tree_array)) {
    $user_tree_array = array();
    $sql = "SELECT comments.cm_message,comments.cm_id,comments.parentid,comments.created,comments.uname
                FROM comments WHERE comments.postid=:post_id AND comments.parentid =:parentid AND comments.status=:status ORDER by comments.cm_id DESC";
    $stmt = $db->prepare($sql);
    $status = 1;
    $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
    $stmt->bindParam(":parentid", $parentid, PDO::PARAM_INT);
    $stmt->bindParam(":status", $status);
    $stmt->execute();
    //$rows = $stmt->fetchAll();
    $count = $stmt->rowCount();

    if ($count > 0) {
      while ($row = $stmt->fetchObject()) {
        $user_tree_array[] = array("cm_id" => $row->cm_id, "parentid" => $row->parentid, "username" => $spacing . $row->uname, "created" => $row->created, "cm_message" => $spacing . $row->cm_message);
        $user_tree_array = commentTree($post_id, $row->cm_id, $spacing, $user_tree_array);
      }
    }
  }
  return $user_tree_array;
}

function easy($date)
{
  if ($date > 0) {
    return date('d M Y', strtotime($date));
  } else {
    return '';
  }
}
function userfind($parentid, $db)
{
  $sql = "SELECT cm_message,cm_id,created,parentid,uname FROM comments WHERE cm_id=:cm_id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(":cm_id", $parentid, PDO::PARAM_STR);
  $stmt->execute();
  $rowcup = $stmt->fetch();
  $uname = $rowcup['uname'];
  if ($uname != '') {
    return $uname;
  } else {
    return 'Anonymous';
  }
}
function count_comment($post_id, $db)
{
  $sql = "SELECT count(*) FROM comments WHERE postid=:postid AND status!=0";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':postid', $post_id, PDO::PARAM_INT);
  $stmt->execute();
  $number_of_rows = $stmt->fetchColumn();
  return $number_of_rows;
}
function name($val)
{
  if ($val < 2) {
    return 'Comment';
  } else {
    return 'Comments';
  }
}
