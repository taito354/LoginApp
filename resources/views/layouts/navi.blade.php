{{-- //ログイン後のすべてのページに共通するヘッダーです --}}
<nav>
    <div class="navibar">
        <p class="main_logo">HOTARUER</p>
        <div class="navi_list">
            <ul>
                <li><a href="#">マップ</a></li>
                <li><a href="#">掲示板</a></li>
                <li>
                    <form action="{{ route('dashboard.logout' )}}" method="post">
                        @csrf
                        <button type="submit" class="logout_btn">ログアウト</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
