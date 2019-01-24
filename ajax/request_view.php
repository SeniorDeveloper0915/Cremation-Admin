<?php
/*
 * Script:    DataTables server-side script for PHP and MySQL
 * Copyright: 2010 - Allan Jardine, 2012 - Chris Wright
 * License:   GPL v2 or BSD (3-point)
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

/* Array of database columns which should be read and sent back to DataTables. Use a space where
 * you want to insert a non-database field (for example a counter or static image)
 */
$aColumns = array( 'id','Requester', 'sender_status','receiver_status', 'sender_mail_unread', 'receiver_mail_unread','provider_pNumber', 'updated_at', 'id');
$asColumns = array( 'id','Requester', 'sender_status','receiver_status', 'sender_mail_unread', 'receiver_mail_unread','provider_pNumber', 'updated_at', 'id');
$aaColumns = array( 'id','Requester', 'sender_status','receiver_status', 'sender_mail_unread', 'receiver_mail_unread','provider_pNumber', 'updated_at', 'id');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "id";

/* DB table to use */
$sTable = "requests";

/* Database connection information */

require_once("../config/config.php");


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
 * no need to edit below this line
 */

/*
 * Local functions
 */
function fatal_error ( $sErrorMessage = '' )
{
    header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
    die( $sErrorMessage );
}


/*
 * MySQL connection
 */
if ( ! $gaSql['link'] = mysqli_connect( $GLOBALS["HOST"] , $GLOBALS["USERNAME"] , $GLOBALS["PASSWORD"]  ,$GLOBALS["DATABASE"]  ) )
{
    fatal_error( 'Could not open connection to server' );
}



/*
 * Paging
 */
$sLimit = "";
if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
{
    $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
        intval( $_GET['iDisplayLength'] );
}


/*
 * Ordering
 */
$sOrder = "";
if ( isset( $_GET['iSortCol_0'] ) )
{
    $sOrder = "ORDER BY  ";
    for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
    {
        if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
        {
            $sOrder .= $aaColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
        }
    }

    $sOrder = substr_replace( $sOrder, "", -2 );
    if ( $sOrder == "ORDER BY" )
    {
        $sOrder = "";
    }
}


/*
 * Filtering
 * NOTE this does not match the built-in DataTables filtering which does it
 * word by word on any field. It's possible to do here, but concerned about efficiency
 * on very large tables, and MySQL's regex functionality is very limited
 */
$sWhere =  "";
if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
{
    $sWhere .= "WHERE (";
    for ( $i=0 ; $i<count($asColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
        {
            $sWhere .= $asColumns[$i]." LIKE '%".mysqli_real_escape_string( $gaSql['link'],$_GET['sSearch'] )."%' OR ";
        }
    }
    $sWhere = substr_replace( $sWhere, "", -3 );
    $sWhere .= ')';
}

///* Individual column filtering */
for ( $i=0 ; $i<count($asColumns) ; $i++ )
{
    if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
    {
        if ( $sWhere == "" )
        {
            $sWhere = "WHERE ";
        }
        else
        {
            $sWhere .= " AND ";
        }
        $sWhere .= $asColumns[$i]." LIKE '%".mysqli_real_escape_string($gaSql['link'],$_GET['sSearch_'.$i])."%' ";
    }
}


/*
 * SQL queries
 * Get data to display SELECT * FROM users
 */
$sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
    ";
$rResult = mysqli_query($gaSql['link'], $sQuery ) or fatal_error( 'MySQL Error: ' . mysql_errno() );

/* Data set length after filtering */
$sQuery = "
        SELECT FOUND_ROWS()
    ";
$rResultFilterTotal = mysqli_query($gaSql['link'] , $sQuery) or fatal_error( 'MySQL Error: ' . mysql_errno() );
$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

/* Total data set length */
$sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   $sTable
    ";
$rResultTotal = mysqli_query($gaSql['link'] ,$sQuery) or fatal_error( 'MySQL Error: ' . mysql_errno() );
$aResultTotal = mysqli_fetch_array($rResultTotal);
$iTotal = $aResultTotal[0];


/*
 * Output
 */
$output = array(
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array()
);

while ( $aRow = mysqli_fetch_array( $rResult ) )
{
    $row = array();
    for ( $i=0 ; $i<count($aaColumns) ; $i++ )
    {
//        print_r($aaColumns[$i]);
                /* General output */
                $row[] = $aRow[ $aaColumns[$i] ];

    }
    $row[] = '<a type="button" href="javascript:;" onclick="editModal('.$row[0].')" class="btn btn green btn-outline btn-xs margin-top-10"> <i class="fa fa-edit"></i> Edit</a>&nbsp;
                <a href="javascript:;" onclick="del('.$row[0].',\''.addslashes($row[1]).'\')" class="btn btn-outline red btn-xs margin-top-10"> <i class="fa fa-trash-o"></i> Delete</a>';

    $output['aaData'][] = $row;
}

echo json_encode( $output );
?>