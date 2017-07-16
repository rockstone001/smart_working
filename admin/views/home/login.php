<div id="login">
    <div class="container">

        <form class="form-signin" method="post" action="<?php echo config_item('index_url') . '/home/login'?>">
            <h4 class="form-signin-heading">道生中医-后台管理</h4>
            <span class="error"><?php echo isset($error) ? $error : ''?></span>
            <input type="text" name="user_login" class="input-block-level" placeholder="用户名">
            <input type="password" name="user_pass" class="input-block-level" placeholder="密码">
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> 记住我
            </label>
            <button class="btn btn-large btn-primary" type="submit">登录</button>
        </form>

    </div> <!-- /container -->
</div>