<nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sistem Informasi Poliklinik</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Data Master
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?page=dokter">Dokter</a></li>
            <li><a class="dropdown-item" href="index.php?page=pasien">Pasien</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=periksa">Periksa</a>
        </li>
      </ul>
      
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['username'])): ?>
        <a class="nav-link" href="#">Halo, <?php echo $_SESSION['username']; ?></a>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="loginUser.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="registrasiUser.php">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
