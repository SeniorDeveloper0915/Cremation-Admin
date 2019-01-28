<style type="text/css">
    .dropdown-btn {
        font-size: 16px;
        /*background: #f2f6f9;*/
        color: #5b9bd1;
    }
    .dropdown-container {
        display: none;
        /*padding-left: 8px;*/
    }

    span {
        font-size: 16px;
    }
</style>
<li class="nav-item start <?php if((strpos($url, 'dashboard/table/index.php') != false)) echo 'active open'; ?>">
    <a href="../../dashboard/table/index.php" class="nav-link nav-toggle">
        <i class="icon-bar-chart"></i>
        <span class="title">首页</span>
        <span class="selected"></span>
    </a>
</li>

<li class="nav-item <?php if((strpos($url, 'banner/table/index.php') != false)) echo 'active';?> ">
    <a href="../../banner/table/index.php" class="nav-link ">
        <i class="icon-users"></i>
        <span class="title" style="font-size: 16px;">banner管理</span>
    </a>
</li>

<li class="dropdown-btn nav-item inactive">
    <a class="nav-link ">
        <i class="icon-envelope"></i>
            整形项目管理
        <i class="fa fa-caret-down"></i>
    </a>
</li>
<div class="dropdown-container" style="margin-left: 45px; font-size: 20px;">
    <li class="nav-item <?php if((strpos($url, 'first_level/table/index.php') != false)) echo 'active';?>">
        <a href="../../first_level/table/index.php" class="nav-link">
            <span class="title">一级项目管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'second_level/table/index.php') != false)) echo 'active';?> ">
        <a href="../../second_level/table/index.php">
            <span class="title">二级项目管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'third_level/table/index.php') != false)) echo 'active';?> ">
        <a href="../../third_level/table/index.php">
            <span class="title">三级项目管理</span>
        </a>
    </li>
</div>

<li class="dropdown-btn">
    <a class="nav-link ">
        <i class="icon-envelope"></i>
        医生管理
        <i class="fa fa-caret-down"></i>
    </a>
</li>
<div class="dropdown-container" style="margin-left: 45px; font-size: 20px;">
    <li class="nav-item <?php if((strpos($url, 'doctor_title/table/index.php') != false)) echo 'active';?> ">
        <a href="../../doctor_title/table/index.php" class="nav-link">
            <span class="title">职称管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'doctor/table/index.php') != false)) echo 'active';?> ">
        <a href="../../doctor/table/index.php">
            <span class="title">医生列表</span>
        </a>
    </li>
</div>


<!-- <li class="nav-item <?php if((strpos($url, 'affidavits') != false)) echo 'active';?> ">
    <a href="affidavits.php" class="nav-link ">
        <i class="icon-envelope"></i>
        <span class="title">日记管理</span>
    </a>
</li> -->
<li class="dropdown-btn inactive">
    <a class="nav-link ">
        <i class="icon-envelope"></i>
        医院列表
        <i class="fa fa-caret-down"></i>
    </a>
</li>

<div class="dropdown-container" style="margin-left: 45px; font-size: 20px;">
    <li class="nav-item <?php if((strpos($url, 'hospital/table/index.php') != false)) echo 'active';?> ">
        <a href="../../hospital/table/index.php" class="nav-link">
            <span class="title">医院列表</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'case/table/index.php') != false)) echo 'active';?> ">
        <a href="../../case/table/index.php">
            <span class="title">案例列表</span>
        </a>
    </li>
</div>

<li class="nav-item <?php if((strpos($url, 'qa/table/index.php') != false)) echo 'active';?> ">
    <a href="../../qa/table/index.php" class="nav-link ">
        <i class="icon-envelope"></i>
        <span class="title" style="font-size: 16px;">问答管理</span>
    </a>
</li>    

<li class="dropdown-btn inactive">
    <a class="nav-link ">
        <i class="icon-envelope"></i>
        攻略管理
        <i class="fa fa-caret-down"></i>
    </a>
</li>
<div class="dropdown-container" style="margin-left: 45px; font-size: 20px;">
    <li class="nav-item <?php if((strpos($url, 'raider_category/table/index.php') != false)) echo 'active';?> ">
        <a href="../../raider_category/table/index.php" class="nav-link">
            <span class="title">攻略类别管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'raider/table/index.php') != false)) echo 'active';?> ">
        <a href="../../raider/table/index.php">
            <span class="title">攻略管理</span>
        </a>
    </li>
</div>

<li class="dropdown-btn">
    <a class="nav-link ">
        <i class="icon-envelope"></i>
        官网信息维护管理
        <i class="fa fa-caret-down"></i>
    </a>
</li>
<div class="dropdown-container" style="margin-left: 45px; font-size: 20px;">
    <li class="nav-item <?php if((strpos($url, 'korean/table/index.php') != false)) echo 'active';?> ">
        <a href="../../korean/table/index.php" class="nav-link">
            <span class="title">简介管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'member/table/index.php') != false)) echo 'active';?> ">
        <a href="../../member/table/index.php">
            <span class="title">核心团队管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'contact/table/index.php') != false)) echo 'active';?> ">
        <a href="../../contact/table/index.php">
            <span class="title">联系我们管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'copyright/table/index.php') != false)) echo 'active';?> ">
        <a href="../../copyright/table/index.php">
            <span class="title">版权声明管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'help_center/table/index.php') != false)) echo 'active';?> ">
        <a href="../../help_center/table/index.php">
            <span class="title">帮助中心管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'dynamic/table/index.php') != false)) echo 'active';?> ">
        <a href="../../dynamic/table/index.php">
            <span class="title">公司动态管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'industry/table/index.php') != false)) echo 'active';?> ">
        <a href="../../industry/table/index.php">
            <span class="title">业界资讯管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'recruitment/table/index.php') != false)) echo 'active';?> ">
        <a href="../../recruitment/table/index.php">
            <span class="title">人才招聘管理</span>
        </a>
    </li>
</div>

<script type="text/javascript">
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            // this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>