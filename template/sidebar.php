<div id="sidebar" class="sidebar">

    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:void(0);"><img src="assets/img/user-13.jpg" alt=""/></a>
                </div>
                <div class="info">
                    <?php if (isset($_SESSION['username'])) {
                        echo $_SESSION['username'];
                    } ?>
                    <small><?php if (isset($_SESSION['usergroup'])) {
                            echo $_SESSION['usergroup'];
                        } ?></small>
                </div>
            </li>
        </ul>

        <ul class="nav">
            <li class="nav-header">导航栏</li>
            <li id="仪表盘" class="">
                <a href="javascript:void(0);">
                    <i class="fa fa-laptop"></i>
                    <span>仪表盘</span>
                </a>
            </li>

            <li id="index" class="">
                <a href="index.php">
                    <i class="fa fa-home"></i>
                    <span>首页</span>
                </a>
            </li>


            <li id="订单管理" class="has-sub">
                <a href="javascript:void(0);">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-gears (alias)"></i>
                    <span>订单管理</span>
                </a>
                <ul class="sub-menu">
                    <li id="订单录入"><a href="AddOrder.php">订单录入</a></li>
                    <li id="订单评审一般"><a href="OrderReviewNormal.php">订单评审(一般)</a></li>
                    <li id="订单评审特殊"><a href="OrderReviewSpecial.php">订单评审(特殊)</a></li>


                    <li id="订单信息查询"><a href="order_info_query.php">订单信息查询</a></li>
                </ul>
            </li>

            <li id="订单跟踪" class="has-sub">
                <a href="javascript:void(0);">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-paper-plane"></i>
                    <span>订单跟踪</span>
                </a>
                <ul class="sub-menu">
                    <li id="订单跟踪_"><a href="track_order.php">订单跟踪</a></li>
                    <li id="施工单跟踪"><a href="track_pro.php">施工单跟踪</a></li>
                    <li id="订单实时欠货"><a href="pro_on_credit.php">订单实时欠货</a></li>
                    <li id="订单全程跟踪"><a href="track_pro_whole.php">订单全程跟踪</a></li>
                </ul>
            </li>


            <li id="订单统计" class="has-sub">
                <a href="javascript:void(0);">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-bar-chart-o"></i>
                    <span>订单统计</span>
                </a>
                <ul class="sub-menu">
                    <li id="订货信息查询"><a href="order_statistics_query.php">订货信息查询</a></li>
                </ul>
            </li>

            <li><a href="javascript:void(0);" class="sidebar-minify-btn" data-click="sidebar-minify"><i
                        class="fa fa-angle-double-left"></i></a></li>

        </ul>
    </div>
</div>
<div class="sidebar-bg"></div>
