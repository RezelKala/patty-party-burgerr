<?php
// ============================================================
// PATTY PARTY BURGER — ADMIN PANEL
// Password: pattyparty2024 (ganti di bawah)
// ============================================================

session_start();
$ADMIN_PASS = 'pattyparty2024'; // Ganti password di sini

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pass'])) {
    if ($_POST['pass'] === $ADMIN_PASS) {
        $_SESSION['admin'] = true;
    } else {
        $error = 'Password salah!';
    }
}
// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patty Party — Admin Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Nunito', sans-serif; background: #f5f0e8; color: #2d2d2d; min-height: 100vh; }

/* LOGIN */
.login-bg { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #c0392b; }
.login-card { background: white; border-radius: 16px; padding: 2.5rem 2rem; width: 100%; max-width: 380px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); text-align: center; }
.login-card h1 { font-size: 1.5rem; color: #c0392b; margin-bottom: 0.3rem; }
.login-card p { color: #888; font-size: 0.85rem; margin-bottom: 1.5rem; }
.admin-input { width: 100%; padding: 0.8rem 1rem; border: 2px solid #e0d0b0; border-radius: 8px; font-family: 'Nunito', sans-serif; font-size: 0.95rem; outline: none; margin-bottom: 1rem; }
.admin-input:focus { border-color: #c0392b; }
.btn-login { width: 100%; background: #c0392b; color: white; border: none; padding: 0.85rem; border-radius: 8px; font-weight: 800; font-size: 1rem; cursor: pointer; font-family: 'Nunito', sans-serif; }
.btn-login:hover { background: #a93226; }
.error-msg { color: #c0392b; font-size: 0.82rem; margin-bottom: 0.8rem; }

/* DASHBOARD */
.admin-nav { background: #c0392b; color: white; padding: 1rem 2rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
.admin-nav h1 { font-size: 1.1rem; font-weight: 900; }
.btn-logout { background: rgba(255,255,255,0.2); color: white; border: none; padding: 0.4rem 1rem; border-radius: 6px; cursor: pointer; font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 0.82rem; }
.btn-logout:hover { background: rgba(255,255,255,0.3); }

.admin-wrap { padding: 2rem; max-width: 1200px; margin: 0 auto; }
.stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
.stat-card { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid; }
.stat-card.red { border-color: #c0392b; }
.stat-card.gold { border-color: #f0ab24; }
.stat-card.green { border-color: #27ae60; }
.stat-card.blue { border-color: #2980b9; }
.stat-num { font-size: 2rem; font-weight: 900; color: #2d2d2d; }
.stat-label { font-size: 0.82rem; color: #888; margin-top: 0.2rem; }
.stat-icon { font-size: 1.5rem; margin-bottom: 0.5rem; }

.section-title { font-size: 1.1rem; font-weight: 900; margin-bottom: 1rem; color: #2d2d2d; display: flex; align-items: center; gap: 0.5rem; }
.admin-table-wrap { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden; margin-bottom: 2rem; overflow-x: auto; }
table { width: 100%; border-collapse: collapse; min-width: 600px; }
thead { background: #c0392b; color: white; }
th, td { padding: 0.85rem 1rem; text-align: left; font-size: 0.83rem; }
th { font-weight: 800; }
tbody tr { border-bottom: 1px solid #f0e8d0; }
tbody tr:hover { background: #fffbf0; }
.badge { padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.72rem; font-weight: 700; }
.badge.paid { background: #d5f5e3; color: #1a7a40; }
.badge.pending { background: #fef9e7; color: #7d6608; }

.tabs { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; }
.tab-btn { padding: 0.5rem 1.5rem; border: 2px solid #e0d0b0; background: white; border-radius: 8px; font-weight: 700; cursor: pointer; font-family: 'Nunito', sans-serif; font-size: 0.85rem; transition: 0.2s; }
.tab-btn.active { background: #c0392b; color: white; border-color: #c0392b; }

.loading { text-align: center; padding: 2rem; color: #888; }
.empty-state { text-align: center; padding: 3rem; color: #888; font-size: 0.9rem; }

/* Firebase data loaded via JS */
#usersTable tbody tr td, #ordersTable tbody tr td { vertical-align: middle; }

@media(max-width:600px){ .admin-wrap { padding: 1rem; } th, td { padding: 0.6rem 0.7rem; font-size: 0.75rem; } .stat-num { font-size: 1.5rem; } }
</style>
</head>
<body>

<?php if (!isset($_SESSION['admin'])): ?>
<!-- ===== LOGIN PAGE ===== -->
<div class="login-bg">
  <div class="login-card">
    <div style="font-size:3rem;margin-bottom:0.5rem">🍔</div>
    <h1>Admin Panel</h1>
    <p>Patty Party Burger Dashboard</p>
    <?php if (isset($error)): ?>
      <p class="error-msg">⚠️ <?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST">
      <input type="password" name="pass" class="admin-input" placeholder="Password Admin" autofocus>
      <button type="submit" class="btn-login">Masuk →</button>
    </form>
  </div>
</div>

<?php else: ?>
<!-- ===== DASHBOARD ===== -->
<nav class="admin-nav">
  <h1>🍔 Patty Party — Admin Dashboard</h1>
  <a href="?logout=1"><button class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button></a>
</nav>

<div class="admin-wrap">
  <!-- Stats -->
  <div class="stat-grid">
    <div class="stat-card red"><div class="stat-icon">👥</div><div class="stat-num" id="totalUsers">—</div><div class="stat-label">Total Users</div></div>
    <div class="stat-card gold"><div class="stat-icon">📦</div><div class="stat-num" id="totalOrders">—</div><div class="stat-label">Total Orders</div></div>
    <div class="stat-card green"><div class="stat-icon">💰</div><div class="stat-num" id="totalRevenue">—</div><div class="stat-label">Total Revenue</div></div>
    <div class="stat-card blue"><div class="stat-icon">📅</div><div class="stat-num" id="todayOrders">—</div><div class="stat-label">Orders Today</div></div>
  </div>

  <!-- Tabs -->
  <div class="tabs">
    <button class="tab-btn active" onclick="showTab('users',this)"><i class="fas fa-users"></i> Data Users</button>
    <button class="tab-btn" onclick="showTab('orders',this)"><i class="fas fa-shopping-bag"></i> Data Orders</button>
  </div>

  <!-- USERS TABLE -->
  <div id="tab-users">
    <div class="section-title"><i class="fas fa-users"></i> Daftar Users Terdaftar</div>
    <div class="admin-table-wrap">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No. WhatsApp</th>
            <th>Tanggal Daftar</th>
          </tr>
        </thead>
        <tbody id="usersTableBody">
          <tr><td colspan="5" class="loading">⏳ Memuat data dari Firebase...</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ORDERS TABLE -->
  <div id="tab-orders" style="display:none">
    <div class="section-title"><i class="fas fa-shopping-bag"></i> Daftar Orders</div>
    <div class="admin-table-wrap">
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Items</th>
            <th>Total</th>
            <th>Metode</th>
            <th>Status</th>
            <th>Waktu</th>
          </tr>
        </thead>
        <tbody id="ordersTableBody">
          <tr><td colspan="7" class="loading">⏳ Memuat data dari Firebase...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Firebase SDK -->
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
  import { getFirestore, collection, getDocs, orderBy, query } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

  const firebaseConfig = {
    apiKey: "AIzaSyA3nz7zNvUbGHsveekg3RI9VK8KUlPggh4",
    authDomain: "patty-party.firebaseapp.com",
    projectId: "patty-party",
    storageBucket: "patty-party.firebasestorage.app",
    messagingSenderId: "418127733758",
    appId: "1:418127733758:web:141cfc6e1ff976de3c16af"
  };

  const app = initializeApp(firebaseConfig);
  const db = getFirestore(app);

  function fmtDate(ts) {
    if (!ts) return '—';
    const d = ts.toDate ? ts.toDate() : new Date(ts);
    return d.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' });
  }
  function fmtRp(n) { return 'Rp ' + (n||0).toLocaleString('id-ID'); }

  // Load Users
  async function loadUsers() {
    try {
      const snap = await getDocs(collection(db, 'users'));
      const tbody = document.getElementById('usersTableBody');
      tbody.innerHTML = '';
      let count = 0;
      snap.forEach(doc => {
        count++;
        const u = doc.data();
        tbody.innerHTML += `<tr>
          <td>${count}</td>
          <td><strong>${u.name || '—'}</strong></td>
          <td>${u.email || '—'}</td>
          <td>${u.phone ? '+62' + u.phone : '—'}</td>
          <td>${fmtDate(u.registeredAt || u.createdAt)}</td>
        </tr>`;
      });
      document.getElementById('totalUsers').textContent = count;
      if (count === 0) tbody.innerHTML = '<tr><td colspan="5" class="empty-state">Belum ada user terdaftar</td></tr>';
    } catch (e) {
      document.getElementById('usersTableBody').innerHTML = '<tr><td colspan="5" class="empty-state">❌ Gagal load data: ' + e.message + '</td></tr>';
    }
  }

  // Load Orders
  async function loadOrders() {
    try {
      const snap = await getDocs(collection(db, 'orders'));
      const tbody = document.getElementById('ordersTableBody');
      tbody.innerHTML = '';
      let totalRev = 0, todayCount = 0;
      const today = new Date().toDateString();
      let count = 0;

      snap.forEach(doc => {
        count++;
        const o = doc.data();
        totalRev += o.total || 0;
        const orderDate = o.orderedAt?.toDate ? o.orderedAt.toDate() : new Date(o.orderedAt || '');
        if (orderDate.toDateString() === today) todayCount++;

        const itemsStr = (o.items || []).map(i => `${i.name} x${i.qty}`).join(', ');
        tbody.innerHTML += `<tr>
          <td><code style="font-size:0.75rem">${o.orderId || '—'}</code></td>
          <td><strong>${o.customer?.name || 'Guest'}</strong><br><small style="color:#888">${o.customer?.email || ''}</small></td>
          <td style="max-width:180px;white-space:normal;font-size:0.75rem">${itemsStr || '—'}</td>
          <td><strong>${fmtRp(o.total)}</strong></td>
          <td>${o.paymentMethod || '—'}</td>
          <td><span class="badge paid">${o.status || 'paid'}</span></td>
          <td style="white-space:nowrap;font-size:0.75rem">${fmtDate(o.orderedAt)}</td>
        </tr>`;
      });

      document.getElementById('totalOrders').textContent = count;
      document.getElementById('totalRevenue').textContent = totalRev >= 1000000
        ? 'Rp ' + (totalRev/1000000).toFixed(1) + 'jt'
        : fmtRp(totalRev);
      document.getElementById('todayOrders').textContent = todayCount;
      if (count === 0) tbody.innerHTML = '<tr><td colspan="7" class="empty-state">Belum ada order</td></tr>';
    } catch (e) {
      document.getElementById('ordersTableBody').innerHTML = '<tr><td colspan="7" class="empty-state">❌ Gagal load data: ' + e.message + '</td></tr>';
    }
  }

  loadUsers();
  loadOrders();
</script>

<script>
function showTab(tab, btn) {
  document.getElementById('tab-users').style.display = tab === 'users' ? 'block' : 'none';
  document.getElementById('tab-orders').style.display = tab === 'orders' ? 'block' : 'none';
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  if (btn) btn.classList.add('active');
}
</script>

<?php endif; ?>
</body>
</html>