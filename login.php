<?php // Example 27-7: login.php
require_once 'header.php';
date_default_timezone_set('PRC');
$error = "";
$user = $_POST['user'];
$pass = $_POST['pass'];
$verify=$_POST['verification'];
if($verify=="yes"){
    if (isset($_POST['user']))
    {
        $user = sanitizeString($_POST['user']);
        $pass = sanitizeString($_POST['pass']);

        if ($user == "" || $pass == "") {
             echo "<script type='text/javascript'>html_reload();</script>";
        }
        else
        {
            $result = queryMySQL("SELECT user,pass FROM members
        WHERE user='$user' AND pass='$pass'");

            if ($result->num_rows == 0)
            {
                echo "<script type='text/javascript'>html_reload();</script>";
                $error = "Invalid login attempt";
            }
            else
            {
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                header("Location: /members.php?view=$user");
                //确保重定向后，后续代码不会被执行
                exit;
//                echo "<script type='text/javascript'>tiaozhuan();</script>";
//                echo "<script type='text/javascript'>html_reload();</script>";
//                die("<div class='center'>You are now logged in. Please
//             <a data-transition='slide' href='members.php?view=$user'>click here</a>
//             to continue.</div></div></body></html>");
            }
        }
    }
}
//}
echo <<<_END
      <form method='post' action='login.php'>
        <div data-role='fieldcontain'>
          <label></label>
          <span class='error'>$error</span>
        </div>
        <div data-role='fieldcontain'>
          <label></label>
          Please enter your details to log in
        </div>
        <div data-role='fieldcontain'>
          <label>Username</label>
          <input id="us" type='text' maxlength='16' name='user' value='$user'>
        </div>
        <div data-role='fieldcontain'>
          <label>Password</label>
          <input id="ps" type='password' maxlength='16' name='pass' value='$pass'>
        </div>
        
        <div data-role='fieldcontain'>
        <label>Verification</label>
        <label style="display:inline-block;width:450px;float: left;"><input type="text" value="" placeholder="请输入验证码（不区分大小写）" class="input-val"></label>
        <canvas style="display:inline-block;width:150px;float: left;" id="canvas" width="100" height="30"></canvas>
         </div>
         
        <div data-role='fieldcontain'>
          <label></label>
          <!-- <input data-transition='slide' type='submit' value='Login' class="btn"> -->
          <button data-transition='slide' class="btn">Login</button>
        </div>
        
      </form>
    </div>
  </body>
</html>
_END;
?>
<script>
    $(document).ready(function(){
        var show_num = [];
        draw(show_num);
        $("#canvas").on('click',function(){ //刷新验证码
            draw(show_num);
        })
        $(".btn").on('click',function(){
            var val = $(".input-val").val().toLowerCase();//val是用户输入的验证码
            console.log("用户输入的验证码"+val);
            var num = show_num.join(""); //num是正确验证码
            console.log("正确的验证码"+num);
            var user = $("#us").val();
            console.log("jQuery获得的user:"+user);
            var pass = $("#ps").val();
            console.log("jQuery获得的pass:"+pass);

            if(val==''){ //输入为空
                alert('请输入验证码！');
                location.reload();
            }else if(val == num){ //输入正确
                $.ajax({
                    url:'login.php',
                    type:'POST',
                    data:{verification:'yes',user:user,pass:pass},
                    success:function(result){
                        console.log("验证码输入正确—ajax结果:成功");
                    },
                    error:function(msg){
                        alert('Error:'+msg);
                    }
                });
            }else{ //输入错误
                alert("验证码输入错误");
                location.reload();
            }
        })
    })
    //reload
    function html_reload() {
        location.reload();
    }
    function tiaozhuan() {
        window.location.href="members.php?view="+user;
    }
    //生成并渲染出验证码图形
    function draw(show_num) {
        var canvas_width=$('#canvas').width();
        var canvas_height=$('#canvas').height();
        var canvas = document.getElementById("canvas");//获取到canvas的对象，演员
        var context = canvas.getContext("2d");//获取到canvas画图的环境，演员表演的舞台
        canvas.width = canvas_width;
        canvas.height = canvas_height;
        var sCode = "a,b,c,d,e,f,g,h,i,j,k,m,n,p,q,r,s,t,u,v,w,x,y,z,A,B,C,E,F,G,H,J,K,L,M,N,P,Q,R,S,T,W,X,Y,Z,1,2,3,4,5,6,7,8,9,0";
        var aCode = sCode.split(",");
        var aLength = aCode.length;//获取到数组的长度
        for (var i = 0; i < 4; i++) { //这里的for循环可以控制验证码位数（如果想显示6位数，4改成6即可）
            var j = Math.floor(Math.random() * aLength);//获取到随机的索引值
            // var deg = Math.random() * 30 * Math.PI / 180;//产生0~30之间的随机弧度
            var deg = Math.random() - 0.5; //产生一个随机弧度
            var txt = aCode[j];//得到随机的一个内容
            show_num[i] = txt.toLowerCase();
            var x = 10 + i * 20;//文字在canvas上的x坐标
            var y = 20 + Math.random() * 8;//文字在canvas上的y坐标
            context.font = "bold 23px 微软雅黑";
            context.translate(x, y);
            context.rotate(deg);
            context.fillStyle = randomColor();
            context.fillText(txt, 0, 0);
            context.rotate(-deg);
            context.translate(-x, -y);
        }
        for (var i = 0; i <= 5; i++) { //验证码上显示线条
            context.strokeStyle = randomColor();
            context.beginPath();
            context.moveTo(Math.random() * canvas_width, Math.random() * canvas_height);
            context.lineTo(Math.random() * canvas_width, Math.random() * canvas_height);
            context.stroke();
        }
        for (var i = 0; i <= 30; i++) { //验证码上显示小点
            context.strokeStyle = randomColor();
            context.beginPath();
            var x = Math.random() * canvas_width;
            var y = Math.random() * canvas_height;
            context.moveTo(x, y);
            context.lineTo(x + 1, y + 1);
            context.stroke();
        }
    }
    //得到随机的颜色值
    function randomColor() {
        var r = Math.floor(Math.random() * 256);
        var g = Math.floor(Math.random() * 256);
        var b = Math.floor(Math.random() * 256);
        return "rgb(" + r + "," + g + "," + b + ")";
    }
</script>
