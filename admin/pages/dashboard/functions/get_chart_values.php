<?php 
include_once("../../../config/config.php");

// Array
$dateArray_values = [];
// end Array

// Session info
session_start();
$email = $_SESSION["email"];
$id = GetID($conn, $email);
// end Session Info


/*************************/

// Blogs Chart Values

/*************************/


/*
	Week
*/

// Week info
$now_date = date("Y-m-d");
$old_week = date('Y-m-d', strtotime("-6 day"));
// end Week info

// SQL Week count
$sql_week = "SELECT count(*) as BlogCount, Date(date) as BlogDate FROM `blogs` WHERE date BETWEEN '$old_week' and '$now_date' GROUP BY BlogDate ORDER BY BlogDate asc";
if ($query = mysqli_query($conn, $sql_week)) {
	$number = 0;
	while ($row = mysqli_fetch_array($query)) {
		$dateArray_values["blog"]["week"][0][$number] = $row["BlogCount"]; 
		$dateArray_values["blog"]["week"][1][$number] = substr($row["BlogDate"], 0, 10);
		$number++;
	}
}else{
	echo mysqli_error($conn);
}
// end SQL

/*
	end Week
*/

/*
	Month
*/

// Month info
$old_month = date("Y-m-d", strtotime("-1 month"));
$now_date = date('Y-m-d');
// end Month info

// SQL Month count
$sql_month = "SELECT count(*) as BlogCount, Date(date) as BlogDate FROM `blogs` WHERE date BETWEEN '$old_month' and '$now_date' GROUP BY BlogDate ORDER BY BlogDate asc";
if ($query = mysqli_query($conn, $sql_month)) {
	$number = 0;
	while ($row = mysqli_fetch_array($query)) {
		$dateArray_values["blog"]["month"][0][$number] = $row["BlogCount"]; 
		$dateArray_values["blog"]["month"][1][$number] = substr($row["BlogDate"], 0, 10);
		$number++;
	}
}else{
	echo mysqli_error($conn);
}
// end SQL

/*
	end Month
*/


/*
	Year
*/

// Year info
$old_date = "";
$new_year = date('Y', strtotime("+1 year"));
$now_date = date("Y");
// end Year info

// SQL Year count
$sql_year = "SELECT count(*) as BlogCount, Date(date) as BlogDate FROM `blogs` WHERE date BETWEEN '$now_date' and '$new_year' GROUP BY DATE_FORMAT(BlogDate, '%y-%m') ORDER BY BlogDate asc";
if ($query = mysqli_query($conn, $sql_year)) {
	$number = 0;
	while ($row = mysqli_fetch_array($query)) {
			$dateArray_values["blog"]["year"][0][$number] = $row["BlogCount"]; 
			$dateArray_values["blog"]["year"][1][$number] = substr($row["BlogDate"], 0, 7);
			$number++;
	}
}else{
	echo mysqli_error($conn);
}
// end SQL

/*
	end Year
*/

// Check Empty Blog
if (count($dateArray_values["blog"]["week"][0][0]) < 1) {
	$dateArray_values["blog"]["week"][1][0] = date("Y-m-d");
	$dateArray_values["blog"]["week"][0][0] = "0";
}if (count($dateArray_values["blog"]["month"][0][0]) < 1) {
	$dateArray_values["blog"]["month"][1][0] = date("Y-m-d");
	$dateArray_values["blog"]["month"][0][0] = "0";
}if (count($dateArray_values["blog"]["year"][0][0]) < 1) {
	$dateArray_values["blog"]["year"][1][0] = date("Y-m");
	$dateArray_values["blog"]["year"][0][0] = "0";
}
// end Check Empty Blog


/*************************/

// end Blog Chart Values

/*************************/


/* <------------------------------------------------- New Chart Values -------------------------------------------------> */


/*************************/

// View List Chart Values

/*************************/


/*
	Week
*/


// Week info
$now_date = date("Y-m-d");
$old_day = date('Y-m-d', strtotime("-6 day"));
// end Week info

// SQL Week count
$sql_week = "SELECT count(*) as ViewCount, Date(date) as ViewDate FROM `view_list` WHERE date BETWEEN '$old_day' and '$now_date' GROUP BY ViewDate ORDER BY ViewDate asc";
if ($query = mysqli_query($conn, $sql_week)) {
	$number = 0;
	while ($row = mysqli_fetch_array($query)) {
		$dateArray_values["view_list"]["week"][0][$number] = $row["ViewCount"]; 
		$dateArray_values["view_list"]["week"][1][$number] = substr($row["ViewDate"], 0, 10);
		$number++;
	}
}else{
	echo mysqli_error($conn);
}
// end SQL

/*
	end Week
*/

/*
	Month
*/

// Month info
$old_date = "";
$old_month = date("Y-m-d", strtotime("-1 month"));
$now_date = date('Y-m-d');
// end Month info

// SQL Month count
$sql_month = "SELECT count(*) as ViewCount, Date(date) as ViewDate FROM `view_list` WHERE date BETWEEN '$old_month' and '$now_date' GROUP BY ViewDate ORDER BY ViewDate asc";
if ($query = mysqli_query($conn, $sql_month)) {
	$number = 0;
	while ($row = mysqli_fetch_array($query)) {
		$dateArray_values["view_list"]["month"][0][$number] = $row["ViewCount"]; 
		$dateArray_values["view_list"]["month"][1][$number] = substr($row["ViewDate"], 0, 10);
		$number++;
	}
}else{
	echo mysqli_error($conn);
}
// end SQL

/*
	end Month
*/


/*
	Year
*/

// Year info
$old_date = "";
$new_year = date('Y', strtotime("+1 year"));
$now_date = date("Y");
// end Year info

// SQL Year count
$sql_year = "SELECT count(*) as ViewCount, DATE(date) as ViewDate FROM `view_list` WHERE date BETWEEN '$now_date' and '$new_year' GROUP BY DATE_FORMAT(ViewDate, '%y-%m') ORDER BY ViewDate asc";
if ($query = mysqli_query($conn, $sql_year)) {
	$number = 0;
	while ($row = mysqli_fetch_array($query)) {
			$dateArray_values["view_list"]["year"][0][$number] = $row["ViewCount"]; 
			$dateArray_values["view_list"]["year"][1][$number] = substr($row["ViewDate"], 0, 7);
			$number++;
	}
}else{
	echo mysqli_error($conn);
}
// end SQL

/*
	end Year
*/

// Check Empty View List
if (count($dateArray_values["view_list"]["week"][0][0]) < 1) {
	$dateArray_values["view_list"]["week"][1][0] = date("Y-m-d");
	$dateArray_values["view_list"]["week"][0][0] = "0";
}if (count($dateArray_values["view_list"]["month"][0][0]) < 1) {
	$dateArray_values["view_list"]["month"][1][0] = date("Y-m-d");
	$dateArray_values["view_list"]["month"][0][0] = "0";
}if (count($dateArray_values["view_list"]["year"][0][0]) < 1) {
	$dateArray_values["view_list"]["year"][1][0] = date("Y-m");
	$dateArray_values["view_list"]["year"][0][0] = "0";
}
// end Check Empty View List


/*************************/

// View List Chart Values

/*************************/

echo json_encode($dateArray_values);
?>