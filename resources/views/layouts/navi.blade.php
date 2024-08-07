{{-- //ログイン後のすべてのページに共通するヘッダーです --}}
<nav>
    <div class="navibar">
        <p class="main_logo"><a href="{{ route('dashboard') }}">HOTARUER</a></p>
        <div class="navi_list">
            <ul>
                <li><a href="#">マップ</a></li>
                <li><a href="#">掲示板</a></li>
                <li><a href="{{ route('setting.account') }}">アカウント設定</a></li>
                <li>
                    <form action="{{ route('user.logout' )}}" method="post">
                        @csrf
                        <button type="submit" class="logout_btn">ログアウト</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>



