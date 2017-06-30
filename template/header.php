<div id="header" class="header navbar navbar-inverse navbar-fixed-top">

    <div class="container-fluid">

        <div class="navbar-header">
            <a href="index.php" class="navbar-brand"><span class=""></span> 华铸ERP</a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <!--  <li>
                <form class="navbar-form full-width">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter keyword" />
                        <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </li>-->

            <!--<li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                    <i class="fa fa-bell-o"></i>
                    <span class="label">5</span>
                </a>
                <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                    <li class="dropdown-header">Notifications (5)</li>
                    <li class="media">
                        <a href="javascript:;">
                            <div class="media-left"><i class="fa fa-envelope media-object bg-blue"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading"> New Email From John</h6>
                                <div class="text-muted f-s-11">2 hour ago</div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-footer text-center">
                        <a href="javascript:;">View more</a>
                    </li>
                </ul>
            </li>-->
            <li class="dropdown navbar-user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="assets/img/user-13.jpg" alt=""/>
                    <span class="hidden-xs"><?php if (isset($_SESSION['username'])) {
	echo $_SESSION['username'];
}?></span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
                    <li><a href="doAction.php?act=logout">退出</a></li>
                </ul>
            </li>
        </ul>

    </div>
</div>
