<?php
include("php/dbconnect.php");
include("php/checklogin.php");


if ($_GET['type'] == "feesearch") {
	$aColumns = array('s.id', 's.sname', 's.balance', 's.fees', 'b.grade', 's.contact', 's.joindate');

	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.id";

	/* DB table to use */
	$sTable = " student as s,grade as b ";



	/* 
	 * Paging
	 */
	$sLimit = "";
	if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
		$sLimit = "LIMIT " . mysqli_real_escape_string($conn, $_GET['iDisplayStart']) . ", " .
			mysqli_real_escape_string($conn, $_GET['iDisplayLength']);
	}


	/*
	 * Ordering
	 */
	$sOrder = "";
	if (isset($_GET['iSortCol_0'])) {
		$sOrder = "ORDER BY  ";
		for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
			if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
				$sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
				 	" . mysqli_real_escape_string($conn, $_GET['sSortDir_' . $i]) . ", ";
			}
		}

		$sOrder = substr_replace($sOrder, "", -2);
		if ($sOrder == "ORDER BY") {
			$sOrder = "";
		}
	}

	$cond = "";
	$condArr = array();
	if (isset($_GET['student']) && $_GET['student'] != "") {
		$condArr[] = "s.sname like '%" . mysqli_real_escape_string($conn, $_GET['student']) . "%'";
	}

	if (isset($_GET['grade']) && $_GET['grade'] != "") {
		$condArr[] = "b.id = '" . mysqli_real_escape_string($conn, $_GET['grade']) . "'";
	}


	if (isset($_GET['doj']) && $_GET['doj'] != "") {
		$Adate = explode(' ', $_GET['doj']);
		$month = $Adate[0];
		$year = $Adate[1];
		$months = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');

		$doj = $months[$month] . '-' . $year;
		$condArr[] = " DATE_FORMAT(s.joindate, '%m-%Y') = '" . $doj . "'";
	}
	if (count($condArr) > 0) {
		$cond = " and ( " . implode(" and ", $condArr) . " )";
	}

	$mycount = count($aColumns);

	$sWhere = " WHERE b.id=s.grade and s.delete_status='0' and s.balance>0 ";
	if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {

		$sWhere = $sWhere . " and (";
		for ($i = 0; $i < $mycount; $i++) {

			$sWhere .= $aColumns[$i] . " LIKE '%" . mysqli_real_escape_string($conn, $_GET['sSearch']) . "%' OR ";
		}
		$sWhere = substr_replace($sWhere, "", -3);
		$sWhere .= ')';
	}

	/* Individual column filtering 
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn,$_GET['sSearch_'.$i])."%' ";
		}
	}*/


	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS   " . implode(", ", $aColumns) . "
		FROM   " . $sTable . "	" . $sWhere . $cond . " " . $sOrder . " " . $sLimit;

	$rResult = $conn->query($sQuery) or die(mysqli_error($conn));

	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() as rr
	";
	$rResultFilterTotal = $conn->query($sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	$iFilteredTotal = $aResultFilterTotal['rr'];

	/* Total data set length */
	$sQuery = "SELECT COUNT(" . $sIndexColumn . ") as cc
		FROM   " . $sTable . " WHERE b.id=s.grade and s.delete_status='0' and s.balance>0  ";
	$rResultTotal = $conn->query($sQuery) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch_assoc();
	$iTotal = $aResultTotal['cc'];


	/*
	 * Output
	 */

	if (isset($_GET['sEcho'])) {
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
	} else {
		$output = array(

			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
	}

	$row = array();
	while ($aRow = $rResult->fetch_assoc()) {


		$row = array(
			html_entity_decode($aRow['sname'] . '<br/>' . $aRow['contact']),
			$aRow['fees'],
			$aRow['balance'],
			$aRow['grade'],
			date("d M y", strtotime($aRow['joindate'])),

			html_entity_decode('<button class="btn btn-success btn-sm" style="border-radius:0%" onclick="javascript:GetFeeForm(' . $aRow['id'] . ')"><i class="fa fa-money"></i> Cobrar Pago </button>')

		);

		$output['aaData'][] = $row;
	}

	echo json_encode($output);
}



if ($_GET['type'] == "report") {
	$aColumns = array('s.id', 's.sname', 's.balance', 's.fees', 'b.grade', 's.contact', 's.joindate');

	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "s.id";

	/* DB table to use */
	$sTable = " student as s,grade as b ";



	/* 
	 * Paging
	 */
	$sLimit = "";
	if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
		$sLimit = "LIMIT " . mysqli_real_escape_string($conn, $_GET['iDisplayStart']) . ", " .
			mysqli_real_escape_string($conn, $_GET['iDisplayLength']);
	}


	/*
	 * Ordering
	 */
	$sOrder = "";
	if (isset($_GET['iSortCol_0'])) {
		$sOrder = "ORDER BY  ";
		for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
			if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
				$sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
				 	" . mysqli_real_escape_string($conn, $_GET['sSortDir_' . $i]) . ", ";
			}
		}

		$sOrder = substr_replace($sOrder, "", -2);
		if ($sOrder == "ORDER BY") {
			$sOrder = "";
		}
	}

	$cond = "";
	$condArr = array();
	if (isset($_GET['student']) && $_GET['student'] != "") {
		$condArr[] = "s.sname like '%" . mysqli_real_escape_string($conn, $_GET['student']) . "%'";
	}

	if (isset($_GET['grade']) && $_GET['grade'] != "") {
		$condArr[] = "b.id = '" . mysqli_real_escape_string($conn, $_GET['grade']) . "'";
	}


	if (isset($_GET['doj']) && $_GET['doj'] != "") {
		$Adate = explode(' ', $_GET['doj']);
		$month = $Adate[0];
		$year = $Adate[1];
		$months = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');

		$doj = $months[$month] . '-' . $year;
		$condArr[] = " DATE_FORMAT(s.joindate, '%m-%Y') = '" . $doj . "'";
	}
	if (count($condArr) > 0) {
		$cond = " and ( " . implode(" and ", $condArr) . " )";
	}

	$mycount = count($aColumns);

	$sWhere = " WHERE b.id=s.grade and s.delete_status='0'  ";
	if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {

		$sWhere = $sWhere . " and (";
		for ($i = 0; $i < $mycount; $i++) {

			$sWhere .= $aColumns[$i] . " LIKE '%" . mysqli_real_escape_string($conn, $_GET['sSearch']) . "%' OR ";
		}
		$sWhere = substr_replace($sWhere, "", -3);
		$sWhere .= ')';
	}

	/* Individual column filtering 
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysqli_real_escape_string($conn,$_GET['sSearch_'.$i])."%' ";
		}
	}*/


	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS   " . implode(", ", $aColumns) . "
		FROM   " . $sTable . "	" . $sWhere . $cond . " " . $sOrder . " " . $sLimit;

	$rResult = $conn->query($sQuery) or die(mysqli_error($conn));

	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS() as rr
	";
	$rResultFilterTotal = $conn->query($sQuery) or die(mysqli_error($conn));
	$aResultFilterTotal = $rResultFilterTotal->fetch_assoc();
	$iFilteredTotal = $aResultFilterTotal['rr'];

	/* Total data set length */
	$sQuery = "SELECT COUNT(" . $sIndexColumn . ") as cc
		FROM   " . $sTable . " WHERE b.id=s.grade and s.delete_status='0'   ";
	$rResultTotal = $conn->query($sQuery) or die(mysqli_error($conn));
	$aResultTotal = $rResultTotal->fetch_assoc();
	$iTotal = $aResultTotal['cc'];


	/*
	 * Output
	 */

	if (isset($_GET['sEcho'])) {
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
	} else {
		$output = array(

			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
	}

	$row = array();
	while ($aRow = $rResult->fetch_assoc()) {


		$row = array(
			html_entity_decode($aRow['sname'] . '<br/>' . $aRow['contact']),
			$aRow['fees'],
			$aRow['balance'],
			$aRow['grade'],
			date("d M y", strtotime($aRow['joindate'])),

			html_entity_decode('<button class="btn btn-success btn-sm" style="border-radius:0%" onclick="javascript:GetFeeForm(' . $aRow['id'] . ')"> Validar Reporte </button>')

		);

		$output['aaData'][] = $row;
	}

	echo json_encode($output);
}
