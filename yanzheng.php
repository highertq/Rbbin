<?php

if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    if ($user == "" || $pass == "") {
        $error = 'Not all fields were entered';
    }
    else if($Is_right == "no"){
        $error = "Verifications code is wrong.";
    }else{
        $result = queryMySQL("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");
    }
    if ($result->num_rows == 0) {
        $error = "Invalid login attempt";
    } else {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        $thing5 = "log in";
        $time = time();
        queryMysql("INSERT INTO log VALUES(NULL,'$user', '$thing5',$time)");
        die("<div class='center'>You are now logged in. Please
             <a data-transition='slide' href='members.php?view=$user'>click here</a>
             to continue.</div></div></body></html>");
    }
}
?>
<script>
    $(".btn").on('click',function(){
        var val = $(".input-val").val().toLowerCase();
        var num = show_num.join("");
        if(val==''){ //输入为空
            alert('请输入验证码！');
        }else if(val == num){ //输入正确
            $.ajax({
                type : "post",
                url : 'login.php',
                dateType : "json",
                data:{'Isright':'yes'},
                success : function(data) {

                }
            });
            $(".input-val").val('');
            draw(show_num);
        }else{ //输入错误
            $(".input-val").val('');
            draw(show_num);
        }
    })
</script>

