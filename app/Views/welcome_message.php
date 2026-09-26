<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Task Manager — Sign in</title>
<style>
*{box-sizing:border-box}
:root{--green:#2f7d32;--text:#222;--muted:#777;--line:#ddd;--soft:#f7f7f5}
body{
  margin:0;min-height:100vh;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif;
  background:#f7f7f5;color:var(--text);display:flex;flex-direction:column
}
.topbar{
  height:64px;background:#fff;border-bottom:1px solid var(--line);display:flex;
  align-items:center;justify-content:space-between;padding:0 32px
}
.brand{display:flex;align-items:center;gap:12px;font-weight:800;font-size:17px}
.brand-mark{
  width:32px;height:32px;border-radius:7px;background:var(--green);color:#fff;
  display:grid;place-items:center;font-size:16px;font-weight:900
}
.help{font-size:13px;color:#666}.help a{color:#444;font-weight:600;text-decoration:none}.help a:hover{text-decoration:underline}
.page{flex:1;display:grid;place-items:center;padding:48px 20px}
.login-wrap{width:100%;max-width:440px}
.intro{text-align:center;margin-bottom:24px}
.intro h1{font-size:30px;letter-spacing:-.4px;margin:0 0 9px}
.intro p{margin:0;color:#777;font-size:14px;line-height:1.5}
.card{
  background:#fff;border:1px solid #d8d8d5;border-radius:9px;padding:32px;
  box-shadow:0 2px 12px rgba(0,0,0,.055)
}
label{display:block;font-size:13px;font-weight:700;margin:0 0 7px}
.field{margin-bottom:19px}
input[type=email],input[type=password]{
  width:100%;border:1px solid #aaa;border-radius:5px;padding:12px 12px;font-size:15px;
  outline:none;background:#fff;color:#222
}
input:focus{border-color:#555;box-shadow:0 0 0 2px rgba(47,125,50,.10)}
.password-head{display:flex;justify-content:space-between;align-items:center}
.password-head a{font-size:12px;color:#555;text-decoration:none}.password-head a:hover{text-decoration:underline}
.remember{display:flex;align-items:center;gap:8px;font-size:13px;color:#555;margin:2px 0 21px}
.remember input{width:16px;height:16px;accent-color:var(--green)}
.signin{
  width:100%;border:0;border-radius:5px;background:var(--green);color:#fff;padding:12px 16px;
  font-size:15px;font-weight:800;cursor:pointer
}
.signin:hover{filter:brightness(.95)}
.divider{display:flex;align-items:center;gap:12px;margin:24px 0;color:#999;font-size:12px}
.divider:before,.divider:after{content:"";height:1px;background:#e1e1df;flex:1}
.sso{
  width:100%;background:#fff;border:1px solid #bbb;border-radius:5px;padding:11px 14px;
  font-size:14px;font-weight:650;color:#333;cursor:pointer;margin-bottom:9px
}
.sso:hover{background:#f7f7f5}
.signup{text-align:center;color:#666;font-size:13px;margin-top:22px}
.signup a{color:#333;font-weight:700;text-decoration:none}.signup a:hover{text-decoration:underline}
.footer{
  border-top:1px solid #e2e2df;background:#fafafa;padding:17px 25px;text-align:center;
  color:#888;font-size:12px
}
.error{
  display:none;background:#fff4f2;border:1px solid #e7b7ae;color:#8a2c20;
  padding:10px 12px;border-radius:5px;font-size:13px;margin-bottom:18px
}
@media(max-width:520px){
  .topbar{padding:0 18px}.help span{display:none}.page{padding:30px 15px}
  .card{padding:25px 20px}.intro h1{font-size:27px}
}
</style>
</head>
<body>

<header class="topbar">
  <div class="brand">
    <span class="brand-mark">B</span>
    <span>Task Manager</span>
  </div>
  <div class="help"><span>Need help? </span><a href="#">Contact support</a></div>
</header>

<main class="page">
  <div class="login-wrap">
    <div class="intro">
      <h1>Welcome back</h1>
      <p>Sign in to get back to your projects and to-dos.</p>
    </div>

    <section class="card">
      <div class="error" id="loginError">Please enter your email address and password.</div>

      <form id="loginForm" action="<?php echo base_url();?>/task-manager" method="post">
        <div class="field">
          <label for="email">Email address</label>
          <input id="email" name="email" type="email" autocomplete="email" placeholder="you@company.com" required autofocus>
        </div>

        <div class="field">
          <div class="password-head">
            <label for="password">Password</label>
            <a href="forgot-password.php">Forgot password?</a>
          </div>
          <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Your password" required>
        </div>

        <label class="remember">
          <input type="checkbox" name="remember" value="1">
          <span>Keep me signed in</span>
        </label>

        <button class="signin" type="submit">Sign in</button>
      </form>

      <div class="divider">or</div>

      <button class="sso" type="button">Continue with Google</button>
      <button class="sso" type="button">Continue with GitHub</button>
    </section>

    <div class="signup">
      New to Task Manager? <a href="register.php">Create an account</a>
    </div>
  </div>
</main>

<footer class="footer">
  Task Manager &nbsp;·&nbsp; Simple project management
</footer>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value;
  if (!email || !password) {
    e.preventDefault();
    document.getElementById('loginError').style.display = 'block';
  }
});
</script>
</body>
</html>
