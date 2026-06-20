<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>404 — Page Not Found | AutoHub LK</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background: #f8fafc; }
    .error-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; }
    .error-code { font-size: 8rem; font-weight: 800; color: #e2e8f0; line-height: 1; }
    .error-icon { font-size: 4rem; color: #f59e0b; }
  </style>
</head>
<body>
  <div class="error-page">
    <div>
      <div class="error-code">404</div>
      <div class="error-icon mb-3"><i class="bi bi-search"></i></div>
      <h1 class="h3 fw-bold mb-3">Page Not Found</h1>
      <p class="text-muted mb-4"><?= e($message ?? 'The page you are looking for does not exist or has been moved.') ?></p>
      <a href="<?= BASE_URL ?>" class="btn btn-primary px-5 me-2">Go Home</a>
      <a href="javascript:history.back()" class="btn btn-outline-secondary px-5">Go Back</a>
    </div>
  </div>
</body>
</html>
