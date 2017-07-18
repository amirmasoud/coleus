<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="https://organicthemes.com/demo/profile/files/2012/12/profile_img.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Admin</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-user text-default"></i> Admin</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ activeRoute([route('dashboard')]) }}"><a href=""><i class="fa fa-dashboard"></i><span> Dashboard</span></a></li>
            <li class="treeview {{ activeRoute([route('dashboard'), route('categories.index')]) }}">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Book</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('books.index') }}"><i class="fa fa-circle-thin"></i> All</a></li>
                    <li class="{{ activeRoute([route('categories.index')]) }}"><a href="{{ route('categories.index') }}"><i class="fa fa-folder-o"></i> Category</a></li>
                </ul>
            </li>
            <li class="treeview {{ activeRoute([route('authors.index'), route('publishers.index')]) }}">
                <a href="#">
                    <i class="fa fa-user-o"></i> <span>User</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-user"></i><span> Admin</span></a></li>
                    <li class="{{ activeRoute([route('authors.index')]) }}"><a href="{{ route('authors.index') }}"><i class="fa fa-pencil"></i><span> Author</span></a></li>
                    <li class="{{ activeRoute([route('publishers.index')]) }}"><a href="{{ route('publishers.index') }}"><i class="fa fa-pencil"></i><span> Publisher</span></a></li>
                    <li><a href="#"><i class="fa fa-bell-o"></i><span> Subscriber</span></a></li>
                </ul>
            </li>
            <li class="{{ activeRoute([route('occupations.index')]) }}">
                <a href="{{ route('occupations.index') }}"><i class="fa fa-puzzle-piece"></i><span> Occupation</span></a>
            </li>
            <li class="{{ activeRoute([route('movements.index')]) }}">
                <a href="{{ route('movements.index') }}"><i class="fa fa-commenting-o"></i><span> Movement</span></a>
            </li>
            <li><a href="#"><i class="fa fa-comment-o"></i><span> Comment</span></a></li>
            <li class="{{ activeRoute([route('sliders.index')]) }}">
                <a href="{{ route('sliders.index') }}"><i class="fa fa-clone"></i><span> Slider</span></a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cog"></i> <span>Setting</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-thin"></i><span> General</span></a></li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>