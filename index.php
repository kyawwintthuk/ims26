<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
}

include('db/config.php');
include('includes/header.php');
// echo $_SERVER['HTTP_USER_AGENT'];

$res = $conn->query("SELECT value FROM `setting` WHERE id = 1");
if ($res->num_rows > 0) {
    $select_option = $res->fetch_assoc()['value'];
} else {
    $select_option = 'All';
}

?>
<!-- <div class="container" style="margin-top: 153px;"> -->
<div class="container container-expand">
    <div style="background-color: #e9fdff; margin-bottom: 24px;">
    <!-- 20230724 Monday KWT 15:16 PM start -->
        <input type="radio" name="category" id="all" style="margin: 0px;" value="0"  checked="true">
        <label for="all" style="padding-right: 7px;" class="font-style">All</label>
        <?php
        $sql = "SELECT * FROM `category`";
        foreach ($conn->query($sql) as $row) {
        ?>
            <input type="radio" name="category" id="<?= $row['name'] ?>"  value="<?= $row['id'] ?>" <?= ($row['name'] == $select_option) ? 'checked' : '' ?> style="margin: 0px;">
            <label for="<?= $row['name'] ?>" style="padding-right: 7px;" class="font-style"><?= $row['name'] ?></label>
        <?php } ?>
    </div>


     <div id="record_details">
        <!-- <div> -->
        <div style="text-align:center;">
            <img id="loading_spinner" src="images/loading-spinner.gif">
            <div class="my_update_panel"></div>
        </div>
    </div>
   
</div>

<script type="text/javascript">

    $(document).ready(function() {
        fetch_record();

        $('input[type=radio]').on('change', function() {            
            fetch_record();                           
        });

        function fetch_record() {
            var selected_id = $('input[type=radio]:checked').val(); 
            var selected_value =  $('input[type=radio]:checked').next('label').text();
            // alert(selected_id);
            ajax('controller/update_setting.php', 'POST', {
                'id': 1,
                'value': selected_value,
                'option1': selected_id,
                'option2': 'index_page',
            }).then(function(data) {
                console.log(data);
            }).catch(function(error) {
                console.error(error);
            });

            $.ajax({
                url: 'controller/fetch_record.php',
                method: 'GET',
                data: {
                    category_id : selected_id
                },
                async: true, // avoid blocking the page rendering
                success: function(data) {
                    $("#record_details").html(data);

                    $("#record_details img").each(function(){
                        $(this).on('error', handleImageLoadError);
                    });

                    var timer;
                    // 2026-06-22 16:23 Monday
                    $('#record_details').on('mousedown touchstart', '.record', function() {
                        var id = $(this).data('id');
                        timer = setTimeout(function() {
                            // alert(id);
                            var url = "add-record.php?id=" + id + ".1"; //1 : record
                            window.location.href = url;
                        }, 1 * 1000);
                    }).on("mouseup mouseleave touchend touchmove", function() {
                        clearTimeout(timer);
                    });

                    $('#record_details').on('mousedown touchstart', '.category', function() {
                        var id = $(this).data('id');
                        timer = setTimeout(function() {
                            var url = "add-record.php?id=" + id + ".2"; // 2 : category
                            window.location.href = url;
                        }, 1 * 1000);
                    }).on("mouseup mouseleave touchend touchmove", function() {
                        clearTimeout(timer);
                    });
                }
            });

        }

    });
</script>
<?php
include('includes/footer.php');
?>