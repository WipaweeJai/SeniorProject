<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Be Limitless</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <a href="/"><img src="logo.png" alt="Be Limitless"></a>
    <a href="/sign-up">Sign up</a>
    <a href="/log-in">Log in</a>
  </header>
  <main>
    <form action="/sign-up" method="post">
      <h2>Sign up</h2>
      <input type="text" name="name" placeholder="Name">
      <input type="email" name="email" placeholder="Email address">
      <input type="password" name="password" placeholder="Password">
      <input type="checkbox" name="terms" id="terms">
      <label for="terms">I agree to the <a href="/terms">Terms of Service</a> and <a href="/privacy">Privacy Policy</a>.</label>
      <button type="submit">Create account</button>
    </form>
    <p>or sign up with</p>
    <a href="/sign-up/google"><img src="google.png" alt="Google"></a>
    <a href="/sign-up/facebook"><img src="facebook.png" alt="Facebook"></a>
  </main>
  <footer>
    <p>Copyright &copy; 2023 Be Limitless</p>
  </footer>
</body>
</html>
