</main>

<footer class="site-footer">
  <div class="wrap footer-row">
    <p>X-Men Archive &middot; Professor Xavier's secure hero registry</p>
    <p class="session"><?= logged_in() ? 'Session active · ' . e($_SESSION['username'] ?? '') : 'Public access' ?></p>
  </div>
</footer>

<script src="assets/app.js"></script>
</body>
</html>
