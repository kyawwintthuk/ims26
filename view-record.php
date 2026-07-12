<?php

include('db/config.php');
include('includes/header.php');
session_start();

$isEdit = false;

if (isset($_GET['id'])) {
    $isEdit = true;
    $value = $_GET['id'];
    $id_array = explode('.', $value);
    $id = $id_array[0];
    $status = $id_array[1];
    // echo $id;

    if ($status == 1) {
        $sql1 = "SELECT * FROM `record` WHERE id=" . $id;
        // echo $sql1;
        $result = $conn->query($sql1);
        $record = $result->fetch_assoc();

        $stmt = $conn->prepare("SELECT u.name, ru.url_id, ru.url_value FROM record_url ru, url u WHERE u.id=ru.url_id AND ru.record_id = ?");
        $stmt->bind_param("i", $record['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        $existing_urls = [];
        while ($row = $result->fetch_assoc()) {
            $existing_urls[] = $row;
        }
        $stmt->close();

    } else if ($status == 2) {
        $sql2 = "SELECT * FROM `category` WHERE id=" . $id;
        // echo $sql2;
        $result2 = $conn->query($sql2);
        $category = $result2->fetch_assoc();
    }    
}

?>

<div class="container container-expand">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="form-group mb-3 input-div">
                    <h4><?= $record['name']?></h4> 
                    <span class="general-font">[ <?= $record['date']?> ]</span>
                </div>

                <div class="form-group mb-3 input-div">
                    <?php foreach ($existing_urls as $index => $url): ?>                        
                        <?= '<input type="button" class="general-font" onclick="window.open(\''.$url['url_value'].'\')" target="_blank" value="'.$url['name'].'">' ?>
                    <?php endforeach; ?>
                </div>

                <div class="form-group mb-3 input-div">
                    <span class="general-font"><?= $record['description']?></span>
                </div>
                                                          
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   
</script>

<?php

include('includes/footer.php');

?>