<?php
class Action
{
	private $db;

	public function __construct()
	{
		include '../connection.php';

		$this->db = $connection;
	}
	function __destruct()
	{
		$this->db->close();
	}
	function save_course()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'fid', 'type', 'amount')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM courses where course ='$course' and level ='$level' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO courses set $data");
			if ($save) {
				$id = $this->db->insert_id;
				foreach ($fid as $k => $v) {
					$data = " course_id = '$id' ";
					$data .= ", description = '{$type[$k]}' ";
					$data .= ", amount = '{$amount[$k]}' ";
					$save2[] = $this->db->query("INSERT INTO fee_structure set $data");
				}
				if (isset($save2))
					return 1;
			}
		} else {
			$save = $this->db->query("UPDATE courses set $data where id = $id");
			if ($save) {
				$this->db->query("DELETE FROM fee_structure where course_id = $id and id not in (" . implode(',', $fid) . ") ");
				foreach ($fid as $k => $v) {
					$data = " course_id = '$id' ";
					$data .= ", description = '{$type[$k]}' ";
					$data .= ", amount = '{$amount[$k]}' ";
					if (empty($v)) {
						$save2[] = $this->db->query("INSERT INTO fee_structure set $data");
					} else {
						$save2[] = $this->db->query("UPDATE fee_structure set $data where id = $v");
					}
				}
				if (isset($save2))
					return 1;
			}
		}

	}



	function save_subject()
	{

		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('sub_id', 'sub_code', 'sub_name', 's_stream','sem')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}

		$sub_id += 1;

		
		$save = $this->db->query("INSERT INTO subject_record (subject_id,subject_code,subject_name,subject_stream,subject_sem) VALUES ('$sub_id', '$sub_code', '$sub_name', '$s_stream', '$sem')");
	// 	$query = "INSERT INTO subject_record (subject_id,subject_code,subject_name,subject_stream,subject_sem) VALUES ('$sub_id', '$sub_code', '$sub_name', '$s_stream', '$sem')";
    // $result = $this->db->query($query);

    if($save){
        return 1;
    }
    else{
        return 2;
    }

	}


}

?>