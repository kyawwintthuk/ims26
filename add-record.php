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

        $stmt = $conn->prepare("SELECT url_id, url_value FROM record_url WHERE record_id = ?");
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
                <form action="controller/add_record.php" method="POST">
                    <div class="card-header" id="status" <?= (isset($_SESSION['color'])) ? 'style="background-color: ' . $_SESSION['color'] . '"' : '' ?>>
                        <h1>
                            <div class="add_radio_buttons">
                                <input type="radio" name="operation" id="operaton_record" value="Record" <?= ($isEdit) ? ($status == 2) ? 'disabled unchecked' : 'checked' : 'checked' ?>>
                                <label for="operaton_record" <?= ($isEdit && $status == 2) ? 'style="color: #bcbcbc;"' : '' ?>>Record</label>

                                <input type="radio" name="operation" id="operation_category" value="Category" <?= ($isEdit) ? ($status == 1) ? 'disabled unchecked' : 'checked' : '' ?>>
                                <label for="operation_category" <?= ($isEdit && $status == 1) ? 'style="color: #bcbcbc;"' : '' ?>>Category</label>

                                <input type="radio" name="operation" id="operation_url" value="URL" <?= ($isEdit) ? ($status == 1 || $status == 2) ? 'disabled unchecked' : 'checked' : '' ?>>
                                <label for="operation_url" <?= ($isEdit && ($status == 1 || $status == 2)) ? 'style="color: #bcbcbc;"' : '' ?>>URL</label>
                            </div>
                        </h1>
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo "<span id='message'>" . $_SESSION['message'] . "</span>";
                            unset($_SESSION['message']);
                        }

                        if (isset($_SESSION['color'])) {
                            unset($_SESSION['color']);
                        }
                        ?>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3 input-div display">
                            <div id="image-container" style="width: 189px;">
                                <img src="images/default_image.png">
                            </div>
                        </div>
                       
                        <div id="data_item">
                            <div class="form-group mb-3 input-div display">
                                <select name="category" id="category" style="float: left;">
                                    <?php
                                    foreach ($conn->query("SELECT * FROM `category`") as $row) { ?>
                                        <option value="<?= $row['id'] ?>" <?= ($isEdit) ? ($row['id'] == $record['category_id']) ? 'selected' : '' : ''  ?>><?= $row['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <br>                       
                            <input type="hidden" id="id" name="id" <?php echo ($isEdit) ? 'value="' . $id . '"' : '' ?>>
                            <div class="form-group mb-3 input-wrap input-div ">
                                <input type="text" id="name" name="name" placeholder=" " class="input form-control" <?= ($isEdit) ? ($status == 1) ?  'value="' . $record['name'] . '"' : 'value="' . $category['name'] . '"' : '' ?> autofocus required>
                                <label id="label" for="name">Name</label>
                            </div>
                            <div class="form-group mb-3 input-wrap input-div">
                                <input type="text" id="description" name="description" placeholder=" " class="input form-control" <?= ($isEdit) ? ($status == 1) ? 'value="' . $record['description'] . '"' : 'value="' . $category['description'] . '"' : '' ?>>
                                <label id="label" for="description">Description</label>
                            </div>     
                            
                            <div id="urlContainer" class="display">
                                <?php if (!empty($existing_urls)): ?>
                                    <?php foreach ($existing_urls as $index => $url): ?>
                                        <div class="form-group mb-3 input-wrap input-div url-group" data-index="<?= $index + 1 ?>">                                
                                            <select name="url_id[]" id="url_1" class="url_option" >
                                                <?php
                                                foreach ($conn->query("SELECT * FROM `url`") as $row) { ?>
                                                    <option value="<?= $row['id'] ?>" <?= $url['url_id'] == 1 ? 'selected' : '' ?>><?= $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type="text" id="url_1" name="url_value[]" placeholder=" " value="<?= htmlspecialchars($url['url_value']) ?>" class="input form-control">
                                            <label id="label" class="url_label">URL</label> 
                                            <button type="button" class="btn btn-danger btn-sm remove-url" style="<?= $index == 0 ? 'display:none;  width: 10%;' : 'width: 10%;' ?>">×</button>
                                        </div> 
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="form-group mb-3 input-wrap input-div url-group" data-index="1">                                
                                        <select name="url_id[]" id="url_1" class="url_option" >
                                            <?php
                                            foreach ($conn->query("SELECT * FROM `url`") as $row) { ?>
                                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="text" id="url_1" name="url_value[]" placeholder=" " class="input form-control">
                                        <label id="label" class="url_label">URL</label> 
                                        <button type="button" class="btn btn-danger btn-sm remove-url" style="float: right; display: none; width: 10%;">×</button>
                                    </div> 
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3 input-wrap input-div display">
                                <button type="button" name="add_url" class="btn btn-info font-style" id="addUrlBtn" style="float: right; color: #fff; width:100%;">+</button>  
                                <br>
                            </div>                            
                            
                            
                            <div class="form-group mb-3 input-wrap input-div display">
                                <input type="text" id="image_url" name="image_url" placeholder=" " class="input form-control" <?= ($isEdit && $status == 1) ? 'value="' . $record['image_url'] . '"' : '' ?>>
                                <label id="label" for="image_url">Image URL</label>
                            </div>    
                            <div class="form-group mb-3 input-wrap input-div display">
                                <input type="text" id="google_sheet_url" name="google_sheet_url" placeholder=" " class="input form-control" <?= ($isEdit && $status == 1) ? 'value="' . $record['google_sheet_url'] . '"' : '' ?> autofocus>
                                <label id="label" for="google_sheet_url">Google Sheet URL</label>
                            </div>    
                            <div class="form-group mb-3 input-wrap input-div display">
                                <input type="text" id="linkedin_url" name="linkedin_url" placeholder=" " class="input form-control" <?= ($isEdit && $status == 1) ? 'value="' . $record['linkedin_url'] . '"' : '' ?> autofocus>
                                <label id="label" for="linkedin_url">LinkedIn URL</label>
                            </div>             
                            <div class="form-group mb-3 input-wrap input-div display">
                                <input type="text" id="gmail_url" name="gmail_url" placeholder=" " class="input form-control" <?= ($isEdit && $status == 1) ? 'value="' . $record['gmail_url'] . '"' : '' ?>>
                                <label id="label" for="gmail_url">Gmail URL</label>
                            </div>
                            <div class="form-group mb-3 input-wrap input-div display">
                                <input type="text" id="date" name="date" placeholder=" " class="input form-control" value="<?= date('d-m-Y') ?>" <?= ($isEdit && $status == 1) ? 'value="' . $record['date'] . '"' : '' ?> required>
                                <label id="label" for="date">Date</label>
                            </div>                                                                                                              

                            <?php
                            if ($isEdit) {
                            ?>
                                <button type="submit" name="edit" class="btn btn-primary font-style" style="float: right;">Edit</button>
                                <button type="submit" name="delete" class="btn btn-danger font-style" onclick="return confirm('Are you sure?')" style="float: right;">Delete</button>
                            <?php
                            } else {
                            ?>
                                <button type="submit" name="add" class="btn btn-primary font-style" style="float: right;">Add</button>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // var radio_button = "<?php echo isset($_SESSION['radio_button']) ? $_SESSION['radio_button'] : ''; ?>";

        var _top = $(window).scrollTop();

        $(window).scroll(function() {
            var _cur_top = $(window).scrollTop();
            if (_top < _cur_top) { // scroll = down
                $(".button-corner").slideUp(100);
            } else {
                $(".button-corner").slideDown(100);
            }
        }).scroll();


        radioButton($('input[name=operation]:checked').val());

        var imagePath = $('#image_url').val();
        var img = $('<img>');
        img.attr('src', imagePath);
        img.on('error', function() {
            $(this).attr('src', 'images/default_image.png');
        });
        $('#image-container').empty().append(img);


        $('#date').datepicker({
            dateFormat: 'dd-mm-yy'
        });

        $('input[type=radio]').on('change', function() {
            radioButton($('input[name=operation]:checked').val());
        });
    

        setTimeout(function() {
            $('#status').css('background-color', 'initial');
            $('#message').css('color', '#fa2525');
        }, 3000);

        $('#image_url').on('input', function() {
            var imagePath = $(this).val();
            var img = $('<img>');
            img.attr('src', imagePath);
            img.on('error', function() {
                $(this).attr('src', 'images/default_image.png');
            });
            $('#image-container').empty().append(img);
        });

        var urlCounter = 1;
        $('#addUrlBtn').click(function() {
            urlCounter++;
            
            // Clone the first group
            var $newGroup = $('.url-group:first').clone();
            
            // Update IDs and names
            $newGroup.attr('data-index', urlCounter);
            $newGroup.find('select')
                // .attr('name', 'url_' + urlCounter)
                .attr('id', 'url_' + urlCounter);
            $newGroup.find('input[type="text"]')
                // .attr('name', 'url_' + urlCounter)
                .attr('id', 'url_' + urlCounter)
                .val(''); // Clear the value
            
            // Show remove button (except for first one)
            $newGroup.find('.remove-url').show();
            
            // Append to container
            $('#urlContainer').append($newGroup);
            
            // Show remove button on first group if there are multiple
            // if ($('.url-group').length > 1) {
            //     $('.url-group:first .remove-url').show();
            // }
        });

        $(document).on('click', '.remove-url', function() {
            if ($('.url-group').length > 1) {
                $(this).closest('.url-group').remove();
                
                // Hide remove button on first if only one left
                if ($('.url-group').length === 1) {
                    $('.url-group:first .remove-url').hide();
                }
            } else {
                alert('Cannot remove the last URL field');
            }
        });
                                
    });

    function radioButton(value) {        
        // var value = $('input[name=operation]:checked').val();
        if (value == 'Record') {
            $('.display').css('cssText', 'display: block !important;');
            // $('.for-category-block').css('display', 'none');
        }

        if (value == 'Category') {
           $('.display').css('cssText', 'display: none !important;');
            // $('.for-category-block').css('display', 'block');
        }

        if (value == 'URL') {
           $('.display').css('cssText', 'display: none !important;');
            // $('.for-category-block').css('display', 'none');
        }
    }
</script>

<?php

include('includes/footer.php');

?>