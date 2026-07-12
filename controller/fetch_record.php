<?php
include('../db/config.php');

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile')) {
    $total_img = 4;
} else {
    $total_img = 6;
}
$i = 1;
$output = '';

//   20230724 Monday KWT 15:16 PM  -- start 
$category_id = $_GET['category_id'];

if($category_id == 0){
    $sql1 = "SELECT id, name, description FROM `category`";
}else{
    $sql1 = "SELECT id, name, description FROM `category` WHERE id = " . $category_id . "";
}
//   20230724 Monday KWT 15:16 PM  -- end 

foreach ($conn->query($sql1) as $row) {

    $sql2 = "SELECT IFNULL(COUNT(*),0) AS total FROM `record` WHERE category_id=" . $row['id'] . " GROUP BY category_id;";

    $result = $conn->query($sql2);
    $total_item = ($result->num_rows > 0) ? $result->fetch_assoc()['total'] : 0;

    $output .= '
        <div class="card">
            <div class="card-header category" style="background-color: #f0f0f0;" data-id="' . $row['id'] . '">
                <span id="category">' . $row['name'] . ' </span>
                <span id="item_total" style="float:right;">[ ' . $total_item . ' ] </span>
            </div>
            <div class="card-body">
                <div class="row">
    ';

    $sql3 = "SELECT id, name, description, date FROM `record` WHERE category_id = " . $row['id'] . "";

    foreach ($conn->query($sql3) as $row) {      

        // 20230803 Thursday -- not available add -- KWT 
        // if(!empty($row['image_url'])):
        //     $image_url = $row['image_url'];
        // else:
        //     $image_url = 'images/not_available.jpg ';
        // endif;
        

        $output .= '            
            <div class="record col-md-12" data-id="' . $row['id'] . '" onclick="location=\'view-record.php?id=' . $row['id'] . '.1\'" >
                <div class="row">
                    <div class="card" style="border:none; padding: 0px;">
                        <div class="card-header" style="border:none; padding: 0px;">                                                                                                        
                        </div>
                        <div class="card-body" style="padding: 5px 0px;">
                            <span> ' . $row['name'] . '</span>';
        
        $output .=   ($row['description'] != null) ? '<br><span> ' . substr($row['description'], 0, 100) . '...' . '</span>' : '';

        $sql4 = "SELECT u.name, ru.url_id, ru.url_value FROM `url` u, `record_url` ru WHERE u.id = ru.url_id AND ru.record_id=". $row['id'];
        // echo $sql4;
        foreach ($conn->query($sql4) as $row1) { 
            $output .=   ($row1['url_value'] != null) ? '<input type="button" onclick="window.open(\''.$row1['url_value'].'\')" target="_blank" value="'.$row1['name'].'">' : '';
        }

        // $output .=   ($row['image_url'] != null) ? '<input type="button" onclick="window.open(\''.$row['image_url'].'\')" target="_blank" value="Image">' : '';
        // $output .=   ($row['google_sheet_url'] != null) ? '<input type="button" onclick="window.open(\''.$row['google_sheet_url'].'\')" target="_blank" value="Google Sheet">' : '';
        // $output .=   ($row['linkedin_url'] != null) ? '<input type="button" onclick="window.open(\''.$row['linkedin_url'].'\')" target="_blank" value="LinkedIn">' : '';
        // $output .=   ($row['gmail_url'] != null) ? '<input type="button" onclick="window.open(\''.$row['gmail_url'].'\')" target="_blank" value="Gmail">' : '';

 
        $output .= ' </div>
                    </div>
                </div>                
            </div>
        ';
        $output .= ($total_item > 1  && $i < $total_item) ? '<div style="border-bottom:2px solid #dfd4d4; padding-bottom: 10px;"></div>' : '';
        $i++;
    }
    
    $i  = 1;

    $output .= '
                </div>
            </div>
        </div>
        <br>
    ';
}





echo $output;
