<?php
session_start();
include('./db/config.php');
$id = 1;
// PHP program to get IP address of client
$ip_address = $_SERVER['REMOTE_ADDR'];
$device_name = $_SERVER['HTTP_USER_AGENT'];
//echo $ip_address.'/'.$device_name;
// $sql = "SELECT * FROM `ip_list` WHERE ip_address='" . $ip_address . "' AND device_name='" . $device_name . "' AND authority = 1";
// if(!$conn->query($sql)-> num_rows > 0){
//     header('Location: 403.php');
// }
$server_ip = $_SERVER['SERVER_ADDR'];
if($server_ip === '127.0.0.1' || $server_ip === '::1'){
  $title = 'localhost';
}else{
  $title = 'IMS 26';
}

$monthsColorsCode = $conn->query("SELECT option2 FROM `master` WHERE type='MonthsColors' AND option1='".date('m')."'")->fetch_assoc()['option2'];
$monthsColorsCodeCSS = "style='color: $monthsColorsCode;'";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- CSS CDN -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" /> -->
    <!-- datetimepicker jQuery CDN -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"> -->
    </script>
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/en/thumb/9/9e/Flag_of_Japan.svg/1200px-Flag_of_Japan.svg.png">

    <script src="https://www.google.com/jsapi"></script>

    <!-- Search box -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <title><?= $title ?></title>
</head>

<!-- <body oncontextmenu="return false" style="background-color: #f7f7f7;"> -->
<body style="background-color: #f7f7f7;">
    <section class="vh-100" style="height: 90vh!important;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h1 class="mb-5" <?= $monthsColorsCodeCSS ?>>IMS 26</h1>
                            <div class="panel">
                                <div class="table-bordered table-responsive text-center">

                                    <table class="table table-bordered" style="border: 1px solid #ddd !important;">
                                        <tbody>
                                            <?php
                                            for ($i = 1; $i <= 4; $i++) {
                                            ?>
                                                <tr style="background-color: #e7e4e4;">
                                                    <?php
                                                    for ($j = 1; $j <= 4; $j++) {
                                                    ?>
                                                        <td <?= 'id="code-' . $id . '"' ?> style="background-color: #fff; border: 4px solid #afacac;"><?= rand(0, 9); ?></td>
                                                    <?php
                                                        $id++;
                                                    }
                                                    ?>
                                                </tr>
                                            <?php }  ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="panel">
                                <div class="table-bordered table-responsive text-center">

                                    <table class="table table-bordered" style="border: 1px solid #ddd !important;">
                                        <tbody>
                                            <?php
                                            for ($i = 1; $i <= 4; $i++) {
                                            ?>
                                                <tr style="background-color: #e7e4e4;">
                                                    <?php
                                                    for ($j = 1; $j <= 4; $j++) {
                                                    ?>
                                                        <td <?= 'id="code-' . $id . '"' ?> style="background-color: #fff; border: 4px solid #afacac;"><?= rand(0, 9); ?></td>
                                                    <?php
                                                        $id++;
                                                    }
                                                    ?>
                                                </tr>
                                            <?php }  ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="password" class="form-control form-control-lg" placeholder="●●●●●●●●●" autofocus />
                            </div>



                            <!-- Checkbox -->
                            <!-- <div class="form-check d-flex justify-content-start mb-4"> -->
                            <!-- <input class="form-check-input" type="checkbox" value="" id="form1Example3" /> -->
                            <!-- <label class="form-check-label" for="form1Example3"> Remember password </label> -->
                            <!-- </div> -->

                            <!-- <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button> -->
                            <!-- <br> -->
                            <!-- <hr class="my-4"> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
<script>
    // $(window).on("load", function() {
    //     fetch_ip_list();
        
    //     function fetch_ip_list() {
    //         $.ajax({
    //             url: 'fetch_ip_list.php',
    //             type: 'POST',
    //             data: {
    //                 ip_address: <?php echo json_encode($_SERVER['REMOTE_ADDR']) ?>,
    //                 device_name: <?php echo json_encode($_SERVER['HTTP_USER_AGENT']) ?>
    //             }
    //             ,
    //             success: function(data) {
    //                 if(data == '403'){
    //                     window.location.href = '403.php';
    //                 }
    //             }
    //         });
    //     }
    //     setInterval(function() {
    //         fetch_ip_list();
    //     }, 1000); // it will refresh your data every 1 sec
    // });

    $(document).on('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80)) {
            // alert("You can't print!");
            e.cancelBubble = true;
            e.preventDefault();

            e.stopImmediatePropagation();
        }
    });

    // https://stackoverflow.com/questions/28690564/is-it-possible-to-remove-inspect-element
    // Right Click
    // F12
    // Ctrl + Shift + I
    // Ctrl + Shift + J
    // Ctrl + Shift + C
    // Ctrl + U
    // document.onkeydown = function(e) {
    //     if (event.keyCode == 123) {
    //         return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
    //         return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
    //         return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
    //         return false;
    //     }
    //     if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
    //         return false;
    //     }
    // }

    if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
        $.ajax({
            url: "destroy_session.php",
            method: 'GET'
        });
    }

    $i = 1;
    $code = '';
    while ($i <= 32) {
        $code += $('#code-' + $i).text();
        $i++;
    }
    // console.log($code);

    $('#password').keyup(function() {
        $.ajax({
            url: "controller/fetch_login.php",
            method: "POST",
            data: {
                password: $('#password').val(),
                code: $code
            },
            success: function(data) {
                // console.log(data);
                if (data == "success") {
                    window.location.href = 'index.php';
                }
            }
        });

    });
</script>