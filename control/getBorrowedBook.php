<?php
include '../CommonPage/function.php';
/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "phenol69";
$dbname = "LibraryNotifier";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array(
// datatable column index  => database column name
    0 => 'BookName',
    1 => 'IssueDate',
    2 => 'DueDate',
    3 => 'StudentId'
);

$whichData=$_GET['whichData'];
// getting total number records without any search
$sql = "SELECT id";
$sql.=" FROM book";
$query=mysqli_query($conn, $sql) or die("getBorrowedBook.php: get Book");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
$currentDate=getCurrentDate();
$sql = "SELECT Id, BookName, IssueDate, DueDate, StudentId ";
if($whichData=='old'){
    $sql.=" FROM book WHERE DueDate < '".$currentDate."'";
}else{
    $sql.=" FROM book WHERE DueDate >= '".$currentDate."'";
}

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND StudentId LIKE '".$requestData['search']['value']."%'";
    /*$sql.=" AND BookName LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR IssueDate LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR DueDate LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR StudentId LIKE '".$requestData['search']['value']."%' ";*/
}
$query=mysqli_query($conn, $sql) or die("getBorrowedBook.php: get Book");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query=mysqli_query($conn, $sql) or die("getBorrowedBook.php: get Book");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
    $nestedData=array();
    $nestedData[] = $row["StudentId"];
    $nestedData[] = $row["BookName"];
    $date = new DateTime($row["IssueDate"]);
    $nestedData[] = $date->format('d-m-Y'); //only fetching date
    $date1 = new DateTime($row["DueDate"]);
    $nestedData[] = $date1->format('d-m-Y'); //only fetching date

    $data[] = $nestedData;
}
$json_data = array(
    "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    "recordsTotal"    => intval( $totalData ),  // total number of records
    "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format

?>
