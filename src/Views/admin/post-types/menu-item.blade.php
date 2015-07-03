<li class="sub-menu">
    <a href="javascript:void(0);"><i class="fa fa-book"></i><span>{{ $postType->title }}</span><i class="arrow fa fa-angle-right pull-right"></i></a>
    <ul>
        <li><a href="{{ route('admin.posts.list', [$postType->id]) }}"><i class="arrow fa fa-angle-right"></i>Create {{ $postType->title }}</a></li>
        <li><a href="{{ route('admin.posts.create', [$postType->id]) }}"><i class="arrow fa fa-angle-right"></i>List {{ $postType->title }}</a></li>
    </ul>
</li>