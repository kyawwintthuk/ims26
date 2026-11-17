<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <div class="navbar-brand">
      <a href="index.php"><?php echo date('d-M-Y (l)') ?></a><br>
      <table>
        <tr>
          <td>Goal</td>
          <td onclick="location.href='#';" style="cursor: pointer;">: [ 0/0 ]</td>
          <td style="padding-left: 10px; color: #a8bbea;">|</td>
          <td style="padding-left: 10px;">ToDoList</td>
          <td onclick="location.href='index.php';">: [ 0/0 ]</td>
        </tr>
      </table>

    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="db_export.php">[DB]</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://bts22.rf.gd/">[BTS-22]</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://pms23.rf.gd/">[PMS-23]</a>
        </li>      
        <!-- <li class="nav-item">
          <a class="nav-link" href="index.php">Page2</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Page3</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Page4</a>
        </li> -->
      </ul>
    </div>
  </div>
</nav>