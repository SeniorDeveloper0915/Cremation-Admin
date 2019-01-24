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
<li class="nav-item start <?php if((strpos($url, 'dashboard/dashboard.php') != false)) echo 'active open'; ?>">
    <a href="../dashboard/dashboard.php" class="nav-link nav-toggle">
        <i class="icon-bar-chart"></i>
        <span class="title">首页</span>
        <span class="selected"></span>
    </a>
</li>

<li class="nav-item <?php if((strpos($url, 'banner/banner.php') != false)) echo 'active';?> ">
    <a href="../banner/banner.php" class="nav-link ">
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
    <li class="nav-item <?php if((strpos($url, 'first_level/project.php') != false)) echo 'active';?>">
        <a href="../first_level/project.php" class="nav-link">
            <span class="title">一级项目管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'second_level/project.php') != false)) echo 'active';?> ">
        <a href="../second_level/project.php">
            <span class="title">二级项目管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'third_level/project.php') != false)) echo 'active';?> ">
        <a href="../third_level/project.php">
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
    <li class="nav-item <?php if((strpos($url, 'doctor_title/title.php') != false)) echo 'active';?> ">
        <a href="../doctor_title/title.php" class="nav-link">
            <span class="title">职称管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'doctor/doctor.php') != false)) echo 'active';?> ">
        <a href="../doctor/doctor.php">
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
    <li class="nav-item <?php if((strpos($url, 'hospital/hospital.php') != false)) echo 'active';?> ">
        <a href="../hospital/hospital.php" class="nav-link">
            <span class="title">医院列表</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'case/case.php') != false)) echo 'active';?> ">
        <a href="../case/case.php">
            <span class="title">案例列表</span>
        </a>
    </li>
</div>

<li class="nav-item <?php if((strpos($url, 'qa/qa.php') != false)) echo 'active';?> ">
    <a href="../qa/qa.php" class="nav-link ">
        <i class="icon-envelope"></i>
        <span class="title">问答管理</span>
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
    <li class="nav-item <?php if((strpos($url, 'raider_category/category.php') != false)) echo 'active';?> ">
        <a href="../raider_category/category.php" class="nav-link">
            <span class="title">攻略类别管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'raider/raider.php') != false)) echo 'active';?> ">
        <a href="../raider/raider.php">
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
    <li class="nav-item <?php if((strpos($url, 'korean/korean.php') != false)) echo 'active';?> ">
        <a href="../korean/korean.php" class="nav-link">
            <span class="title">简介管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'member/member.php') != false)) echo 'active';?> ">
        <a href="../member/member.php">
            <span class="title">核心团队管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'contact/contact.php') != false)) echo 'active';?> ">
        <a href="../contact/contact.php">
            <span class="title">联系我们管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'copyright/copyright.php') != false)) echo 'active';?> ">
        <a href="../copyright/copyright.php">
            <span class="title">版权声明管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'help_center/help.php') != false)) echo 'active';?> ">
        <a href="../help_center/help.php">
            <span class="title">帮助中心管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'dynamic/dynamic.php') != false)) echo 'active';?> ">
        <a href="../dynamic/dynamic.php">
            <span class="title">公司动态管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'industry/industry.php') != false)) echo 'active';?> ">
        <a href="../industry/industry.php">
            <span class="title">业界资讯管理</span>
        </a>
    </li>
    <li class="nav-item <?php if((strpos($url, 'recruitment/recruitment.php') != false)) echo 'active';?> ">
        <a href="../recruitment/recruitment.php">
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